@extends('layouts.acheteur') {{-- Utilisation du layout acheteur pour garder la sidebar --}}

@section('title', 'Négociation - ' . $conversation->produit->nom_produit)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            
            {{-- HEADER DE LA CONVERSATION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('acheteur.messages.index') }}" class="btn btn-light rounded-circle me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">{{ $conversation->produit->nom_produit }}</h5>
                            <span class="small text-muted">Avec le producteur : <strong>{{ $conversation->producteur->nom }}</strong></span>
                        </div>
                    </div>
                    <div>
                        <span class="badge rounded-pill px-3 py-2 
                            {{ $conversation->statut === 'accord_trouve' ? 'bg-success bg-opacity-10 text-success border-success' :
                               ($conversation->statut === 'cloturee' ? 'bg-secondary bg-opacity-10 text-secondary' : 'bg-warning bg-opacity-10 text-warning') }} border">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ ucfirst(str_replace('_',' ', $conversation->statut)) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ZONE DE MESSAGES --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4" id="chat-box" style="height: 500px; overflow-y: auto; background-color: #f8f9fa;">
                    @foreach($conversation->messages as $message)
                        <div class="d-flex {{ $message->expediteur_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-4">
                            <div style="max-width: 80%;">
                                <div class="p-3 shadow-sm {{ $message->expediteur_id === auth()->id() 
                                    ? 'bg-success text-white rounded-start-4 rounded-bottom-4' 
                                    : 'bg-white text-dark rounded-end-4 rounded-bottom-4' }}">
                                    
                                    @if($message->contenu)
                                        <div class="mb-0">{{ $message->contenu }}</div>
                                    @endif

                                    @if($message->prix_propose)
                                        <div class="mt-2 p-2 bg-black bg-opacity-10 rounded text-center fw-bold">
                                            <i class="bi bi-tag-fill me-1"></i>
                                            Offre : {{ number_format($message->prix_propose, 0, ',', ' ') }} FCFA
                                        </div>
                                    @endif
                                </div>
                                <div class="small text-muted mt-1 {{ $message->expediteur_id === auth()->id() ? 'text-end' : '' }}">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- FORMULAIRE D'ACTION (PIED DE PAGE) --}}
                <div class="card-footer bg-white border-0 p-4">
                    
                    {{-- BOUTONS D'ACTION POUR LE PRODUCTEUR --}}
                    @if(auth()->id() === $conversation->producteur_id && $conversation->statut === 'ouverte')
                    <div class="alert alert-light border d-flex align-items-center justify-content-between rounded-4 mb-4">
                        <span class="small fw-bold text-dark">Répondre à cette offre :</span>
                        <div class="d-flex gap-2">
                            <form action="{{ route('producteur.conversation.accepter', $conversation->id_conversation) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm rounded-pill px-3">Accepter l'offre</button>
                            </form>
                            <form action="{{ route('producteur.conversation.refuser', $conversation->id_conversation) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3">Refuser</button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- ENVOI DE MESSAGE --}}
                    @if($conversation->statut === 'ouverte')
                    <form action="{{ route('conversation.message.store', $conversation->id_conversation) }}" method="POST">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-7">
                                <div class="form-floating">
                                    <input type="text" name="contenu" class="form-control rounded-4 bg-light border-0" id="msg" placeholder="Votre message">
                                    <label for="msg text-muted">Message...</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="number" name="prix_propose" class="form-control rounded-4 bg-light border-0" id="prix" placeholder="Prix proposé">
                                    <label for="prix text-muted">Prix proposé (FCFA)</label>
                                </div>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button class="btn btn-success rounded-4 shadow-sm">
                                    <i class="bi bi-send-fill fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-2">
                        <span class="text-muted small"><i class="bi bi-lock-fill"></i> Cette conversation est terminée.</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Scroll automatique vers le bas pour voir les derniers messages
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection