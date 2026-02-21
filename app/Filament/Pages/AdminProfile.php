<?php

namespace App\Filament\Pages;

use App\Models\Admin;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AdminProfile extends Page
{
    use WithFileUploads;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Profile';

    protected static ?int $navigationSort = 99;

    protected static ?string $slug = 'profile';

    protected string $view = 'filament.pages.admin-profile';

    public ?string $name = null;

    public ?string $email = null;

    public $avatar = null;

    public ?string $current_password = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public function mount(): void
    {
        $admin = $this->getAdmin();

        $this->name = $admin->name;
        $this->email = $admin->email;
    }

    public function updateProfile(): void
    {
        $admin = $this->getAdmin();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->save();

        Notification::make()
            ->title('Profile updated successfully.')
            ->success()
            ->send();
    }

    public function updateAvatar(): void
    {
        $admin = $this->getAdmin();

        $validated = $this->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (! empty($admin->avatar) && ! str_starts_with($admin->avatar, 'http')) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $path = $validated['avatar']->store('admin-avatars', 'public');
        $admin->avatar = $path;
        $admin->save();

        $this->avatar = null;

        Notification::make()
            ->title('Avatar uploaded successfully.')
            ->success()
            ->send();
    }

    public function updatePassword(): void
    {
        $admin = $this->getAdmin();

        $validated = $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], $admin->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $admin->password = Hash::make($validated['password']);
        $admin->save();

        $this->reset(['current_password', 'password', 'password_confirmation']);

        Notification::make()
            ->title('Password changed successfully.')
            ->success()
            ->send();
    }

    public function getAvatarUrl(): string
    {
        $admin = $this->getAdmin();

        if (! empty($admin->avatar)) {
            if (! str_starts_with($admin->avatar, 'http') && ! Storage::disk('public')->exists($admin->avatar)) {
                return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim((string) $admin->email))) . '?s=360&d=identicon';
            }

            return str_starts_with($admin->avatar, 'http')
                ? $admin->avatar
                : asset('storage/app/public/' . $admin->avatar);
        }

        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim((string) $admin->email))) . '?s=360&d=identicon';
    }

    protected function getAdmin(): Admin
    {
        $admin = auth('admin')->user();

        abort_unless($admin instanceof Admin, 403);

        return $admin;
    }
}