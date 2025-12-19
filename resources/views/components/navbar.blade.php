<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="{{ route('accueil') }}">
            <i class="fas fa-seedling me-2"></i>AgroMarket
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('accueil') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('boutique.index') }}">Boutique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('magazin.index') }}">Producteurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('a-propos') }}">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact.index') }}">Contact</a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <!-- Panier -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                </li>
                
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success ms-2" href="{{ route('register') }}">Créer un compte</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->nom }}
                        </a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->role->nom === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                            @elseif(Auth::user()->role->nom === 'producteur')
                                <li><a class="dropdown-item" href="{{ route('producteur.dashboard') }}">Dashboard Producteur</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('acheteur.dashboard') }}">Mon compte</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>