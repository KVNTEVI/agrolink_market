@extends('layouts.app')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="py-5" style="background-color: rgba(25, 135, 84, 0.08);">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="fw-bold text-success display-5">
                    Bienvenue sur AgroLink Market
                </h1>
                <p class="text-dark mt-3 fs-5">
                    La passerelle entre producteurs et acheteurs de produits agricoles de qualité. Profitez du circuit court pour vos récoltes.
                </p>

                <div class="mt-4">
                    <a href="{{ route('boutique.index') }}" class="btn btn-success btn-lg me-2 rounded-pill px-4 shadow-sm hero-btn">
                        <i class="bi bi-cart3 me-2"></i>Voir les produits
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg rounded-pill px-4 hero-btn-outline">
                        Devenir vendeur
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div id="produitCarousel" class="carousel slide hero-slider" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-1 shadow-lg">

                        <div class="carousel-item active">
                            <img src="{{ asset('images/slider/111.jpg') }}"
                                 class="d-block w-100 image-overlay" alt="Soja"
                                 style="height: 400px; object-fit: cover;">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('images/slider/2222.jpg') }}"
                                 class="d-block w-100 image-overlay" alt="Cacao"
                                 style="height: 400px; object-fit: cover;">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('images/slider/3333.jpg') }}"
                                 class="d-block w-100 image-overlay" alt="Café"
                                 style="height: 400px; object-fit: cover;">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= CATÉGORIES ================= -->
