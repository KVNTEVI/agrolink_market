@extends('layouts.producteur')

@section('title', 'Mes Produits')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    {{-- EN-TÊTE HARMONISÉ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Gestion du catalogue</h4>
            <p class="text-muted small mb-0">Vous avez actuellement {{ $produits->count() }} produits enregistrés.</p>
        </div>
        <a href="{{ route('producteur.produit.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Ajouter un produit
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARTE PRINCIPALE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Aperçu</th>
                            <th>Désignation</th>
                            <th>Prix Unitaire</th>
                            <th>Stock Disponible</th>
                            <th>État</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $p)
                        <tr style="transition: all 0.2s ease;">
                            <td class="ps-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('images/produits/' . $p->image) }}" 
                                         class="rounded-3 shadow-sm border" 
                                         width="55" height="55" 
                                         style="object-fit: cover;">
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $p->nom }}</span>
                                <small class="text-muted">Réf: #PRD-{{ $p->id_produit }}</small>
                            </td>
                            <td>
                                <span class="fw-bold text-success">{{ number_format($p->prix_unitaire, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td>
                                @if($p->stock < 10)
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 border border-danger border-opacity-25">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $p->stock }} restants
                                        </span>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted rounded-pill px-3 py-2 border fw-normal">
                                        {{ $p->stock }} en stock
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($p->statut == 'valide')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> En ligne
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                        <i class="bi bi-hourglass-split me-1"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('producteur.produit.edit', $p->id_produit) }}" 
                                       class="btn btn-sm btn-white shadow-sm border rounded-3" 
                                       title="Modifier">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    
                                    <form action="{{ route('producteur.produit.destroy', $p->id_produit) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')"
                                          class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white shadow-sm border rounded-3" title="Supprimer">
                                            <i class="bi bi-trash3 text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                    <i class="bi bi-box2 text-muted fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark">Votre catalogue est vide</h5>
                                <p class="text-muted">Commencez à vendre en ajoutant votre premier produit agricole.</p>
                                <a href="{{ route('producteur.produit.create') }}" class="btn btn-success rounded-pill px-4">
                                    Créer un produit
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Effet sur les lignes du tableau */
    .table tbody tr:hover {
        background-color: #fcfdfc !important;
        cursor: pointer;
    }
    
    /* Boutons d'action blancs */
    .btn-white {
        background-color: #fff;
        transition: all 0.2s;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }

    /* Style des badges */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
</style>
@endsection