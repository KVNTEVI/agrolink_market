@extends('layouts.producteur')

@section('title', 'Journal de mes Activités')

@section('content')
<div class="container-fluid py-4 min-vh-100">
    
    {{-- EN-TÊTE HARMONISÉ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-success mb-1">Journal de mes Activités</h4>
            <p class="text-muted small mb-0"><i class="bi bi-bell text-success me-1"></i> Suivez vos commandes et messages clients</p>
        </div>
        
        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
            <form action="{{ route('producteur.notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold btn-sm">
                    <i class="bi bi-check2-all me-1"></i> Tout marquer comme traité
                </button>
            </form>
        @endif
    </div>

    {{-- TABLEAU STYLE "NOIR MAT" --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 border-0">Type d'Alerte</th>
                            <th class="py-3 border-0">Détails de l'événement</th>
                            <th class="py-3 border-0">Date & Heure</th>
                            <th class="text-end pe-4 py-3 border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($allNotifications as $notification)
                            @php $isUnread = !$notification->read_at; @endphp
                            <tr class="{{ $isUnread ? 'bg-success bg-opacity-10' : '' }}" style="transition: all 0.2s ease;">
                                <td class="ps-4">
                                    <span class="status-badge badge {{ $isUnread ? 'bg-success text-success' : 'bg-secondary text-secondary' }} bg-opacity-10 border {{ $isUnread ? 'border-success' : 'border-secondary' }} border-opacity-25 fw-normal">
                                        @if(isset($notification->data['conversation_id']))
                                            <i class="bi bi-chat-left-dots me-1"></i> Message
                                        @else
                                            <i class="bi bi-cart-check me-1"></i> Commande
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small {{ $isUnread ? 'fw-bold text-dark' : 'text-muted' }}">
                                            {{ $notification->data['message'] ?? 'Nouvelle mise à jour' }}
                                        </span>
                                        @if($isUnread && isset($notification->data['conversation_id']))
                                            <small class="text-success fw-medium" style="font-size: 0.65rem;">Réponse attendue</small>
                                        @endif
                                    </div>
                                </td>

                                <td class="small text-muted">
                                    <div class="text-nowrap"><i class="bi bi-calendar3 me-1"></i> {{ $notification->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="text-nowrap"><i class="bi bi-clock me-1"></i> {{ $notification->created_at->format('H:i') }}</div>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        @if(isset($notification->data['conversation_id']))
                                            <a href="{{ route('producteur.conversation.show', $notification->data['conversation_id']) }}" 
                                               class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 fw-bold" style="font-size: 0.75rem;">
                                                Consulter
                                            </a>
                                        @endif

                                        @if($isUnread)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-white border shadow-sm rounded-3 px-2 text-success" title="Marquer comme lu">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-light text-muted border fw-normal rounded-pill px-2" style="font-size: 0.7rem;">
                                                <i class="bi bi-check2-all me-1"></i>Lu
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
                                    <p class="mt-3 text-muted">Aucune activité enregistrée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FOOTER PAGINATION - EXACTEMENT COMME L'ACHETEUR --}}
        <div class="card-footer bg-white border-top py-2">
            <div class="d-flex justify-content-center">
                @if($allNotifications->hasPages())
                    {{ $allNotifications->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

<style>
    /* Global Background */
    body { background-color: #f0f2f5; }

    /* En-tête Noir Mat */
    .table thead.table-dark tr { background-color: #1a1d20 !important; }
    .table thead th {
        color: #ffffff !important;
        border: none !important;
        padding: 15px 10px !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.8px;
    }

    /* Centrage vertical des cellules */
    .table tbody td {
        vertical-align: middle !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }

    /* Badges alignés */
    .status-badge {
        min-width: 100px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 6px 12px !important;
        font-size: 0.7rem !important;
        border-radius: 50px !important;
    }

    /* Style des lignes non lues */
    .bg-success.bg-opacity-10 {
        border-left: 4px solid #198754 !important;
    }

    /* Style du survol vert */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.1) !important;
        transition: background-color 0.15s ease-in-out;
    }

    /* Boutons Blancs Action */
    .btn-white {
        background: #ffffff !important;
        border: 1px solid #dee2e6 !important;
        transition: all 0.2s !important;
        color: #212529 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .btn-white:hover {
        background: #f8f9fa !important;
        border-color: #198754 !important;
        color: #198754 !important;
    }

/* --- SECTION PAGINATION CORRIGÉE --- */
    .card-footer .pagination {
        margin-bottom: 0 !important; /* Supprime la marge du bas qui crée l'espace vide */
        margin-top: 0 !important;
        display: flex !important;
        padding-left: 0;
        list-style: none;
    }

    .card-footer .page-item .page-link {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 32px !important; /* Taille légèrement réduite pour plus d'élégance */
        min-width: 32px !important;
        padding: 0 8px !important;
        font-size: 0.8rem !important;
        border: 1px solid #dee2e6 !important;
        background-color: #ffffff !important;
        color: #000000 !important;
        border-radius: 6px !important;
        margin: 0 2px !important;
        transition: all 0.2s ease !important;
    }

    .card-footer .page-item.active .page-link {
        background-color: #1a1d20 !important; /* Noir mat pour l'actif */
        border-color: #1a1d20 !important;
        color: #ffffff !important;
    }

    .card-footer .page-link:hover {
        background-color: #f8f9fa !important;
        border-color: #198754 !important;
        color: #198754 !important;
    }

    /* Supprime les flèches doubles ou textes bizarres si présents */
    .pagination nav svg {
        height: 16px;
    }
</style>
@endsection