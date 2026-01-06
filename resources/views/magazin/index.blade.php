@extends('layouts.app')

@section('content')

{{-- NOUVEL EN-TÊTE HARMONISÉ --}}
<section class="bg-success bg-opacity-10 py-5 text-center">
    <div class="container">
        <h2 class="text-success fw-bold">Nos Producteurs</h2>
        <p class="mt-2 text-dark">
            Découvrez les passionnés qui nourrissent notre communauté. Des produits frais, directement de la terre à votre table.
        </p>
    </div>
</section>

{{-- TA SECTION ORIGINALE GARDÉE TELLE QUELLE --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            @forelse($producteurs as $producteur)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm text-center hover-card">

                        <div class="card-body">
                            <img src="{{ asset('images/utilisateurs/' . $producteur->image) }}" 
                            class="rounded-circle shadow-sm" 
                            width="90" 
                            height="90" 
                            style="object-fit: cover;"
                            alt="{{ $producteur->nom }}">

                            <h5 class="fw-bold mt-3">
                                {{ $producteur->nom }}
                            </h5>

                            <p class="text-muted">
                                Producteur agricole
                            </p>

                            <a href="{{ route('magazin.show', $producteur->id_utilisateur) }}"
                               class="btn btn-outline-success btn-sm">
                                Voir le profil
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">
                        Aucun producteur disponible pour le moment.
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</section>



@endsection