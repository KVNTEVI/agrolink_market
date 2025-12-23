@extends('layouts.app')

@section('content')

<section class="py-5">
    <div class="container">

        <h2 class="fw-bold text-center mb-4">
            Nos Producteurs
        </h2>

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

                            <h5 class="fw-bold">
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
                <p class="text-center text-muted">
                    Aucun producteur disponible pour le moment.
                </p>
            @endforelse

        </div>

    </div>
</section>

@endsection
