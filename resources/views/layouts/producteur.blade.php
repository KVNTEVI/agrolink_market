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
        
        .sidebar {
            width: 260px;
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
            border-radius: 8px;
            margin: 2px 15px;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #f0fdf4;
            color: #198754;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 12px;
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
    </style>
</head>
<body>

<div class="wrapper">

        <aside class="sidebar">
            <div class="p-3 border-bottom text-center text-success fw-bold fs-5">
                <i class="bi bi-shop"></i> Producteur
            </div>
            
            <nav class="mt-3">
                <ul class="nav flex-column">
                    {{-- Tableau de bord --}}
                    <li class="nav-item">
                        <a href="{{ route('producteur.dashboard') }}" class="nav-link {{ request()->routeIs('producteur.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Tableau de bord
                        </a>
                    </li>

                    {{-- Gestion des Produits --}}
                    <li class="nav-item">
                        {{-- Utilisation de produit.* pour englober index, create, edit --}}
                        <a href="{{ route('producteur.produit.index') }}" class="nav-link {{ request()->routeIs('producteur.produit.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> Mes produits
                        </a>
                    </li>

                    {{-- Gestion des Commandes --}}
                    <li class="nav-item">
                        <a href="{{ route('producteur.commandes.index') }}" class="nav-link {{ request()->routeIs('producteur.commandes.*') ? 'active' : '' }}">
                            <i class="bi bi-bag-check"></i> Commandes reçues
                        </a>
                    </li>

                    {{-- Messagerie / Négociations --}}
                    <li class="nav-item">
                        <a href="{{ route('producteur.conversation.index') }}"  class="nav-link {{ request()->routeIs('producteur.conversation.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-dots"></i> Messagerie
                        </a>
                    </li>

                    {{-- Notifications --}}
                    <li class="nav-item">
                        <a href="{{ route('producteur.notifications') }}" class="nav-link {{ request()->routeIs('producteur.notifications') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-bell"></i> Notifications
                            </div>
                            @if(auth()->user()->unreadNotifications->count())
                                <span class="badge bg-danger rounded-pill" id="sidebar-notification-badge">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Profil --}}
                    <li class="nav-item">
                        <a href="{{ route('producteur.profil') }}" class="nav-link {{ request()->routeIs('producteur.profil') ? 'active' : '' }}">
                            <i class="bi bi-person-circle"></i> Mon profil
                        </a>
                    </li>

                    {{-- Déconnexion --}}
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
        @include('partials.navbar') <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@auth
<script>
    // Script de mise à jour automatique des badges de notification
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
    }, 30000); // 30 secondes
</script>
@endauth

</body>
</html>