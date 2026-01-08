@extends(Auth::user()->role_id == 3 ? 'layouts.producteur' : 'layouts.acheteur')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- HEADER --}}
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

        {{-- CHAT BOX --}}
        <div id="chat-box" class="card-body bg-light p-4" style="height: 450px; overflow-y: auto;">
            @foreach($conversation->messages as $msg)
                <div class="d-flex {{ $msg->expediteur_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                    <div class="max-width-75">
                        <div class="p-3 rounded-4 {{ $msg->expediteur_id == Auth::id() ? 'bg-primary text-white shadow-sm' : 'bg-white border' }}">
                            @if($msg->prix_propose)
                                <div class="badge {{ $msg->expediteur_id == Auth::id() ? 'bg-white text-primary' : 'bg-warning text-dark' }} mb-2">
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

        {{-- FOOTER AVEC LOGIQUE DE FINALISATION --}}
        <div class="card-footer bg-white p-3">
            @if($conversation->statut == 'ouverte')
                {{-- Négociation en cours --}}
                <form action="{{ route('messages.store', $conversation->id_conversation) }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="number" name="prix_propose" class="form-control rounded-pill bg-light" placeholder="Prix (FCFA)">
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" name="contenu" class="form-control bg-light" placeholder="Écrivez votre message..." required>
                                <button type="submit" class="btn btn-primary rounded-pill-end px-4">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            @elseif($conversation->statut == 'prix_accepte')
                {{-- Prix validé : Formulaire de Quantité --}}
                @if(Auth::user()->role_id == 2) {{-- Interface Acheteur --}}
                    <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-0">
                        <h6 class="fw-bold text-success"><i class="bi bi-check-circle-fill me-2"></i>Prix validé : {{ number_format($conversation->prix_final, 0, ',', ' ') }} FCFA</h6>
                        <p class="small text-muted">Indiquez la quantité pour passer commande :</p>
                        <form action="{{ route('acheteur.conversation.finaliser', $conversation->id_conversation) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="quantite" class="form-control" placeholder="Quantité finale /kg" min="1" required>
                                <button type="submit" class="btn btn-success px-4">Valider l'achat</button>
                            </div>
                        </form>
                    </div>
                @else {{-- Interface Producteur --}}
                    <div class="alert alert-info text-center rounded-pill mb-0">
                        <i class="bi bi-hourglass-split me-2"></i> Prix accepté. En attente de la quantité finale de l'acheteur.
                    </div>
                @endif

            @else
                {{-- Négociation clôturée --}}
                <div class="alert alert-secondary text-center mb-0 rounded-pill">
                    <i class="bi bi-lock-fill me-2"></i> Cette négociation est terminée (Commande effectuée).
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Scroller automatiquement vers le bas à l'ouverture
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection