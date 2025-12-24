@extends('layouts.acheteur')

@section('title', 'Historique des commandes')

@section('content')

{{-- TITRE --}}
<div class="mb-4">
    <h4 class="fw-bold">Historique des commandes</h4>
    <p class="text-muted mb-0">
        Consultez toutes vos commandes passées
    </p>
</div>

{{-- MESSAGE SUCCÈS --}}
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>
@endif

{{-- AUCUNE COMMANDE --}}
@if($commandes->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-receipt fs-1 text-muted"></i>
        <p class="mt-3 text-muted">
            Vous n’avez encore passé aucune commande.
        </p>
        <a href="{{ route('boutique.index') }}" class="btn btn-success">
            <i class="bi bi-shop"></i> Aller à la boutique
        </a>
    </div>
@else

{{-- TABLEAU --}}
<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Commande</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>

            @foreach($commandes as $commande)
                @foreach($commande->items as $item)
                <tr>
                    {{-- ID --}}
                    <td class="fw-semibold">
                        CMD-{{ $commande->id_commande }}
                    </td>

                    {{-- Produit --}}
                    <td>
                        {{ $item->produit->nom }}
                    </td>

                    {{-- Quantité --}}
                    <td>
                        {{ $item->quantite }}
                    </td>

                    {{-- Montant --}}
                    <td>
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </td>

                    {{-- Statut --}}
                    <td>
                        @if($commande->statut === 'payée')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Payée
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-hourglass-split"></i> En attente
                            </span>
                        @endif
                    </td>

                    {{-- Action --}}
                    <td class="text-end">
                        @if($commande->statut !== 'payée')
                            <a href="{{ route('paiement.show', $commande->id_commande) }}"
                               class="btn btn-sm btn-outline-success">
                                <i class="bi bi-credit-card"></i> Payer
                            </a>
                        @else
                            <span class="text-muted">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach

            </tbody>
        </table>
    </div>
</div>

@endif

@endsection
