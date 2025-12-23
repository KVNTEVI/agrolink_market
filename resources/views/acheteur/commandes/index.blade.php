@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
<div class="container py-4">

    {{-- Titre --}}
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-receipt fs-4 text-success me-2"></i>
        <h4 class="mb-0 fw-semibold">Mes commandes</h4>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Aucune commande --}}
    @if($commandes->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Aucune commande enregistrée.</p>
            <a href="{{ route('boutique.index') }}" class="btn btn-success">
                <i class="bi bi-shop me-1"></i> Accéder à la boutique
            </a>
        </div>
    @else

    {{-- Tableau --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>
                        <i class="bi bi-box-seam me-1"></i> Produit
                    </th>
                    <th>
                        <i class="bi bi-hash me-1"></i> Quantité
                    </th>
                    <th>
                        <i class="bi bi-currency-exchange me-1"></i> Montant
                    </th>
                    <th>
                        <i class="bi bi-info-circle me-1"></i> Statut
                    </th>
                    <th class="text-center">
                        <i class="bi bi-gear me-1"></i> Action
                    </th>
                </tr>
            </thead>

            <tbody>
            @foreach($commandes as $commande)
                @foreach($commande->items as $item)
                <tr>
                    {{-- Produit --}}
                    <td>
                        {{ $item->produit->nom }}
                    </td>

                    {{-- Quantité --}}
                    <td>
                        {{ $item->quantite }}
                    </td>

                    {{-- Montant --}}
                    <td class="fw-semibold">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </td>

                    {{-- Statut --}}
                    <td>
                        @if($commande->statut === 'payée')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle-fill me-1"></i> Payée
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-clock-history me-1"></i> En attente
                            </span>
                        @endif
                    </td>

                    {{-- Action --}}
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('acheteur.commandes.show', $commande->id_commande) }}"
                            class="btn btn-sm btn-outline-primary" 
                            title="Voir les détails">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if($commande->statut !== 'payée')
                                <a href="{{ route('paiement.show', $commande->id_commande) }}"
                                class="btn btn-sm btn-outline-success" 
                                title="Procéder au paiement">
                                    <i class="bi bi-credit-card"></i>
                                </a>
                            @else
                                <span class="text-success p-1" title="Commande réglée">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

    @endif
</div>
@endsection
