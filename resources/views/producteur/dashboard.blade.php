@extends('layouts.producteur')

@section('title', 'Tableau de Bord')

@section('content')

<div class="container-fluid py-4">
    {{-- EN-TÊTE HARMONISÉ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-success">Tableau de bord producteur</h4>
            <p class="text-dark small mb-0">Vue générale de votre activité AgroLink</p>
        </div>

        <div class="text-muted small bg-white p-2 px-3 border rounded-4 shadow-sm d-inline-block">
            <i class="bi bi-calendar3 me-2 text-success"></i>{{ Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- STATISTIQUES --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-wallet2 fs-3 text-success"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 small text-muted">Chiffre d'affaires</h6>
                        <h4 class="fw-bold mb-0">{{ number_format($chiffreAffaires, 0, ',', ' ') }} F</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-bag-check fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 small text-muted">En attente</h6>
                        <h4 class="fw-bold mb-0">{{ $commandesEnAttente }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-box-seam fs-3 text-warning"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 small text-muted">Mes Produits</h6>
                        <h4 class="fw-bold mb-0">{{ $totalProduits }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-star fs-3 text-info"></i>
                    </div>
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
            {{-- ACTIONS RAPIDES (En-tête Noir) --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-dark text-white fw-bold py-3">
                    <i class="bi bi-lightning-charge me-2"></i>Actions rapides
                </div>
                <div class="card-body bg-light bg-opacity-50">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('producteur.produit.create') }}" class="btn btn-white w-100 py-3 shadow-sm border-0 bg-white action-btn">
                                <i class="bi bi-plus-circle text-success fs-4 d-block mb-1"></i>
                                <span class="small fw-bold">Nouveau produit</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('producteur.commandes.index') }}" class="btn btn-white w-100 py-3 shadow-sm border-0 bg-white action-btn">
                                <i class="bi bi-list-ul text-primary fs-4 d-block mb-1"></i>
                                <span class="small fw-bold">Commandes</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ALERTES STOCK (En-tête Noir) --}}
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white fw-bold py-3 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle me-2 text-danger"></i> Alertes Stock
                </div>
                <div class="card-body p-0 bg-white">
                    <div class="list-group list-group-flush">
                        @forelse($alertesStock as $produit)
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom py-3">
                                <div>
                                    <span class="fw-bold text-dark d-block">{{ $produit->nom }}</span>
                                    <small class="text-muted">Réapprovisionnement conseillé</small>
                                </div>
                                <span class="badge {{ $produit->stock == 0 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill px-3">
                                    {{ $produit->stock == 0 ? 'Rupture' : 'Reste: ' . $produit->stock }}
                                </span>
                            </div>
                        @empty
                            <div class="py-4 text-center">
                                <i class="bi bi-check-circle text-success fs-2 d-block mb-2"></i>
                                <p class="text-muted small mb-0">Tous vos stocks sont corrects.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE --}}
        <div class="col-lg-5">
            {{-- COMMANDES RÉCENTES (En-tête Noir) --}}
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white fw-bold py-3 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cart3 me-2"></i>Commandes récentes</span>
                    <a href="{{ route('producteur.commandes.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3" style="font-size: 0.7rem;">Voir tout</a>
                </div>
                <div class="list-group list-group-flush bg-white">
                    @forelse($commandesRecentes as $cmd)
                        <div class="list-group-item border-0 border-bottom py-3 hvr-light">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="mb-0 fw-bold text-dark">#{{ $cmd->id_commande }}</h6>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2" style="font-size: 0.7rem;">
                                    {{ $cmd->statut }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small">
                                    <i class="bi bi-person text-muted me-1"></i> {{ $cmd->acheteur->nom ?? 'Client' }}
                                </div>
                                <div class="text-success fw-bold">
                                    {{ number_format($cmd->montant_total, 0, ',', ' ') }} F
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted small">Aucune commande pour le moment.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .action-btn { transition: all 0.3s ease; }
    .action-btn:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important; 
    }
    .hvr-light:hover { background-color: #f8f9fa; }
    .card { transition: transform 0.2s ease; }
    /* Optionnel : adoucir le noir de l'en-tête pour coller au style moderne */
    .bg-dark { background-color: #1a1d20 !important; }
</style>

@endsection