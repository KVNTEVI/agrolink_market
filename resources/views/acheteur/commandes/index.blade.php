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
                    <th class="text-center">Détails</th> {{-- Nouvelle colonne --}}
                    <th class="text-end">Paiement</th>
                </tr>
            </thead>
            <tbody>

            @foreach($commandes as $commande)
                @foreach($commande->items as $item)
                <tr>
                    {{-- ID --}}
                    <td class="fw-semibold text-nowrap">
                        CMD-{{ $commande->id_commande }}
                    </td>

                    {{-- Produit --}}
                    <td>{{ $item->produit->nom }}</td>

                    {{-- Quantité --}}
                    <td>{{ $item->quantite }}</td>

                    {{-- Montant --}}
                    <td class="text-nowrap">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </td>

                    {{-- Statut --}}
                    <td>
                        @if($commande->statut === 'payée')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                <i class="bi bi-check-circle me-1"></i> Payée
                            </span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3">
                                <i class="bi bi-hourglass-split me-1"></i> En attente
                            </span>
                        @endif
                    </td>

                    {{-- Détails --}}
                    <td class="text-center">
                        <a href="{{ route('acheteur.commandes.show', $commande->id_commande) }}" 
                           class="btn btn-sm btn-light rounded-circle shadow-sm" 
                           title="Voir les détails">
                            <i class="bi bi-eye text-primary"></i>
                        </a>
                    </td>

                    {{-- Action Paiement --}}
                    <td class="text-end">
                        @if($commande->statut !== 'payée')
                            <a href="{{ route('acheteur.paiement.show', $commande->id_commande) }}"
                               class="btn btn-sm btn-success px-3">
                                <i class="bi bi-credit-card me-1"></i> Payer
                            </a>
                        @else
                            <span class="badge bg-light text-muted border px-3">
                                <i class="bi bi-shield-check me-1"></i> Terminé
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
