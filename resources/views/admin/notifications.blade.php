@extends('layouts.admin')

@section('title', 'Administration - Alertes Système')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête avec textes compréhensifs --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                Journal des Alertes & Activités
            </h4>
            <p class="text-muted small mb-0">
                Suivez les inscriptions, les validations de produits et les rapports de sécurité du marché.
            </p>
        </div>
        
        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
            <div class="d-flex gap-2">
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check2-all me-1"></i> Marquer tout comme traité
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Tableau des notifications --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase fw-bold" style="width: 180px;">Catégorie</th>
                        <th class="py-3 text-muted small text-uppercase fw-bold">Description de l'événement</th>
                        <th class="py-3 text-muted small text-uppercase fw-bold">Date & Heure</th>
                        <th class="text-end pe-4 py-3 text-muted small text-uppercase fw-bold">État de suivi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        @php
                            $isUnread = !$notification->read_at;
                            $type = str_replace(['App\\Notifications\\', 'Notification'], '', $notification->type);
                        @endphp
                        <tr class="{{ $isUnread ? 'bg-primary bg-opacity-10' : 'opacity-75' }}" style="transition: all 0.2s ease;">
                            <td class="ps-4">
                                <span class="badge rounded-pill {{ $isUnread ? 'bg-primary' : 'bg-secondary' }} px-3 py-2 fw-normal">
                                    <i class="bi bi-tag-fill me-1 small"></i> {{ $type }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="{{ $isUnread ? 'fw-bold text-dark' : 'text-muted' }}">
                                        {{ $notification->data['message'] ?? 'Information système générique' }}
                                    </span>
                                    @if($isUnread)
                                        <small class="text-primary" style="font-size: 0.75rem;">Action administrative recommandée</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-muted small">
                                <div><i class="bi bi-calendar3 me-1"></i> {{ $notification->created_at->translatedFormat('d M Y') }}</div>
                                <div><i class="bi bi-clock me-1"></i> {{ $notification->created_at->format('H:i') }}</div>
                            </td>
                            <td class="text-end pe-4">
                                @if($isUnread)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill" title="Classer comme traité">
                                            <span class="small">Clôturer</span> <i class="bi bi-check-lg text-primary ms-1"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small"><i class="bi bi-check2-circle me-1"></i>Traité</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
                                    <p class="mt-3 text-muted mb-0">Aucun événement récent n'a été enregistré dans le journal.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
    {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    /* Style spécifique pour l'administration */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05) !important;
    }
    .btn-white {
        background: #ffffff;
        color: #444;
        transition: all 0.2s;
    }
    .btn-white:hover {
        background: #f8f9fa;
        border-color: #0d6efd !important;
    }
    .bg-primary.bg-opacity-10 {
        border-left: 4px solid #0d6efd;
    }
</style>
@endsection