@extends('layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm text-center p-4 hover-card">

                    <img src="{{ asset('images/utilisateurs/' . ($producteur->image ?? 'user-default.png')) }}" 
                    class="rounded-circle shadow-sm" 
                    width="90" 
                    height="90" 
                    style="object-fit: cover;"
                    alt="{{ $producteur->nom }}">

                    <h3 class="fw-bold">
                        {{ $producteur->nom }}
                    </h3>

                    <p class="text-muted">
                        Producteur agricole certifié
                    </p>

                    <hr>

                    <p>
                        Localisation :
                        <strong>{{ $producteur->localisation ?? 'Non précisée' }}</strong>
                    </p>

                    <p>
                        Contact :
                        <strong>{{ $producteur->telephone ?? '—' }}</strong>
                    </p>

                    <a href="{{ route('magazin.produits', $producteur->id_utilisateur) }}"
                       class="btn btn-success mt-3">
                        Voir ses produits
                    </a>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection
