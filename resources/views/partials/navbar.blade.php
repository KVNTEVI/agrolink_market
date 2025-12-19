<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="/">
            <i class="bi bi-leaf-fill fs-4 me-2"></i>
            AgroLink Market
        </a>

        <!-- TOGGLE MOBILE -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <!-- LIENS -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apropos') }}">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('boutique.index') }}">Boutique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('magazin.index') }}">Magazin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.index') }}">Contact</a>
                </li>
            </ul>

            <!-- PANIER + AUTH -->
            <div class="d-flex align-items-center gap-3">

                <!-- PANIER -->
                <a href="{{ route('acheteur.panier.index') }}" class="text-dark fs-5">
                    <i class="bi bi-cart"></i>
                </a>

                @guest
                    <!-- CONNEXION -->
                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
                        Connexion
                    </a>

                    <!-- INSCRIPTION -->
                    <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                        Inscription
                    </a>
                @else
                    <!-- UTILISATEUR CONNECTÉ -->
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle"
                           href="#" data-bs-toggle="dropdown">

                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nom }}"
                                 alt="avatar"
                                 width="32"
                                 height="32"
                                 class="rounded-circle me-2">

                            <span class="fw-semibold">
                                {{ Auth::user()->nom }}
                            </span>
                        </a>

                      <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @php
                                    // On fait correspondre le nom en BDD avec le nom de la route
                                    $routeName = match(Auth::user()->role->nom_role) {
                                        'Administrateur' => 'admin.dashboard',
                                        'Producteur'     => 'producteur.dashboard',
                                        'Acheteur'       => 'acheteur.dashboard',
                                        default          => 'home'
                                    };
                                @endphp
                                
                                <a class="dropdown-item" href="{{ route($routeName) }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
