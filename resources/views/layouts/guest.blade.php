<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Imperial') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS (CDN) - required for components/navigation -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Vite / app CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#000; color:#FAEBD7; min-height:100vh; margin:0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;">
    @include('components.navigation')

    <main style="min-height:calc(100vh - 80px); display:flex; align-items:center; justify-content:center; padding:3rem 1rem;">
        <div style="width:100%; max-width:520px;">
            <div style="text-align:center; margin-bottom:1.25rem;">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/imperial-kost-logo.png') }}" alt="{{ config('app.name', 'Imperial') }} Logo" style="height:72px; display:inline-block;">
                </a>
            </div>

            <div style="background:#0a0a0a; padding:2rem; border-radius:12px; color:#FAEBD7; box-shadow:0 8px 30px rgba(0,0,0,0.6);">
                {{ $slot }}
            </div>

            <div style="text-align:center; margin-top:1rem; color:#cfc6bc; font-size:0.9rem;">
                <a href="{{ route('home') }}" style="color:#cfc6bc; text-decoration:none; margin-right:1rem;">Home</a>
                <a href="{{ route('login') }}" style="color:#cfc6bc; text-decoration:none; margin-right:1rem;">Log in</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" style="color:#FAEBD7; font-weight:600; text-decoration:none;">Register</a>
                @endif
            </div>
        </div>
    </main>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
