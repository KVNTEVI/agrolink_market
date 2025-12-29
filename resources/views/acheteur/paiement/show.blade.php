@extends('layouts.acheteur')
@section('title', 'Confirmer le Paiement')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            {{-- CARTE DE PAIEMENT --}}
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-check text-success fs-1"></i>
                        </div>
                        <h4 class="fw-bold">Finaliser votre achat</h4>
                        <p class="text-muted">Commande #{{ $commande->id_commande }}</p>
                    </div>

                    <div class="bg-light rounded-4 p-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Montant de la commande</span>
                            <span class="fw-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Frais de service</span>
                            <span class="text-success fw-bold">Gratuit</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total à payer</span>
                            <span class="fw-bold fs-5 text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <form action="{{ route('acheteur.paiement.payer', $commande->id_commande) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Choisir un mode de paiement</label>
                            <div class="list-group">
                                <label class="list-group-item d-flex gap-3 py-3 rounded-4 border-2 mb-2">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="mode" value="mobile_money" checked>
                                    <span>
                                        <strong class="d-block text-dark">Mobile Money (T-Money / Flooz)</strong>
                                        <small class="text-muted">Paiement instantané via votre téléphone.</small>
                                    </span>
                                </label>
                                <label class="list-group-item d-flex gap-3 py-3 rounded-4 border-2">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="mode" value="cash">
                                    <span>
                                        <strong class="d-block text-dark">Espèces (Cash)</strong>
                                        <small class="text-muted">Paiement direct à la livraison.</small>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow-sm">
                            Confirmer le paiement de {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('acheteur.commandes.index') }}" class="text-muted small text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Retourner à mes commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection