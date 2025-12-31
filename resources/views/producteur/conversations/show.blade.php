@extends('layouts.producteur')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="height: 80vh;">
        <div class="row g-0 h-100">
            <div class="col-12 bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/produits/' . $conversation->produit->image) }}" class="rounded-circle me-3" width="45" height="45">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $conversation->produit->nom }}</h6>
                        <small class="text-success">Prix initial : {{ number_format($conversation->produit->prix_unitaire, 0, ',', ' ') }} FCFA</small>
                    </div>
                </div>
                @if($conversation->statut == 'ouverte')
                <div class="d-flex gap-2">
                    <form action="{{ route('producteur.conversation.accepter', $conversation->id_conversation) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-sm rounded-pill px-3">Accepter l'offre</button>
                    </form>
                    <form action="{{ route('producteur.conversation.refuser', $conversation->id_conversation) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm rounded-pill px-3">Refuser</button>
                    </form>
                </div>
                @endif
            </div>

            <div class="col-12 p-4 overflow-auto" style="height: calc(100% - 140px); background: #f8f9fa;">
                @foreach($conversation->messages as $msg)
                <div class="d-flex {{ $msg->expediteur_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                    <div class="max-width-75">
                        <div class="p-3 rounded-4 {{ $msg->expediteur_id == Auth::id() ? 'bg-primary text-white shadow-sm' : 'bg-white border' }}">
                            @if($msg->prix_propose)
                                <div class="badge bg-warning text-dark mb-2">Offre : {{ number_format($msg->prix_propose, 0, ',', ' ') }} FCFA</div><br>
                            @endif
                            {{ $msg->contenu }}
                        </div>
                        <small class="text-muted d-block mt-1 {{ $msg->expediteur_id == Auth::id() ? 'text-end' : '' }}">
                            {{ $msg->created_at->format('H:i') }}
                        </small>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-12 p-3 bg-white border-top">
                @if($conversation->statut == 'ouverte')
                <form action="{{ route('messages.store', $conversation->id_conversation) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="contenu" class="form-control border-0 bg-light" placeholder="Votre réponse...">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-send"></i></button>
                    </div>
                </form>
                @else
                <div class="alert alert-light text-center mb-0">La négociation est clôturée.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection