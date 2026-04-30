<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}" defer></script>
    <style>
        :root {
            --bg-1: #05080f;
            --bg-2: #0f172a;
            --card: rgba(255, 255, 255, 0.98);
            --text: #1f2937;
            --muted: #64748b;
            --line: rgba(148, 163, 184, 0.35);
            --accent: #d97706;
            --accent-strong: #b45309;
            --danger: #b91c1c;
            --danger-soft: #fff1f2;
            --danger-line: #fecdd3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Manrope", "Segoe UI", sans-serif;
            color: #f8fafc;
            background:
                radial-gradient(circle at 18% 20%, rgba(245, 158, 11, 0.2), transparent 34%),
                radial-gradient(circle at 86% 84%, rgba(59, 130, 246, 0.14), transparent 40%),
                linear-gradient(145deg, var(--bg-1) 0%, var(--bg-2) 100%);
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
        }

        .shell {
            width: min(100%, 1020px);
            border-radius: 24px;
            overflow: hidden;
            background: rgba(15, 23, 42, 0.55);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: 0 36px 62px rgba(2, 6, 23, 0.4);
            backdrop-filter: blur(10px);
            display: grid;
            grid-template-columns: 1fr 1fr;
            animation: settle 440ms ease-out;
        }

        .panel-left {
            padding: 2.5rem 2.3rem;
            background:
                linear-gradient(170deg, rgba(245, 158, 11, 0.24), rgba(245, 158, 11, 0.06)),
                linear-gradient(200deg, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.7));
            border-right: 1px solid rgba(148, 163, 184, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.8rem;
        }

        .kicker {
            display: inline-flex;
            width: fit-content;
            border-radius: 999px;
            padding: 0.34rem 0.76rem;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
            background: rgba(248, 250, 252, 0.14);
            color: #e2e8f0;
        }

        .panel-left h1 {
            margin: 1rem 0 0.85rem;
            font-family: "Sora", "Manrope", sans-serif;
            letter-spacing: -0.02em;
            line-height: 1.1;
            font-size: clamp(1.6rem, 4.1vw, 2.15rem);
        }

        .panel-left p {
            margin: 0;
            color: rgba(226, 232, 240, 0.82);
            line-height: 1.62;
            max-width: 34ch;
        }

        .trust {
            border-top: 1px solid rgba(148, 163, 184, 0.24);
            padding-top: 1rem;
            color: rgba(226, 232, 240, 0.84);
            font-size: 0.9rem;
        }

        .panel-right {
            background: var(--card);
            padding: 2.35rem;
            color: var(--text);
        }

        .panel-right h2 {
            margin: 0;
            font-size: 1.45rem;
            font-family: "Sora", "Manrope", sans-serif;
        }

        .sub {
            margin: 0.4rem 0 1.45rem;
            color: var(--muted);
            font-size: 0.94rem;
        }

        .error {
            border: 1px solid var(--danger-line);
            background: var(--danger-soft);
            color: var(--danger);
            border-radius: 12px;
            padding: 0.74rem 0.92rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        form {
            display: grid;
            gap: 0.95rem;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.83rem;
            letter-spacing: 0.01em;
            font-weight: 700;
            color: #334155;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 2.85rem;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 0 0.9rem;
            font-size: 0.95rem;
            color: #0f172a;
            background: #fff;
            transition: border-color 140ms ease, box-shadow 140ms ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: color-mix(in srgb, var(--accent) 48%, white);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 18%, white);
        }

        .actions {
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.89rem;
            color: #475569;
        }

        .remember input {
            accent-color: var(--accent);
        }

        .action-group {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }

        .forgot {
            color: #0369a1;
            text-decoration: none;
            font-size: 0.89rem;
            font-weight: 700;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .btn {
            border: 0;
            border-radius: 12px;
            height: 2.85rem;
            padding: 0 1.12rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: transform 140ms ease, filter 140ms ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
        }

        .footnote {
            margin-top: 1.15rem;
            color: #64748b;
            font-size: 0.84rem;
        }

        @keyframes settle {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .panel-left {
                border-right: 0;
                border-bottom: 1px solid rgba(148, 163, 184, 0.2);
                padding: 2rem 1.5rem;
            }

            .panel-right {
                padding: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <main class="shell" aria-label="Admin login page">
        <section class="panel-left" aria-hidden="true">
            <div>
                <span class="kicker">TraderScap Admin</span>
                <h1>Administrative control panel access.</h1>
                <p>Authenticate to manage users, operations, and internal workflows with audit-aware account controls.</p>
            </div>
            <p class="trust">Restricted area. Access is limited to authorized personnel only.</p>
        </section>

        <section class="panel-right">
            <h2>Admin Sign In</h2>
            <p class="sub">Enter your credentials to continue to the admin panel.</p>

            @if($errors->any())
                <div class="error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" novalidate>
                @csrf

                <div>
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password">
                </div>

                <div class="actions">
                    <label class="remember"><input type="checkbox" name="remember">Keep me signed in</label>
                    <div class="action-group">
                        <a class="forgot" href="{{ route('admin.password.request') }}">Forgot password?</a>
                        <button type="submit" class="btn">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="footnote">All login attempts are monitored for security and compliance.</p>
        </section>
    </main>
</body>
</html>
