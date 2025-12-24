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
            width: 250px;
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
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #f0fdf4;
            color: #198754;
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
                <li class="nav-item">
                    <a href="{{ route('acheteur.dashboard') }}" class="nav-link {{ request()->routeIs('acheteur.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-3"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-clock-history me-3"></i> Historique paiements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-chat-dots me-3"></i> Messages
                    </a>
                </li>

                <li class="nav-item">
                   <a href="{{ route('acheteur.notifications.index') }}" class="nav-link {{ request()->routeIs('acheteur.notifications.index') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-bell me-3"></i>
                            Notifications
                        </div>
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="badge bg-danger rounded-pill" id="sidebar-notification-badge">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('acheteur.profil') }}" class="nav-link">
                        <i class="bi bi-person-circle"></i>
                        Mon profil
                    </a>
                </li>

                
                <li class="mt-4 px-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger w-100 btn-sm d-flex align-items-center justify-content-center">
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
                
                // Mise à jour du badge Navbar (si ID existant)
                const badgeNav = document.getElementById('notification-badge');
                
                // Mise à jour du badge Sidebar
                const badgeSidebar = document.getElementById('sidebar-notification-badge');

                [badgeNav, badgeSidebar].forEach(badge => {
                    if (badge) {
                        if (count > 0) {
                            badge.innerText = count;
                            badge.classList.remove('d-none');
                        } else {
                            badge.classList.add('d-none');
                        }
                    }
                });
            })
            .catch(err => console.error('Erreur:', err));
    }, 30000);
</script>
@endauth

</body>
</html>