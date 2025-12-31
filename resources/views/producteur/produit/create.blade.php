@extends('layouts.producteur')

@section('title', 'Ajouter un Produit')

@section('content')
<div class="mb-4">
    <a href="{{ route('producteur.produit.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
    <h4 class="fw-bold mt-2">Nouveau produit</h4>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 p-4">
            {{-- ATTENTION : Ajout de enctype obligatoire pour les images --}}
            <form action="{{ route('producteur.produit.store') }}" method="POST" enctype="multipart/form-data">
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

                    {{-- Nouveau champ pour l'image directe --}}
                    <div class="col-12">
                        <label class="form-label fw-bold small">Image du produit</label>
                        <div class="input-group">
                            <input type="file" name="image" class="form-control bg-light border-0 py-2" accept="image/*" required>
                            <label class="input-group-text bg-light border-0"><i class="bi bi-camera"></i></label>
                        </div>
                        <div class="form-text small text-muted">Formats acceptés : JPG, PNG (Max 2Mo).</div>
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
        <div class="card shadow-sm border-0 p-4 bg-light text-center mb-3">
            <i class="bi bi-info-circle fs-3 text-success mb-3"></i>
            <h6 class="fw-bold">Conseil de vente</h6>
            <p class="small text-muted">Ajoutez une photo réelle de votre produit pour augmenter la confiance des acheteurs.</p>
        </div>
        
        {{-- Zone de prévisualisation (optionnelle) --}}
        <div id="image-preview-container" class="card shadow-sm border-0 p-2 d-none">
            <p class="small fw-bold text-center">Aperçu de l'image :</p>
            <img id="preview" src="#" alt="Aperçu" class="img-fluid rounded shadow-sm">
        </div>
    </div>
</div>

{{-- Petit script pour afficher l'aperçu de l'image avant l'envoi --}}
<script>
    document.querySelector('input[name="image"]').onchange = evt => {
        const [file] = evt.target.files
        if (file) {
            document.getElementById('image-preview-container').classList.remove('d-none');
            document.getElementById('preview').src = URL.createObjectURL(file)
        }
    }
</script>
@endsection