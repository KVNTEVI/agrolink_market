@extends('layouts.admin')
@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Contrôle des Utilisateurs</h4>
            <p class="text-muted small mb-0">Gérez les accès et les rôles de la plateforme AgroLink</p>
        </div>
        <div class="badge bg-dark p-2 px-3">Inscrits : {{ $utilisateurs->count() }}</div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary" style="font-size: 0.9rem;">
                            <th class="ps-4">Identité & Email</th>
                            <th>Rôle</th>
                            <th>Statut Compte</th>
                            <th>Date d'Inscription</th>
                            <th class="text-end pe-4">Actions de Modération</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utilisateurs as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person text-secondary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $u->nom }} {{ $u->prenom }}</span>
                                        <small class="text-muted">{{ $u->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 rounded-pill text-uppercase" style="font-size: 0.75rem;">
                                    {{ $u->role->nom_role ?? 'Client' }}
                                </span>
                            </td>
                            <td>
                                @if($u->statut)
                                    <span class="badge bg-success rounded-pill px-3">Actif</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3">Bloqué</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $u->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Bouton Bloquer / Débloquer --}}
                                    <form action="{{ route('admin.utilisateurs.statut', $u->id_utilisateur) }}" method="POST">
                                        @csrf @method('PATCH')
                                        @if($u->statut)
                                            <button class="btn btn-sm btn-outline-warning border-0 shadow-sm" title="Bloquer l'accès">
                                                <i class="bi bi-slash-circle"></i> Bloquer
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-success text-white border-0 shadow-sm" title="Activer l'accès">
                                                <i class="bi bi-check-lg"></i> Activer
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Bouton Supprimer --}}
                                    <form action="{{ route('admin.utilisateurs.destroy', $u->id_utilisateur) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light text-danger border-0 shadow-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
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