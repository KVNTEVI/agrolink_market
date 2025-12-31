@extends('layouts.acheteur')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4">Mes Négociations</h4>
    <div class="list-group shadow-sm rounded-4 border-0">
        @forelse($conversations as $conv)
        <a href="{{ route('acheteur.conversation.show', $conv->id_conversation) }}" class="list-group-item list-group-item-action p-3 border-0 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/produits/' . $conv->produit->image) }}" class="rounded-3 me-3" width="60" height="60">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-bold mb-1">{{ $conv->produit->nom }}</h6>
                        <small class="text-muted">{{ $conv->updated_at->format('d/m') }}</small>
                    </div>
                    <p class="text-muted small mb-1">Producteur : {{ $conv->producteur->nom }}</p>
                    <span class="badge {{ $conv->statut == 'ouverte' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }}">
                        {{ ucfirst($conv->statut) }}
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="p-5 text-center bg-white rounded-4">Vous n'avez aucune discussion.</div>
        @endforelse
    </div>
</div>
@endsection