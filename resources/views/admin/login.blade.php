<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}" defer></script>
    <style>
        :root{--bg:#f7fafc;--card:#ffffff;--muted:#6b7280;--accent:#0f172a}
        body{background:linear-gradient(180deg,#eef2ff 0%,var(--bg) 100%);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial}
        .login-wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
        .card{width:100%;max-width:420px;background:var(--card);box-shadow:0 10px 30px rgba(2,6,23,0.08);border-radius:12px;padding:2rem}
        .brand{display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem}
        .brand-logo{width:42px;height:42px;border-radius:8px;background:linear-gradient(135deg,#4f46e5,#06b6d4);display:inline-block}
        h1{font-size:1.125rem;margin:0;color:var(--accent)}
        p.summary{margin:0;margin-top:0.25rem;color:var(--muted);font-size:0.95rem}
        label{display:block;font-size:0.875rem;color:#111827;margin-bottom:0.35rem}
        input[type=email],input[type=password]{width:100%;padding:0.65rem;border:1px solid #e6e9ef;border-radius:8px;font-size:0.95rem}
        .row{display:flex;align-items:center;justify-content:space-between;margin-top:1rem}
        .remember{display:flex;align-items:center;gap:0.5rem;color:var(--muted);font-size:0.9rem}
        .btn{background:#111827;color:#fff;padding:0.65rem 0.9rem;border-radius:8px;border:none;font-weight:600}
        a.forgot{color:#2563eb;text-decoration:none;font-size:0.9rem}
        .error{background:#fff5f5;color:#b91c1c;padding:0.6rem;border-radius:8px;margin-bottom:0.75rem;border:1px solid #fecaca}
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="card">
            <div class="brand">
                <span class="brand-logo" aria-hidden="true"></span>
                <div>
                    <h1>Admin Panel</h1>
                    <p class="summary">Sign in to manage the system</p>
                </div>
            </div>

            @if($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" novalidate>
                @csrf

                <div style="margin-top:0.6rem">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div style="margin-top:0.9rem">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password">
                </div>

                <div class="row">
                    <label class="remember"><input type="checkbox" name="remember"> Remember me</label>
                    <div style="display:flex;gap:0.75rem;align-items:center">
                        <a class="forgot" href="{{ route('admin.password.request') }}">Forgot?</a>
                        <button type="submit" class="btn">Sign in</button>
                    </div>
                </div>
            </form>

            <div style="margin-top:1rem;color:var(--muted);font-size:0.85rem;text-align:center">
                <small>Access is limited to authorized personnel.</small>
            </div>
        </div>
    </div>
</body>
</html>
