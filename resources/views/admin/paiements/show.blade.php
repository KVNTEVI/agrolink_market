@extends('layouts.admin')
@section('title', 'Détails du Paiement')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.paiements.index') }}" class="btn btn-sm btn-light text-muted mb-3">
            <i class="bi bi-arrow-left me-1"></i> Retour à l'historique
        </a>
        <h4 class="fw-bold">Détails de la Transaction</h4>
        <p class="text-muted small">Référence : PAY-{{ str_pad($paiement->id_paiement, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="row g-4">
        {{-- COLONNE GAUCHE : INFOS PAIEMENT --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">Informations financières</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Montant payé</label>
                            <span class="fs-4 fw-bold text-success">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <label class="text-muted small d-block">Statut du flux</label>
                            <span class="badge {{ $paiement->statut == 'complété' ? 'bg-warning' : 'bg-success' }} rounded-pill px-3">
                                {{ ucfirst($paiement->statut) }}
                            </span>
                        </div>
                        <hr class="my-3 opacity-25">
                        <div class="col-md-4">
                            <label class="text-muted small d-block">Mode de règlement</label>
                            <span class="fw-semibold"><i class="bi bi-credit-card me-2"></i>{{ strtoupper($paiement->mode) }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block">Date & Heure</label>
                            <span class="fw-semibold">{{ $paiement->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small d-block">ID Transaction</label>
                            <span class="text-monospace small">#{{ $paiement->transaction_id ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RÉCAPITULATIF COMMANDE --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Produits concernés</h6>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small">
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th class="text-end">Prix Unitaire</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paiement->commande->items as $item)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $item->produit->nom }}</span>
                                    </td>
                                    <td>{{ $item->quantite }} kg</td>
                                    <td class="text-end">{{ number_format($item->prix_final, 0, ',', ' ') }}</td>
                                    <td class="text-end fw-bold">{{ number_format($item->prix_final * $item->quantite, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : CLIENT --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-person text-secondary fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ $paiement->commande->acheteur->nom }} {{ $paiement->commande->acheteur->prenom }}</h6>
                    <p class="text-muted small mb-3">Acheteur</p>
                    <hr class="opacity-25">
                    <div class="text-start">
                        <p class="small mb-2"><i class="bi bi-envelope me-2"></i>{{ $paiement->commande->acheteur->email }}</p>
                        <p class="small mb-0"><i class="bi bi-telephone me-2"></i>{{ $paiement->commande->acheteur->telephone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card bg-success bg-opacity-10 border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-success">
                        <i class="bi bi-shield-check fs-1 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Paiement Sécurisé</h6>
                            <small>Transaction vérifiée par AgroLink</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection