@extends('layouts.acheteur')
@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid py-3 py-md-4">
    {{-- EN-TÊTE HARMONISÉ --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-2 mb-md-0">
            <h4 class="fw-bold mb-1">Tableau de bord acheteur</h4>
            <p class="text-muted small mb-0">Bienvenue sur votre espace AgroLink Market</p>
        </div>
        <div class="text-muted small bg-white p-2 rounded shadow-sm d-inline-block">
            <i class="bi bi-clock-history me-2"></i>Dernière activité : {{ now()->format('H:i') }}
        </div>
    </div>

    {{-- STATISTIQUES (Optimisées pour le tactile) --}}
    <div class="row g-3 g-md-4 mb-5">
        {{-- Commandes en cours --}}
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-1 hover-card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-bag-check text-success fs-4"></i>
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-muted d-block text-truncate">Commandes en cours</small>
                        <h4 class="mb-0 fw-bold">{{ $commandesEnCoursCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-1 hover-card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-chat-dots text-primary fs-4"></i>
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-muted d-block text-truncate">Messages</small>
                        <h4 class="mb-0 fw-bold">{{ $messagesCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications --}}
        <div class="col-12 col-sm-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-1 hover-card">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-bell text-warning fs-4"></i>
                    </div>
                    <div class="overflow-hidden">
                        <small class="text-muted d-block text-truncate">Notifications</small>
                        <h4 class="mb-0 fw-bold">{{ $unreadNotificationsCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLEAU DES COMMANDES --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold fs-6 fs-md-5">
                <i class="bi bi-cart3 me-2 text-success"></i>Suivi de mes commandes
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase" style="font-size: 0.75rem;">
                            <th class="ps-4">Réf</th>
                            <th>Produit</th>
                            <th class="d-none d-md-table-cell">Qté</th> {{-- Caché sur mobile pour gagner de la place --}}
                            <th>Total</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dernieresCommandes as $commande)
                        <tr>
                            <td class="ps-4 fw-bold text-dark small">#{{ $commande->id_commande }}</td>
                            <td>
                                <div class="fw-semibold small" style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $commande->items->first()->produit->nom ?? 'Produit inconnu' }}
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $commande->items->sum('quantite') }}
                            </td>
                            <td>
                                <span class="fw-bold small">{{ number_format($commande->montant_total, 0, ',', ' ') }} <span class="d-none d-sm-inline">FCFA</span></span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($commande->statut) {
                                        'en_attente' => 'bg-warning text-warning border-warning',
                                        'payée'      => 'bg-success text-success border-success',
                                        'expedie', 'expédiée' => 'bg-primary text-primary border-primary',
                                        'livre', 'livrée'     => 'bg-success text-success border-success',
                                        'annule'     => 'bg-danger text-danger border-danger',
                                        default      => 'bg-secondary text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} bg-opacity-10 border rounded-pill px-2" style="font-size: 0.65rem;">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('acheteur.commandes.show', $commande->id_commande) }}" class="btn btn-sm btn-light rounded-pill text-primary border">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Aucune commande récente</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 text-center">
            <a href="{{ route('acheteur.commandes.index') }}" class="text-decoration-none small fw-bold text-success">
                Voir tout l'historique <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection