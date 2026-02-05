@extends('layouts.app')

@section('title', 'Mon panier')

@section('content')

{{-- Style personnalisé pour l'esthétique AgroLink --}}
<style>

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    .cart-header {
        background: linear-gradient(135deg, #198754 0%, #0d5a35 100%);
    }
    .table-dark-header thead {
        background-color: #212529;
        color: white;
    }
    .table-dark-header thead th {
        border: none;
        padding: 1.2rem 1rem;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }
    .product-img {
        transition: transform 0.3s ease;
        object-fit: cover;
        border-radius: 12px;
    }
    .hover-shadow:hover .product-img {
        transform: scale(1.05);
    }
    .btn-checkout {
        background: #198754;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-checkout:hover {
        background: #146c43;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    .table-dark-header thead th {
        background-color: #212529 !important; /* !important force la couleur noire */
        color: white !important;
        border: none;
        padding: 1.2rem 1rem;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    /* Optionnel : pour arrondir les coins du tableau noir */
    .table-dark-header {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-dark-header thead tr:first-child th:first-child {
        border-top-left-radius: 12px;
    }
    
    .table-dark-header thead tr:first-child th:last-child {
        border-top-right-radius: 12px;
    }
</style>

{{-- Section Titre --}}
<section class="bg-success bg-opacity-10 py-5">
    <div class="container">
        <h2 class="fw-bold d-flex text-success align-items-center justify-content-center mb-1">
            <i class="bi bi-cart3 me-3"></i> Mon Panier
        </h2>
        <p class="opacity-75 mb-0 text-center">Finalisez vos achats et soutenez nos producteurs locaux</p>
    </div>
</section>

<section class="py-5 bg-light" style="min-height: 60vh;">
    <div class="container">

        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill me-3 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if(!$panier || $panier->items->isEmpty())
            <div class="text-center py-5">
                <div class="card border-0 shadow-sm rounded-4 p-5">
                    <div class="card-body text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                            <i class="bi bi-basket2 fs-1 text-success"></i>
                        </div>
                        <h3 class="fw-bold">Votre panier est encore vide</h3>
                        <p class="text-muted mb-4">Parcourez nos produits frais et remplissez votre panier !</p>
                        <a href="{{ route('boutique.index') }}" class="btn btn-success rounded-pill px-5 py-2 shadow-sm">
                            <i class="bi bi-shop me-2"></i> Découvrir la boutique
                        </a>
                    </div>
                </div>
            </div>
        @else

            <div class="row g-4">
                {{-- Tableau des produits --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="table-responsive">
                            
                            <table class="table align-middle table-hover mb-0 table-dark-header">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Produit</th>
                                        <th>Prix Unit.</th>
                                        <th class="text-center">Qté</th>
                                        <th>Sous-total</th>
                                        <th class="text-center pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($panier->items as $item)
                                        @php
                                            $prix = $item->prix_negocie ?? $item->produit->prix_unitaire;
                                            $sousTotal = $prix * $item->quantite;
                                            $total += $sousTotal;
                                        @endphp
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('images/produits/' . $item->produit->image) }}"
                                                         class="product-img border shadow-sm"
                                                         width="70" height="70"
                                                         alt="{{ $item->produit->nom }}">
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->produit->nom }}</h6>
                                                        <span class="badge bg-success bg-opacity-10 text-success small fw-normal">
                                                            <i class="bi bi-tag me-1"></i> {{ $item->produit->categorie->nom ?? 'Agricole' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-dark fw-medium">
                                                {{ number_format($prix, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('acheteur.panier.update', $item->id_item) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    
                                                    <div class="d-flex align-items-center justify-content-center border rounded-pill bg-white px-2 shadow-sm" style="width: fit-content; margin: auto;">
                                                        {{-- Bouton - --}}
                                                        <button type="submit" name="action" value="decrease" class="btn btn-link text-success p-1" {{ $item->quantite <= 1 ? 'disabled' : '' }}>
                                                            <i class="bi bi-dash-circle-fill"></i>
                                                        </button>

                                                        {{-- Saisie directe avec soumission automatique au changement --}}
                                                        <input type="number" 
                                                            name="quantite" 
                                                            value="{{ $item->quantite }}" 
                                                            class="form-control border-0 text-center fw-bold p-0" 
                                                            style="width: 50px; outline: none; box-shadow: none; background: transparent;"
                                                            min="1" 
                                                            max="{{ $item->produit->stock }}"
                                                            onchange="this.form.submit()">

                                                        {{-- Bouton + --}}
                                                        <button type="submit" name="action" value="increase" class="btn btn-link text-success p-1">
                                                            <i class="bi bi-plus-circle-fill"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    {{ number_format($sousTotal, 0, ',', ' ') }} <small>FCFA</small>
                                                </span>
                                            </td>
                                            <td class="text-center pe-4">
                                                <form action="{{ route('acheteur.panier.remove', $item->id_item) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Supprimer cet article ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle p-2">
                                                        <i class="bi bi-trash3-fill fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-white border-0 p-3">
                            <a href="{{ route('boutique.index') }}" class="text-success fw-bold text-decoration-none small">
                                <i class="bi bi-arrow-left me-1"></i> Continuer mes achats
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Résumé de la commande --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-shadow sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 d-flex justify-content-between align-items-center">
                                Résumé
                                <span class="badge bg-dark rounded-pill" style="font-size: 0.7rem;">{{ $panier->items->count() }} items</span>
                            </h5>
                            
                            <div class="d-flex justify-content-between mb-3 text-muted">
                                <span>Nombre d'articles</span>
                                <span class="fw-bold text-dark">{{ $panier->items->sum('quantite') }}</span>
                            </div>

                            <hr class="my-4 opacity-50">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="h5 fw-bold mb-0 text-dark">Total</span>
                                <div class="text-end">
                                    <span class="h3 fw-bold text-success mb-0">
                                        {{ number_format($total, 0, ',', ' ') }}
                                    </span>
                                    <span class="text-success fw-bold">FCFA</span>
                                </div>
                            </div>

                            <form action="{{ route('acheteur.commandes.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-checkout text-white w-100 rounded-3 mb-3">
                                    <i class="bi bi-credit-card-2-front me-2"></i> Finaliser la commande
                                </button>
                            </form>
                            
                            <div class="bg-light rounded-3 p-3 mt-4">
                                <div class="d-flex gap-2 mb-2">
                                    <i class="bi bi-shield-check text-success"></i>
                                    <span class="small fw-bold">Paiement 100% sécurisé</span>
                                </div>
                                <p class="text-muted x-small mb-0" style="font-size: 0.75rem;">
                                    Vos transactions sont protégées par notre système de sécurité AgroLink.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
</section>

@endsection