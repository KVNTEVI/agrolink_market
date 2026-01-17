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
    
    /* Sidebar plus moderne */
    .sidebar { 
        width: 260px; 
        background: #ffffff; 
        border-right: 1px solid rgba(0,0,0,0.05); 
        display: flex; 
        flex-direction: column;
        position: fixed;
        height: 100vh;
        box-shadow: 4px 0 10px rgba(0,0,0,0.02); /* Ombre légère pour décoller du fond */
    }

    /* Liens de navigation avec transition */
    .sidebar .nav-link { 
        padding: 12px 20px; 
        color: black; 
        display: flex; 
        align-items: center; 
        border-radius: 10px; 
        margin: 4px 15px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    /* Style Actif : fond vert très clair et texte vert foncé */
    .sidebar .nav-link:hover, 
    .sidebar .nav-link.active { 
        background-color: #f0fdf4; 
        color: #198754; 
        transform: translateX(5px); /* Petit effet de mouvement au survol */
    }

    .sidebar .nav-link i { font-size: 1.2rem; margin-right: 12px; }

    /* Contenu principal sur ton fond vert 10% */
    .main-content { 
        flex: 1; 
        background-color: rgba(25, 135, 84, 0.1); 
        margin-left: 260px;
    }

    /* Bouton retour arrondi type pilule */
    .btn-outline-success {
        border-radius: 5px;
        font-weight: 600;
        border-width: 1.5px;
    }

    /* Bloc profil en bas plus "Card" */
    .user-profile-card {
        background-color: #ffffff;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    }
</style>
</head>
<body>
<div class="wrapper">
    <aside class="sidebar d-flex flex-column">
        <div class="p-4 border-bottom text-center">
            <div class="text-success fw-bold fs-5 mb-3" style="letter-spacing: 1px;">
                <i class="bi bi-shield-check"></i> Administrateur
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-success btn-sm w-100 shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Vers le site
            </a>
        </div>

        <nav class="mt-3 flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i> Tableau de bord
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
                        <i class="bi bi-box-seam"></i> Modérer les Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paiements.index') }}" class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}">
                        <i class="bi bi-wallet2"></i> Paiements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.notifications') }}" class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
                        <div>
                            <i class="bi bi-bell"></i> Notifications
                        </div>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-3 border-top bg-light bg-opacity-50">
            <div class="user-profile-card d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nom }}&background=198754&color=fff"
                    alt="avatar" width="38" height="38" class="rounded-circle me-2 shadow-sm">
                
                <div class="overflow-hidden">
                    <div class="fw-bold text-dark text-truncate small">{{ Auth::user()->nom }}</div>
                    <div class="text-muted text-truncate" style="font-size: 0.7rem;">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-danger w-100 py-2">
                    <i class="bi bi-power me-2"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>