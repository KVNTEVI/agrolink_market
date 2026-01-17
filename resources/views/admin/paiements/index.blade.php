@extends('layouts.admin')
@section('title', 'Suivi des Paiements')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-success">Historique des transactions</h4>
            <p class="text-muted small mb-0">Suivi financier de la plateforme AgroLink Market</p>
        </div>
        <div class="badge bg-dark p-2 px-3">Transactions : {{ $paiements->total() }}</div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary" style="font-size: 0.9rem;">
                            <th class="ps-4">Référence & Commande</th>
                            <th>Montant</th>
                            <th>Mode de Paiement</th>
                            <th>État du Flux</th>
                            <th>Date de Transaction</th>
                            <th class="text-end pe-4">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">PAY-{{ str_pad($paiement->id_paiement, 5, '0', STR_PAD_LEFT) }}</span>
                                    <small class="text-muted">Commande #{{ $paiement->commande_id }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-success">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-wallet2 me-2 text-secondary"></i>
                                    <span class="text-uppercase small fw-semibold text-muted">{{ $paiement->mode ?? 'Inconnu' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($paiement->statut == 'complété' || $paiement->statut == 'reçu')
                                    <span class="badge bg-success rounded-pill px-3">Encaissé</span>
                                @elseif($paiement->statut == 'en attente')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">En attente</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3 text-capitalize">{{ $paiement->statut }}</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $paiement->created_at->translatedFormat('d M Y à H:i') }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.paiements.show', $paiement->id_paiement) }}" class="btn btn-sm btn-light border-0 shadow-sm text-primary" title="Voir les détails">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-cash-stack fs-1 d-block mb-2 opacity-25"></i>
                                Aucun flux financier enregistré.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                {{ $paiements->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    /* 1. Distinction de l'en-tête du tableau */
    .table thead.table-light tr {
        background-color: #212529 !important; /* Gris très foncé */
        color: #ffffff !important; /* Texte blanc */
    }
    
    .table thead.table-light th {
        background-color: transparent !important;
        color: inherit !important;
        border: none;
        padding-top: 15px;
        padding-bottom: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    /* 2. Style de la pagination (Taille réduite + Noir & Blanc) */
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
        gap: 3px;
    }

    .table-pagination .page-link {
        padding: 0.35rem 0.75rem; /* Taille réduite */
        font-size: 0.85rem;       /* Texte plus petit */
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        color: #000000;
        border-radius: 4px !important;
        transition: all 0.2s ease;
    }

    /* État au survol */
    .table-pagination .page-link:hover {
        background-color: #000000;
        color: #ffffff;
        border-color: #000000;
    }

    /* Page active */
    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
        font-weight: bold;
    }

    /* Désactivation focus bleu */
    .table-pagination .page-link:focus {
        box-shadow: none !important;
    }
    
    /* Pages désactivées */
    .table-pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        color: #adb5bd;
        border-color: #e9ecef;
    }
</style>