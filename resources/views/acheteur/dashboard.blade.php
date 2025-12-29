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
                        <h4 class="mb-0 fw-bold">2</h4>
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
                        <h4 class="mb-0 fw-bold">3</h4>
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
                        <h4 class="mb-0 fw-bold">2</h4>
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
                        {{-- Exemple 1 --}}
                        <tr>
                            <td class="ps-4 fw-bold text-dark">CMD-001</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold">Soja</span>
                                </div>
                            </td>
                            <td>2 Tonnes</td>
                            <td><span class="fw-bold">150 000 FCFA</span></td>
                            <td>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3" style="font-size: 0.7rem;">
                                    En attente
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light rounded-circle text-primary shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>

                        {{-- Exemple 2 --}}
                        <tr>
                            <td class="ps-4 fw-bold text-dark">CMD-002</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold">Anacarde</span>
                                </div>
                            </td>
                            <td>1 Tonne</td>
                            <td><span class="fw-bold">200 000 FCFA</span></td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3" style="font-size: 0.7rem;">
                                    Expédié
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light rounded-circle text-primary shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
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