@extends('layouts.acheteur')

@section('title', 'Mes Négociations')

@section('content')
<div class="container-fluid py-4 min-vh-100" >
    {{-- EN-TÊTE --}}
    <div class="mb-4">
        <h4 class="fw-bold text-success mb-1">Mes Négociations</h4>
        <p class="text-muted small mb-0">Discutez en direct avec les producteurs et suivez vos offres de prix.</p>
    </div>

    {{-- LISTE DES DISCUSSIONS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="list-group list-group-flush">
            @forelse($conversations as $conv)
            <a href="{{ route('acheteur.conversation.show', $conv->id_conversation) }}" 
               class="list-group-item list-group-item-action p-3 border-0 border-bottom conversation-item">
                <div class="d-flex align-items-center">
                    {{-- IMAGE PRODUIT --}}
                    <div class="position-relative">
                        <img src="{{ asset('images/produits/' . ($conv->produit->image ?? 'default.png')) }}" 
                             class="rounded-3 border" width="65" height="65" style="object-fit: cover;">
                        @if($conv->messages->where('lu', false)->where('destinataire_id', auth()->id())->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </div>

                    {{-- CONTENU --}}
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $conv->produit->nom }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-calendar3 me-1"></i>{{ $conv->updated_at->format('d/m/Y') }}
                            </small>
                        </div>
                        
                        <p class="text-muted small mb-2">
                            <i class="bi bi-person me-1"></i>Producteur : <span class="fw-medium">{{ $conv->producteur->nom }}</span>
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge rounded-pill px-3 py-2 fw-normal {{ $conv->statut == 'ouverte' ? 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25' : 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' }}" style="font-size: 0.7rem;">
                                <i class="bi {{ $conv->statut == 'ouverte' ? 'bi-chat-dots' : 'bi-check2-all' }} me-1"></i>
                                {{ strtoupper($conv->statut) }}
                            </span>
                            
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-5 text-center bg-white">
                <i class="bi bi-chat-left-dots display-4 text-muted opacity-25"></i>
                <p class="mt-3 text-muted mb-0">Vous n'avez aucune discussion en cours.</p>
                <a href="{{ route('boutique.index') }}" class="btn btn-dark btn-sm rounded-pill px-4 mt-3">Explorer la boutique</a>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection