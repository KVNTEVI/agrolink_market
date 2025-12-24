@extends('layouts.app')

@section('title', 'Conversation')

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0">{{ $conversation->produit->nom }}</h5>
        <small class="text-muted">
            Statut :
            <span class="badge 
                {{ $conversation->statut === 'accord_trouve' ? 'bg-success' :
                   ($conversation->statut === 'cloturee' ? 'bg-secondary' : 'bg-warning text-dark') }}">
                {{ ucfirst(str_replace('_',' ', $conversation->statut)) }}
            </span>
        </small>
    </div>
</div>

{{-- MESSAGES --}}
<div class="card mb-3">
    <div class="card-body" style="max-height: 400px; overflow-y: auto">

        @foreach($conversation->messages as $message)
            <div class="mb-3 
                {{ $message->expediteur_id === auth()->id() ? 'text-end' : '' }}">

                <div class="d-inline-block p-3 rounded 
                    {{ $message->expediteur_id === auth()->id()
                        ? 'bg-success text-white'
                        : 'bg-light' }}">

                    {{-- TEXTE --}}
                    @if($message->contenu)
                        <div>{{ $message->contenu }}</div>
                    @endif

                    {{-- PRIX --}}
                    @if($message->prix_propose)
                        <div class="mt-1 fw-bold">
                            <i class="bi bi-cash-coin"></i>
                            {{ number_format($message->prix_propose, 0, ',', ' ') }} FCFA
                        </div>
                    @endif
                </div>

                <div class="small text-muted mt-1">
                    {{ $message->expediteur->nom }} • {{ $message->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach

    </div>
</div>

{{-- ACTION PRODUCTEUR --}}
@if(auth()->id() === $conversation->producteur_id && $conversation->statut === 'ouverte')
<div class="d-flex gap-2 mb-3">
    <form action="{{ route('producteur.conversation.accepter', $conversation->id_conversation) }}" method="POST">
        @csrf
        <button class="btn btn-success">
            <i class="bi bi-check-circle"></i> Accepter l’offre
        </button>
    </form>

    <form action="{{ route('producteur.conversation.refuser', $conversation->id_conversation) }}" method="POST">
        @csrf
        <button class="btn btn-outline-danger">
            <i class="bi bi-x-circle"></i> Refuser
        </button>
    </form>
</div>
@endif

{{-- FORMULAIRE MESSAGE --}}
@if($conversation->statut === 'ouverte')
<form action="{{ route('conversation.message.store', $conversation->id_conversation) }}" method="POST">
    @csrf

    <div class="row g-2">
        <div class="col-md-8">
            <input type="text" name="contenu" class="form-control"
                   placeholder="Votre message">
        </div>

        <div class="col-md-3">
            <input type="number" name="prix_propose" class="form-control"
                   placeholder="Prix proposé">
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-success">
                <i class="bi bi-send"></i>
            </button>
        </div>
    </div>
</form>
@endif

@endsection
