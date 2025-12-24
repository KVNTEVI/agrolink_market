@extends('layouts.producteur')

@section('title', 'Mes Produits')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Mes produits</h4>
        <p class="text-muted small mb-0">Gérez votre catalogue d'articles</p>
    </div>
    <a href="{{ route('producteur.produit.create') }}" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-lg"></i> Ajouter un produit
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Produit</th>
                    <th>Prix Unitaire</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produits as $produit)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($produit->image ? 'images/produits/' . $produit->image : 'images/default-product.png') }}" class="rounded me-3" width="45" height="45" style="object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $produit->nom }}</h6>
                                <small class="text-muted">{{ Str::limit($produit->description, 30) }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="fw-bold">{{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="badge {{ $produit->stock < 5 ? 'bg-danger-subtle text-danger' : 'bg-light text-dark' }} border">
                            {{ $produit->stock }} en stock
                        </span>
                    </td>
                    <td>
                        @if($produit->stock > 0)
                            <span class="text-success small"><i class="bi bi-check-circle-fill"></i> Disponible</span>
                        @else
                            <span class="text-danger small"><i class="bi bi-x-circle-fill"></i> Rupture</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-box2 fs-1 d-block mb-2"></i>
                        Aucun produit pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection