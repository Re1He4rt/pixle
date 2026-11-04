<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pixel Search Engine</title>

    <!-- Script Pencegah Layar Berkedip Putih (FOUC) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fef7ff] dark:bg-[#1d1b20] text-[#1d1b20] dark:text-[#e6e0e9] antialiased transition-colors duration-300">

    <main id="app">
        @yield('content')
    </main>

    @include('partials.pixel-overlay')

    @stack('scripts')
</body>
</html>
