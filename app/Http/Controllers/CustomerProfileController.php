<?php

namespace App\Http\Controllers;

use App\Notifications\PendingEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user()->load('country');

        $hasActivePlan = $user->userPackages()
            ->whereIn('status', ['active', 'active_waiting'])
            ->exists();

        $countries = \App\Models\Country::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'phone_code']);

        return view('customer.profile', compact('user', 'hasActivePlan', 'countries'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone'      => ['nullable', 'string', 'max:30',
                'regex:/^\+?[0-9\s\-\(\)]{5,30}$/',
            ],
            'country_id' => ['nullable', 'integer', Rule::exists('countries', 'id')],
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        $firstName = preg_replace('/\s+/', ' ', trim($data['first_name']));
        $lastName  = preg_replace('/\s+/', ' ', trim((string) ($data['last_name'] ?? '')));
        $name      = trim($firstName . ($lastName !== '' ? ' ' . $lastName : ''));

        $newEmail = strtolower(trim($data['email']));
        $emailChanged = $newEmail !== strtolower(trim($user->email));

        $user->name       = $name;
        $user->phone      = $data['phone'] ? trim($data['phone']) : null;
        $user->country_id = $data['country_id'] ?: null;

        // Email change: queue for verification, don't apply immediately
        if ($emailChanged) {
            // Don't re-send if same pending email already queued
            if ($user->pending_email !== $newEmail) {
                $hadProfileChanges = $user->isDirty(['name', 'phone', 'country_id']);

                try {
                    DB::transaction(function () use ($user, $newEmail, $hadProfileChanges): void {
                        $user->pending_email = $newEmail;
                        $user->save();

                        // Send verification only after persisting pending email in the same request.
                        $user->notify(new PendingEmailVerification($newEmail));

                        // Persist any profile changes made in this request.
                        if ($hadProfileChanges) {
                            $user->save();
                        }
                    });
                } catch (\Throwable $e) {
                    report($e);

                    return back()
                        ->withInput()
                        ->withErrors([
                            'email' => 'We could not send verification to the new email address right now. Please check mail domain DNS (DKIM/SPF) and try again.',
                        ]);
                }

                if (! $hadProfileChanges) {
                    return back()->with('profile_success',
                        'A verification email has been sent to ' . $newEmail . '. Your email will be updated once confirmed.');
                }

                return back()->with('profile_success',
                    'Profile updated. A verification email has been sent to ' . $newEmail . '. Your email will be updated once confirmed.');
            }

            // Same pending email already queued — just save other fields
            if (! $user->isDirty(['name', 'phone', 'country_id'])) {
                return back()->with('profile_success', 'No changes were detected.');
            }
            $user->save();
            return back()->with('profile_success', 'Profile updated successfully.');
        }

        if (! $user->isDirty(['name', 'phone', 'country_id'])) {
            return back()->with('profile_success', 'No changes were detected.');
        }

        $user->save();

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=200,min_height=200',
        ]);

        $path = $data['avatar']->store('avatars', 'public');

        $previousAvatarPath = $this->normalizePublicStoragePath($user->avatar);

        $user->avatar = $path;
        $user->save();

        if ($previousAvatarPath && $previousAvatarPath !== $path) {
            Storage::disk('public')->delete($previousAvatarPath);
        }

        return back()->with('avatar_success', 'Avatar uploaded successfully.');
    }

    public function verifyPendingEmail(Request $request)
    {
        $user = $request->user();

        if (! $request->hasValidSignature()) {
            abort(403, 'This verification link is invalid or has expired.');
        }

        if (! $user->pending_email) {
            return redirect()->route('profile')
                ->with('profile_success', 'No pending email change found.');
        }

        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            abort(403, 'This verification link does not belong to your account.');
        }

        if (! hash_equals(sha1($user->pending_email), (string) $request->route('hash'))) {
            abort(403, 'This verification link is no longer valid.');
        }

        $user->email            = $user->pending_email;
        $user->pending_email    = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('profile')
            ->with('profile_success', 'Email address updated and verified successfully!');
    }

    public function cancelPendingEmail(Request $request)
    {
        $user = $request->user();

        if ($user->pending_email) {
            $user->pending_email = null;
            $user->save();
        }

        return back()->with('profile_success', 'Pending email change cancelled.');
    }

    public function resendPendingEmailChange(Request $request)
    {
        $user = $request->user();

        if (! $user->pending_email) {
            return back()->with('profile_success', 'No pending email change found.');
        }

        try {
            $user->notify(new PendingEmailVerification($user->pending_email));
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'email' => 'Unable to resend verification email. Please fix mail DNS (DKIM/SPF) and try again.',
            ]);
        }

        return back()->with('profile_success',
            'Verification email resent to ' . $user->pending_email . '.');
    }

    private function normalizePublicStoragePath(?string $path): ?string
    {
        if (empty($path) || str_starts_with($path, 'http')) {
            return null;
        }

        return ltrim((string) preg_replace('#^(storage/app/public|public)/#', '', $path), '/');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ], 'passwordUpdate');
        }

        $user->password = $data['password'];
        $user->save();

        return back()->with('password_success', 'Password changed successfully.');
    }
}