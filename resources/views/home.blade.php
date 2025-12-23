@extends('layouts.app')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="bg-success bg-opacity-10 py-5">
    <div class="container">
        <div class="row align-items-center">

            <!-- TEXTE -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="fw-bold text-success">
                    Bienvenue sur AgroLink Market
                </h1>
                <p class="text-muted mt-3">
                    La passerelle entre producteurs et acheteurs de produits agricoles de qualité.
                </p>

                <div class="mt-4">
                    <a href="{{ route('boutique.index') }}" class="btn btn-success me-2">
                        Voir les produits
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-success">
                        Devenir vendeur
                    </a>
                </div>
            </div>

            <!-- SLIDER -->
            <div class="col-lg-6">
                <div id="produitCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow">

                        <div class="carousel-item active">
                            <img src="{{ asset('images/slider/111.jpg') }}"
                                 class="d-block w-100" alt="Soja"
                                 style="height: 300px; object-fit: cover;">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('images/slider/2222.jpg') }}"
                                 class="d-block w-100" alt="Cacao"
                                 style="height: 300px; object-fit: cover;">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('images/slider/3333.jpg') }}"
                                 class="d-block w-100" alt="Café"
                                 style="height: 300px; object-fit: cover;">
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= CATÉGORIES ================= -->
<section class="py-5 bg-white">
    <div class="container text-center">
        <h3 class="fw-bold mb-4">Catégories populaires</h3>

        <div class="row g-4 justify-content-center">
            @foreach (['Cacao','Anacarde','Soja','Café'] as $cat)
            <div class="col-6 col-md-3">
                <div class="border rounded p-4 h-100 shadow-sm hover-card" style="cursor: pointer;">
                    @php
                        $nomFichier = Str::lower(Str::ascii($cat));
                    @endphp
                    <img src="{{ asset('images/icones/' . $nomFichier . '.png') }}" 
                         alt="{{ $cat }}" 
                         class="mb-3"
                         style="width: 32px; height: 32px; object-fit: contain;">
                    <h6 class="fw-bold text-dark">{{ $cat }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ================= PRODUITS PHARES ================= -->
<section class="py-5 bg-success bg-opacity-10">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Produits phares</h3>

        <div class="row g-4">
            @forelse ($produitsPhares as $produit)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="{{ asset('images/produits/' . $produit->image)}}"
                         class="card-img-top" alt="Produit"
                         style="height:200px; object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">{{ $produit->nom }}</h6>
                        <p class="text-success fw-bold">
                            {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA
                        </p>
                        <a href="{{ route('boutique.show', $produit->id_produit) }}" 
                           class="btn btn-sm btn-success mt-auto">
                            Voir le produit
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted text-center">Aucun produit phare disponible pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ================= CTA PRODUCTEUR ================= -->
<section class="py-5 bg-white">
    <div class="container text-center">
        <img src="{{ asset('images/icones/tracteur.png') }}" 
                         alt="{{ $cat }}" 
                         class="mb-3"
                         style="width: 64px; height: 64px; object-fit: contain;">
        <h4 class="fw-bold mt-3">
            Cultivez votre succès avec AgroLink Market
        </h4>
        <p class="text-muted">
            Vendez directement vos produits agricoles à des acheteurs fiables.
        </p>
        <a href="{{ route('register') }}" class="btn btn-success">
            Créer un compte producteur
        </a>
    </div>
</section>

@endsection
