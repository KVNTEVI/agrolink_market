@extends('layouts.admin')
@section('title', 'Modération des Produits')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-success">Modération des Produits</h4>
            <p class="text-muted small mb-0">Validez ou refusez les articles mis en ligne sur AgroLink</p>
        </div>
        <div class="badge bg-dark p-2 px-3">Total : {{ $produits->total() }}</div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary" style="font-size: 0.9rem;">
                            <th class="ps-4">Image & Désignation</th>
                            <th>Prix Unitaire</th>
                            <th>Statut Actuel</th>
                            <th>Date d'ajout</th>
                            <th class="text-end pe-4">Actions de Modération</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img src="{{ asset($p->image ? 'images/produits/'.$p->image : 'images/default.png') }}" 
                                             class="rounded-3 border" width="45" height="45" style="object-fit: cover;">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $p->nom }}</span>
                                        <small class="text-muted">Réf: #PROD-{{ $p->id_produit }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold">{{ number_format($p->prix_unitaire, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td>
                                @if($p->statut == 'valide')
                                    <span class="badge bg-success rounded-pill px-3">Validé</span>
                                @elseif($p->statut == 'refuse')
                                    <span class="badge bg-danger rounded-pill px-3">Refusé</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3">En attente</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $p->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    {{-- Bouton Valider --}}
                                    <form action="{{ route('admin.produits.approve', $p->id_produit) }}" method="POST" class="m-0 d-inline-block">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success text-white border-0 shadow-sm d-flex align-items-center gap-1" title="Approuver">
                                            <i class="bi bi-check-circle"></i> <span>Valider</span>
                                        </button>
                                    </form>

                                    {{-- Bouton Refuser --}}
                                    <form action="{{ route('admin.produits.reject', $p->id_produit) }}" method="POST" class="m-0 d-inline-block">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger border-0 shadow-sm d-flex align-items-center gap-1" title="Refuser">
                                            <i class="bi bi-x-circle"></i> <span>Refuser</span>
                                        </button>
                                    </form>

                                    {{-- Bouton Supprimer --}}
                                    <form action="{{ route('admin.produits.destroy', $p->id_produit) }}" method="POST" class="m-0 d-inline-block" onsubmit="return confirm('Supprimer définitivement ce produit ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger border-0 shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-center">
                {{ $produits->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* 1. En-tête de tableau sombre et contrasté */
    .table thead.table-light tr {
        background-color: #1a1d20 !important; /* Noir profond */
        color: #ffffff !important;
    }
    
    .table thead.table-light th {
        background-color: transparent !important;
        color: #ffffff !important;
        border: none;
        padding-top: 14px;
        padding-bottom: 14px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
    }

    /* 2. Pagination Noir & Blanc (Taille réduite) */
    .table-pagination nav > div:first-child {
        display: none !important; /* Masque "Showing x to y..." */
    }

    .table-pagination nav > div:last-child {
        width: 100%;
        display: flex !important;
        justify-content: center !important;
    }

    .table-pagination .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .table-pagination .page-link {
        padding: 0.35rem 0.8rem;
        font-size: 0.8rem;
        border: 1px solid #e0e0e0;
        background-color: #ffffff;
        color: #000000;
        border-radius: 4px !important;
        transition: all 0.2s ease;
    }

    .table-pagination .page-link:hover {
        background-color: #000000;
        color: #ffffff;
        border-color: #000000;
    }

    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }

    .table-pagination .page-link:focus {
        box-shadow: none !important;
    }
    
    .table-pagination .page-item.disabled .page-link {
        background-color: #ffffff;
        color: #d6d6d6;
        border-color: #f0f0f0;
    }
</style>