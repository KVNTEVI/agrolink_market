@extends('layouts.app')

@section('title', 'Négociation')

@section('content')
<div class="container py-4">

    {{-- 🔙 Retour --}}
    <a href="{{ url()->previous() }}" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    {{-- 🧾 En-tête conversation --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold">{{ $conversation->produit->nom }}</h5>
                <small class="text-muted">
                    Statut :
                    <span class="badge
                        @if($conversation->statut === 'ouverte') bg-warning text-dark
                        @elseif($conversation->statut === 'accord_trouve') bg-success
                        @else bg-secondary @endif">
                        {{ ucfirst(str_replace('_', ' ', $conversation->statut)) }}
                    </span>
                </small>
            </div>

            @if($conversation->prix_final)
                <div class="text-success fw-bold">
                    Prix final : {{ number_format($conversation->prix_final, 0, ',', ' ') }} FCFA
                </div>
            @endif
        </div>
    </div>

    {{-- 💬 Messages --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body" style="max-height: 420px; overflow-y: auto">

            @forelse($conversation->messages as $message)

                @php
                    $isMe = $message->expediteur_id === auth()->id();
                @endphp

                <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-3 rounded shadow-sm
                        {{ $isMe ? 'bg-success text-white' : 'bg-light' }}"
                        style="max-width: 70%">

                        {{-- Nom --}}
                        <div class="fw-semibold small mb-1">
                            {{ $message->expediteur->nom }}
                        </div>

                        {{-- Message --}}
                        @if($message->contenu)
                            <div class="mb-1">{{ $message->contenu }}</div>
                        @endif

                        {{-- Offre --}}
                        @if($message->prix_propose)
                            <div class="mt-2 p-2 rounded bg-white text-dark border">
                                <i class="bi bi-cash-coin text-success"></i>
                                Offre : <strong>{{ number_format($message->prix_propose, 0, ',', ' ') }} FCFA</strong>
                            </div>
                        @endif

                        <div class="text-end small opacity-75 mt-1">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

            @empty
                <p class="text-muted text-center">Aucun message pour le moment.</p>
            @endforelse
        </div>
    </div>

    {{-- ⚙️ ACTION PRODUCTEUR --}}
    @if(
        auth()->id() === $conversation->producteur_id &&
        $conversation->statut === 'ouverte' &&
        $conversation->messages->whereNotNull('prix_propose')->count() > 0
    )
        <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-end gap-2">

                {{-- Refuser --}}
                <form method="POST" action="{{ route('producteur.conversation.refuser', $conversation->id_conversation) }}">
                    @csrf
                    <button class="btn btn-outline-danger">
                        <i class="bi bi-x-circle"></i> Refuser
                    </button>
                </form>

                {{-- Accepter --}}
                <form method="POST" action="{{ route('producteur.conversation.accepter', $conversation->id_conversation) }}">
                    @csrf
                    <button class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Accepter l’offre
                    </button>
                </form>

            </div>
        </div>
    @endif

    {{-- ✍️ Envoi message --}}
    @if($conversation->statut === 'ouverte')
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('conversation.message.store', $conversation->id_conversation) }}">
                    @csrf

                    <div class="mb-2">
                        <textarea name="contenu" class="form-control" rows="2"
                            placeholder="Votre message (optionnel)"></textarea>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">FCFA</span>
                        <input type="number" name="prix_propose" class="form-control"
                            placeholder="Proposer un prix (optionnel)">
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary">
                            <i class="bi bi-send"></i> Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
@endsection
