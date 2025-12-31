@extends('layouts.producteur')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Négociations en cours</h4>

    <div class="row">
        @forelse($conversations as $conv)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge {{ $conv->statut == 'ouverte' ? 'bg-primary' : 'bg-success' }}">
                            {{ ucfirst($conv->statut) }}
                        </span>
                        <small class="text-muted">{{ $conv->updated_at->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/produits/' . $conv->produit->image) }}" class="rounded-3 me-3" width="60" height="60" style="object-fit: cover;">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $conv->produit->nom }}</h6>
                            <small class="text-muted">Acheteur : {{ $conv->acheteur->nom }}</small>
                        </div>
                    </div>
                    <a href="{{ route('producteur.conversation.show', $conv->id_conversation) }}" class="btn btn-outline-primary w-100 rounded-pill">
                        Voir la discussion
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-chat-left-dots display-1 text-muted"></i>
            <p class="mt-3 text-muted">Aucune négociation pour le moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection