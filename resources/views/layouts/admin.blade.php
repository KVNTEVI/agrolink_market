<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin AgroLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #fff; border-right: 1px solid #e5e7eb; }
        .sidebar .nav-link { padding: 12px 20px; color: #4b5563; display: flex; align-items: center; border-radius: 8px; margin: 2px 15px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #f0fdf4; color: #198754; }
        .sidebar .nav-link i { font-size: 1.2rem; margin-right: 12px; }
        .main-content { flex: 1; background-color: #f9fafb; }
        .card-stats { border: none; border-radius: 12px; transition: transform 0.3s; }
        .card-stats:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
<div class="wrapper">
    <aside class="sidebar">
        <div class="p-3 border-bottom text-center text-success fw-bold fs-5">
            <i class="bi bi-shield-check"></i> AgroLink Admin
        </div>
        <nav class="mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link {{ request()->routeIs('admin.utilisateurs.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Utilisateurs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Catégories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.produits.index') }}" class="nav-link {{ request()->routeIs('admin.produits.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Modération Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paiements.index') }}" class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i> Paiements
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="mt-4 px-3">
                        @csrf
                        <button class="btn btn-outline-danger w-100 btn-sm d-flex align-items-center justify-content-center py-2">
                            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        @include('partials.navbar')
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>