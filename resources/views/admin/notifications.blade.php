@extends('layouts.admin')

@section('title', 'Administration - Alertes Système')

@section('content')
<div class="container-fluid py-4 min-vh-100">
    {{-- En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-success mb-1">Journal des Alertes & Activités</h4>
            <p class="text-muted small mb-0">Suivez les inscriptions, les validations de produits et les rapports de sécurité.</p>
        </div>
        
        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
            <div class="d-flex gap-2">
                <form action="{{ route('admin.notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check2-all me-1"></i> Marquer tout comme traité
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Tableau des notifications --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0" style="width: 180px;">Catégorie</th>
                            <th class="py-3 border-0">Description de l'événement</th>
                            <th class="py-3 border-0">Date & Heure</th>
                            <th class="text-end pe-4 py-3 border-0">État de suivi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($notifications as $notification)
                            @php
                                $isUnread = !$notification->read_at;
                                $type = str_replace(['App\\Notifications\\', 'Notification'], '', $notification->type);
                            @endphp
                            <tr class="{{ $isUnread ? 'unread-row' : 'opacity-75' }}">
                                <td class="ps-4">
                                    <span class="badge rounded-pill {{ $isUnread ? 'bg-dark' : 'bg-light text-muted border' }} px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-tag-fill me-1"></i> {{ strtoupper($type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="{{ $isUnread ? 'fw-bold text-dark' : 'text-muted' }} small">
                                            {{ $notification->data['message'] ?? 'Information système générique' }}
                                        </span>
                                        @if($isUnread)
                                            <small class="text-success fw-medium" style="font-size: 0.7rem;">Action recommandée</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    <div class="fw-medium text-dark"><i class="bi bi-calendar3 me-1"></i> {{ $notification->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="opacity-75" style="font-size: 0.7rem;"><i class="bi bi-clock me-1"></i> {{ $notification->created_at->format('H:i') }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    @if($isUnread)
                                        <a href="{{ route('admin.notifications.readAndView', $notification->id) }}" 
                                           class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill">
                                            <span class="small">Consulter</span> <i class="bi bi-eye text-success ms-1"></i>
                                        </a>
                                    @else
                                        <span class="badge bg-light text-success border border-success border-opacity-25 rounded-pill px-3 fw-normal">
                                            <i class="bi bi-check2-circle me-1"></i>Traité
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 bg-white">
                                    <div class="py-4">
                                        <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
                                        <p class="mt-3 text-muted mb-0">Aucun événement enregistré dans le journal.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                {{ $notifications->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; }

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

    /* Style des lignes non lues */
    .unread-row {
        background-color: rgba(25, 135, 84, 0.02) !important; /* Teinte verte très légère */
        border-left: 4px solid #198754; /* Bordure verte (success) pour marquer l'importance */
    }

    /* --- MODIFICATION DEMANDÉE : HOVER SUCCESS OPACITY 10 --- */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.1) !important; /* Correspond à bg-success bg-opacity-10 */
        transition: background-color 0.15s ease-in-out;
    }

    .table-hover tbody tr:hover td {
        color: #000; 
    }

    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
    }

    .btn-white:hover {
        background: #198754;
        color: #ffffff !important;
        border-color: #198754;
    }

    /* Pagination Noir & Blanc */
    .table-pagination nav > div:first-child { display: none !important; }
    .table-pagination nav > div:last-child {
        width: 100%;
        display: flex !important;
        justify-content: center !important;
    }
    .table-pagination .pagination { gap: 4px; margin-bottom: 0; }
    .table-pagination .page-link {
        padding: 0.35rem 0.8rem;
        font-size: 0.8rem;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        color: #000000;
        border-radius: 4px !important;
    }
    .table-pagination .page-link:hover {
        background-color: #000000;
        color: #ffffff;
    }
    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }
</style>
@endsection