@extends('layouts.admin')
@section('title', 'Gestion des Produits')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Modération des produits</h4>
        <div class="badge bg-dark p-2 px-3">Total : {{ $produits->count() }}</div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Image & Nom</th>
                            <th>Prix</th>
                            <th>Statut Actuel</th>
                            <th class="text-end pe-4">Actions de Modération</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($p->image ? 'images/produits/'.$p->image : 'images/default.png') }}" 
                                         class="rounded-3 me-3" width="45" height="45" style="object-fit: cover;">
                                    <span class="fw-bold">{{ $p->nom }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($p->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($p->statut == 'valide')
                                    <span class="badge bg-success rounded-pill">Validé</span>
                                @elseif($p->statut == 'refuse')
                                    <span class="badge bg-danger rounded-pill">Refusé</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill">En attente</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Bouton Valider --}}
                                    <form action="{{ route('admin.produits.approve', $p->id_produit) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success text-white border-0 shadow-sm" title="Approuver">
                                            <i class="bi bi-check-circle"></i> Valider
                                        </button>
                                    </form>

                                    {{-- Bouton Refuser --}}
                                    <form action="{{ route('admin.produits.reject', $p->id_produit) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger border-0 shadow-sm" title="Refuser">
                                            <i class="bi bi-x-circle"></i> Refuser
                                        </button>
                                    </form>

                                    {{-- Bouton Supprimer --}}
                                    <form action="{{ route('admin.produits.destroy', $p->id_produit) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">
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