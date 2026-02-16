<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Admin Password</title>
</head>
<body style="max-width:480px;margin:6rem auto;padding:1.5rem;border:1px solid #eee;border-radius:8px;">
    <h2>Set New Password</h2>

    @if($errors->any())
        <div style="color:#b91c1c">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div style="margin-top:1rem">
            <label>Email</label><br>
            <input name="email" type="email" value="{{ $email ?? old('email') }}" required style="width:100%;padding:0.5rem;border:1px solid #ddd;border-radius:4px;">
        </div>

        <div style="margin-top:1rem">
            <label>Password</label><br>
            <input name="password" type="password" required style="width:100%;padding:0.5rem;border:1px solid #ddd;border-radius:4px;">
        </div>

        <div style="margin-top:1rem">
            <label>Confirm Password</label><br>
            <input name="password_confirmation" type="password" required style="width:100%;padding:0.5rem;border:1px solid #ddd;border-radius:4px;">
        </div>

        <div style="margin-top:1rem">
            <button type="submit" style="background:#111;color:#fff;padding:0.5rem 0.75rem;border-radius:4px;border:none">Reset Password</button>
        </div>
    </form>
</body>
</html>
