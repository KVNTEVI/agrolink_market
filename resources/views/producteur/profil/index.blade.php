@extends('layouts.producteur')

@section('title', 'Mon Profil Producteur')

@section('content')
<div class="container-fluid py-4" >
    <div class="row justify-content-center">
        <div class="col-xl-9">
            
            {{-- En-tête de page --}}
            <div class="mb-4">
                <h4 class="fw-bold text-success mb-1">Paramètres du profil Producteur</h4>
                <p class="text-muted small">Gérez vos informations professionnelles et vos coordonnées de contact.</p>
            </div>

            <div class="row g-4">
                {{-- COLONNE GAUCHE : RÉCAPITULATIF --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            {{-- Affichage de l'image de profil --}}
                            <div id="image-preview-container">
                                @if($user->image)
                                    <img src="{{ asset('images/utilisateurs/' . $user->image) }}" 
                                         id="profile-img"
                                         alt="Avatar" 
                                         class="rounded-circle shadow-sm object-fit-cover" 
                                         style="width: 100px; height: 100px;">
                                @else
                                    <div id="profile-placeholder" class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                                        <i class="bi bi-shop-window" style="font-size: 3rem;"></i>
                                    </div>
                                    {{-- Image cachée pour l'aperçu JS --}}
                                    <img src="" id="profile-img" class="rounded-circle shadow-sm object-fit-cover d-none" style="width: 100px; height: 100px;">
                                @endif
                            </div>
                            
                            {{-- Petit bouton caméra décoratif --}}
                            <span class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm p-2">
                                <i class="bi bi-camera-fill text-success"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->nom }}</h5>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25">
                            Compte Producteur
                        </span>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <h6 class="fw-bold text-dark mb-3 px-2">Sécurité & Accès</h6>
                        
                        {{-- Lien vers la page de modification du mot de passe --}}
                        <a href="{{ route('producteur.password.edit') }}" class="btn btn-light btn-sm w-100 text-start rounded-3 mb-2 py-2">
                            <i class="bi bi-shield-lock me-2 text-primary"></i> Modifier le mot de passe
                        </a>

                        {{-- Formulaire pour désactiver la boutique (plus sécurisé qu'un simple lien) --}}
                        <form action="{{ route('producteur.desactiver') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir désactiver votre boutique ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm w-100 text-start rounded-3 py-2 text-danger border-0">
                                <i class="bi bi-trash me-2"></i> Désactiver la boutique
                            </button>
                        </form>
                    </div>
                </div>

                {{-- COLONNE DROITE : FORMULAIRE --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="bi bi-pencil-square me-2 text-success"></i> Modifier mes informations
                            </h5>
                        </div>
                        
                        <div class="card-body px-4 pb-4">
                            @if(session('success'))
                                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('producteur.profil.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-3">
                                    {{-- CHAMP IMAGE --}}
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Photo de profil</label>
                                        <input type="file" name="image" id="image-input" class="form-control bg-light border-0 py-2 @error('image') is-invalid @enderror">
                                        <div class="form-text small text-muted">Format accepté : JPG, PNG (max 2Mo)</div>
                                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Nom de la Ferme / Nom complet</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                            <input type="text" name="nom" class="form-control bg-light border-0 py-2 @error('nom') is-invalid @enderror" 
                                                   value="{{ old('nom', $user->nom) }}" required>
                                        </div>
                                        @error('nom') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Email Professionnel</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                            <input type="email" name="email" class="form-control bg-light border-0 py-2 @error('email') is-invalid @enderror" 
                                                   value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Téléphone Contact</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-muted"></i></span>
                                            <input type="text" name="telephone" class="form-control bg-light border-0 py-2" 
                                                   value="{{ old('telephone', $user->telephone) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Adresse d'exploitation / Localisation</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-muted"></i></span>
                                            <textarea name="adresse" class="form-control bg-light border-0 py-2" rows="3">{{ old('adresse', $user->adresse) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 text-end">
                                    <button type="submit" class="btn btn-success rounded px-5 shadow-sm py-2">
                                        <i class="bi bi-save me-2"></i> Mettre à jour le profil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #198754 !important;
        box-shadow: none;
    }
    .input-group-text { border-radius: 10px 0 0 10px; }
    .form-control { border-radius: 0 10px 10px 0; }
    .object-fit-cover { object-fit: cover; }
</style>

{{-- SCRIPT POUR L'APERÇU DE L'IMAGE --}}
<script>
    document.getElementById('image-input').onchange = evt => {
        const [file] = document.getElementById('image-input').files;
        if (file) {
            const preview = document.getElementById('profile-img');
            const placeholder = document.getElementById('profile-placeholder');
            
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
            if(placeholder) placeholder.classList.add('d-none');
        }
    }
</script>
@endsection