<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TradersCap - Find Your Best Broker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-indigo-600">TradersCap</h1>
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
                    @endif
                @endauth

                @if(auth('admin')->check())
                    <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-gray-900">Admin Panel</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h2 class="text-5xl font-bold text-gray-900 mb-4">Find Your Best Broker</h2>
            <p class="text-xl text-gray-600 mb-8">Take our quick quiz to discover the forex broker that matches your trading needs</p>
            <a href="{{ route('quiz') }}" class="inline-block px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                Start Quiz →
            </a>
        </div>
    </div>
</body>
</html>
