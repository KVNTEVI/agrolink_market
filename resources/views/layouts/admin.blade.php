<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin AgroLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>

    /* Animation de la flèche pour les sous-menus */
    .nav-link .ms-auto {
        transition: transform 0.3s ease;
    }
    .nav-link[aria-expanded="true"] .ms-auto {
        transform: rotate(180deg);
    }

    /* Style des sous-liens */
    .submenu .nav-link {
        margin: 2px 15px 2px 35px !important;
        font-size: 0.85rem;
        padding: 8px 15px !important;
    }
    
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
        z-index: 1050;
        transition: transform 0.3s ease; /* Ajout transition pour le menu mobile */
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
        text-decoration: none;
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
        min-width: 0;
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

    /* --- AJOUTS POUR LE RESPONSIVE --- */
    
    /* Le bouton hamburger style Navbar */
    .mobile-admin-bar {
        display: none;
        background: #ffffff;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 10px 15px;
        position: sticky;
        top: 0;
        z-index: 1040;
    }

    @media (max-width: 991px) {
        .mobile-admin-bar { 
            display: flex; 
            align-items: center; 
            justify-content: space-between;
        }
        .sidebar { transform: translateX(-100%); } /* Cache la sidebar */
        .sidebar.show { transform: translateX(0); } /* Affiche la sidebar */
        .main-content { margin-left: 0; } /* Contenu pleine largeur */
        
        /* Overlay sombre quand le menu est ouvert */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1045;
        }
        .sidebar-overlay.active { display: block; }
    }
</style>
</head>
<body>

<div class="mobile-admin-bar shadow-sm">
    <button class="navbar-toggler border-0" type="button" id="mobile-toggle">
        <i class="bi bi-list fs-2 text-success"></i>
    </button>
    <span class="fw-bold text-success">Admin AgroLink</span>
    <div style="width: 40px;"></div> </div>

<div class="sidebar-overlay" id="overlay"></div>

<div class="wrapper">
    <aside class="sidebar d-flex flex-column" id="adminSidebar">
        <div class="p-4 border-bottom text-center">
            <div class="text-success fw-bold fs-5 mb-3" style="letter-spacing: 1px;">
                <i class="bi bi-shield-check"></i> Administrateur
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-success btn-sm w-100 shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Vers le site
            </a>
        </div>

        <nav class="mt-3 flex-grow-1 overflow-auto">
            <ul class="nav flex-column">
                
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i> Tableau de bord
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.utilisateurs.*') ? 'active' : '' }}" 
                    data-bs-toggle="collapse" href="#menuUsers" role="button" 
                    aria-expanded="{{ request()->routeIs('admin.utilisateurs.*') ? 'true' : 'false' }}">
                        <i class="bi bi-people"></i> Communauté
                        <i class="bi bi-chevron-down ms-auto small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.utilisateurs.*') ? 'show' : '' }}" id="menuUsers">
                        <ul class="nav flex-column submenu">
                            <li>
                                <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link">
                                    Liste des utilisateurs
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.produits.*') || request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                    data-bs-toggle="collapse" href="#menuCatalog" role="button" 
                    aria-expanded="{{ request()->routeIs('admin.produits.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }}">
                        <i class="bi bi-box-seam"></i> Catalogue
                        <i class="bi bi-chevron-down ms-auto small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.produits.*') || request()->routeIs('admin.categories.*') ? 'show' : '' }}" id="menuCatalog">
                        <ul class="nav flex-column submenu">
                            <li>
                                <a href="{{ route('admin.produits.index') }}" class="nav-link">Modérer les produits</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.index') }}" class="nav-link">Catégories</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}" 
                    data-bs-toggle="collapse" href="#menuFinance" role="button" 
                    aria-expanded="{{ request()->routeIs('admin.paiements.*') ? 'true' : 'false' }}">
                        <i class="bi bi-wallet2"></i> Finance
                        <i class="bi bi-chevron-down ms-auto small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.paiements.*') ? 'show' : '' }}" id="menuFinance">
                        <ul class="nav flex-column submenu">
                            <li>
                                <a href="{{ route('admin.paiements.index') }}" class="nav-link">Paiements</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.notifications') }}" class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
                        <i class="bi bi-bell"></i> 
                        <span>Notifications</span>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger rounded-pill ms-auto">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.profil') }}" class="nav-link {{ request()->routeIs('admin.profil') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> Mon Profil
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
        <div class="p-4 pt-lg-4"> 
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

<script>
    const mobileToggle = document.getElementById('mobile-toggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('overlay');

    // Fonction pour basculer le menu
    function toggleSidebar() {
        adminSidebar.classList.toggle('show');
        overlay.classList.toggle('active');
    }

    mobileToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Fermer le menu si on clique sur un lien (sur mobile)
    const navLinks = document.querySelectorAll('.sidebar .nav-link:not([data-bs-toggle="collapse"])');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if(window.innerWidth < 992) toggleSidebar();
        });
    });
</script>
</body>
</html>