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
        <div class="mb-5">
            <h3 class="fw-bold text-dark text-start mb-1">Comment ça <span class="text-success">marche ?</span></h3>
            <p class="text-dark text-start">Un processus simple, transparent et efficace pour tous.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 step-card">
                    <div class="card-body p-4 text-center">
                        <div class="step-icon-wrapper mb-3 mx-auto">
                            <i class="bi bi-person-plus fs-2 text-success"></i>
                            <span class="step-number">1</span>
                        </div>
                        <h5 class="fw-bold text-dark mt-3">Inscription Facile</h5>
                        <p class="text-muted small mb-0">
                            Acheteurs et producteurs créent un compte sécurisé en quelques minutes pour accéder à la plateforme.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 step-card">
                    <div class="card-body p-4 text-center">
                        <div class="step-icon-wrapper mb-3 mx-auto">
                            <i class="bi bi-cart-check fs-2 text-success"></i>
                            <span class="step-number">2</span>
                        </div>
                        <h5 class="fw-bold text-dark mt-3">Explorer & Commander</h5>
                        <p class="text-muted small mb-0">
                            Parcourez les produits locaux, négociez les prix en direct et passez vos commandes facilement.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 step-card">
                    <div class="card-body p-4 text-center">
                        <div class="step-icon-wrapper mb-3 mx-auto">
                            <i class="bi bi-shield-lock fs-2 text-success"></i>
                            <span class="step-number">3</span>
                        </div>
                        <h5 class="fw-bold text-dark mt-3">Transaction Sécurisée</h5>
                        <p class="text-muted small mb-0">
                            Bénéficiez d'un paiement sécurisé, d'un suivi logistique et d'une validation rigoureuse de vos achats.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- POURQUOI NOUS CHOISIR -->
