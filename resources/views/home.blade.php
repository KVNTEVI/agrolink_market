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
                            <img src="https://images.unsplash.com/photo-1587049352846-4a222e7841b4"
                                 class="d-block w-100" alt="Soja">
                        </div>

                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93"
                                 class="d-block w-100" alt="Cacao">
                        </div>

                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1511690743698-d9d85f2fbf38"
                                 class="d-block w-100" alt="Café">
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

        <div class="row g-4">
            @foreach (['Cacao','Anacarde','Soja','Café'] as $cat)
            <div class="col-6 col-md-3">
                <div class="border rounded p-4 h-100 shadow-sm">
                    <i class="bi bi-box-seam fs-1 text-success"></i>
                    <h6 class="mt-3">{{ $cat }}</h6>
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
            @for ($i = 0; $i < 6; $i++)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="https://images.unsplash.com/photo-1587049352846-4a222e7841b4"
                         class="card-img-top" alt="Produit">
                    <div class="card-body">
                        <h6 class="card-title">Produit agricole</h6>
                        <p class="text-success fw-bold">25 000 FCFA / sac</p>
                        <a href="#" class="btn btn-sm btn-success w-100">
                            Voir
                        </a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- ================= CTA PRODUCTEUR ================= -->
<section class="py-5 bg-white">
    <div class="container text-center">
        <i class="bi bi-truck fs-1 text-success"></i>
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
