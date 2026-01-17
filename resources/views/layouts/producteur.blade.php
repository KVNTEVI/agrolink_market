<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Producteur') - AgroLink Market</title>
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
        }

        /* Liens de navigation style Admin */
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

        /* Contenu principal sur fond vert 10% comme l'Admin */
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

        /* Bloc profil style Admin */
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
                <i class="bi bi-shop"></i> Producteur
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-success btn-sm w-100 shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Vers le site
            </a>
        </div>

        <nav class="mt-3 flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('producteur.dashboard') }}" class="nav-link {{ request()->routeIs('producteur.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('producteur.produit.index') }}" class="nav-link {{ request()->routeIs('producteur.produit.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Mes produits
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('producteur.commandes.index') }}" class="nav-link {{ request()->routeIs('producteur.commandes.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check"></i> Commandes reçues
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('producteur.conversation.index') }}" class="nav-link {{ request()->routeIs('producteur.conversation.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> Messagerie
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('producteur.notifications') }}" class="nav-link {{ request()->routeIs('producteur.notifications') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-bell"></i> Notifications</div>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger rounded-pill" id="sidebar-notification-badge">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('producteur.profil') }}" class="nav-link {{ request()->routeIs('producteur.profil') ? 'active' : '' }}">
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

@auth
<script>
    setInterval(() => {
        fetch("{{ route('producteur.notifications') }}")
            .then(r => r.json())
            .then(data => {
                const count = data.length;
                const badgeSidebar = document.getElementById('sidebar-notification-badge');
                if (badgeSidebar) {
                    if (count > 0) {
                        badgeSidebar.innerText = count;
                        badgeSidebar.classList.remove('d-none');
                    } else {
                        badgeSidebar.classList.add('d-none');
                    }
                }
            })
            .catch(err => console.error('Erreur notifications:', err));
    }, 30000);
</script>
@endauth

</body>
</html>