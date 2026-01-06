@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(to bottom, #ffffff, #f8f9fa);">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('boutique.index') }}" class="text-muted text-decoration-none small">
                <i class="bi bi-chevron-left"></i> Boutique / <span class="text-dark fw-bold">{{ $produit->nom }}</span>
            </a>
        </div>

        <div class="row g-5">
            <div class="col-md-7">
                <div class="position-sticky" style="top: 20px;">
                    <div class="bg-white rounded-2 shadow-sm border">
                        <img src="{{ asset('images/produits/'.$produit->image) }}"
                             class="img-fluid rounded-2 w-100"
                             alt="{{ $produit->nom }}"
                             style="object-fit: cover; max-height: 600px;">
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="ps-md-4">
                    <span class="badge bg-success-subtle text-success px-3 py-2 mb-3 rounded-pill fw-bold">
                         {{ $produit->categorie->nom ?? 'Agricole' }}
                    </span>
                    
                    <h1 class="display-5 fw-bold text-dark mb-2">{{ $produit->nom }}</h1>
                    
                    <div class="d-flex align-items-center mb-4">
                        <h2 class="text-success fw-bold mb-0 me-2">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</h2>
                        <span class="text-muted">/ Kg</span>
                    </div>

                    <div class="p-4 bg-white rounded-2 border shadow-sm mb-4">
                        <h6 class="fw-bold mb-3">À propos de ce produit</h6>
                        <p class="text-secondary mb-0" style="line-height: 1.7;">
                            {{ $produit->description }}
                        </p>
                    </div>

                    <div class="d-flex align-items-center p-3 border rounded-2 mb-4 bg-light">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                {{ substr($produit->producteur->nom, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted small mb-0">Producteur vérifié</p>
                            <h6 class="mb-0 fw-bold">{{ $produit->producteur->nom }}</h6>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        @auth
                            @if(auth()->user()->role_id == 2)
                                <form action="{{ route('acheteur.panier.add', $produit->id_produit) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm">
                                        <i class="bi bi-cart-plus me-2"></i> Ajouter au panier
                                    </button>
                                </form>

                                <a href="{{ route('acheteur.conversation.start', $produit->id_produit) }}"
                                   class="btn btn-outline-success btn-lg py-3 fw-bold">
                                    <i class="bi bi-chat-dots me-2"></i> Négocier en direct
                                </a>
                            @else
                                <div class="alert alert-warning border-0 rounded-4 px-4 py-3">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Achat réservé aux comptes <strong>Acheteur</strong>.
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success btn-lg py-3 rounded-4 fw-bold">
                                Connectez-vous pour commander
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Animation subtile pour l'image */
    img.rounded-4 {
        transition: transform 0.4s ease;
    }
    img.rounded-4:hover {
        transform: scale(1.02);
    }
    
    /* Couleur de fond discrète pour le badge */
    .bg-success-subtle {
        background-color: #e8f5e9 !important;
    }

    /* Style des boutons */
    .btn-lg {
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-2px);
    }
</style>
@endsection