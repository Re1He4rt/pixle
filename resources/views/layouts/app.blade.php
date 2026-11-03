<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Wajib ada untuk CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pixel Search</title>

    <!-- Wajib ada untuk memanggil CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fef7ff] antialiased">
    <main id="app">
        @yield('content')
    </main>

    @include('partials.pixel-overlay')

    @stack('scripts')
</body>
</html>
