@extends('layouts.producteur')

@section('title', 'Gestion des Commandes')

@section('content')
<div class="container-fluid py-4 min-vh-100">

    {{-- EN-TÊTE DE PAGE (Identique au style Acheteur) --}}
    <div class="mb-4">
        <h4 class="fw-bold text-success mb-1">Commandes reçues</h4>
        <p class="text-dark small mb-0"><i class="bi bi-box-seam text-success me-1"></i> Gérez vos ventes et suivez l'état de vos expéditions</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLEAU DES COMMANDES --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    {{-- EN-TÊTE NOIR MAT --}}
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0">Référence</th>
                            <th class="py-3 border-0">Client</th>
                            <th class="py-3 border-0">Produits</th>
                            <th class="py-3 border-0">Montant</th>
                            <th class="py-3 border-0 text-center">Statut</th>
                            <th class="py-3 border-0">Date</th>
                            <th class="text-end pe-4 py-3 border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($commandes as $commande)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 fw-bold text-dark small text-nowrap">
                                #{{ $commande->id_commande }}
                            </td>

                            {{-- Client --}}
                            <td class="small fw-medium">
                                {{ $commande->acheteur->nom ?? 'Client inconnu' }}
                            </td>

                            {{-- Produits --}}
                            <td class="small">
                                @foreach($commande->items as $item)
                                    <div class="text-nowrap">• {{ $item->produit->nom }} <span class="text-muted">(x{{ $item->quantite }})</span></div>
                                @endforeach
                            </td>

                            {{-- Montant --}}
                            <td class="text-nowrap fw-bold small">
                                {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                            </td>

                            {{-- Statut (Utilisant le même style de badge arrondi que l'acheteur) --}}
                            <td class="text-center">
                                @php
                                    $statusConfig = [
                                        'en attente' => ['class' => 'bg-warning text-warning', 'icon' => 'bi-hourglass-split'],
                                        'payée'      => ['class' => 'bg-success text-success', 'icon' => 'bi-check-circle'],
                                        'expédiée'   => ['class' => 'bg-primary text-primary', 'icon' => 'bi-truck'],
                                        'livrée'     => ['class' => 'bg-success text-success', 'icon' => 'bi-check-all'],
                                        'annulée'    => ['class' => 'bg-danger text-danger', 'icon' => 'bi-x-circle'],
                                    ][$commande->statut] ?? ['class' => 'bg-secondary text-secondary', 'icon' => 'bi-dot'];
                                @endphp
                                <span class="badge {{ $statusConfig['class'] }} bg-opacity-10 border border-{{ explode('-', $statusConfig['class'])[1] }} border-opacity-25 rounded-pill px-3 fw-normal text-capitalize" style="font-size: 0.7rem;">
                                    <i class="bi {{ $statusConfig['icon'] }} me-1"></i> {{ $commande->statut }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="small text-muted">
                                {{ $commande->created_at->format('d/m/Y') }}
                            </td>

                            {{-- Actions (Dropdown pour le changement de statut) --}}
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                        Action <i class="bi bi-chevron-down ms-1" style="font-size: 0.6rem;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 small">
                                        <li><h6 class="dropdown-header text-uppercase opacity-50" style="font-size: 0.65rem;">Changer statut</h6></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('producteur.commandes.status', [$commande->id_commande, 'expédiée']) }}"><i class="bi bi-truck me-2 text-primary"></i> Expédiée</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('producteur.commandes.status', [$commande->id_commande, 'livrée']) }}"><i class="bi bi-check-all me-2 text-success"></i> Livrée</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 text-danger" href="{{ route('producteur.commandes.status', [$commande->id_commande, 'annulée']) }}"><i class="bi bi-x-circle me-2"></i> Annuler</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-receipt display-4 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted">Aucune commande reçue pour le moment.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION NOIRE (Identique à l'acheteur) --}}
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                 {{ $commandes->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Background */
    body { background-color: #f0f2f5; }

    /* En-tête de tableau noir mat */
    .table thead.table-dark tr {
        background-color: #1a1d20 !important;
    }
    
    .table thead th {
        color: #ffffff !important;
        border: none !important;
        padding-top: 15px !important;
        padding-bottom: 15px !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.8px;
    }

    /* Centrage vertical des cellules */
    .table tbody td {
        vertical-align: middle;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    /* Style du survol vert (Effet Acheteur) */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.1) !important; 
        transition: background-color 0.15s ease-in-out;
    }

    /* Style des boutons blancs / Action */
    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
        color: #212529;
    }

    .btn-white:hover {
        background: #f8f9fa;
        border-color: #198754;
        color: #198754;
    }

    /* Pagination Noire Harmonisée */
    .table-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        padding: 0 0.8rem;
        font-size: 0.8rem;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        color: #000000;
        border-radius: 4px !important;
        margin: 0 2px;
    }

    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }

    .dropdown-item:hover {
        background-color: rgba(25, 135, 84, 0.1);
    }
</style>
@endsection