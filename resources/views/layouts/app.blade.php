<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AgroLink Market</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS PERSONNALISÉ -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    @include('partials.navbar')

    <main class="min-vh-100">
        @yield('content')
    </main>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @include('partials.footer')
</body>
</html>
