<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Halaman')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')

    <link rel="icon" href="{{ asset('favicon-v2.png') }}" type="image/png">

</head>

<body>

    <header>
        <!-- Header kustom -->
    </header>

    <main class="container mt-5">
        @yield('content')
    </main>

    <footer>
        <!-- Footer -->
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>

</html>
