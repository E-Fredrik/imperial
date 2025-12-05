<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Imperial Kost')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        html, body{
            height: 100%;
            margin: 0;
        }
        body{
            display: flex;
            flex-direction: column;
        }
        main{
            flex: 1 0 auto;
        }
        footer{
            flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('components.navigation')
    <main>
        @yield('content')
    </main>
    @include('components.footer')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    @stack('scripts')
</body>
</html>