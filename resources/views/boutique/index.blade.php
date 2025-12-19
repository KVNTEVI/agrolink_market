@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Boutique</h2>

    <div class="row">
        @foreach($produits as $produit)
        <div class="col-6 col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $produit->nom }}</h5>
                    <p>{{ $produit->prix }} FCFA</p>
                    <a href="{{ route('boutique.show', $produit->id_produit) }}"
                       class="btn btn-sm btn-success">
                       Voir
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $produits->links() }}
</div>
@endsection
