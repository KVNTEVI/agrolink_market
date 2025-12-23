@extends('layouts.app')

@section('content')

<!-- HERO BOUTIQUE -->
<section class="bg-success bg-opacity-10 py-5 text-center">
    <div class="container">
        <h2 class="fw-bold text-success">Boutique AgroLink Market</h2>
        <p>Découvrez des produits agricoles locaux de qualité</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">

            <!-- FILTRES -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Filtrer</h5>

                        <!-- Recherche -->
                        <form method="GET" action="{{ route('boutique.index') }}">
                            <div class="mb-3">
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Rechercher..."
                                       value="{{ request('search') }}">
                            </div>

                            <!-- Catégories -->
                            <div class="mb-3">
                                <select name="categorie" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-success w-100 shadow-sm">
                                Appliquer
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- PRODUITS -->
            <div class="col-lg-9">
                <div class="row g-4">

                    @forelse($produits as $produit)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm hover-card">

                                <img src="{{ asset('images/produits/'.$produit->image) }}"
                                     class="card-img-top"
                                     style="height:200px; object-fit:cover;"
                                     alt="{{ $produit->nom }}">

                                <div class="card-body d-flex flex-column">
                                    <h5 class="fw-bold">{{ $produit->nom }}</h5>

                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($produit->description, 60) }}
                                    </p>

                                    <p class="fw-bold text-success">
                                        {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA
                                    </p>

                                    <a href="{{ route('boutique.show', $produit->id_produit) }}"
                                       class="btn btn-outline-success mt-auto">
                                        Voir le produit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">
                                Aucun produit disponible pour le moment.
                            </p>
                        </div>
                    @endforelse

                </div>

                <!-- PAGINATION -->
                <div class="mt-4">
                    {{ $produits->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
