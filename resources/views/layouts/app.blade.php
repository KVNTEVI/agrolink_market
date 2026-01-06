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
    /* 1. Cible les liens de la navbar horizontale */
    .navbar-nav .nav-link {
        transition: color 0.3s ease;
        color: #4b5563 !important; /* Gris foncé par défaut */
        font-weight: 500;
    }

    /* 2. Effet au survol (HOVER) ET état ACTIF (page actuelle) */
    .navbar-nav .nav-link:hover, 
    .navbar-nav .nav-link.active {
        color: #198754 !important; /* Le vert "success" */
    }

    /* 3. Petit trait vert optionnel sous le lien actif pour un look moderne */
    .navbar-nav .nav-link.active {
        border-bottom: 2px solid #198754;
        padding-bottom: 4px;
    }

    /* 4. Style pour les liens du footer */
    a.footer-link {
        transition: color 0.3s ease;
        text-decoration: none;
        color: inherit; /* Garde la couleur du parent par défaut */
    }

    a.footer-link:hover {
        color: #198754 !important;
        text-decoration: underline !important;
    }

    .navbar-nav .nav-link {
    position: relative;
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

    /* 5. Animation des cartes (Boutique/Dashboard) */
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
    }

    /* 6. Correction pour les icônes dans la navbar (cloche, panier) */
    .nav-link i {
        transition: color 0.3s ease;
    }
    
    .nav-link:hover i {
        color: #198754 !important;
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
