@extends('layouts.producteur')

@section('title', 'Négociations')

@section('content')
<div class="container-fluid py-4 min-vh-100">

    {{-- EN-TÊTE DE PAGE --}}
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h4 class="fw-bold text-success mb-1">Négociations en cours</h4>
            <p class="text-dark small mb-0"><i class="bi bi-chat-dots text-success me-1"></i> Discutez des prix et concluez vos ventes</p>
        </div>
        <div class="col-auto">
            <div class="bg-white p-2 px-3 rounded-3 shadow-sm border border-light">
                <span class="text-success fw-bold">{{ $conversations->total() }}</span> <span class="text-muted small">Discussions</span>
            </div>
        </div>
    </div>

    {{-- GRILLE DES NÉGOCIATIONS --}}
    <div class="row">
        @forelse($conversations as $conv)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 negotiation-card transition-all bg-white">
                <div class="card-body p-4">
                    
                    {{-- STATUTS FILTRÉS : Ouvert ou Accord trouvé --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        @if($conv->statut == 'prix_accepte' || $conv->statut == 'cloturee')
                            <span class="badge bg-success rounded-pill px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                <i class="bi bi-check2-all me-1"></i> Accord trouvé
                            </span>
                        @else
                            <span class="badge bg-primary rounded-pill px-3 py-2 fw-normal" style="font-size: 0.7rem;">
                                <i class="bi bi-chat-left-text me-1"></i> Ouvert
                            </span>
                        @endif
                        
                        <small class="text-muted fw-medium" style="font-size: 0.75rem;">
                            <i class="bi bi-clock me-1"></i>{{ $conv->updated_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="position-relative">
                            <img src="{{ asset('images/produits/' . $conv->produit->image) }}" 
                                 class="rounded-3 border shadow-sm" 
                                 width="65" height="65" 
                                 style="object-fit: cover;">
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold text-dark mb-1">{{ $conv->produit->nom }}</h6>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 22px; height: 22px;">
                                    <i class="bi bi-person text-muted" style="font-size: 0.75rem;"></i>
                                </div>
                                <span class="text-muted small">Acheteur : <strong class="text-dark">{{ $conv->acheteur->nom }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('producteur.conversation.show', $conv->id_conversation) }}" 
                       class="btn btn-white border rounded-pill w-100 py-2 fw-bold shadow-sm action-btn">
                        Voir la discussion
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-white rounded-4 shadow-sm py-5 border border-light">
                <i class="bi bi-chat-left-dots display-1 text-muted opacity-25"></i>
                <h5 class="mt-3 fw-bold text-dark">Aucune négociation</h5>
                <p class="text-muted small">Vos futures discussions apparaîtront ici.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($conversations->hasPages())
    <div class="d-flex justify-content-center mt-4 table-pagination">
        {{ $conversations->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<style>
    body { background-color: #f0f2f5; }

    .negotiation-card {
        border: 1px solid transparent !important;
        transition: all 0.3s ease;
    }

    .negotiation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
        border-color: rgba(25, 135, 84, 0.2) !important;
    }

    .btn-white {
        background: #ffffff;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
        color: #212529;
        font-size: 0.85rem;
    }

    .btn-white:hover {
        background: #f8f9fa;
        border-color: #198754;
        color: #198754;
    }

    .table-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 35px;
        padding: 0 0.9rem;
        font-size: 0.85rem;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        color: #000000;
        border-radius: 6px !important;
        margin: 0 3px;
    }

    .table-pagination .page-item.active .page-link {
        background-color: #1a1d20 !important;
        border-color: #1a1d20 !important;
        color: #ffffff !important;
    }
</style>
@endsection