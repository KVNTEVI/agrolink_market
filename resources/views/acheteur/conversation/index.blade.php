@extends('layouts.acheteur')

@section('title', 'Messagerie')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold">Messagerie</h4>
    <p class="text-muted mb-0">Vos conversations avec les producteurs</p>
</div>

@if($conversations->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-chat-dots fs-1 text-muted"></i>
        <p class="mt-3 text-muted">Aucune conversation disponible</p>
    </div>
@else
<div class="list-group shadow-sm">
    @foreach($conversations as $conversation)
        <a href="{{ route('conversation.show', $conversation->id_conversation) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

            <div>
                <strong>{{ $conversation->produit->nom }}</strong><br>
                <small class="text-muted">
                    Producteur : {{ $conversation->producteur->nom }}
                </small>
            </div>

            <span class="badge 
                {{ $conversation->statut === 'accord_trouve' ? 'bg-success' :
                   ($conversation->statut === 'cloturee' ? 'bg-secondary' : 'bg-warning text-dark') }}">
                {{ ucfirst(str_replace('_',' ', $conversation->statut)) }}
            </span>
        </a>
    @endforeach
</div>
@endif

@endsection
