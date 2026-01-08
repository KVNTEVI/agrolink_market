@extends('layouts.acheteur')

@section('title', 'Détail commande')

@section('content')
<div class="container py-4">

    {{-- EN-TÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Détail de la commande</h4>
            <p class="text-muted small mb-0">Récapitulatif complet de votre achat #{{ $commande->id_commande }}</p>
        </div>
        <a href="{{ route('acheteur.commandes.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Retour à l'historique
        </a>
    </div>

    <div class="row g-4">
        {{-- COLONNE GAUCHE : RÉSUMÉ --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white fw-bold border-0 py-3">
                    <i class="bi bi-box-seam text-success me-2"></i>Produits commandés
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th class="text-end pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commande->items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        {{-- Nom du Produit --}}
                                        <span class="fw-bold text-dark">{{ $item->produit->nom }}</span>
                                        
                                        {{-- AJOUT : NOM DU PRODUCTEUR --}}
                                        <small class="text-muted mt-1">
                                            <i class="bi bi-shop me-1"></i>Vendeur : 
                                            <span class="text-primary fw-medium">
                                                {{ $item->produit->producteur->nom ?? 'Producteur inconnu' }}
                                            </span>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark rounded-pill px-3">{{ $item->quantite }} Kg</span>
                                </td>
                                <td>{{ number_format($item->prix_final, 0, ',', ' ') }} F</td>
                                <td class="text-end pe-4 fw-bold text-success">
                                    {{ number_format($item->prix_final * $item->quantite, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-end pe-4">
                    <span class="text-muted me-2">Total à régler :</span>
                    <span class="fs-5 fw-bold text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : INFOS & ACTIONS --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Informations générales</h6>
                    
                    <div class="mb-3">
                        <label class="small text-muted d-block text-uppercase fw-semibold">Référence</label>
                        <span class="fw-bold">CMD-{{ $commande->id_commande }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted d-block text-uppercase fw-semibold">Date d'achat</label>
                        <span><i class="bi bi-calendar3 me-2 text-primary"></i>{{ $commande->created_at->format('d/m/Y') }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted d-block text-uppercase fw-semibold mb-2">État actuel</label>
                        @if($commande->statut === 'payée')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 w-100 d-block">
                                <i class="bi bi-check-circle-fill me-1"></i> Commande Payée
                            </span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2 w-100 d-block">
                                <i class="bi bi-hourglass-split me-1"></i> Paiement en attente
                            </span>
                        @endif
                    </div>

                    <hr class="my-4 opacity-10">

                    {{-- BOUTON DE PAIEMENT --}}
                    @if($commande->statut !== 'payée')
                        <a href="{{ route('acheteur.paiement.show', $commande->id_commande) }}"
                           class="btn btn-success w-100 py-3 fw-bold shadow-sm">
                            <i class="bi bi-credit-card me-2"></i> Payer maintenant
                        </a>
                        <p class="text-center text-muted small mt-2">Transaction sécurisée</p>
                    @else
                        <div class="text-center py-2">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="bi bi-shield-check fs-3"></i>
                            </div>
                            <p class="small fw-bold text-success mb-0">Cette commande est validée.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection