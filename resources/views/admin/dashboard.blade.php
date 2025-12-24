@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold">Vue d'ensemble</h4>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card card-stats shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted">Utilisateurs</small>
                        <h4 class="mb-0 fw-bold">{{ $totalUtilisateurs }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-box-seam text-success fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted">Produits</small>
                        <h4 class="mb-0 fw-bold">{{ $totalProduits }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-tags text-warning fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted">Catégories</small>
                        <h4 class="mb-0 fw-bold">{{ $totalCategories }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-credit-card text-info fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted">Paiements</small>
                        <h4 class="mb-0 fw-bold">{{ $totalPaiements }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Gestion des utilisateurs</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ici, vous bouclerez sur vos utilisateurs réels --}}
                        @foreach($utilisateursRecents ?? [] as $u)
                        <tr>
                            <td class="fw-bold">{{ $u->nom }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role->nom ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $u->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill p-2 px-3">
                                    {{ $u->is_active ? 'Actif' : 'Bloqué' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-slash-circle"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection