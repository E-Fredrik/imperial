<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Imperial Kost')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
    
    {{-- Render modals at the end of body --}}
    @stack('modals')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>