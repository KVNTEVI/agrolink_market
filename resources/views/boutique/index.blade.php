@extends('layouts.app')

@section('content')

<section class="py-5 text-center" style="background-color: rgba(25, 135, 84, 0.1);">
    <div class="container">
        <h2 class="fw-bold text-success display-6">Boutique AgroLink Market</h2>
        <p class="text-dark">Découvrez des produits agricoles locaux de qualité, directement du champ à votre table.</p>
    </div>
</section>

<section class="py-5" style="background-color: rgba(25, 135, 84, 0.05); min-height: 100vh;">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 1000;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-funnel me-2 text-success"></i>Filtrer</h5>

                        <form method="GET" action="{{ route('boutique.index') }}">
                            <div class="mb-3">
                                <label class="small fw-bold text-muted mb-2">Rechercher</label>
                                <div class="input-group border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-0 shadow-none" 
                                           placeholder="Ex: soja, café..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="small fw-bold text-muted mb-2">Catégorie</label>
                                    <select name="categorie" class="form-select border-1 rounded-3 shadow-none">
                                        <option value="">Toutes les catégories</option>
                                        @foreach($categories as $categorie)
                                            {{-- Remplace ->id par ->id_categorie ici --}}
                                            <option value="{{ $categorie->id_categorie }}" {{ request('categorie') == $categorie->id_categorie ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>

                            <button class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-sm transition-all">
                                <i class="bi bi-sliders me-2"></i>Appliquer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">

                    @forelse($produits as $produit)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm product-card rounded-4 overflow-hidden">
                                
                                {{-- Conteneur Image avec Badge --}}
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ asset('images/produits/'.$produit->image) }}"
                                         class="card-img-top img-zoom"
                                         style="height:220px; object-fit:cover;"
                                         alt="{{ $produit->nom }}">
                                    
                                    {{-- Badge de catégorie optionnel si tu as la relation --}}
                                    @if($produit->categorie)
                                    <span class="badge bg-white text-success position-absolute top-0 start-0 m-3 shadow-sm rounded-pill px-3">
                                        {{ $produit->categorie->nom }}
                                    </span>
                                    @endif
                                </div>

                                <div class="card-body p-4 d-flex flex-column bg-white">
                                    <h5 class="fw-bold text-dark mb-1">{{ $produit->nom }}</h5>
                                    
                                    <p class="text-muted small mb-3">
                                        {{ Str::limit($produit->description, 50) }}
                                    </p>

                                    <div class="mb-3">
                                        <span class="text-success fw-bolder fs-5">
                                            {{ number_format($produit->prix_unitaire, 0, ',', ' ') }}
                                        </span>
                                        <small class="text-success fw-bold">FCFA / Kg</small>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('boutique.show', $produit->id_produit) }}"
                                           class="btn btn-outline-success rounded-pill fw-bold btn-sm py-2">
                                            <i class="bi bi-eye me-1"></i> Voir détail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-search display-1 text-muted opacity-25"></i>
                            <h4 class="text-muted mt-3">Aucun produit trouvé.</h4>
                            <a href="{{ route('boutique.index') }}" class="btn btn-success mt-2 rounded-pill">Réinitialiser</a>
                        </div>
                    @endforelse

                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $produits->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</section>

{{-- STYLES CSS PERSONNALISÉS --}}
<style>
    /* Effet sur les cartes produits */
    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(25, 135, 84, 0.15) !important;
    }

    /* Animation de zoom sur l'image au survol */
    .img-zoom {
        transition: transform 0.5s ease;
    }

    .product-card:hover .img-zoom {
        transform: scale(1.1);
    }

    /* Personnalisation de la pagination pour qu'elle soit verte */
    .pagination .page-link {
        color: #198754;
        border-radius: 8px;
        margin: 0 3px;
        border-color: #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    /* Bouton transition */
    .transition-all {
        transition: all 0.2s;
    }
    
    .btn-success:hover {
        transform: scale(1.02);
    }

    /* Masquer le texte "Showing X to Y of Z results" */
.pagination nav div:first-child p.text-muted {
    display: none !important;
}

/* Personnalisation de la pagination en vert */
.pagination .page-link {
    color: #198754 !important; /* Vert success */
    border-radius: 8px !important;
    margin: 0 3px;
    border-color: #dee2e6;
    background-color: white;
}

.pagination .page-item.active .page-link {
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: white !important;
}

.pagination .page-link:hover {
    background-color: #f0fdf4;
    color: #146c43 !important;
}
</style>

@endsection