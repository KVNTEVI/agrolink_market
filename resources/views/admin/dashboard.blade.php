@extends('layouts.admin')
@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Vue d'ensemble</h4>
            <p class="text-muted small mb-0">Statistiques globales de la plateforme AgroLink Market</p>
        </div>
        <div class="text-muted small">
            <i class="bi bi-calendar3 me-2"></i>{{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Utilisateurs</small>
                        <h4 class="mb-0 fw-bold">{{ $totalUtilisateurs }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-box-seam text-success fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Produits</small>
                        <h4 class="mb-0 fw-bold">{{ $totalProduits }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-tags text-warning fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Catégories</small>
                        <h4 class="mb-0 fw-bold">{{ $totalCategories }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-credit-card text-info fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Paiements</small>
                        <h4 class="mb-0 fw-bold text-nowrap">{{ number_format($totalPaiements, 0, ',', ' ') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2 text-primary"></i>Inscriptions récentes</h5>
            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Voir tout</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">Utilisateur</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Inscription</th>
                            <th class="text-end pe-4">Action rapide</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateursRecents as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <span class="small fw-bold text-secondary">{{ strtoupper(substr($u->nom, 0, 1)) }}</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold small">{{ $u->nom }} {{ $u->prenom }}</span>
                                        <span class="text-muted" style="font-size: 0.75rem;">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3 fw-normal" style="font-size: 0.7rem;">
                                    {{ $u->role->nom_role ?? 'Client' }}
                                </span>
                            </td>
                            <td>
                                @if($u->statut)
                                    <span class="badge bg-success rounded-pill px-3" style="font-size: 0.7rem;">Actif</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3" style="font-size: 0.7rem;">Bloqué</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $u->created_at->diffForHumans() }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-sm btn-light text-primary border-0">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">Aucun utilisateur récent</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection