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
    </style>
</head>
<body>

<div class="wrapper">

    <aside class="sidebar">
        <div class="p-3 border-bottom text-center text-success fw-bold fs-5">
            <i class="bi bi-leaf-fill"></i> AgroLink Ach
        </div>
        
        <nav class="mt-3">
            <ul class="nav flex-column">
                {{-- Tableau de bord --}}
                <li class="nav-item">
                    <a href="{{ route('acheteur.dashboard') }}" class="nav-link {{ request()->routeIs('acheteur.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Tableau de bord
                    </a>
                </li>

                {{-- Mes Commandes (NOUVEAU) --}}
                <li class="nav-item">
                    <a href="{{ route('acheteur.commandes.index') }}" class="nav-link {{ request()->routeIs('acheteur.commandes.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i> Mes commandes
                    </a>
                </li>
                
                {{-- Historique Paiements --}}
                <li class="nav-item">
                    <a href="{{ route('acheteur.paiements.index') }}" class="nav-link {{ request()->routeIs('acheteur.paiements.index') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Historique paiements
                    </a>
                </li>

                {{-- Messages --}}
                <li class="nav-item">
                    <a href="{{ route('acheteur.conversation.index') }}" class="nav-link {{ request()->routeIs('acheteur.messages.index') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> Messages
                    </a>
                </li>

                {{-- Notifications --}}
                <li class="nav-item">
                <a href="{{ route('acheteur.notifications.index') }}" class="nav-link {{ request()->routeIs('acheteur.notifications.index') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-bell"></i> Notifications
                        </div>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger rounded-pill">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </li>

                {{-- Mon profil --}}
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
        @include('partials.navbar')

        <div class="p-4">
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

{{-- Ton script de notifications est conservé ici --}}

</body>
</html>