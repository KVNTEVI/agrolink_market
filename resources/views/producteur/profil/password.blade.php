@extends('layouts.producteur')

@section('title', 'Modifier mon mot de passe')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }

    .reset-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
    }

    .reset-header {
        background-color: #198754; /* Vert standard de ton projet */
        color: white;
        text-align: center;
        padding: 1.5rem;
        font-size: 1.5rem;
        font-weight: bold;
        border-radius: 15px 15px 0 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset {
        background-color: #198754;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-reset:hover {
        background-color: #146c43;
        transform: translateY(-1px);
        color: white;
    }

    .form-label {
        font-weight: 600;
        color: #444;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh; padding: 40px 0;">
    <div class="col-md-7 col-lg-5">
        
        {{-- Bouton Retour --}}
        <div class="mb-3">
            <a href="{{ route('producteur.profil') }}" class="text-decoration-none text-dark small fw-bold">
                <i class="bi bi-arrow-left me-1"></i> Retour au profil
            </a>
        </div>

        <div class="card reset-card">
            <div class="card-header reset-header">
                <i class="bi bi-leaf-fill me-2"></i>
                <span>AgroLink Market</span>
            </div>

            <div class="card-body p-4 p-md-5">
                <h4 class="text-center mb-4 fw-bold">Sécurité du compte</h4>
                <p class="text-center text-muted small mb-4">Veuillez confirmer votre ancien mot de passe avant d'en choisir un nouveau.</p>
                
                <form method="POST" action="{{ route('producteur.password.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Mot de passe actuel --}}
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input id="current_password" type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               name="current_password" required placeholder="Saisissez votre mot de passe actuel">
                        
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <hr class="my-4 opacity-50">

                    {{-- Nouveau mot de passe --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input id="password" type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" required placeholder="Minimum 8 caractères">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Confirmation --}}
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input id="password-confirm" type="password" class="form-control" 
                               name="password_confirmation" required placeholder="Répétez le nouveau mot de passe">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-reset text-white shadow-sm">
                            <i class="bi bi-shield-check me-2"></i>Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection