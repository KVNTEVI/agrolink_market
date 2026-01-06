@extends('layouts.acheteur')
@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid py-4">
    {{-- EN-TÊTE HARMONISÉ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tableau de bord acheteur</h4>
            <p class="text-muted small mb-0">Bienvenue sur votre espace AgroLink Market</p>
        </div>
        <div class="text-muted small">
            <i class="bi bi-clock-history me-2"></i>Dernière activité : {{ now()->format('H:i') }}
        </div>
    </div>

    {{-- STATISTIQUES (Style Admin) --}}
    <div class="row g-4 mb-5">
        {{-- Commandes en cours --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-bag-check text-success fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Commandes en cours</small>
                        <h4 class="mb-0 fw-bold">{{ $commandesEnCoursCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-chat-dots text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Messages</small>
                        <h4 class="mb-0 fw-bold">{{ $messagesCount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-bell text-warning fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Notifications</small>
                        <h4 class="mb-0 fw-bold">{{ $unreadNotificationsCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLEAU DES COMMANDES (Style Admin) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2 text-success"></i>Suivi de mes commandes</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">Référence</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Montant Total</th>
                            <th>Statut Livraison</th>
                            <th class="text-end pe-4">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dernieresCommandes as $commande)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">#{{ $commande->id_commande }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold">{{ $commande->produit->nom ?? 'Produit inconnu' }}</span>
                                </div>
                            </td>
                            <td>{{ $commande->quantite }}</td>
                            <td><span class="fw-bold">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</span></td>
                            <td>
                                @php
                                    $badgeClass = match($commande->statut) {
                                        'en_attente' => 'bg-warning text-warning',
                                        'expedie'    => 'bg-info text-info',
                                        'livre'      => 'bg-success text-success',
                                        'annule'     => 'bg-danger text-danger',
                                        default      => 'bg-secondary text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} bg-opacity-10 border rounded-pill px-3" style="font-size: 0.7rem;">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('acheteur.commandes.show', $commande->id_commande) }}" class="btn btn-sm btn-light rounded-circle text-primary shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Vous n'avez pas encore de commandes.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 text-center">
            <a href="#" class="text-decoration-none small fw-bold text-success">Voir tout l'historique <i class="bi bi-chevron-right"></i></a>
        </div>
    </div>
</div>
@endsection