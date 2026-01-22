@extends('layouts.app')

@section('content')

{{-- Remplacement de bg-light par le vert 5% --}}
<section class="py-5 min-vh-100" style="background-color: rgba(25, 135, 84, 0.05);">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    {{-- Bouton retour discret en haut à gauche --}}
                    <div class="p-3">
                        <a href="javascript:history.back()" class="btn btn-outline-success btn-sm rounded-circle" title="Retour">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>

                    <div class="card-body text-center p-4 pt-0">
                        {{-- Image de profil avec bordure verte --}}
                        <div class="mb-3">
                            <img src="{{ asset('images/utilisateurs/' . ($producteur->image ?? 'user-default.png')) }}" 
                                 class="rounded-circle shadow-sm border border-3 border-white" 
                                 width="120" 
                                 height="120" 
                                 style="object-fit: cover; margin-top: -20px;"
                                 alt="{{ $producteur->nom }}">
                        </div>

                        <h3 class="fw-bold text-dark mb-1">
                            {{ $producteur->nom }}
                        </h3>

                        <p class="text-success fw-medium mb-4">
                            <i class="bi bi-patch-check-fill me-1"></i> Producteur agricole certifié
                        </p>

                        <div class="row justify-content-center mb-4">
                            <div class="col-md-10">
                                <div class="p-3 rounded-3 bg-light border-start border-success border-4 text-start shadow-sm">
                                    <p class="mb-2">
                                        <i class="bi bi-geo-alt text-success me-2"></i> Localisation :
                                        <strong class="text-dark">{{ $producteur->adresse ?? 'Non précisée' }}</strong>
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-telephone text-success me-2"></i> Contact :
                                        <strong class="text-dark">{{ $producteur->telephone ?? '—' }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="opacity-10">

                        <div class="d-grid col-md-6 mx-auto">
                            <a href="{{ route('magazin.produits', $producteur->id_utilisateur) }}"
                               class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                Voir ses produits
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
    /* Optionnel : un petit effet sur la carte */
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>

@endsection