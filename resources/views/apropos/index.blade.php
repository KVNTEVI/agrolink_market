@extends('layouts.app')

@section('content')

<!-- SECTION MISSION -->
<section class="bg-success bg-opacity-10 py-5">
    <div class="container text-center">
        <h2 class="fw-bold text-success">
            Notre Mission : Révolutionner le marché Agricole au TOGO
        </h2>
        <p class="text-dark mx-auto" style="max-width:800px;">
            AgroLink Market est dédié à la transformation du paysage agricole togolais.
            Nous connectons directement les producteurs locaux avec les acheteurs,
            en garantissant des transactions équitables, un transport sécurisé
            et une traçabilité des produits, tout en créant un écosystème durable.
        </p>
    </div>
</section>

<!-- COMMENT ÇA MARCHE -->
<section class="py-5 bg-white">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">
            Comment ça marche ? Un processus simple et efficace
        </h3>

        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body">
                        <i class="bi bi-person-plus fs-1 text-success"></i>
                        <h5 class="mt-3 fw-bold">1. Inscription Facile</h5>
                        <p class="text-muted small">
                            Acheteurs et producteurs créent un compte en quelques minutes.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body">
                        <i class="bi bi-cart-check fs-1 text-success"></i>
                        <h5 class="mt-3 fw-bold">2. Explorer & Commander</h5>
                        <p class="text-muted small">
                            Parcourez les produits, négociez les prix et passez commande.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body">
                        <i class="bi bi-shield-lock fs-1 text-success"></i>
                        <h5 class="mt-3 fw-bold">3. Transaction Sécurisée</h5>
                        <p class="text-muted small">
                            Paiement sécurisé, suivi et validation de la commande.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- POURQUOI NOUS CHOISIR -->
<section class="bg-success bg-opacity-10 py-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-5">
            Pourquoi choisir AgroLink Market ?
        </h3>

        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold text-success">Pour les Producteurs</h5>
                <ul class="text-muted">
                    <li>Accès direct au marché</li>
                    <li>Fixation libre des prix</li>
                    <li>Visibilité nationale</li>
                    <li>Paiement sécurisé et rapide</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold text-success">Pour les Acheteurs</h5>
                <ul class="text-muted">
                    <li>Produits locaux de qualité</li>
                    <li>Négociation directe avec le producteur</li>
                    <li>Traçabilité des produits</li>
                    <li>Livraison fiable</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CHIFFRES CLÉS -->
<section class="py-5 bg-white">
    <div class="container">
        <h3 class="text-center fw-bold mb-4">
            Nos Engagements & Chiffres Clés
        </h3>

        <div class="row text-center g-4 ">
            <div class="col-md-4">
                <div class="card shadow-sm hover-card">
                    <div class="card-body">
                        <i class="bi bi-people fs-1 text-success"></i>
                        <h4 class="fw-bold mt-2">500+</h4>
                        <p class="text-muted small">Producteurs inscrits</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm hover-card">
                    <div class="card-body">
                        <i class="bi bi-cash-stack fs-1 text-success"></i>
                        <h4 class="fw-bold mt-2">10K+</h4>
                        <p class="text-muted small">Transactions réalisées</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm hover-card">
                    <div class="card-body">
                        <i class="bi bi-star fs-1 text-success"></i>
                        <h4 class="fw-bold mt-2">98%</h4>
                        <p class="text-muted small">Satisfaction client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="bg-success bg-opacity-10 py-5 text-center" style="background-color:#F9C79A;">
    <div class="container">
        <h3 class="fw-bold mb-3">
            Prêt à transformer votre expérience agricole ?
        </h3>
        <p class="mb-4">
            Rejoignez AgroLink Market et développez votre activité dès aujourd’hui.
        </p>
        <a href="{{ route('register') }}" class="btn btn-success btn-lg">
            Commencer maintenant
        </a>
    </div>
</section>

@endsection
