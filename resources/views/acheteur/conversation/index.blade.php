@extends('layouts.acheteur')

@section('title', 'Mes Négociations')

@section('content')
<div class="container-fluid py-4 min-vh-100">

    {{-- EN-TÊTE DE PAGE --}}
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h4 class="fw-bold text-success mb-1">Négociations</h4>
            <p class="text-muted small mb-0"> Gérez vos échanges directs avec les producteurs</p>
        </div>
        <div class="col-auto">
            <div class="bg-white p-2 px-3 rounded-3 shadow-sm border border-light">
                {{-- Utilisation de count() au lieu de total() car pas de pagination --}}
                <span class="text-success fw-bold">{{ $conversations->count() }}</span> <span class="text-muted small">Discussions</span>
            </div>
        </div>
    </div>

    {{-- LISTE DES DISCUSSIONS --}}
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="list-group list-group-flush">
                    @forelse($conversations as $conv)
                    <div class="list-group-item p-3 p-md-4 border-0 border-bottom conversation-item transition-all">
                        <div class="d-flex align-items-center">
                            
                            {{-- IMAGE PRODUIT --}}
                            <div class="position-relative me-3">
                                <div class="rounded-4 overflow-hidden border shadow-sm" style="width: 75px; height: 75px;">
                                    <img src="{{ asset('images/produits/' . ($conv->produit->image ?? 'default.png')) }}" 
                                         class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                @php $unread = $conv->messages->where('lu', false)->where('destinataire_id', auth()->id())->count(); @endphp
                                @if($unread > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white">
                                        {{ $unread }}
                                    </span>
                                @endif
                            </div>

                            {{-- CONTENU --}}
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="fw-bold text-dark mb-0 fs-5">{{ $conv->produit->nom }}</h6>
                                    <small class="text-muted fw-medium">
                                        <i class="bi bi-clock me-1"></i>{{ $conv->updated_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <div class="d-flex align-items-center text-muted small mb-3">
                                    <i class="bi bi-shop me-2 text-success"></i>
                                    <span class="fw-medium">Ferme de {{ $conv->producteur->nom }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    {{-- STATUTS FILTRÉS --}}
                                    <div>
                                        @if($conv->statut == 'prix_accepte' || $conv->statut == 'cloturee')
                                            <span class="badge bg-success rounded-pill px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                                <i class="bi bi-check2-all me-1"></i> Accord trouvé
                                            </span>
                                        @else
                                            <span class="badge bg-primary rounded-pill px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                                <i class="bi bi-chat-left-text me-1"></i> Ouvert
                                            </span>
                                        @endif
                                    </div>

                                    {{-- BOUTON ACTION BLANC --}}
                                    <a href="{{ route('acheteur.conversation.show', $conv->id_conversation) }}" 
                                       class="btn btn-white btn-sm border rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        Voir la discussion <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center bg-white">
                        <i class="bi bi-chat-square-quote display-1 text-muted opacity-25"></i>
                        <h5 class="fw-bold text-dark mt-3">Aucune négociation</h5>
                        <p class="text-muted small mx-auto mb-4" style="max-width: 400px;">
                            Trouvez un produit qui vous intéresse et proposez votre prix !
                        </p>
                        <a href="{{ route('boutique.index') }}" class="btn btn-success rounded-pill px-5 shadow-sm">
                            Parcourir la boutique
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f0f2f5; }

    .conversation-item {
        transition: all 0.2s ease-in-out;
        background-color: #fff;
    }

    .conversation-item:hover {
        background-color: rgba(25, 135, 84, 0.05) !important;
    }

    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
        color: #212529;
    }

    .btn-white:hover {
        background: #f8f9fa;
        border-color: #198754;
        color: #198754;
    }

    .bg-danger.position-absolute {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>
@endsection