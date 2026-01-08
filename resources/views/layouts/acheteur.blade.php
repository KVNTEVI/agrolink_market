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
        
        .sidebar {
            width: 260px; /* Identique au producteur */
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            transition: all 0.3s;
        }

        .sidebar .nav-link {
            padding: 12px 20px;
            color: #4b5563;
            display: flex;
            align-items: center;
            transition: 0.3s;
            border-radius: 8px; /* Ajouté pour correspondre au producteur */
            margin: 2px 15px;  /* Ajouté pour correspondre au producteur */
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #f0fdf4;
            color: #198754;
        }

        /* Aligne parfaitement les icônes */
        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 12px;
            width: 24px; /* Fixe la largeur pour que le texte soit aligné */
            display: inline-block;
            text-align: center;
        }

        .main-content {
            flex: 1;
            background-color: #f9fafb;
        }

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }

        /* Couleur de base et forçage du survol en vert */
        .navbar-nav .nav-link {
            color: #4b5563 !important; /* Gris foncé de base */
            transition: color 0.3s ease !important;
        }

        /* Force le vert au passage de la souris */
        .navbar-nav .nav-link:hover {
            color: #198754 !important; /* Vert Succès */
        }

        /* Force le vert si le lien est actif */
        .navbar-nav .nav-link.active {
            color: #198754 !important;
            font-weight: 600;
        }

        /* Animation optionnelle : petit trait vert sous le lien au survol */
        .navbar-nav .nav-link {
            position: relative;
            font-weight: 500;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #198754;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        /* --- RESPONSIVITÉ --- */

/* Le voile noir qui couvre l'écran sur mobile quand le menu est ouvert */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1040;
}

@media (max-width: 991.98px) {
    .sidebar {
        position: fixed;
        left: -260px; /* On cache la sidebar à gauche */
        top: 0;
        height: 100vh;
        z-index: 1050;
        box-shadow: 5px 0 15px rgba(0,0,0,0.1);
    }

    /* Quand on ajoute la classe .show en JS, la sidebar glisse vers la droite */
    .sidebar.show {
        left: 0;
    }

    /* On affiche le voile noir */
    .sidebar-overlay.show {
        display: block;
    }

    /* Ajustement de la navbar pour le bouton mobile */
    .mobile-nav-toggle {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }
}

@media (min-width: 992px) {
    .mobile-nav-toggle {
        display: none; /* Cache le bouton menu sur ordinateur */
    }
}
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="wrapper">

    <aside class="sidebar" id="sidebar">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <span class="text-success fw-bold fs-5 mx-auto">
                <i class="bi bi-basket2-fill"></i> Acheteur
            </span>
            <button class="btn d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <nav class="mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('acheteur.dashboard') }}" class="nav-link {{ request()->routeIs('acheteur.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.commandes.index') }}" class="nav-link {{ request()->routeIs('acheteur.commandes.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i> Mes commandes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('acheteur.paiements.index') }}" class="nav-link {{ request()->routeIs('acheteur.paiements.index') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Historique paiements
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
                <li class="mt-4 px-3">
                    <form method="POST" action="{{ route('logout') }}">
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
        <div class="mobile-nav-toggle d-lg-none">
            <button class="btn btn-success" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="ms-3 fw-bold text-success">Menu tableau de bord</span>
        </div>

        @include('partials.navbar')

        <div class="p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
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

    // Fermer si on clique sur le voile noir
    document.getElementById('sidebarOverlay').onclick = function() {
        toggleSidebar();
    };
</script>

</body>
</html>