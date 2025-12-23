<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AgroLink Market</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS PERSONNALISÉ -->
    <style>

        /* Cible les liens de la navbar */
        .navbar-nav .nav-link {
            transition: color 0.3s ease;
            color: #4b5563 !important; /* Gris foncé par défaut */
        }

        /* Effet au survol */
        .navbar-nav .nav-link:hover {
            color: #198754 !important; /* Le vert "success" */
        }

        /* Style pour les liens du footer */
        a.footer-link {
            transition: color 0.3s ease; /* Animation douce pour le changement de couleur */
        }

        a.footer-link:hover {
            color: #198754 !important; /* Le vert 'success' de Bootstrap */
            text-decoration: underline !important; /* Optionnel : souligne au survol */
        }

        .hover-card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <main class="min-vh-100">
        @yield('content')
    </main>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @auth
    <script>
        setInterval(() => {
            fetch("{{ route('producteur.notifications') }}")
                .then(r => r.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    const count = data.length;

                    if (badge) {
                        if (count > 0) {
                            // Met à jour le chiffre et affiche le badge
                            badge.innerText = count;
                            badge.classList.remove('d-none');
                        } else {
                            // Cache le badge s'il n'y a plus de notifications
                            badge.classList.add('d-none');
                        }
                    }
                    console.log('Notifications synchronisées:', count);
                })
                .catch(err => console.error('Erreur de synchro notifications:', err));
        }, 30000); // 30 secondes
    </script>
    @endauth
    @include('partials.footer')
</body>
</html>
