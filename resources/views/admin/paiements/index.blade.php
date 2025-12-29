@extends('layouts.admin')
@section('title', 'Suivi des Paiements')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Historique des transactions</h4>
            <p class="text-muted small mb-0">Suivi financier de la plateforme AgroLink Market</p>
        </div>
        <div class="badge bg-dark p-2 px-3">Transactions : {{ $paiements->count() }}</div>
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
                                    <span class="text-uppercase small fw-semibold text-muted">{{ $paiement->mode }}</span>
                                </div>
                            </td>
                            <td>
                                @if($paiement->statut == 'complété' || $paiement->statut == 'reçu')
                                    <span class="badge bg-success rounded-pill px-3">Encaissé</span>
                                @elseif($paiement->statut == 'en attente')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">En attente</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 text-capitalize">{{ $paiement->statut }}</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $paiement->created_at->translatedFormat('d M Y à H:i') }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border-0 shadow-sm text-primary" title="Voir les détails">
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
    </div>
</div>
@endsection