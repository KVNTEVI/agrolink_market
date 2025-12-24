@extends('layouts.acheteur')

@section('title', 'Tableau de bord')

@section('content')

{{-- TITRE --}}
<div class="mb-4">
    <h4 class="fw-bold">Tableau de bord acheteur</h4>
    <p class="text-muted mb-0">Vue générale de votre activité</p>
</div>

{{-- STATISTIQUES --}}
<div class="row g-3 mb-4">

    {{-- Commandes en cours --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-bag-check fs-2 text-success me-3"></i>
                <div>
                    <h6 class="mb-0">Commandes en cours</h6>
                    <h4 class="fw-bold">2</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-chat-dots fs-2 text-primary me-3"></i>
                <div>
                    <h6 class="mb-0">Messages</h6>
                    <h4 class="fw-bold">3</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-bell fs-2 text-warning me-3"></i>
                <div>
                    <h6 class="mb-0">Notifications</h6>
                    <h4 class="fw-bold">2</h4>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- COMMANDES EN COURS --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        Commandes en cours
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Commande</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>

                {{-- Exemple statique (on dynamisera après) --}}
                <tr>
                    <td>CMD-001</td>
                    <td>Soja</td>
                    <td>2 T</td>
                    <td>150 000 FCFA</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            En attente
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>CMD-002</td>
                    <td>Anacarde</td>
                    <td>1 T</td>
                    <td>200 000 FCFA</td>
                    <td>
                        <span class="badge bg-success">
                            En cours
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

@endsection
