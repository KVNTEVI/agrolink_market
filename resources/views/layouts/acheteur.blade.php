<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Acheteur') - AgroLink Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar - Strictement identique à ton Admin */
        .sidebar { 
            width: 260px; 
            background: #ffffff; 
            border-right: 1px solid rgba(0,0,0,0.05); 
            display: flex; 
            flex-direction: column;
            position: fixed;
            height: 100vh;
            box-shadow: 4px 0 10px rgba(0,0,0,0.02);
            z-index: 1050;
            transition: all 0.3s ease;
        }

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

        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active { 
            background-color: #f0fdf4; 
            color: #198754; 
            transform: translateX(5px);
        }

        .sidebar .nav-link i { font-size: 1.2rem; margin-right: 12px; }

        /* Contenu principal - Fond vert 10% comme l'Admin */
        .main-content { 
            flex: 1; 
            background-color: rgba(25, 135, 84, 0.1); 
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Bouton retour style Admin */
        .btn-outline-success {
            border-radius: 5px;
            font-weight: 600;
            border-width: 1.5px;
        }

        /* Bloc profil en bas style Admin */
        .user-profile-card {
            background-color: #ffffff;
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }

        /* AJOUTS RESPONSIVE (Strictement comme Admin/Producteur) */
        .mobile-admin-bar {
            display: none;
            background: #ffffff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 10px 15px;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        /* Overlay mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1045;
        }

        @media (max-width: 991.98px) {
            .mobile-admin-bar { 
                display: flex; 
                align-items: center; 
                justify-content: space-between;
            }
            .sidebar { left: -260px; }
            .sidebar.show { left: 0; }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="mobile-admin-bar shadow-sm">
    <button class="navbar-toggler border-0" type="button" onclick="toggleSidebar()">
        <i class="bi bi-list fs-2 text-success"></i>
    </button>
    <span class="fw-bold text-success">Acheteur AgroLink</span>
    <div style="width: 40px;"></div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="wrapper">
    <aside class="sidebar d-flex flex-column" id="sidebar">
        <div class="p-4 border-bottom text-center">
            <div class="text-success fw-bold fs-5 mb-3" style="letter-spacing: 1px;">
                <i class="bi bi-basket2-fill"></i> Acheteur
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-success btn-sm w-100 shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Vers le site
            </a>
        </div>

        <nav class="mt-3 flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('acheteur.dashboard') }}" class="nav-link {{ request()->routeIs('acheteur.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.commandes.index') }}" class="nav-link {{ request()->routeIs('acheteur.commandes.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i> Mes commandes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.paiements.index') }}" class="nav-link {{ request()->routeIs('acheteur.paiements.index') ? 'active' : '' }}">
                        <i class="bi bi-wallet2"></i> Paiements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.conversation.index') }}" class="nav-link {{ request()->routeIs('acheteur.messages.index') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.notifications.index') }}" class="nav-link {{ request()->routeIs('acheteur.notifications.index') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-bell"></i> Notifications</div>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.profil') }}" class="nav-link {{ request()->routeIs('acheteur.profil') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> Mon profil
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
                <button class="btn btn-sm btn-outline-danger w-100 py-2 d-flex align-items-center justify-content-center">
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
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
    document.getElementById('sidebarOverlay').onclick = function() {
        toggleSidebar();
    };
</script>
</body>
</html>