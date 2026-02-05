@extends('layouts.producteur')

@section('title', 'Mes Produits')

@section('content')
<div class="container-fluid py-4 min-vh-100">
    
    {{-- EN-TÊTE HARMONISÉ --}}
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h4 class="fw-bold text-success mb-1">Gestion du catalogue</h4>
            <p class="text-dark small mb-0"><i class="bi bi-box-seam text-success me-1"></i> Gérez vos stocks et la visibilité de vos produits</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('producteur.produit.create') }}" class="btn btn-success rounded px-4 shadow-sm fw-bold">
                <i class="bi bi-plus-lg me-2"></i> Ajouter un produit
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLEAU STYLE "COMMANDES" --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0">Aperçu</th>
                            <th class="py-3 border-0">Désignation</th>
                            <th class="py-3 border-0">Prix Unitaire</th>
                            <th class="py-3 border-0 text-center">Stock Disponible</th>
                            <th class="py-3 border-0 text-center">État</th>
                            <th class="text-end pe-4 py-3 border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($produits as $p)
                        <tr>
                            <td class="ps-4">
                                <img src="{{ asset('images/produits/' . $p->image) }}" 
                                     class="rounded-3 shadow-sm border" 
                                     width="50" height="50" 
                                     style="object-fit: cover;">
                            </td>
                            <td>
                                <span class="fw-bold text-dark d-block small">{{ $p->nom }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">Réf: #PRD-{{ $p->id_produit }}</small>
                            </td>
                            <td class="small fw-bold text-nowrap text-success">
                                {{ number_format($p->prix_unitaire, 0, ',', ' ') }} FCFA
                            </td>
                            
                            {{-- STOCK RE-AJUSTÉ --}}
                            <td class="text-center">
                                @if($p->stock < 10)
                                    <span class="status-badge badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 fw-normal">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $p->stock }} restants
                                    </span>
                                @else
                                    <span class="status-badge badge bg-light text-muted border fw-normal">
                                        {{ $p->stock }} en stock
                                    </span>
                                @endif
                            </td>

                            {{-- ÉTAT RE-AJUSTÉ --}}
                            <td class="text-center">
                                @if($p->statut == 'valide')
                                    <span class="status-badge badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-normal">
                                        <i class="bi bi-check-circle-fill me-1"></i> En ligne
                                    </span>
                                @else
                                    <span class="status-badge badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 fw-normal">
                                        <i class="bi bi-hourglass-split me-1"></i> En attente
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('producteur.produit.edit', $p->id_produit) }}" 
                                       class="btn btn-sm btn-white border shadow-sm rounded-3" title="Modifier">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    
                                    <form action="{{ route('producteur.produit.destroy', $p->id_produit) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Supprimer ce produit ?')"
                                          class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white border shadow-sm rounded-3 text-danger" title="Supprimer">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-box2 display-4 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted">Votre catalogue est vide.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                 {{ $produits->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; }

    /* Alignement des badges */
    .status-badge {
        min-width: 115px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px !important;
        font-size: 0.7rem !important;
        border-radius: 50px !important;
    }

    /* Style Header Noir Mat */
    .table thead.table-dark tr { background-color: #1a1d20 !important; }
    .table thead th {
        color: #ffffff !important;
        border: none !important;
        padding: 15px 10px !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.8px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.08) !important; 
    }

    /* Boutons actions carrés arrondis comme avant */
    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
    }
    .btn-white:hover {
        border-color: #198754;
        background: #f8f9fa;
        transform: translateY(-1px);
    }

    /* Pagination Noire */
    .table-pagination .page-link {
        display: flex; align-items: center; justify-content: center;
        height: 32px; padding: 0 0.8rem; font-size: 0.8rem;
        border: 1px solid #dee2e6; background-color: #ffffff;
        color: #000000; border-radius: 4px !important; margin: 0 2px;
    }
    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important; border-color: #000000 !important; color: #ffffff !important;
    }
</style>
@endsection