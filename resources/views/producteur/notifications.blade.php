@extends('layouts.producteur')

@section('title', 'Gestion des Activités')

@section('content')
<div class="container-fluid py-4">
    {{-- En-tête avec textes compréhensifs --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                Journal de mes Activités
            </h4>
            <p class="text-muted small mb-0">
                Suivez vos nouvelles commandes, les messages de vos clients et les mises à jour de vos produits.
            </p>
        </div>
        
        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
            <div class="d-flex gap-2">
                <form action="{{ route('producteur.notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check2-all me-1"></i> Tout marquer comme traité
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Tableau des notifications (Style Admin) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase fw-bold" style="width: 180px;">Type d'Alerte</th>
                        <th class="py-3 text-muted small text-uppercase fw-bold">Détails de l'événement</th>
                        <th class="py-3 text-muted small text-uppercase fw-bold">Date & Heure</th>
                        <th class="text-end pe-4 py-3 text-muted small text-uppercase fw-bold">État de lecture</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(auth()->user()->notifications as $notification)
                        @php
                            $isUnread = !$notification->read_at;
                            // Simplification du nom de la notification pour le badge
                            $type = str_replace(['App\\Notifications\\', 'Notification'], '', $notification->type);
                        @endphp
                        <tr class="{{ $isUnread ? 'bg-success bg-opacity-10' : 'opacity-75' }}" style="transition: all 0.2s ease;">
                            <td class="ps-4">
                                <span class="badge rounded-pill {{ $isUnread ? 'bg-success' : 'bg-secondary' }} px-3 py-2 fw-normal">
                                    @if(isset($notification->data['conversation_id']))
                                        <i class="bi bi-chat-left-dots me-1 small"></i> Message
                                    @else
                                        <i class="bi bi-cart-check me-1 small"></i> Commande
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="{{ $isUnread ? 'fw-bold text-dark' : 'text-muted' }}">
                                        {{ $notification->data['message'] ?? 'Nouvelle mise à jour' }}
                                    </span>
                                    @if($isUnread && isset($notification->data['conversation_id']))
                                        <small class="text-success" style="font-size: 0.75rem;">Réponse client attendue</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-muted small">
                                <div><i class="bi bi-calendar3 me-1"></i> {{ $notification->created_at->translatedFormat('d M Y') }}</div>
                                <div><i class="bi bi-clock me-1"></i> {{ $notification->created_at->format('H:i') }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group align-items-center">
                                    {{-- Action principale : Voir --}}
                                    @if(isset($notification->data['conversation_id']))
                                        <a href="{{ route('producteur.conversation.show', $notification->data['conversation_id']) }}" 
                                           class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill me-2" title="Ouvrir la discussion">
                                            <span class="small">Consulter</span>
                                        </a>
                                    @endif

                                    {{-- Action : Marquer comme lu --}}
                                    @if($isUnread)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-success border-0 rounded-circle" title="Marquer comme traité">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small px-2"><i class="bi bi-check2-circle me-1"></i>Lu</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
                                    <p class="mt-3 text-muted mb-0">Aucune activité enregistrée pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Harmonisation avec le style Admin mais aux couleurs Producteur (Vert) */
    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.05) !important;
    }
    .btn-white {
        background: #ffffff;
        color: #198754;
        transition: all 0.2s;
    }
    .btn-white:hover {
        background: #f8f9fa;
        border-color: #198754 !important;
    }
    /* Bordure latérale pour les nouveaux messages */
    .bg-success.bg-opacity-10 {
        border-left: 4px solid #198754;
    }
</style>
@endsection