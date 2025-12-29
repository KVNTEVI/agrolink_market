@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Modifier la catégorie</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $categorie->id_categorie) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="nom" class="form-label fw-bold">Nom de la catégorie</label>
                        <input type="text" name="nom" id="nom" 
                               class="form-control @error('nom') is-invalid @enderror" 
                               value="{{ old('nom', $categorie->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection