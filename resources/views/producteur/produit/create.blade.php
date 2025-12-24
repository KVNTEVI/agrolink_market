@extends('layouts.producteur')

@section('title', 'Ajouter un Produit')

@section('content')
<div class="mb-4">
    <a href="{{ route('producteur.produits.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
    <h4 class="fw-bold mt-2">Nouveau produit</h4>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 p-4">
            <form action="{{ route('producteur.produits.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold small">Nom du produit</label>
                        <input type="text" name="nom" class="form-control bg-light border-0 py-2" placeholder="Ex: Sac de Soja 50kg" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Prix unitaire (FCFA)</label>
                        <input type="number" name="prix_unitaire" class="form-control bg-light border-0 py-2" placeholder="0.00" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Stock initial</label>
                        <input type="number" name="stock" class="form-control bg-light border-0 py-2" placeholder="Ex: 100" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="4" placeholder="Décrivez la qualité, l'origine..."></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small">URL de l'image (ou lien)</label>
                        <input type="text" name="image" class="form-control bg-light border-0 py-2" placeholder="https://...">
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                            <i class="bi bi-check-lg"></i> Enregistrer le produit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-4 bg-light text-center">
            <i class="bi bi-info-circle fs-3 text-success mb-3"></i>
            <h6 class="fw-bold">Conseil de vente</h6>
            <p class="small text-muted">Ajoutez une description détaillée et un prix compétitif pour attirer plus d'acheteurs sur AgroLink.</p>
        </div>
    </div>
</div>
@endsection