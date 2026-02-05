@extends('layouts.admin')
@section('title', 'Tableau de Bord')

@section('content')
{{-- Fond de page plus sombre pour faire ressortir les cartes --}}
<div class="container-fluid py-4 min-vh-100">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-success">Vue d'ensemble</h4>
            <p class="text-muted small mb-0">Statistiques globales de la plateforme AgroLink Market</p>
        </div>
        <div class="text-muted small bg-white px-3 py-2 rounded shadow-sm border">
            <i class="bi bi-calendar3 me-2 text-primary"></i>{{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- Cartes de statistiques : Alignement de 5 cartes --}}
    <div class="row g-3 mb-5">
        {{-- Utilisateurs --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm rounded-4 p-2 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Utilisateurs</small>
                        <h5 class="mb-0 fw-bold">{{ $totalUtilisateurs }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produits --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm rounded-4 p-2 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-box-seam text-success fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Produits</small>
                        <h5 class="mb-0 fw-bold">{{ $totalProduits }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Catégories --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm rounded-4 p-2 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-tags text-warning fs-4"></i>
                    </div>
                    <div>
                        <small class="mb-0 small text-muted">Catégories</small>
                        <h5 class="mb-0 fw-bold">{{ $totalCategories }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Paiements --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm rounded-4 p-2 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-credit-card text-info fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Paiements</small>
                        <h5 class="mb-0 fw-bold text-nowrap">{{ number_format($totalPaiements, 0, ',', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenus Plateforme --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card border-0 shadow-sm rounded-4 p-2 h-100 bg-dark">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-25 p-3 rounded-4 me-3">
                        <i class="bi bi-piggy-bank text-success fs-4"></i>
                    </div>
                    <div>
                        <small class="text-white-50 d-block mb-1">Revenus (5%)</small>
                        <h5 class="mb-0 fw-bold text-white text-nowrap">
                            {{ number_format($revenusPlateforme, 0, ',', ' ') }} <small style="font-size: 0.6em">FCFA</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau des inscriptions récentes --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2 text-dark"></i>Inscriptions récentes</h5>
            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-sm btn-dark rounded-pill px-4 shadow-sm" style="font-size: 0.8rem;">
                Voir tout
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0">Utilisateur</th>
                            <th class="border-0">Rôle</th>
                            <th class="border-0">Statut</th>
                            <th class="border-0">Inscription</th>
                            <th class="text-end pe-4 border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($utilisateursRecents as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3 border shadow-sm" style="width: 38px; height: 38px;">
                                        <span class="small fw-bold text-dark">{{ strtoupper(substr($u->nom, 0, 1)) }}</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark small">{{ $u->nom }} {{ $u->prenom }}</span>
                                        <span class="text-muted" style="font-size: 0.75rem;">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3 fw-normal" style="font-size: 0.7rem; font-weight: 600;">
                                    {{ $u->role->nom_role ?? 'Client' }}
                                </span>
                            </td>
                            <td>
                                @if($u->statut)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3" style="font-size: 0.7rem;">Actif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3" style="font-size: 0.7rem;">Bloqué</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                <div class="fw-medium text-dark">{{ $u->created_at->format('d M Y') }}</div>
                                <div class="opacity-75" style="font-size: 0.7rem;">{{ $u->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-sm btn-light text-dark border-0 shadow-sm rounded-3">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted bg-white">
                                <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                                Aucun utilisateur récent
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
    /* Global Background */
    body { background-color: #f0f2f5; }

    /* Style des en-têtes de table */
    .table thead.table-dark tr {
        background-color: #1a1d20 !important;
    }
    
    .table thead th {
        color: #ffffff !important;
        border: none !important;
        padding-top: 15px !important;
        padding-bottom: 15px !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
    }

    /* Effet au survol des lignes */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    /* Harmonisation des cartes statistiques */
    .card.shadow-sm {
        transition: transform 0.2s ease;
    }
    .card.shadow-sm:hover {
        transform: translateY(-3px);
    }

    /* Ajustement responsive pour petits écrans */
    @media (max-width: 1200px) {
        h5.mb-0 { font-size: 1rem; }
    }
</style>
@endsection