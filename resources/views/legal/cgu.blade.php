@extends('layouts.app')

@section('content')
<div class="container bg-success bg-opacity-10 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <h1 class="fw-bold text-success mb-4 text-center">Conditions Générales d'Utilisation</h1>
                <p class="text-muted text-center">Dernière mise à jour : {{ date('d/m/Y') }}</p>

                <hr class="my-4 opacity-25">

                <section class="mb-4">
                    <h4 class="text-dark fw-bold">1. Objet de la plateforme</h4>
                    <p>AgroLink Market est une plateforme de mise en relation entre producteurs agricoles et acheteurs. Nous facilitons la négociation et la vente de produits frais.</p>
                </section>

                <section class="mb-4">
                    <h4 class="text-dark fw-bold">2. Inscription et Comptes</h4>
                    <p>Pour utiliser nos services, vous devez créer un compte en choisissant un profil (Acheteur ou Producteur). Vous êtes responsable de la confidentialité de vos identifiants.</p>
                </section>

                <section class="mb-4">
                    <h4 class="text-dark fw-bold">3. Rôles et Responsabilités</h4>
                    <ul>
                        <li><strong>Producteurs :</strong> S'engagent à fournir des informations exactes sur leurs produits et à honorer les commandes acceptées.</li>
                        <li><strong>Acheteurs :</strong> S'engagent à payer le prix convenu lors de la finalisation d'une transaction.</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h4 class="text-dark fw-bold">4. Négociations et Paiements</h4>
                    <p>Les prix peuvent faire l'objet d'une négociation via la messagerie interne. Une fois l'offre acceptée, la vente devient ferme et définitive selon les modalités de paiement choisies.</p>
                </section>

                <section class="mb-4">
                    <h4 class="text-dark fw-bold">5. Protection des données</h4>
                    <p>Conformément aux lois en vigueur, vos données personnelles sont collectées uniquement pour le bon fonctionnement du service et ne sont jamais revendues à des tiers.</p>
                </section>

                <div class="mt-5 text-center">
                    <a href="{{ route('register') }}" class="btn btn-success px-4">Retour à l'inscription</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection