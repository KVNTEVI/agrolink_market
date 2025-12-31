@extends('layouts.acheteur')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            
            {{-- En-tête de page --}}
            <div class="mb-4">
                <h4 class="fw-bold text-dark mb-1">Paramètres du compte</h4>
                <p class="text-muted small">Gérez vos informations personnelles et vos adresses de livraison.</p>
            </div>

            <div class="row g-4">
                {{-- COLONNE GAUCHE : RÉCAPITULATIF --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                                <i class="bi bi-person-fill" style="font-size: 3rem;"></i>
                            </div>
                            <span class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm p-2" style="cursor: pointer;">
                                <i class="bi bi-camera-fill text-success"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->nom }}</h5>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25">
                            Compte Acheteur
                        </span>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <h6 class="fw-bold text-dark mb-3 px-2">Sécurité</h6>
                        <a href="#" class="btn btn-light btn-sm w-100 text-start rounded-3 mb-2 py-2">
                            <i class="bi bi-shield-lock me-2 text-primary"></i> Modifier le mot de passe
                        </a>
                        <a href="#" class="btn btn-light btn-sm w-100 text-start rounded-3 py-2 text-danger">
                            <i class="bi bi-trash me-2"></i> Supprimer le compte
                        </a>
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

                            <form action="{{ route('acheteur.profil.update') }}" method="POST">
                                @csrf
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Nom complet</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                            <input type="text" name="nom" class="form-control bg-light border-0 py-2 @error('nom') is-invalid @enderror" 
                                                   value="{{ old('nom', $user->nom) }}" required>
                                        </div>
                                        @error('nom') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                            <input type="email" name="email" class="form-control bg-light border-0 py-2 @error('email') is-invalid @enderror" 
                                                   value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Téléphone</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-muted"></i></span>
                                            <input type="text" name="telephone" class="form-control bg-light border-0 py-2" 
                                                   value="{{ old('telephone', $user->telephone) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Adresse de livraison</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-muted"></i></span>
                                            <textarea name="adresse" class="form-control bg-light border-0 py-2" rows="3">{{ old('adresse', $user->adresse) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 text-end">
                                    <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm py-2">
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
    /* Focus sur les inputs sans bordure */
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #198754 !important;
        box-shadow: none;
    }
    .input-group-text { border-radius: 10px 0 0 10px; }
    .form-control { border-radius: 0 10px 10px 0; }
</style>
@endsection