@extends('layouts.producteur')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- EN-TÊTE --}}
        <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/produits/' . $conversation->produit->image) }}" class="rounded-3 me-3" width="50" height="50" style="object-fit: cover;">
                <div>
                    <h6 class="fw-bold mb-0">{{ $conversation->produit->nom }}</h6>
                    <small class="text-muted">
                        {{ Auth::user()->role_id == 3 ? 'Acheteur : ' . $conversation->acheteur->nom : 'Producteur : ' . $conversation->producteur->nom }}
                    </small>
                </div>
            </div>
            
            {{-- Le producteur voit les boutons seulement si la conversation est encore ouverte --}}
            @if(Auth::user()->role_id == 3 && $conversation->statut == 'ouverte')
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
            @endif
        </div>

        {{-- ZONE DE MESSAGES --}}
        <div id="chat-box" class="card-body bg-light p-4" style="height: 450px; overflow-y: auto;">
            @foreach($conversation->messages as $msg)
                <div class="d-flex {{ $msg->expediteur_id == Auth::user()->id_utilisateur ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                    <div class="max-width-75" style="max-width: 75%;">
                        <div class="p-3 rounded-4 {{ $msg->expediteur_id == Auth::user()->id_utilisateur ? 'bg-primary text-white shadow-sm' : 'bg-white border' }}">
                            @if($msg->prix_propose)
                                <div class="badge {{ $msg->expediteur_id == Auth::user()->id_utilisateur ? 'bg-white text-primary' : 'bg-warning text-dark' }} mb-2">
                                    Offre : {{ number_format($msg->prix_propose, 0, ',', ' ') }} FCFA
                                </div><br>
                            @endif
                            <p class="mb-0">{{ $msg->contenu }}</p>
                        </div>
                        <small class="text-muted d-block mt-1 {{ $msg->expediteur_id == Auth::id() ? 'text-end' : '' }}">
                            {{ $msg->created_at->format('H:i') }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PIED DE PAGE DYNAMIQUE --}}
        <div class="card-footer bg-white p-3">
            @if($conversation->statut == 'ouverte')
                {{-- Formulaire de discussion classique --}}
                <form action="{{ route('messages.store', $conversation->id_conversation) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="contenu" class="form-control border-0 bg-light py-2" placeholder="Écrivez votre réponse..." required>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </form>

            @elseif($conversation->statut == 'prix_accepte')
                {{-- Cas où le producteur a accepté le prix, on attend la quantité de l'acheteur --}}
                @if(Auth::user()->role_id == 2) {{-- Interface Acheteur --}}
                    <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-0">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                            <h6 class="fw-bold mb-0">Prix validé : {{ number_format($conversation->prix_final, 0, ',', ' ') }} FCFA / unité</h6>
                        </div>
                        <p class="small text-muted">Veuillez indiquer la quantité finale pour générer votre commande :</p>
                        
                        <form action="{{ route('acheteur.conversation.finaliser', $conversation->id_conversation) }}" method="POST">
                            @csrf
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" name="quantite" class="form-control" placeholder="Quantité (ex: 10)" min="1" required>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-success px-4 shadow-sm">Confirmer la commande</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else {{-- Interface Producteur --}}
                    <div class="alert alert-info text-center mb-0 rounded-pill border-0 shadow-sm">
                        <i class="bi bi-hourglass-split me-2"></i> Vous avez accepté le prix. En attente de la quantité finale de l'acheteur.
                    </div>
                @endif

            @else
                {{-- Cas clôturé ou accord trouvé --}}
                <div class="alert alert-secondary text-center mb-0 rounded-pill border-0 shadow-sm">
                    <i class="bi bi-lock-fill me-2"></i> Cette négociation est terminée.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Scroller automatiquement vers le bas
    const chatBox = document.getElementById('chat-box');
    if(chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
@endsection