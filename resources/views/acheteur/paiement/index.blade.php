@extends('layouts.acheteur')
@section('title', 'Mon Historique de Paiements')

@section('content')
<div class="container-fluid py-4">
    {{-- EN-TÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Historique des Paiements</h4>
            <p class="text-muted small mb-0">Consultez vos transactions et téléchargez vos reçus</p>
        </div>
        <div class="bg-white border rounded-4 px-3 py-2 shadow-sm">
            <span class="text-muted small">Total dépensé : </span>
            <span class="fw-bold text-success">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    {{-- TABLEAU DES PAIEMENTS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">Date</th>
                            <th>Référence Commande</th>
                            <th>Mode de Paiement</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th class="text-center">Détails</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $paiement->created_at->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $paiement->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="fw-semibold text-primary">#{{ $paiement->commande->id_commande }}</td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-wallet2 me-1"></i> {{ ucfirst($paiement->mode) }}
                                </span>
                            </td>
                            <td><span class="fw-bold text-dark">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span></td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                    <i class="bi bi-check-circle me-1"></i>{{ ucfirst($paiement->statut) }}
                                </span>
                            </td>
                            
                            {{-- Cellule Détails --}}
                            <td class="text-center">
                                <a href="{{ route('acheteur.commandes.show', $paiement->commande_id) }}" 
                                   class="btn btn-sm btn-light rounded-circle shadow-sm" 
                                   title="Voir la commande">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>
                            </td>

                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                    <i class="bi bi-printer me-1"></i> Reçu
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted"> {{-- Colspan passé à 7 --}}
                                <i class="bi bi-credit-card-2-back fs-1 d-block mb-2"></i>
                                Aucun paiement enregistré pour le moment.
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