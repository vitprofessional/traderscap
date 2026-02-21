<x-filament-panels::page>
    <div style="display:grid;grid-template-columns:minmax(0,2fr) minmax(0,1fr);gap:1.5rem;align-items:start;">
        <div>
            <x-filament::section>
                <x-slot name="heading">Profile</x-slot>

                <form wire:submit="updateProfile" style="display:grid;gap:1rem;">
                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input type="text" wire:model.defer="name" placeholder="Name" />
                        </x-filament::input.wrapper>
                        @error('name')
                            <p style="margin-top:.375rem;color:#dc2626;font-size:.875rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input type="email" wire:model.defer="email" placeholder="Email" />
                        </x-filament::input.wrapper>
                        @error('email')
                            <p style="margin-top:.375rem;color:#dc2626;font-size:.875rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-filament::button type="submit">Save profile</x-filament::button>
                    </div>
                </form>
            </x-filament::section>

            <div style="height:1px;background:#d1d5db;margin:1.5rem 0;"></div>

            <x-filament::section>
                <x-slot name="heading">Password</x-slot>

                <form wire:submit="updatePassword" style="display:grid;gap:1rem;">
                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input type="password" wire:model.defer="current_password" placeholder="Current password" />
                        </x-filament::input.wrapper>
                        @error('current_password')
                            <p style="margin-top:.375rem;color:#dc2626;font-size:.875rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input type="password" wire:model.defer="password" placeholder="New password" />
                        </x-filament::input.wrapper>
                        @error('password')
                            <p style="margin-top:.375rem;color:#dc2626;font-size:.875rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input type="password" wire:model.defer="password_confirmation" placeholder="Confirm" />
                        </x-filament::input.wrapper>
                    </div>

                    <div>
                        <x-filament::button type="submit" color="gray">Change password</x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>

        <div>
            <x-filament::section>
                <x-slot name="heading">Avatar</x-slot>

                <div style="width:180px;height:180px;border:1px solid #d1d5db;border-radius:8px;overflow:hidden;margin-bottom:1rem;">
                    <img src="{{ $this->getAvatarUrl() }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
                </div>

                <form wire:submit="updateAvatar" style="display:grid;gap:1rem;">
                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input type="file" wire:model="avatar" accept="image/*" />
                        </x-filament::input.wrapper>
                        @error('avatar')
                            <p style="margin-top:.375rem;color:#dc2626;font-size:.875rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-filament::button type="submit" color="info">Upload avatar</x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>