@extends('layouts.app')

@section('title', 'Détail commande')

@section('content')
<div class="container py-4">

    {{-- Titre --}}
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-file-text fs-4 text-primary me-2"></i>
        <h4 class="mb-0 fw-semibold">Détail de la commande</h4>
    </div>

    {{-- Infos générales --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">

                <div class="col-md-4">
                    <i class="bi bi-hash"></i>
                    <strong>Commande :</strong> #{{ $commande->id_commande }}
                </div>

                <div class="col-md-4">
                    <i class="bi bi-calendar-event"></i>
                    <strong>Date :</strong>
                    {{ $commande->created_at->format('d/m/Y') }}
                </div>

                <div class="col-md-4">
                    <i class="bi bi-info-circle"></i>
                    <strong>Statut :</strong>
                    @if($commande->statut === 'payée')
                        <span class="badge bg-success">Payée</span>
                    @else
                        <span class="badge bg-warning text-dark">En attente</span>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Produits --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-box-seam me-1"></i> Produits commandés
        </div>

        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($commande->items as $item)
                <tr>
                    <td>{{ $item->produit->nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->prix_final, 0, ',', ' ') }} FCFA</td>
                    <td class="fw-semibold">
                        {{ number_format($item->prix_final * $item->quantite, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-4 d-flex justify-content-between">
        <a href="{{ route('acheteur.commandes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>

        @if($commande->statut !== 'payée')
            <a href="{{ route('paiement.show', $commande->id_commande) }}"
               class="btn btn-success">
                <i class="bi bi-credit-card"></i> Payer la commande
            </a>
        @endif
    </div>

</div>
@endsection
