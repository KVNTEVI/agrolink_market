@extends('layouts.admin')
@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-4">
            <h4 class="fw-bold mb-0 text-dark">Contrôle des Utilisateurs</h4>
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
        <span class="badge bg-dark p-2 px-3 rounded-pill shadow-sm">Total : {{ $utilisateurs->count() }}</span>
        @if($search)
            <span class="badge bg-secondary p-2 px-3 rounded-pill shadow-sm">Résultats pour : "{{ $search }}"</span>
        @endif
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4 py-3">Identité & Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Inscription</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateurs as $u)
                        <tr @if($u->created_at->isToday()) class="table-info-subtle" style="background-color: #f0f9ff;" @endif>
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
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Actif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Bloqué</span>
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
                                            <button class="btn btn-sm btn-outline-warning rounded-3" title="Bloquer">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-success text-white rounded-3" title="Activer">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.utilisateurs.destroy', $u->id_utilisateur) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                Aucun utilisateur trouvé pour cette recherche.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection