<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(to bottom right, #f9fafb, #e5e7eb);
            color: #111827;
        }

        header {
            padding: 1.5rem 2rem;
            text-align: center;
            font-weight: 600;
            font-size: 1.25rem;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 2rem;
            padding: 2rem;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        .btn-group {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            background-color: #2563eb;
            color: white;
            padding: 0.9rem 2.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .btn:hover {
            background-color: #1e40af;
            transform: translateY(-2px);
        }

        footer {
            background-color: #1f2937;
            color: #d1d5db;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: auto;
        }

        @media (max-width: 640px) {
            h1 { font-size: 1.75rem; }
            .btn { padding: 0.75rem 1.75rem; font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <header>
        {{ config('app.name', 'Laravel') }}
    </header>

    <main>
        <h1>Welcome to {{ config('app.name', 'Laravel') }}</h1>
        <div class="btn-group">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </footer>
</body>
</html>
