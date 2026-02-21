<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('customer.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $data['avatar']->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return back()->with('avatar_success', 'Avatar uploaded successfully.');
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