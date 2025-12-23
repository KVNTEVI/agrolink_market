@extends('layouts.app')

@section('title', 'Mon panier')

@section('content')

<section class="bg-success bg-opacity-10 py-5 text-center">
    <div class="container">
        <h2 class="fw-bold text-success d-flex align-items-center justify-content-center">
            <i class="bi bi-cart3 me-2"></i> Mon panier
        </h2>
        <p class="text-muted">Gérez vos articles avant de finaliser votre commande</p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if(!$panier || $panier->items->isEmpty())
            <div class="text-center py-5">
                <div class="alert alert-info border-0 shadow-sm rounded-4 p-5">
                    <i class="bi bi-info-circle fs-1 d-block mb-3 text-info"></i>
                    <h4 class="fw-bold">Votre panier est vide</h4>
                    <p>Il semble que vous n'ayez pas encore ajouté de produits.</p>
                    <a href="{{ route('boutique.index') }}" class="btn btn-success mt-3 rounded-pill px-4">
                        <i class="bi bi-shop me-1"></i> Retourner à la boutique
                    </a>
                </div>
            </div>
        @else

            <div class="row">
                <div class="col-lg-8">
                    <div class="border rounded p-4 h-100 shadow-sm hover-card">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3">Produit</th>
                                        <th>Prix</th>
                                        <th class="text-center">Quantité</th>
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
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('images/produits/' . $item->produit->image) }}"
                                                         class="rounded border"
                                                         width="60" height="60"
                                                         style="object-fit: cover;"
                                                         alt="{{ $item->produit->nom }}">
                                                    <div>
                                                        <strong class="d-block text-dark">{{ $item->produit->nom }}</strong>
                                                        <small class="text-muted">{{ $item->produit->categorie->nom ?? 'Agricole' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">{{ number_format($prix, 0, ',', ' ') }} FCFA</span></td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border px-3 py-2">
                                                    {{ $item->quantite }}
                                                </span>
                                            </td>
                                            <td class="fw-bold text-success">
                                                {{ number_format($sousTotal, 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="text-center pe-4">
                                                <form action="{{ route('acheteur.panier.remove', $item->id_item) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Supprimer ce produit ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0">
                                                        <i class="bi bi-trash3 fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="border rounded p-4 shadow-sm hover-card" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Résumé de la commande</h5>
                            
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Nombre d'articles</span>
                                <span>{{ $panier->items->sum('quantite') }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold h5 mb-0">Total</span>
                                <span class="fw-bold text-success h4 mb-0">
                                    {{ number_format($total, 0, ',', ' ') }} FCFA
                                </span>
                            </div>

                            <form action="{{ route('acheteur.commandes.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 shadow-sm ">
                                    <i class="bi bi-check2-circle me-1"></i> Passer la commande
                                </button>
                            </form>
                            
                            <div class="mt-3 text-center">
                                <a href="{{ route('boutique.index') }}" class="text-muted small text-decoration-none">
                                    <i class="bi bi-arrow-left"></i> Continuer mes achats
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
</section>

@endsection