<section class="py-5 bg-white">
    <div class="container"> {{-- Suppression de text-center ici --}}
        
        <div class="mb-5">
            <h3 class="fw-bold mb-1 text-dark text-start">Catégories <span class="text-success">Populaires</span></h3>
            <p class="text-dark text-start">Naviguez par filières pour trouver vos produits</p>
        </div>

        <div class="row g-4 justify-content-start"> {{-- Alignement du contenu à gauche --}}
            @foreach (['Cacao','Anacarde','Soja','Café'] as $cat)
            <div class="col-6 col-md-3">
                <div class="category-item text-center"> {{-- On garde le centre pour l'icône elle-même --}}
                    <div class="category-icon-wrapper shadow-sm">
                        @php
                            $nomFichier = Str::lower(Str::ascii($cat));
                        @endphp
                        <img src="{{ asset('images/icones/' . $nomFichier . '.png') }}" 
                             alt="{{ $cat }}" 
                             class="category-icon">
                    </div>
                    <h6 class="fw-bold text-dark mt-3 mb-0">{{ $cat }}</h6>
                    <small class="text-success fw-medium opacity-75">Voir les produits</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ================= PRODUITS PHARES ================= -->
<section class="py-5" style="background-color: rgba(25, 135, 84, 0.05);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold mb-0">Produits <span class="text-success">Phares</span></h3>
                <p class="text-dark mb-0">Les meilleures offres sélectionnées pour vous.</p>
            </div>
            <a href="{{ route('boutique.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">Voir tout</a>
        </div>

        <div class="row g-4">
            @forelse ($produitsPhares as $produit)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card rounded-4 overflow-hidden">
                    
                    <div class="position-relative overflow-hidden">
                        <img src="{{ asset('images/produits/' . $produit->image)}}"
                             class="card-img-top img-zoom" 
                             alt="{{ $produit->nom }}"
                             style="height:200px; object-fit:cover;">
                        
                        <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.8rem;">
                            {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA
                        </span>
                    </div>

                    <div class="card-body p-3 d-flex flex-column bg-white">
                        <small class="text-success fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                            Agriculture Locale
                        </small>
                        <h6 class="card-title fw-bold text-dark mt-1 text-truncate">{{ $produit->nom }}</h6>
                        
                        <div class="mb-3 mt-1">
                            <span class="text-dark small">Unité de vente: <strong>1 Kg</strong></span>
                        </div>

                        <div class="d-grid mt-auto">
                            <a href="{{ route('boutique.show', $produit->id_produit) }}" 
                               class="btn btn-sm btn-outline-success rounded-pill fw-bold py-2 transition-all">
                                <i class="bi bi-eye me-1"></i> Voir détail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Aucun produit phare disponible pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ================= CTA PRODUCTEUR ================= -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="cta-banner p-4 p-md-5 rounded-5 shadow-sm border-0 position-relative overflow-hidden" 
             style="background-color: rgba(25, 135, 84, 0.05);">
            
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-2 text-center text-lg-start mb-4 mb-lg-0">
                    <div class="icon-box bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center tractor-icon" 
                         style="width: 100px; height: 100px;">
                        <img src="{{ asset('images/icones/tracteur.png') }}" 
                             alt="Tracteur" 
                             style="width: 60px; height: 60px; object-fit: contain;">
                    </div>
                </div>

                <div class="col-lg-6 text-center text-lg-start">
                    <h4 class="fw-bold text-dark mb-1">
                        Cultivez votre succès avec <span class="text-success">AgroLink Market</span>
                    </h4>
                    
                    <p class="text-dark mb-0 fs-6">
                        Rejoignez notre réseau de producteurs et vendez directement vos récoltes à des acheteurs fiables.
                    </p>
                </div>

                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <div class="position-relative d-inline-block">
                        <a href="{{ route('register') }}" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm cta-button pe-5 ps-4 py-3">
                            <i class="bi bi-person-plus-fill me-2"></i>Devenir Producteur
                        </a>
                        <div class="badge-validation shadow">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Conteneur global de l'item catégorie */

.hero-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.2) !important;
    }

    .hero-btn-outline {
        transition: all 0.3s ease;
        border: 2px solid #198754;
    }
    .hero-btn-outline:hover {
        background-color: #198754;
        color: white;
        transform: translateY(-3px);
    }

    /* 2. Style du Slider */
    .hero-slider {
        border: 8px solid #198754;
        border-radius: 10px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .rounded-4 {
        border-radius: 1.5rem !important;
    }

    /* 3. Animation d'entrée douce pour les images */
    .carousel-item img {
        transition: transform 5s ease;
    }
    .carousel-item.active img {
        transform: scale(1.05); /* Léger zoom lent quand l'image est active */
    }

    /* 4. Overlay léger sur les images pour faire ressortir la qualité */
    .image-overlay {
        filter: brightness(0.95) contrast(1.05);
    }
    .category-item {
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 10px;
    }

    /* Le cercle autour de l'icône */
    .category-icon-wrapper {
        width: 100px;
        height: 100px;
        background-color: rgba(25, 135, 84, 0.05); /* Fond vert 5% */
        border: 2px solid transparent;
        border-radius: 50%;
        margin: 0 auto; /* Centre le cercle dans sa colonne */
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .category-icon {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    /* Effets au survol */
    .category-item:hover .category-icon-wrapper {
        background-color: #ffffff;
        border-color: #198754;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(25, 135, 84, 0.12) !important;
    }

    .category-item:hover h6 {
        color: #198754 !important;
    }

    /* Mobile */
    @media (max-width: 576px) {
        .category-icon-wrapper {
            width: 85px;
            height: 85px;
        }
    }


    /* Carte Produit */
    .product-card {
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(25, 135, 84, 0.15) !important;
    }

    /* Animation de zoom sur l'image */
    .img-zoom {
        transition: transform 0.5s ease;
    }

    .product-card:hover .img-zoom {
        transform: scale(1.1);
    }

    /* Arrondi moderne */
    .rounded-4 {
        border-radius: 1rem !important;
    }

    /* Bouton transition */
    .transition-all {
        transition: all 0.2s;
    }

    .cta-banner {
        border: 1px solid rgba(25, 135, 84, 0.1) !important;
    }

    .rounded-5 { border-radius: 2rem !important; }

    /* Style du bouton */
    .cta-button {
        position: relative;
        z-index: 1;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    
    .badge-validation {
        position: absolute;
        top: -10px;       /* Ajuste la hauteur */
        right: -10px;     /* Sort un peu du bouton pour l'aérer */
        background-color: #198754;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 4px solid #f8fdfa; /* Crée une séparation visuelle avec le fond */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        font-size: 1.2rem;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        background-color: #146c43;
    }

    .cta-banner:hover .badge-validation {
        transform: rotate(15deg) scale(1.1);
        transition: 0.3s;
    }

    /* Icône tracteur */
    .tractor-icon:hover {
        transform: rotate(15deg) scale(1);
        transition: transform 0.3s ease;
    }
</style>

@endsection
