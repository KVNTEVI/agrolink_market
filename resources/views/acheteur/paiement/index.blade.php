@extends('layouts.acheteur')
@section('title', 'Mon Historique de Paiements')

@section('content')
<div class="container-fluid py-4 min-vh-100" >
    {{-- EN-TÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-success mb-1">Historique des Paiements</h4>
            <p class="text-dark small mb-0">Consultez vos transactions et téléchargez vos reçus</p>
        </div>
        <div class="bg-white border-0 rounded-4 px-3 py-2 shadow-sm">
            <span class="text-muted small">Total dépensé : </span>
            <span class="fw-bold text-success">{{ number_format($totalDepense, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    {{-- TABLEAU DES PAIEMENTS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0">Date</th>
                            <th class="py-3 border-0">Référence Commande</th>
                            <th class="py-3 border-0">Mode de Paiement</th>
                            <th class="py-3 border-0">Montant</th>
                            <th class="py-3 border-0">Statut</th>
                            <th class="text-center py-3 border-0">Détails</th>
                            <th class="text-end pe-4 py-3 border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($paiements as $paiement)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark small">{{ $paiement->created_at->format('d M Y') }}</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $paiement->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="fw-bold text-primary small">#{{ $paiement->commande->id_commande }}</td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-wallet2 me-1"></i> {{ ucfirst($paiement->mode) }}
                                </span>
                            </td>
                            <td><span class="fw-bold text-dark small">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span></td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 fw-normal" style="font-size: 0.7rem;">
                                    <i class="bi bi-check-circle me-1"></i>{{ ucfirst($paiement->statut) }}
                                </span>
                            </td>
                            
                            <td class="text-center">
                                <a href="{{ route('acheteur.commandes.show', $paiement->commande_id) }}" 
                                   class="btn btn-sm btn-white border shadow-sm rounded-circle p-0 d-inline-flex align-items-center justify-content-center" 
                                   style="width: 30px; height: 30px;"
                                   title="Voir la commande">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('acheteur.paiements.recu', $paiement->id_paiement) }}" class="btn btn-sm btn-white border shadow-sm rounded-pill px-3">
                                 <i class="bi bi-download me-1"></i> Reçu
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted bg-white">
                                <i class="bi bi-credit-card-2-back display-4 opacity-25 d-block mb-3"></i>
                                Aucun paiement enregistré pour le moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Footer pour la pagination --}}
        @if($paiements->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                {{ $paiements->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
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

    /* Style du survol vert demandé */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.1) !important;
        transition: background-color 0.15s ease-in-out;
    }

    /* Bouton blanc pour les détails */
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
    .table-pagination .pagination {
        margin-bottom: 0 !important;
    }
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
        transition: all 0.2s ease;
    }
    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }
</style>
@endsection