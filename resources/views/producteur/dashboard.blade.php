@extends('layouts.producteur')

@section('title', 'Tableau de Bord')

@section('content')

{{-- TITRE --}}
<div class="mb-4">
    <h4 class="fw-bold">Tableau de bord producteur</h4>
    <p class="text-muted mb-0">Vue générale de votre activité</p>
</div>

{{-- STATISTIQUES --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-wallet2 fs-2 text-success me-3"></i>
                <div>
                    <h6 class="mb-0 small text-muted">Chiffre d'affaires</h6>
                    <h4 class="fw-bold mb-0">{{ number_format($chiffreAffaires, 0, ',', ' ') }} F</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-bag-check fs-2 text-primary me-3"></i>
                <div>
                    <h6 class="mb-0 small text-muted">En attente</h6>
                    <h4 class="fw-bold mb-0">{{ $commandesEnAttente }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-box-seam fs-2 text-warning me-3"></i>
                <div>
                    <h6 class="mb-0 small text-muted">Mes Produits</h6>
                    <h4 class="fw-bold mb-0">{{ $totalProduits }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-star fs-2 text-info me-3"></i>
                <div>
                    <h6 class="mb-0 small text-muted">Satisfaction</h6>
                    <h4 class="fw-bold mb-0">{{ $satisfaction }}%</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- COLONNE GAUCHE --}}
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold border-0 py-3">Actions rapides</div>
            <div class="card-body bg-light rounded-bottom">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('producteur.produit.create') }}" class="btn btn-white w-100 py-3 shadow-sm border-0 bg-white">
                            <i class="bi bi-plus-circle text-success me-2"></i> Nouveau produit
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('producteur.commandes.index') }}" class="btn btn-white w-100 py-3 shadow-sm border-0 bg-white">
                            <i class="bi bi-list-ul text-primary me-2"></i> Commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 py-3 text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i> Alertes Stock
            </div>
            <div class="card-body">
                @forelse($alertesStock as $produit)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span class="fw-semibold">{{ $produit->nom }}</span>
                        <span class="badge {{ $produit->stock == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                            Reste: {{ $produit->stock }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted text-center my-3">Tous vos stocks sont corrects.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- COLONNE DROITE --}}
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 py-3">Commandes récentes</div>
            <div class="list-group list-group-flush">
                @forelse($commandesRecentes as $cmd)
                    <div class="list-group-item border-0 border-bottom py-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1 fw-bold">#{{ $cmd->id_commande }}</h6>
                            <span class="badge bg-light text-dark border">{{ $cmd->statut }}</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span>{{ $cmd->acheteur->nom ?? 'Client' }}</span>
                            <span class="text-success fw-bold">{{ number_format($cmd->montant_total, 0, ',', ' ') }} F</span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">Aucune commande pour le moment.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .btn-white:hover { transform: translateY(-2px); transition: 0.2s; box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important; }
</style>

@endsection