@extends('layouts.producteur')

@section('title', 'Gestion des Commandes')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">

    {{-- EN-TÊTE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Commandes reçues</h4>
            <p class="text-muted small mb-0">Gérez vos ventes et suivez l'état de vos expéditions.</p>
        </div>
        <div class="badge bg-white text-dark shadow-sm border p-2 px-3 rounded-pill">
            <i class="bi bi-filter me-1 text-success"></i> {{ $commandes->count() }} commande(s) au total
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARTE DES COMMANDES --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Réf & Client</th>
                            <th>Produits commandés</th>
                            <th>Montant Total</th>
                            <th>Statut Actuel</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Changer Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            {{-- Référence et Client --}}
                            <td class="ps-4">
                                <span class="fw-bold text-dark d-block">#{{ $commande->id_commande }}</span>
                                <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $commande->acheteur->nom ?? 'Client inconnu' }}</small>
                            </td>

                            {{-- Détails des produits --}}
                            <td>
                                @foreach($commande->items as $item)
                                    <div class="small">
                                        <span class="fw-semibold">{{ $item->produit->nom ?? 'Produit supprimé' }}</span> 
                                        <span class="text-muted">x{{ $item->quantite }}</span>
                                    </div>
                                @endforeach
                            </td>

                            {{-- Montant --}}
                            <td>
                                <span class="fw-bold text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</span>
                            </td>

                            {{-- Statut avec badges colorés --}}
                            <td>
                                @php
                                    $statusClass = [
                                        'en attente' => 'bg-warning text-warning',
                                        'payée'      => 'bg-info text-info',
                                        'expédiée'   => 'bg-primary text-primary',
                                        'livrée'     => 'bg-success text-success',
                                        'annulée'    => 'bg-danger text-danger',
                                    ][$commande->statut] ?? 'bg-secondary text-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} bg-opacity-10 border rounded-pill px-3 py-2 text-capitalize">
                                    {{ $commande->statut }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="small text-muted">
                                {{ $commande->created_at->format('d/m/Y') }}<br>
                                {{ $commande->created_at->format('H:i') }}
                            </td>

                            {{-- ACTIONS DE CHANGEMENT DE STATUT --}}
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                        <li><h6 class="dropdown-header small text-uppercase">Passer à :</h6></li>
                                        @if($commande->statut != 'expédiée')
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('producteur.commandes.status', [$commande->id_commande, 'expédiée']) }}">
                                                <i class="bi bi-truck me-2 text-primary"></i> Expédiée
                                            </a>
                                        </li>
                                        @endif
                                        @if($commande->statut != 'livrée')
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('producteur.commandes.status', [$commande->id_commande, 'livrée']) }}">
                                                <i class="bi bi-check-all me-2 text-success"></i> Livrée
                                            </a>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('producteur.commandes.status', [$commande->id_commande, 'annulée']) }}">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                                    <i class="bi bi-cart-x text-muted fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark">Aucune commande</h5>
                                <p class="text-muted">Vous n'avez pas encore reçu de commandes pour vos produits.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr:hover { background-color: #fcfdfc !important; }
    .dropdown-item { font-size: 0.85rem; padding: 0.5rem 1rem; }
    .dropdown-item:hover { background-color: #f8f9fa; }
    .badge { font-weight: 600; font-size: 0.75rem; }
</style>
@endsection