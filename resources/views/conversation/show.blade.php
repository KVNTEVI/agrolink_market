@extends('layouts.acheteur')

@section('title', 'Négociation - ' . $conversation->produit->nom)

@section('content')
<div class="container-fluid py-4">

    {{-- Fil d'ariane / Retour --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('acheteur.conversation.index') }}" class="text-success text-decoration-none">Messages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Négociation #{{ $conversation->id_conversation }}</li>
        </ol>
    </nav>

    {{-- En-tête conversation --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="bi bi-chat-dots text-success fs-4"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        {{ $conversation->produit->nom_produit ?? $conversation->produit->nom }}
                    </h5>
                    <div class="mt-1">
                        @if($conversation->statut === 'ouverte')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">
                                <i class="bi bi-unlock me-1"></i> Discussion ouverte
                            </span>
                        @elseif($conversation->statut === 'accord' || $conversation->statut === 'accord_trouve')
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3">
                                <i class="bi bi-check-circle me-1"></i> Accord trouvé
                            </span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3">
                                <i class="bi bi-lock me-1"></i> Clôturée
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($conversation->prix_final)
                <div class="text-end">
                    <span class="text-muted d-block small">Prix final</span>
                    <span class="badge bg-success fs-5 px-3 py-2 rounded-4">
                        {{ number_format($conversation->prix_final, 0, ',', ' ') }} FCFA
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Zone de Messages --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body bg-light bg-opacity-50 p-4" id="chat-container" style="height: 450px; overflow-y: auto;">
            @forelse($conversation->messages as $message)
                <div class="mb-4 d-flex {{ $message->expediteur_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="shadow-sm p-3 {{ $message->expediteur_id === auth()->id() ? 'bg-success text-white rounded-start-4 rounded-bottom-4' : 'bg-white text-dark rounded-end-4 rounded-bottom-4' }}" style="max-width: 75%;">
                        <div class="small fw-bold mb-1 d-flex align-items-center">
                            <i class="bi bi-person-circle me-2"></i>
                            {{ $message->expediteur_id === auth()->id() ? 'Moi' : $message->expediteur->nom }}
                        </div>

                        @if($message->contenu)
                            <p class="mb-0">{{ $message->contenu }}</p>
                        @endif

                        @if($message->prix_propose)
                            <div class="mt-2 p-2 rounded {{ $message->expediteur_id === auth()->id() ? 'bg-white bg-opacity-20' : 'bg-light' }} border border-white border-opacity-10 fw-bold">
                                <i class="bi bi-tag-fill me-1"></i>
                                Offre : {{ number_format($message->prix_propose, 0, ',', ' ') }} FCFA
                            </div>
                        @endif

                        <div class="text-end mt-2 opacity-50" style="font-size: 0.75rem;">
                            {{ $message->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-chat-quote fs-1 d-block mb-3 opacity-25"></i>
                    Dites bonjour pour commencer la négociation !
                </div>
            @endforelse
        </div>

        {{-- Formulaire d'envoi --}}
        <div class="card-footer bg-white border-0 p-4">
            @if($conversation->statut === 'ouverte')
                <form action="{{ route('conversation.message.store', $conversation->id_conversation) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-chat-left-text text-muted"></i></span>
                                <input type="text" name="contenu" class="form-control bg-light border-0 py-2" placeholder="Écrire un message..." required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-cash text-muted"></i></span>
                                <input type="number" name="prix_propose" class="form-control bg-light border-0 py-2" placeholder="Proposer un prix">
                            </div>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-success rounded-3 shadow-sm py-2">
                                <i class="bi bi-send-fill me-1"></i> Envoyer
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-info border-0 rounded-4 d-flex align-items-center mb-0">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Négociation terminée.</strong> Le canal de discussion est désormais fermé aux nouveaux messages.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Faire défiler vers le bas automatiquement au chargement
    document.addEventListener("DOMContentLoaded", function() {
        var container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endsection