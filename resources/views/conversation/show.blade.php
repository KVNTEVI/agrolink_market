@extends('layouts.app')

@section('title', 'Messagerie')

@section('content')

<div class="container py-4">


{{-- En-tête conversation --}}
<div class="card mb-3 shadow-sm">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1 fw-bold">
                <i class="bi bi-chat-dots"></i>
                Négociation – {{ $conversation->produit->nom }}
            </h5>
                @if($conversation->statut === 'ouverte')
                    <span class="badge bg-success bg-opacity-10 text-success border border-success">
                        <i class="bi bi-unlock"></i> Discussion ouverte
                    </span>
                @elseif($conversation->statut === 'accord') {{-- Vérifie si c'est 'accord' ou 'accord_trouve' dans ta base --}}
                    <span class="badge bg-primary">
                        <i class="bi bi-check-circle"></i> Accord trouvé
                    </span>
                @else
                    <span class="badge bg-secondary">
                        <i class="bi bi-lock"></i> Discussion clôturée
                    </span>
                @endif
        </div>
        @if($conversation->prix_final)
            <span class="badge bg-success fs-6">
                <i class="bi bi-cash-coin"></i>
                {{ number_format($conversation->prix_final, 0, ',', ' ') }} FCFA
            </span>
        @endif
    </div>
</div>

{{-- Messages --}}
<div class="card shadow-sm mb-3">
    <div class="card-body" style="max-height: 400px; overflow-y: auto;">

        @forelse($conversation->messages as $message)
            <div class="mb-3 d-flex {{ $message->expediteur_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-3 rounded {{ $message->expediteur_id === auth()->id() ? 'bg-success text-white' : 'bg-light' }}" style="max-width: 70%;">
                    <div class="small fw-bold mb-1">
                        <i class="bi bi-person"></i>
                        {{ $message->expediteur->nom }}
                    </div>

                    @if($message->contenu)
                        <div>{{ $message->contenu }}</div>
                    @endif

                    @if($message->prix_propose)
                        <div class="mt-2 fw-bold">
                            <i class="bi bi-cash"></i>
                            Offre : {{ number_format($message->prix_propose, 0, ',', ' ') }} FCFA
                        </div>
                    @endif

                    <div class="text-end small mt-1 opacity-75">
                        {{ $message->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i class="bi bi-chat"></i>
                Aucun message pour le moment
            </div>
        @endforelse

    </div>
</div>

@if($conversation->prix_final)
    <div class="alert alert-success shadow-sm border-0 mb-3 d-flex align-items-center">
        <i class="bi bi-cash-coin fs-4 me-3"></i>
        <div>
            <span class="d-block small">Prix final convenu :</span>
            <strong class="fs-5">{{ number_format($conversation->prix_final, 0, ',', ' ') }} FCFA</strong>
        </div>
    </div>
@endif

{{-- Formulaire d'envoi --}}

@if($conversation->statut === 'ouverte')
<div class="card shadow-sm">
    <div class="card-body">
<form action="{{ route('conversation.message.store', $conversation->id_conversation) }}"
      method="POST" class="border-top pt-3">
    @csrf

    <div class="row g-2">
        <div class="col-md-8">
            <input type="text"
                   name="contenu"
                   class="form-control"
                   placeholder="Écrire un message...">
        </div>

        <div class="col-md-3">
            <input type="number"
                   name="prix_propose"
                   class="form-control"
                   placeholder="Proposer un prix">
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-success">
                <i class="bi bi-send"></i>
                Envoyer
            </button>
        </div>
    </div>
</form>

@else

<div class="alert alert-info mt-3">
    <i class="bi bi-info-circle"></i>
    Cette négociation est terminée. Aucun nouveau message ne peut être envoyé.
</div>

@endif

    </div>
</div>
</div>
@endsection
