<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="/">
            <i class="bi bi-leaf-fill fs-4 me-2"></i>
            AgroLink Market
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('apropos') ? 'active' : '' }}" href="{{ route('apropos') }}">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('boutique.index') ? 'active' : '' }}" href="{{ route('boutique.index') }}">Boutique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('magazin.index') ? 'active' : '' }}" href="{{ route('magazin.index') }}">Magazin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index') }}">Contact</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('acheteur.panier.index') }}" class="nav-link position-relative">
                    <i class="bi bi-cart"></i>
                    @if(isset($panierCount) && $panierCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $panierCount }}
                        </span>
                    @endif
                </a>

                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
                        Connexion
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                        Inscription
                    </a>
                @else
                    
                    <li class="nav-item dropdown" style="list-style: none;">
                        <a class="nav-link position-relative" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <i class="bi bi-bell "></i>

                            @if(auth()->user()->unreadNotifications->count())
                                <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width:320px">
                            <li class="px-3 py-2 fw-bold border-bottom">Notifications</li>
                            
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li class="px-3 py-2 border-bottom">
                                    @php
                                        // Détermination dynamique de la route selon le type de notification
                                        $targetRoute = '#';
                                        if (isset($notification->data['conversation_id'])) {
                                            $targetRoute = route(auth()->user()->role_id == 3 
                                                ? 'producteur.conversation.show' 
                                                : 'acheteur.conversation.show', 
                                                $notification->data['conversation_id']);
                                        } elseif (isset($notification->data['commande_id'])) {
                                            $targetRoute = auth()->user()->role_id == 3 
                                                ? route('producteur.commandes.index') 
                                                : route('acheteur.commandes.show', $notification->data['commande_id']);
                                        }
                                    @endphp

                                    <a href="{{ $targetRoute }}" class="text-decoration-none text-dark">
                                        <div class="small text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>

                                        <div class="fw-semibold" style="font-size: 0.85rem;">
                                            {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                        </div>

                                        @if(isset($notification->data['montant']))
                                            <div class="small text-success fw-bold">
                                                {{ number_format($notification->data['montant'], 0, ',', ' ') }} FCFA
                                            </div>
                                        @endif
                                    </a>

                                    <form method="POST" action="{{ route('producteur.notifications.read', $notification->id) }}" class="mt-1">
                                        @csrf
                                        <button class="btn btn-sm btn-link p-0 text-decoration-none text-muted" style="font-size: 0.65rem;">
                                            Marquer comme lu
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="px-3 py-3 text-center text-muted small">
                                    Aucune notification
                                </li>
                            @endforelse
                        </ul>
                    </li>

                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle"
                           href="#" data-bs-toggle="dropdown">

                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nom }}&background=198754&color=fff"
                                 alt="avatar"
                                 width="32"
                                 height="32"
                                 class="rounded-circle me-2">

                            <span class="fw-semibold">
                                {{ Auth::user()->nom }}
                            </span>
                        </a>

                      <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                @php
                                    $routeName = match(Auth::user()->role->nom_role) {
                                        'administrateur' => 'admin.dashboard',
                                        'producteur'     => 'producteur.dashboard',
                                        'acheteur'       => 'acheteur.dashboard',
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