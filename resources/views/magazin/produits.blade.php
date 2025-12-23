@extends('layouts.app')

@section('content')

<section class="py-5">
    <div class="container">

        <h3 class="fw-bold mb-4">
            Produits de {{ $producteur->nom }}
        </h3>

        <div class="row g-4">

            @forelse($produits as $produit)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="{{ asset('images/produits/'.$produit->image) }}"
                        class="card-img-top"
                        style="height: 200px; object-fit: cover;"
                        alt="{{ $produit->nom }}">

                    <div class="card-body">
                        <h6 class="fw-bold">{{ $produit->nom }}</h6>

                        <p class="text-success fw-bold">
                            {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA
                        </p>

                        <a href="{{ route('boutique.show', $produit->id_produit) }}"
                        class="btn btn-sm btn-outline-success">
                            Voir détail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Aucun produit disponible pour ce producteur.</p>
            </div>
        @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $produits->links() }}
        </div>

    </div>
</section>

@endsection
