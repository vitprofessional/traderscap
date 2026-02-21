<x-layouts.dashboard title="Profile">
    <div class="max-w-6xl w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                @if(session('profile_success'))
                    <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('profile_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-indigo-800 mb-1">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name ?? '') }}"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-indigo-800 mb-1">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email ?? '') }}"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-6 py-3 text-base font-semibold text-white hover:bg-indigo-700">
                        Save profile
                    </button>
                </form>

                <div class="my-8 border-t border-gray-300"></div>

                @if(session('password_success'))
                    <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('password_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-indigo-800 mb-1">Current password</label>
                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        @if($errors->passwordUpdate->has('current_password'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->passwordUpdate->first('current_password') }}</p>
                        @elseif($errors->has('current_password'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('current_password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-indigo-800 mb-1">New password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-indigo-800 mb-1">Confirm</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-300 px-6 py-3 text-base font-semibold text-white hover:bg-indigo-400">
                        Change password
                    </button>
                </form>
            </div>

            <div>
                @if(session('avatar_success'))
                    <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('avatar_success') }}
                    </div>
                @endif

                <h3 class="text-4xl font-semibold text-indigo-950 mb-4">Avatar</h3>

                <div class="w-[180px] h-[180px] rounded-md border border-gray-300 overflow-hidden bg-white mb-8">
                    @php
                        $avatarSrc = null;
                        if (!empty($user?->avatar)) {
                            $avatarSrc = str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/app/public/' . $user->avatar);
                        }
                    @endphp

                    @if($avatarSrc)
                        <img src="{{ $avatarSrc }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email ?? '')) ) }}?s=240&d=identicon" alt="Avatar" class="w-full h-full object-cover">
                    @endif
                </div>

                <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <input type="file" name="avatar" accept="image/*" class="w-full rounded-md border border-gray-300 bg-white px-4 py-3">
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-md bg-cyan-500 px-6 py-3 text-base font-semibold text-white hover:bg-cyan-600">
                        Upload avatar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
