@extends('layouts.acheteur')

@section('title', 'Mes Notifications')

@section('content')
<div class="container-fluid py-4 min-vh-100">
    {{-- EN-TÊTE --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h4 class="fw-bold text-success mb-1">Suivi de mes Activités</h4>
            <p class="text-muted small mb-0">Consultez l'état de vos commandes, vos messages et alertes.</p>
        </div>
        
        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
        <div class="mt-3 mt-md-0">
            <form action="{{ route('acheteur.notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm">
                    <i class="bi bi-check2-all me-1"></i> Tout marquer comme lu
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- TABLEAU DES NOTIFICATIONS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.8px;">Type d'Alerte</th>
                            <th class="py-3 border-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.8px;">Détails de l'événement</th>
                            <th class="py-3 border-0 text-uppercase text-center" style="font-size: 0.7rem; letter-spacing: 0.8px;">Date & Heure</th>
                            <th class="text-end pe-4 py-3 border-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.8px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse(auth()->user()->notifications as $notification)
                            @php
                                $isUnread = !$notification->read_at;
                                $type = str_replace(['App\\Notifications\\', 'Notification'], '', $notification->type);
                            @endphp
                            <tr class="{{ $isUnread ? 'unread-row' : 'opacity-75' }}">
                                <td class="ps-4">
                                    <span class="badge rounded-pill {{ $isUnread ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $isUnread ? 'text-success' : 'text-secondary' }} border px-3 py-2 fw-normal" style="font-size: 0.65rem;">
                                        @if(isset($notification->data['conversation_id']))
                                            <i class="bi bi-chat-dots me-1"></i> Message
                                        @else
                                            <i class="bi bi-bag me-1"></i> Commande
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="{{ $isUnread ? 'fw-bold text-dark' : 'text-muted' }} small">
                                            {{ $notification->data['message'] ?? 'Mise à jour de votre commande' }}
                                        </span>
                                        @if($isUnread && isset($notification->data['conversation_id']))
                                            <small class="text-success fw-bold" style="font-size: 0.7rem;">Nouveau message du producteur</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="small fw-bold text-dark">{{ $notification->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $notification->created_at->format('H:i') }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        @if(isset($notification->data['conversation_id']))
                                            <a href="{{ route('acheteur.notifications.readAndView', $notification->id) }}" 
                                               class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 py-1">
                                                <span style="font-size: 0.75rem;">Voir</span>
                                            </a>
                                        @endif

                                        @if($isUnread)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-light border rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                        style="width: 30px; height: 30px;" title="Marquer comme lu">
                                                    <i class="bi bi-check2 text-success"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted bg-white">
                                    <i class="bi bi-bell-slash display-4 opacity-25 d-block mb-3"></i>
                                    Vous n'avez aucune notification pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION HARMONISÉE --}}
        @if($allNotifications->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="table-pagination d-flex justify-content-center align-items-center">
                {{ $allNotifications->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Global Background */
    body { background-color: #f0f2f5; }

    /* En-tête noir mat */
    .table thead.table-dark tr {
        background-color: #1a1d20 !important;
    }
    
    .table thead th {
        color: #ffffff !important;
        border: none !important;
        padding-top: 15px !important;
        padding-bottom: 15px !important;
        font-weight: 500;
    }

    /* Style des lignes non lues */
    .unread-row {
        background-color: rgba(25, 135, 84, 0.04) !important;
        border-left: 4px solid #198754;
    }

    /* Effet Hover Vert */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.1) !important;
        transition: background-color 0.15s ease-in-out;
    }

    /* Bouton blanc */
    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
    }
    .btn-white:hover {
        background: #f8f9fa;
        border-color: #198754 !important;
        color: #198754;
    }

    /* Pagination Harmonisée */
    .table-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        padding: 0 0.8rem;
        font-size: 0.8rem;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        color: #212529;
        border-radius: 4px !important;
        margin: 0 2px;
    }
    .table-pagination .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }
</style>
@endsection