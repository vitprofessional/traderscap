<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Customer Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}" defer></script>
    <style>
        :root {
            --bg-ink: #061225;
            --bg-navy: #0e2a4f;
            --card: rgba(255, 255, 255, 0.96);
            --line: rgba(15, 23, 42, 0.12);
            --text: #10233c;
            --muted: #57708f;
            --accent: #0d9488;
            --accent-strong: #0f766e;
            --danger: #b91c1c;
            --danger-soft: #fef2f2;
            --danger-line: #fecaca;
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
                radial-gradient(circle at 12% 20%, rgba(56, 189, 248, 0.26), transparent 40%),
                radial-gradient(circle at 88% 82%, rgba(20, 184, 166, 0.2), transparent 38%),
                linear-gradient(135deg, var(--bg-ink) 0%, var(--bg-navy) 100%);
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
        }

        .login-shell {
            width: min(100%, 980px);
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: 0 35px 60px rgba(2, 6, 23, 0.35);
            backdrop-filter: blur(12px);
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            animation: rise 450ms ease-out;
        }

        .login-brand {
            padding: 2.6rem 2.4rem;
            background:
                linear-gradient(160deg, rgba(13, 148, 136, 0.4), rgba(15, 118, 110, 0.1)),
                linear-gradient(210deg, rgba(6, 18, 37, 0.65), rgba(6, 18, 37, 0.9));
            border-right: 1px solid rgba(148, 163, 184, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 2rem;
        }

        .badge {
            display: inline-flex;
            width: fit-content;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            padding: 0.32rem 0.72rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: rgba(248, 250, 252, 0.14);
            color: #e2e8f0;
        }

        .login-brand h1 {
            margin: 1rem 0 0.8rem;
            font-size: clamp(1.6rem, 4vw, 2.1rem);
            line-height: 1.15;
            letter-spacing: -0.02em;
            font-family: "Space Grotesk", "Manrope", sans-serif;
        }

        .login-brand p {
            margin: 0;
            color: rgba(226, 232, 240, 0.86);
            max-width: 30ch;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .signal {
            display: grid;
            gap: 0.5rem;
            margin-top: auto;
            padding-top: 0.6rem;
        }

        .signal strong {
            font-size: 0.83rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: rgba(226, 232, 240, 0.88);
        }

        .signal span {
            color: rgba(226, 232, 240, 0.72);
            font-size: 0.9rem;
        }

        .login-card {
            background: var(--card);
            padding: 2.4rem;
            color: var(--text);
        }

        .login-card h2 {
            margin: 0;
            font-size: 1.42rem;
            letter-spacing: -0.01em;
            font-family: "Space Grotesk", "Manrope", sans-serif;
        }

        .subtitle {
            margin: 0.45rem 0 1.5rem;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .error {
            border: 1px solid var(--danger-line);
            background: var(--danger-soft);
            color: var(--danger);
            border-radius: 12px;
            padding: 0.72rem 0.9rem;
            font-size: 0.92rem;
            margin-bottom: 1rem;
        }

        form {
            display: grid;
            gap: 0.95rem;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.84rem;
            letter-spacing: 0.01em;
            font-weight: 700;
            color: #1e3554;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            height: 2.85rem;
            padding: 0 0.9rem;
            font-size: 0.95rem;
            color: #0f172a;
            background: #ffffff;
            transition: border-color 140ms ease, box-shadow 140ms ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: color-mix(in srgb, var(--accent) 48%, white);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 18%, white);
        }

        .form-row {
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 0.48rem;
            color: #3f5d7f;
            font-size: 0.89rem;
        }

        .remember input {
            accent-color: var(--accent);
        }

        .primary-btn {
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #f8fafc;
            height: 2.85rem;
            padding: 0 1.1rem;
            font-weight: 700;
            font-size: 0.92rem;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: transform 140ms ease, filter 140ms ease;
        }

        .primary-btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
        }

        .primary-btn:focus-visible {
            outline: 2px solid color-mix(in srgb, var(--accent) 55%, white);
            outline-offset: 2px;
        }

        .meta {
            margin-top: 1.1rem;
            font-size: 0.88rem;
            color: #526b8a;
        }

        .meta a {
            color: var(--accent-strong);
            font-weight: 700;
            text-decoration: none;
        }

        .meta a:hover {
            text-decoration: underline;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            .login-shell {
                grid-template-columns: 1fr;
            }

            .login-brand {
                border-right: 0;
                border-bottom: 1px solid rgba(148, 163, 184, 0.2);
                padding: 2rem 1.5rem;
            }

            .login-brand p {
                max-width: 50ch;
            }

            .login-card {
                padding: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <main class="login-shell" aria-label="Customer login page">
        <section class="login-brand" aria-hidden="true">
            <div>
                <span class="badge">{{ config('app.name') }} Portal</span>
                <h1>Welcome back to your customer workspace.</h1>
                <p>Review investment plans, track support tickets, and manage your account from one secure dashboard.</p>
            </div>
            <div class="signal">
                <strong>Secure Session</strong>
                <span>Encrypted login and protected account access.</span>
            </div>
        </section>

        <section class="login-card">
            <h2>Customer Sign In</h2>
            <p class="subtitle">Use your registered email and password to continue.</p>

            @if($errors->any())
                <div class="error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf

                <div>
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password">
                </div>

                <div class="form-row">
                    <label class="remember"><input type="checkbox" name="remember">Keep me signed in</label>
                    <button type="submit" class="primary-btn">Sign In</button>
                </div>
            </form>

            <p class="meta">Need an account? <a href="{{ route('register') }}">Create one here</a>.</p>
        </section>
    </main>
</body>
</html>
