@extends('layouts.app')

@section('content')

{{-- Ajout du background vert très clair sur toute la section --}}
<section class="py-5" style="background-color: rgba(25, 135, 84, 0.05); min-height: 100vh;">
    <div class="container">

        {{-- Barre d'en-tête avec bouton retour --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="javascript:history.back()" class="btn btn-outline-success btn-sm rounded-circle me-3" title="Retour">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h3 class="fw-bold mb-0">
                    Produits de <span class="text-success">{{ $producteur->nom }}</span>
                </h3>
            </div>
            
            {{-- Optionnel : Petit badge indiquant le nombre de produits --}}
            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                {{ $produits->total() }} produits trouvés
            </span>
        </div>

        <div class="row g-4 ">
            @forelse($produits as $produit)
            <div class="col-md-4 col-sm-6 ">
                <div class="card h-100 shadow-sm border-0 hover-card rounded-4" style="transition: transform 0.2s;">
                    <img src="{{ asset('images/produits/'.$produit->image) }}"
                        class="card-img-top rounded-top-4"
                        style="height: 220px; object-fit: cover;"
                        alt="{{ $produit->nom }}">

                    <div class="card-body bg-white rounded-bottom-4">
                        <h6 class="fw-bold text-dark">{{ $produit->nom }}</h6>

                        <p class="text-success fw-bold fs-5 mb-3">
                            {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} <small style="font-size: 0.7rem;">FCFA</small>
                        </p>

                        <div class="d-grid">
                            <a href="{{ route('boutique.show', $produit->id_produit) }}"
                               class="btn btn-success rounded-pill fw-bold">
                                <i class="bi bi-eye me-1"></i> Voir détail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-seam display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3 fs-5">Aucun produit disponible pour ce producteur.</p>
                <a href="{{ route('boutique.index') }}" class="btn btn-success mt-2">Retour à la boutique</a>
            </div>
            @endforelse
        </div>

        {{-- Pagination centrée --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $produits->links('pagination::bootstrap-5') }}
        </div>

    </div>
</section>

<style>
    /* Petit effet de survol pour dynamiser la boutique */
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    /* Harmonisation de la pagination */
    .pagination .page-link {
        color: #198754;
        border-radius: 8px;
        margin: 0 3px;
    }
    .pagination .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
    }
</style>

@endsection