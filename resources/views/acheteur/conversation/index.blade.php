@extends('layouts.acheteur')
@section('title', 'Mes Messages')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Mes Conversations</h4>
            <p class="text-muted small mb-0">Discutez et négociez avec les producteurs</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">Producteur</th>
                            <th>Produit concerné</th>
                            <th>Dernier message</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conversations as $conv)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block">{{ $conv->producteur->nom }} {{ $conv->producteur->prenom }}</span>
                                        <small class="text-muted">Producteur</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    {{ $conv->produit->nom_produit ?? 'Produit supprimé' }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $conv->updated_at->diffForHumans() }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('conversation.show', $conv->id_conversation) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="bi bi-chat-left-text me-1"></i> Ouvrir
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-square-dots fs-1 d-block mb-2"></i>
                                Aucune conversation en cours.
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