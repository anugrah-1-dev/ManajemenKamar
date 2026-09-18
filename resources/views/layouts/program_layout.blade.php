<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Program Brilliant English Course')</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('favicon-v2.png') }}" type="image/png">


    {{-- Styles tambahan dari child --}}
    @yield('styles')
</head>

<body>
    <div id="app">
        {{-- Navbar selalu ada di atas --}}
        @include('navbar.navbar')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script tambahan dari child --}}
    @yield('scripts')
</body>

</html>
