<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Password Reset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
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
            --success: #166534;
            --success-soft: #ecfdf3;
            --success-line: #bbf7d0;
        }

        * { box-sizing: border-box; }

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

        .card {
            width: min(100%, 560px);
            border-radius: 22px;
            background: var(--card);
            color: var(--text);
            border: 1px solid rgba(148, 163, 184, 0.26);
            box-shadow: 0 28px 56px rgba(2, 6, 23, 0.4);
            overflow: hidden;
            animation: settle 420ms ease-out;
        }

        .header {
            padding: 1.5rem 1.6rem;
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.16), rgba(15, 23, 42, 0.04));
            border-bottom: 1px solid rgba(148, 163, 184, 0.24);
        }

        .header h1 {
            margin: 0;
            font-family: "Sora", "Manrope", sans-serif;
            font-size: 1.35rem;
            letter-spacing: -0.02em;
        }

        .header p {
            margin: 0.45rem 0 0;
            color: var(--muted);
            font-size: 0.93rem;
        }

        .body {
            padding: 1.5rem 1.6rem 1.65rem;
        }

        .alert,
        .status {
            border-radius: 12px;
            padding: 0.72rem 0.92rem;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .alert {
            border: 1px solid var(--danger-line);
            background: var(--danger-soft);
            color: var(--danger);
        }

        .status {
            border: 1px solid var(--success-line);
            background: var(--success-soft);
            color: var(--success);
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.83rem;
            font-weight: 700;
            color: #334155;
        }

        input[type="email"] {
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

        input[type="email"]:focus {
            outline: none;
            border-color: color-mix(in srgb, var(--accent) 48%, white);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 18%, white);
        }

        .actions {
            margin-top: 1rem;
            display: flex;
            gap: 0.8rem;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
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

        .back-link {
            color: #0369a1;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .back-link:hover { text-decoration: underline; }

        @keyframes settle {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <main class="card" aria-label="Admin password reset request">
        <section class="header">
            <h1>Reset Admin Password</h1>
            <p>Enter your admin account email to receive a password reset link.</p>
        </section>

        <section class="body">
            @if(session('status'))
                <div class="status" role="status">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf

                <div>
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="actions">
                    <a class="back-link" href="{{ route('filament.admin.auth.login') }}">Back to login</a>
                    <button type="submit" class="btn">Send Reset Link</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
