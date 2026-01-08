@extends('layouts.acheteur')
@section('title', 'Confirmer le Paiement')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            {{-- CARTE DE PAIEMENT --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- En-tête visuel --}}
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-check text-success fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Finaliser votre achat</h4>
                    <p class="text-muted small">Commande #{{ $commande->id_commande }}</p>
                </div>

                <div class="card-body p-4">
                    {{-- RÉSUMÉ DES PRODUITS --}}
                    <h6 class="fw-bold mb-3 text-uppercase small text-muted">Résumé de la commande</h6>
                    <div class="bg-light rounded-4 p-3 mb-4">
                        @foreach($commande->items as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0 fw-bold small">{{ $item->produit->nom }}</h6>
                                <small class="text-muted">{{ number_format($item->prix_final, 0, ',', ' ') }} FCFA x {{ $item->quantite }}</small>
                            </div>
                            <span class="fw-bold small">{{ number_format($item->prix_final * $item->quantite, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endforeach
                        
                        <hr class="my-3 opacity-10">
                        
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Sous-total</span>
                            <span class="fw-bold small">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Frais de service</span>
                            <span class="text-success fw-bold small">Gratuit</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                            <span class="fw-bold">Total à payer</span>
                            <span class="fw-bold fs-5 text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    {{-- FORMULAIRE DE PAIEMENT --}}
                    <form action="{{ route('acheteur.paiement.payer', $commande->id_commande) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-3">Choisir un mode de paiement</label>
                            
                            <div class="list-group gap-2">
                                {{-- Option Mobile Money --}}
                                <label class="list-group-item d-flex gap-3 py-3 rounded-4 border-2 cursor-pointer border-light-subtle shadow-sm">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="mode" value="mobile_money" checked>
                                    <div class="d-flex flex-column">
                                        <strong class="text-dark">Mobile Money (T-Money / Flooz)</strong>
                                        <small class="text-muted">Paiement instantané et sécurisé via votre téléphone.</small>
                                    </div>
                                    <i class="bi bi-phone fs-4 ms-auto text-primary"></i>
                                </label>

                                {{-- Option Espèces --}}
                                <label class="list-group-item d-flex gap-3 py-3 rounded-4 border-2 cursor-pointer border-light-subtle shadow-sm">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="mode" value="cash">
                                    <div class="d-flex flex-column">
                                        <strong class="text-dark">Espèces (Cash)</strong>
                                        <small class="text-muted">Payez en main propre lors de la livraison.</small>
                                    </div>
                                    <i class="bi bi-cash-stack fs-4 ms-auto text-success"></i>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm mb-3">
                            Confirmer le paiement ({{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA)
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('acheteur.commandes.index') }}" class="text-muted small text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Annuler et retourner à mes commandes
                        </a>
                    </div>
                </div>
            </div>

            {{-- Badge de sécurité --}}
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-lock-fill me-1"></i> Transaction sécurisée par cryptage SSL
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .list-group-item input:checked + div + i, 
    .list-group-item input:checked + div strong {
        color: var(--bs-success) !important;
    }
    .list-group-item:has(input:checked) {
        border-color: var(--bs-success) !important;
        background-color: var(--bs-success-border-subtle) !important;
    }
</style>
@endsection