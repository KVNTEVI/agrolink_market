@extends('layouts.app')

@section('content')

<section class="py-5">
    <div class="container">

        <div class="row g-4">

            <!-- IMAGE PRODUIT -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <img src="{{ asset('images/produits/'.$produit->image) }}"
                         class="img-fluid rounded"
                         alt="{{ $produit->nom }}">
                </div>
            </div>

            <!-- INFOS PRODUIT -->
            <div class="col-md-6">
                <h3 class="fw-bold">{{ $produit->nom }}</h3>

                <p class="text-muted mb-1">
                    Catégorie : {{ $produit->categorie->nom ?? '—' }}
                </p>

                <p class="fw-bold text-success fs-4">
                    {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA
                </p>

                <p class="mt-3">
                    {{ $produit->description }}
                </p>

                <p class="mt-3">
                    <strong>Producteur :</strong>
                    {{ $produit->producteur->nom ?? '—' }}
                </p>

                <!-- ACTIONS -->
               <div class="d-flex gap-2 mt-4">
                    @auth
                        {{-- Vérification par ID (ID 2 = acheteur selon votre Seeder) --}}
                        @if(auth()->user()->role_id == 2)
                            <form action="{{ route('acheteur.panier.add', $produit->id_produit) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    Ajouter au panier
                                </button>
                            </form>

                            <a href="{{ route('conversation.start', $produit->id_produit) }}"
                            class="btn btn-outline-secondary">
                                Négocier le prix
                            </a>
                        @else
                            <div class="alert alert-info">
                                Accès réservé aux acheteurs. Vous êtes connecté en tant que 
                                <strong>{{ auth()->user()->role_id == 1 ? 'Admin' : 'Producteur' }}</strong>.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success">
                            Se connecter pour acheter
                        </a>
                    @endauth
                </div>
            </div>

        </div>

        <!-- RETOUR -->
        <div class="mt-5">
            <a href="{{ route('boutique.index') }}"
               class="btn btn-success">
                ← Retour à la boutique
            </a>
        </div>

    </div>
</section>

@endsection
