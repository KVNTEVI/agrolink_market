@extends('layouts.acheteur')

@section('title', 'Historique des commandes')

@section('content')

<div class="container-fluid py-4 min-vh-100">
    {{-- TITRE --}}
    <div class="mb-4">
        <h4 class="fw-bold text-success mb-1">Historique des commandes</h4>
        <p class="text-muted small mb-0">Consultez toutes vos commandes passées sur AgroLink</p>
    </div>

    {{-- MESSAGE SUCCÈS --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- AUCUNE COMMANDE --}}
    @if($commandes->isEmpty())
        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-receipt display-4 text-muted opacity-25"></i>
            <p class="mt-3 text-muted">Vous n’avez encore passé aucune commande.</p>
            <a href="{{ route('boutique.index') }}" class="btn btn-dark rounded-pill px-4">
                <i class="bi bi-shop me-1"></i> Aller à la boutique
            </a>
        </div>
    @else

    {{-- TABLEAU --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0">Commande</th>
                            <th class="py-3 border-0">Produit</th>
                            <th class="py-3 border-0">Quantité</th>
                            <th class="py-3 border-0">Montant</th>
                            <th class="py-3 border-0">Statut</th>
                            <th class="text-center py-3 border-0">Détails</th>
                            <th class="text-end pe-4 py-3 border-0">Paiement</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($commandes as $commande)
                            @foreach($commande->items as $item)
                            <tr>
                                {{-- ID --}}
                                <td class="ps-4 fw-bold text-dark small text-nowrap">
                                    CMD-{{ $commande->id_commande }}
                                </td>

                                {{-- Produit --}}
                                <td class="small fw-medium">{{ $item->produit->nom }}</td>

                                {{-- Quantité --}}
                                <td class="small">{{ $item->quantite }}</td>

                                {{-- Montant --}}
                                <td class="text-nowrap fw-bold small">
                                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                </td>

                                {{-- Statut --}}
                                <td>
                                    @if($commande->statut === 'payée')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 fw-normal" style="font-size: 0.7rem;">
                                            <i class="bi bi-check-circle me-1"></i> Payée
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 fw-normal" style="font-size: 0.7rem;">
                                            <i class="bi bi-hourglass-split me-1"></i> En attente
                                        </span>
                                    @endif
                                </td>

                                {{-- Détails --}}
                                <td class="text-center">
                                    <a href="{{ route('acheteur.commandes.show', $commande->id_commande) }}" 
                                       class="btn btn-sm btn-white border shadow-sm rounded-circle p-0 d-inline-flex align-items-center justify-content-center" 
                                       style="width: 30px; height: 30px;"
                                       title="Voir les détails">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                </td>

                                {{-- Action Paiement --}}
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end align-items-center">
                                        @if($commande->statut !== 'payée')
                                            <a href="{{ route('acheteur.paiement.show', $commande->id_commande) }}"
                                               class="btn btn-sm btn-success rounded px-3 shadow-sm d-flex align-items-center gap-1">
                                                <i class="bi bi-credit-card small"></i> <span class="small">Payer</span>
                                            </a>
                                        @else
                                            <span class="badge bg-light text-muted border rounded px-3 fw-normal" style="font-size: 0.7rem;">
                                                <i class="bi bi-shield-check me-1"></i> Terminé
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Footer pour la pagination (si nécessaire) --}}
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                 {{ $commandes->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @endif
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

    /* Style du survol vert demandé */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.1) !important; /* bg-success bg-opacity-10 */
        transition: background-color 0.15s ease-in-out;
    }

    /* Style des boutons blancs */
    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
    }

    .btn-white:hover {
        background: #f8f9fa;
        border-color: #0d6efd;
    }

    /* Harmonisation Pagination */
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60px; /* Optionnel : définit une hauteur minimale pour une consistance parfaite */
    }

    .table-pagination .pagination {
        margin-bottom: 0 !important;
        display: flex;
        align-items: center; /* Aligne les flèches et les chiffres sur la même ligne */
    }
    .table-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 32px; /* Hauteur fixe pour garantir le centrage vertical du texte/icône */
        padding: 0 0.8rem;
        font-size: 0.8rem;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        color: #000000;
        border-radius: 4px !important;
        transition: all 0.2s ease;
    }
    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }
</style>
@endsection