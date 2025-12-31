@extends('layouts.producteur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('producteur.produit.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
        <h4 class="fw-bold">Modifier le produit</h4>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <form action="{{ route('producteur.produit.update', $produit->id_produit) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nom du produit</label>
                            <input type="text" name="nom" class="form-control bg-light border-0" value="{{ $produit->nom }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Prix (FCFA)</label>
                            <input type="number" name="prix_unitaire" class="form-control bg-light border-0" value="{{ $produit->prix_unitaire }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Stock</label>
                            <input type="number" name="stock" class="form-control bg-light border-0" value="{{ $produit->stock }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Description</label>
                            <textarea name="description" class="form-control bg-light border-0" rows="4">{{ $produit->description }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Changer l'image (optionnel)</label>
                            <div class="d-flex gap-3 align-items-center">
                                <img src="{{ asset('images/produits/' . $produit->image) }}" class="rounded shadow-sm" width="80" height="80" style="object-fit: cover;">
                                <input type="file" name="image" class="form-control bg-light border-0" accept="image/*">
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">Mettre à jour le produit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection