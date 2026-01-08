@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="container-fluid">
    {{-- En-tête avec titre et paragraphe ajoutés --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Gestion des catégories</h4>
            <p class="text-muted small mb-0">Organisez et gérez les types de produits disponibles sur AgroLink Market</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="badge bg-dark p-2 px-3">Total : {{ $categories->count() }}</div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success shadow-sm rounded-3">
                <i class="bi bi-plus-lg"></i> Ajouter
            </a>
        </div>
    </div>

    {{-- Carte stylisée --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 100px;">N°</th>
                            <th>Nom de la catégorie</th>
                            <th>Date de création</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $categorie)
                        <tr>
                            {{-- Numérotation automatique --}}
                            <td class="ps-4 text-muted fw-bold">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="bi bi-tag-fill text-success"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $categorie->nom }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i> 
                                    {{ $categorie->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Bouton Modifier --}}
                                    <a href="{{ route('admin.categories.edit', $categorie->id_categorie) }}" 
                                       class="btn btn-sm btn-light text-primary border-0 shadow-sm" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Bouton Supprimer --}}
                                    <form action="{{ route('admin.categories.destroy', $categorie->id_categorie) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Supprimer cette catégorie ? Cela pourrait affecter les produits liés.')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border-0 shadow-sm" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                Aucune catégorie enregistrée.
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