<section class="py-5" style="background-color: rgba(25, 135, 84, 0.05);">
    <div class="container">
        <div class="mb-5">
            <h3 class="fw-bold text-dark text-start mb-1">Pourquoi choisir <span class="text-success">AgroLink Market ?</span></h3>
            <p class="text-dark text-start">Des avantages concrets pour dynamiser l'agriculture locale.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 benefit-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-sm bg-success text-white rounded-circle me-3">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Pour les Producteurs</h5>
                        </div>
                        
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Accès direct au marché national sans intermédiaire</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Liberté totale sur la fixation de vos prix</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Visibilité accrue auprès d'acheteurs certifiés</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Système de paiement sécurisé et déblocage rapide</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 benefit-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-sm bg-success text-white rounded-circle me-3">
                                <i class="bi bi-cart-fill"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Pour les Acheteurs</h5>
                        </div>

                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Accès à des produits locaux de première qualité</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Négociation directe pour des tarifs équitables</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Traçabilité complète sur l'origine des produits</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                <span>Logistique intégrée pour une livraison fiable</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CHIFFRES CLÉS -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="mb-5">
            <h3 class="fw-bold text-dark text-start mb-1">Nos Engagements & <span class="text-success">Chiffres Clés</span></h3>
            <p class="text-dark text-start">L'impact d'AgroLink Market en quelques chiffres.</p>
        </div>

        <div class="row g-4">
            <div class="col-6 col-md-4">
                <div class="stat-item p-4 text-center shadow-sm rounded-4">
                    <div class="stat-icon-circle mb-3">
                        <i class="bi bi-people text-success"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">500+</h2>
                    <p class="text-muted fw-medium small mb-0">Producteurs inscrits</p>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="stat-item p-4 text-center shadow-sm rounded-4">
                    <div class="stat-icon-circle mb-3">
                        <i class="bi bi-cash-stack text-success"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">10K+</h2>
                    <p class="text-muted fw-medium small mb-0">Transactions</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="stat-item p-4 text-center shadow-sm rounded-4">
                    <div class="stat-icon-circle mb-3">
                        <i class="bi bi-star-fill text-success"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">98%</h2>
                    <p class="text-muted fw-medium small mb-0">Satisfaction client</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5" style="background-color: rgba(25, 135, 84, 0.08);">
    <div class="container">
        <div class="cta-banner p-4 p-md-5 rounded-5 shadow-sm border-0 bg-white position-relative overflow-hidden">

            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-2 text-center text-lg-start mb-4 mb-lg-0">
                    <div class="icon-box-final bg-success bg-opacity-10 shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 100px; height: 100px;">
                        <i class="bi bi-rocket-takeoff text-success" style="font-size: 3rem;"></i>
                    </div>
                </div>

                <div class="col-lg-7 text-center text-lg-start">
                    <h4 class="fw-bold text-dark mb-1">
                        Prêt à transformer votre <span class="text-success">expérience agricole ?</span>
                    </h4>
                    <p class="text-muted mb-0 fs-6">
                        Rejoignez <strong>AgroLink Market</strong> et développez votre activité dès aujourd’hui en profitant d'un marché sans frontières.
                    </p>
                </div>

                <div class="col-lg-3 text-center text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow-sm cta-button-final">
                        Commencer <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Cartes d'étapes */
    .step-card {
        transition: all 0.3s ease;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }

    .step-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(25, 135, 84, 0.1) !important;
        border-color: rgba(25, 135, 84, 0.2) !important;
    }

    /* Conteneur d'icône circulaire */
    .step-icon-wrapper {
        width: 80px;
        height: 80px;
        background-color: rgba(25, 135, 84, 0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .step-card:hover .step-icon-wrapper {
        background-color: #198754;
    }

    .step-card:hover .step-icon-wrapper i {
        color: white !important;
    }

    /* Petit badge numéro d'étape */
    .step-number {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #198754;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        font-size: 0.8rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Arrondi moderne */
    .rounded-4 {
        border-radius: 1.5rem !important;
    }

    /* Cartes de bénéfices */
    .benefit-card {
        transition: all 0.3s ease;
        border-top: 5px solid #198754 !important; /* Ligne verte de rappel en haut */
    }

    .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(25, 135, 84, 0.12) !important;
    }

    /* Petite boîte à icône titre */
    .icon-box-sm {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
    }

    /* Style du texte dans les listes */
    .benefit-card li span {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .benefit-card:hover li i {
        transform: scale(1.2);
        transition: 0.2s ease-in-out;
    }

    .rounded-4 {
        border-radius: 1.25rem !important;
    }

    /* Conteneur de la statistique */
    .stat-item {
        background-color: #f8fdfa; /* Vert très pâle */
        border: 1px solid rgba(25, 135, 84, 0.05);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        background-color: #ffffff;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    /* Cercle pour l'icône */
    .stat-icon-circle {
        width: 60px;
        height: 60px;
        background-color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 1.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .stat-item:hover .stat-icon-circle {
        background-color: #198754;
    }

    .stat-item:hover .stat-icon-circle i {
        color: white !important;
    }

    /* Typographie */
    .fw-extrabold {
        font-weight: 800;
        letter-spacing: -1px;
    }

    .uppercase-tracking {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
    }

    .rounded-4 {
        border-radius: 1.5rem !important;
    }

    /* Ajustement mobile */
    @media (max-width: 768px) {
        .stat-item {
            padding: 1.5rem 1rem !important;
        }
        .stat-item h2 {
            font-size: 1.5rem;
        }
    }

    .cta-banner {
        border: 1px solid rgba(25, 135, 84, 0.1) !important;
        transition: transform 0.3s ease;
    }

    .cta-banner:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .icon-box-final {
        transition: all 0.5s ease;
        border: 4px solid #fff;
    }

    .cta-banner:hover .icon-box-final {
        transform: rotate(15deg) scale(1.1);
        background-color: #198754 !important;
    }

    .cta-banner:hover .icon-box-final i {
        color: white !important;
    }

    .cta-button-final {
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .cta-button-final:hover {
        background-color: #146c43;
        transform: translateX(5px); /* Petit décalage vers la droite */
    }

    .rounded-5 {
        border-radius: 2.5rem !important;
    }

    @media (max-width: 991px) {
        .cta-banner {
            text-align: center;
        }
    }
    
</style>

@endsection
