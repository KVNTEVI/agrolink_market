@extends('layouts.app')

@section('title', 'Paiement de la commande')

@section('content')
<div class="container py-4">

    {{-- Retour --}}
    <a href="{{ route('acheteur.commandes.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left"></i> Mes commandes
    </a>

    {{-- Titre --}}
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-credit-card fs-3 text-success me-2"></i>
        <h4 class="mb-0 fw-bold">Paiement de la commande</h4>
    </div>

    {{-- Carte paiement --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Infos commande --}}
            <div class="mb-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-receipt"></i> Détails de la commande
                </h6>

                <div class="row mb-2">
                    <div class="col-md-4 text-muted">Commande N°</div>
                    <div class="col-md-8 fw-semibold">#{{ $commande->id_commande }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-muted">Montant total</div>
                    <div class="col-md-8 fw-bold text-success">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-muted">Statut</div>
                    <div class="col-md-8">
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-hourglass-split"></i> En attente de paiement
                        </span>
                    </div>
                </div>
            </div>

            {{-- Mode de paiement --}}
            <div class="mb-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-wallet2"></i> Mode de paiement
                </h6>

                <div class="alert alert-light border">
                    <i class="bi bi-phone"></i>
                    Paiement simulé par <strong>Mobile Money / Cash</strong>
                </div>
            </div>

            {{-- Action paiement --}}
            <div class="d-flex justify-content-end gap-2">
                <form method="POST" action="{{ route('paiement.payer', $commande->id_commande) }}">
                    @csrf
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle"></i> Confirmer le paiement
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
