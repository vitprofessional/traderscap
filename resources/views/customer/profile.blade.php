<x-layouts.dashboard title="Profile">
    @php
        $avatarSrc = null;
        if (!empty($user?->avatar)) {
            $avatarPath = preg_replace('#^(storage/app/public|public)/#', '', $user->avatar);
            $avatarSrc = str_starts_with($user->avatar, 'http')
                ? $user->avatar
                : \Illuminate\Support\Facades\Storage::disk('public')->url($avatarPath);
        }

        if (! $avatarSrc) {
            $avatarSrc = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email ?? ''))) . '?s=600&d=identicon';
        }

        $fullName = trim((string) ($user->name ?? ''));
        $nameParts = preg_split('/\s+/', $fullName) ?: [];
        $sureName = count($nameParts) > 1 ? end($nameParts) : ($fullName !== '' ? $fullName : '-');
        $contact = $user->phone ?? $user->contact ?? '-';

        $activeTab = request('tab');
        if (! in_array($activeTab, ['edit', 'password'], true)) {
            if (session('profile_success') || $errors->has('name') || $errors->has('email')) {
                $activeTab = 'edit';
            } elseif (session('password_success') || $errors->passwordUpdate->any() || $errors->has('password') || $errors->has('current_password')) {
                $activeTab = 'password';
            } else {
                $activeTab = null;
            }
        }
    @endphp

    <div style="width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:28px 30px;">
        <h1 style="margin:0; font-size:42px; line-height:1.1; font-weight:700; color:#111827;">My Profile</h1>

        <div style="display:flex; gap:36px; align-items:flex-start; margin-top:24px;">
            <div style="flex:0 0 320px; width:320px;">
                <div style="width:320px; height:320px; overflow:hidden; border-radius:14px; background:#f3f4f6;">
                    <img src="{{ $avatarSrc }}" alt="Profile photo" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
            </div>

            <div style="flex:1; min-width:0;">
                <div style="display:flex; flex-direction:column;">
                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0; border-bottom:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Full Name</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70;">{{ $fullName !== '' ? $fullName : 'N/A' }}</p>
                    </div>

                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0; border-bottom:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Surname</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70;">{{ $sureName !== '' ? $sureName : 'N/A' }}</p>
                    </div>

                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0; border-bottom:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Email Address</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70; word-break:break-word;">{{ $user->email ?? 'N/A' }}</p>
                    </div>

                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Contact Number</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70;">{{ $contact !== '-' ? $contact : 'N/A' }}</p>
                    </div>
                </div>

                <div style="display:flex; gap:16px; align-items:center; margin-top:26px; flex-wrap:wrap;">
                    <a href="{{ route('profile', ['tab' => 'edit']) }}" style="display:inline-flex; align-items:center; padding:11px 18px; border-radius:14px; background:#3b82f6; color:#fff; text-decoration:none; font-size:16px; line-height:1; font-weight:600;">
                        Edit Profile
                    </a>

                    <a href="{{ route('profile', ['tab' => 'password']) }}" style="display:inline-flex; align-items:center; padding:11px 18px; border-radius:14px; background:#6b7280; color:#fff; text-decoration:none; font-size:16px; line-height:1; font-weight:600;">
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($activeTab === 'edit')
        <div style="width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px 30px; margin-top:20px;">
            <h2 style="margin:0 0 16px 0; font-size:24px; font-weight:700; color:#111827;">Edit Profile</h2>

            @if(session('profile_success'))
                <div style="margin-bottom:14px; padding:10px 12px; border-radius:8px; border:1px solid #a7f3d0; background:#ecfdf5; color:#065f46; font-size:14px;">
                    {{ session('profile_success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" style="display:grid; gap:14px; max-width:620px;">
                @csrf

                <div>
                    <label for="name" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name ?? '') }}"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    @error('name')
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email ?? '') }}"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    @error('email')
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="padding-top:4px;">
                    <button type="submit" style="display:inline-flex; align-items:center; padding:11px 18px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:15px; font-weight:600; cursor:pointer;">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($activeTab === 'password')
        <div style="width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px 30px; margin-top:20px;">
            <h2 style="margin:0 0 16px 0; font-size:24px; font-weight:700; color:#111827;">Change Password</h2>

            @if(session('password_success'))
                <div style="margin-bottom:14px; padding:10px 12px; border-radius:8px; border:1px solid #a7f3d0; background:#ecfdf5; color:#065f46; font-size:14px;">
                    {{ session('password_success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}" style="display:grid; gap:14px; max-width:620px;">
                @csrf

                <div>
                    <label for="current_password" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Current Password</label>
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    @if($errors->passwordUpdate->has('current_password'))
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;">{{ $errors->passwordUpdate->first('current_password') }}</p>
                    @elseif($errors->has('current_password'))
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;">{{ $errors->first('current_password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">New Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    @error('password')
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Confirm New Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                </div>

                <div style="padding-top:4px;">
                    <button type="submit" style="display:inline-flex; align-items:center; padding:11px 18px; border:0; border-radius:10px; background:#4b5563; color:#fff; font-size:15px; font-weight:600; cursor:pointer;">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    @endif
</x-layouts.dashboard>
