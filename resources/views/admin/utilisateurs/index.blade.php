@extends('layouts.admin')
@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid py-4" >
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-4">
            <h4 class="fw-bold mb-0 text-success">Contrôle des Utilisateurs</h4>
            <p class="text-muted small mb-0">Gérez les accès et les rôles de la plateforme AgroLink</p>
        </div>
        
        <div class="col-md-8">
            <form action="{{ route('admin.utilisateurs.index') }}" method="GET" class="row g-2 justify-content-md-end align-items-center">
                <div class="col-md-5">
                    <select name="role" class="form-select border-0 shadow-sm py-2" onchange="this.form.submit()">
                        <option value="">Tous les rôles</option>
                        <option value="1" {{ request('role') == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ request('role') == 2 ? 'selected' : '' }}>Acheteur</option>
                        <option value="3" {{ request('role') == 3 ? 'selected' : '' }}>Producteur</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-0 py-2" 
                            placeholder="Nom ou email..." value="{{ $search }}">
                        <button class="btn btn-dark px-3" type="submit">Filtrer</button>
                    </div>
                </div>

                @if($search || $roleFilter)
                <div class="col-auto">
                    <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-light shadow-sm py-2" title="Effacer les filtres">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="mb-3 d-flex gap-2">
        <span class="badge bg-dark p-2 px-3 rounded-pill shadow-sm">Total : {{ $utilisateurs->total() }}</span>
        @if($search)
            <span class="badge bg-secondary p-2 px-3 rounded-pill shadow-sm">Résultats pour : "{{ $search }}"</span>
        @endif
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary">
                            <th class="ps-4 py-3">Identité & Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Inscription</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateurs as $u)
                        <tr @if($u->created_at->isToday()) style="background-color: #f8f9fa;" @endif>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center me-3 border" style="width: 42px; height: 42px;">
                                        <i class="bi bi-person text-dark fs-5"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">
                                            {{ $u->nom }} {{ $u->prenom }}
                                            @if($u->created_at->isToday())
                                                <span class="badge bg-primary ms-1" style="font-size: 0.6rem;">NOUVEAU</span>
                                            @endif
                                        </span>
                                        <small class="text-muted">{{ $u->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 rounded-pill text-uppercase" style="font-size: 0.7rem; font-weight: 600;">
                                    {{ $u->role->nom_role ?? 'Client' }}
                                </span>
                            </td>
                            <td>
                                @if($u->statut)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">Actif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">Bloqué</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                <div>{{ $u->created_at->format('d M Y') }}</div>
                                <div style="font-size: 0.7rem;">{{ $u->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <form action="{{ route('admin.utilisateurs.statut', $u->id_utilisateur) }}" method="POST">
                                        @csrf @method('PATCH')
                                        @if($u->statut)
                                            <button class="btn btn-sm btn-light text-warning border-0 shadow-sm" title="Bloquer">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-dark text-white border-0 shadow-sm" title="Activer">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.utilisateurs.destroy', $u->id_utilisateur) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger border-0 shadow-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                {{ $utilisateurs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<style>
    /* 1. En-tête de tableau sombre */
    .table thead.table-light tr {
        background-color: #1a1d20 !important;
        color: #ffffff !important;
    }
    
    .table thead.table-light th {
        background-color: transparent !important;
        color: #ffffff !important;
        border: none;
        padding-top: 14px;
        padding-bottom: 14px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
    }

    /* 2. Style de la pagination Noir & Blanc */
    .table-pagination nav > div:first-child {
        display: none !important;
    }

    .table-pagination nav > div:last-child {
        width: 100%;
        display: flex !important;
        justify-content: center !important;
    }

    .table-pagination .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .table-pagination .page-link {
        padding: 0.35rem 0.8rem;
        font-size: 0.8rem;
        border: 1px solid #e0e0e0;
        background-color: #ffffff;
        color: #000000;
        border-radius: 4px !important;
        transition: all 0.2s ease;
    }

    .table-pagination .page-link:hover {
        background-color: #000000;
        color: #ffffff;
        border-color: #000000;
    }

    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }

    .table-pagination .page-link:focus {
        box-shadow: none !important;
    }
</style>
@endsection