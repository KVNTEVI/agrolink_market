@extends('layouts.app')

@section('content')
<div class="container bg-success bg-opacity-10 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <ul class="nav nav-pills nav-justified mb-4 bg-white p-2 rounded-pill shadow-sm" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill fw-bold" id="pills-cgu-tab" data-bs-toggle="pill" data-bs-target="#pills-cgu" type="button" role="tab">
                        <i class="bi bi-file-earmark-text me-2"></i>Conditions d'Utilisation
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill fw-bold" id="pills-privacy-tab" data-bs-toggle="pill" data-bs-target="#pills-privacy" type="button" role="tab">
                        <i class="bi bi-shield-lock me-2"></i>Confidentialité
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                
                {{-- SECTION 1 : CGU --}}
                <div class="tab-pane fade show active" id="pills-cgu" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <div class="text-center mb-4">
                            @php $logoPath = public_path('images/logo.png'); @endphp
                            @if(file_exists($logoPath))
                                <img src="{{ asset('images/logo.png') }}" alt="Logo AgroLink" style="max-height: 80px;">
                            @else
                                <h2 class="text-success fw-bold">AgroLink Market</h2>
                            @endif
                            <h1 class="fw-bold text-dark mt-3">Conditions Générales d'Utilisation</h1>
                            <p class="text-muted small">Dernière mise à jour : {{ date('d/m/Y') }}</p>
                        </div>

                        <hr class="my-4 opacity-25">

                        <section class="mb-4">
                            <h5 class="text-success fw-bold">1. Objet de la plateforme</h5>
                            <p>AgroLink Market est une place de marché numérique dédiée à la valorisation des produits agricoles. Nous facilitons le circuit court entre le champ et l'acheteur final.</p>
                        </section>

                        <section class="mb-4">
                            <h5 class="text-success fw-bold">2. Négociation et Prix</h5>
                            <p>La plateforme intègre un système de négociation en temps réel. Tout accord sur un prix final via notre messagerie engage la responsabilité des deux parties.</p>
                        </section>

                        <section class="mb-4">
                            <h5 class="text-success fw-bold">3. Engagements du Producteur</h5>
                            <p>Le producteur s'engage à fournir des produits sains, conformes aux descriptions et disponibles aux quantités indiquées sur son inventaire.</p>
                        </section>

                        {{-- AJOUT : SECTION ACHETEUR --}}
                        <section class="mb-4">
                            <h5 class="text-success fw-bold">4. Engagements de l'Acheteur</h5>
                            <p>L'acheteur s'engage à négocier de bonne foi, à finaliser le paiement une fois l'accord conclu et à se rendre disponible pour la réception des produits frais afin d'éviter toute dégradation de la marchandise.</p>
                        </section>

                        <div class="mt-4 p-3 bg-light rounded-3 border-start border-success border-4">
                            <p class="mb-0 small italic text-muted">En continuant votre navigation, vous acceptez l'intégralité de ces conditions pour le bon fonctionnement de notre écosystème agricole.</p>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2 : CONFIDENTIALITÉ --}}
                <div class="tab-pane fade" id="pills-privacy" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h2 class="fw-bold text-dark mb-4"><i class="bi bi-shield-check text-success me-2"></i>Politique de Confidentialité</h2>
                        
                        <p>Votre vie privée est essentielle pour nous. Voici comment nous traitons vos informations sur AgroLink Market :</p>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="p-3 border rounded-4 h-100">
                                    <h6 class="fw-bold text-success">Données Collectées</h6>
                                    <p class="small text-muted">Nom, téléphone, localisation de l'exploitation, et historique des transactions pour assurer le suivi de vos commandes.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="p-3 border rounded-4 h-100">
                                    <h6 class="fw-bold text-success">Utilisation</h6>
                                    <p class="small text-muted">Vos données ne sont jamais partagées à des fins publicitaires. Elles servent uniquement à la mise en relation et à la sécurité des paiements.</p>
                                </div>
                            </div>
                        </div>

                        <section class="mb-4">
                            <h5 class="fw-bold">Sécurité des transactions</h5>
                            <p>Toutes les données de paiement Mobile Money sont traitées par des partenaires agréés. AgroLink Market ne stocke aucun code PIN ou informations bancaires sensibles.</p>
                        </section>

                        <section class="mb-0">
                            <h5 class="fw-bold">Conservation des données</h5>
                            <p>Nous conservons vos données tant que votre compte est actif. Vous pouvez demander la suppression complète de vos données depuis votre espace profil.</p>
                        </section>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5 rounded shadow">
                    Retour à l'inscription
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        background-color: #198754 !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2);
    }
    .card {
        transition: transform 0.3s ease;
    }
    h5 {
        border-left: 3px solid #198754;
        padding-left: 15px;
        margin-top: 25px;
    }
</style>
@endsection