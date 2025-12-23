@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="container py-4">

    {{-- 🔙 Retour --}}
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    {{-- 📦 Infos produit --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="bi bi-box-seam fs-3 text-success me-3"></i>

            <div>
                <h6 class="mb-1 fw-semibold">{{ $conversation->produit->nom }}</h6>
                <small class="text-muted">
                    Prix : {{ number_format($conversation->produit->prix, 0, ',', ' ') }} FCFA
                </small>
            </div>
        </div>
    </div>

    {{-- 💬 Zone messages --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-chat-dots me-1"></i>
            Discussion
        </div>

        <div class="card-body" style="max-height: 400px; overflow-y: auto;">

            @forelse($conversation->messages as $message)

                {{-- Message envoyé par moi --}}
                @if($message->expediteur_id === auth()->id())
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-success text-white rounded px-3 py-2" style="max-width: 70%;">
                            <p class="mb-1">{{ $message->contenu }}</p>
                            <small class="opacity-75">
                                <i class="bi bi-check2"></i>
                                {{ $message->created_at->format('H:i') }}
                            </small>
                        </div>
                    </div>

                {{-- Message reçu --}}
                @else
                    <div class="d-flex justify-content-start mb-3">
                        <div class="bg-light border rounded px-3 py-2" style="max-width: 70%;">
                            <p class="mb-1">{{ $message->contenu }}</p>
                            <small class="text-muted">
                                <i class="bi bi-person-circle"></i>
                                {{ $message->created_at->format('H:i') }}
                            </small>
                        </div>
                    </div>
                @endif

            @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-chat-square-dots fs-2"></i>
                    <p class="mt-2">Aucun message pour le moment</p>
                </div>
            @endforelse

        </div>

        {{-- ✍️ Formulaire envoi message --}}
        <div class="card-footer bg-white">
            <form action="{{ route('message.store', $conversation->id) }}" method="POST">
                @csrf

                <div class="input-group">
                    <input type="text"
                           name="contenu"
                           class="form-control"
                           placeholder="Écrire un message..."
                           required>

                    <button class="btn btn-success" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
