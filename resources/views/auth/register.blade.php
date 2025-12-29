@extends('layouts.app')

@section('content')

<style>
    body {
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .register-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
    }

    .register-header {
        background-color: #27ae60;
        color: white;
        text-align: center;
        padding: 1.5rem;
        font-size: 1.6rem;
        font-weight: bold;
        border-radius: 15px 15px 0 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-register {
        background-color: #27ae60;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-register:hover {
        background-color: #219150;
        transform: translateY(-1px);
    }

    .form-label {
        font-weight: 500;
        color: #444;
    }

    .login-link {
        color: #27ae60;
        text-decoration: none;
    }

    .login-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh; padding: 20px 0;">
    <div class="col-md-8 col-lg-6">
        <div class="card register-card">
            <div class="card-header register-header">
                <i class="bi bi-leaf-fill me-2"></i>
                <span>Rejoindre AgroLink Market</span>
            </div>

            <div class="card-body p-4 p-md-5">
                <p class="text-center text-muted mb-4">Créez votre compte en quelques secondes</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nom" class="form-label">{{ __('Nom complet') }}</label>
                            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   name="nom" value="{{ old('nom') }}" placeholder="Ex: Jean Dupont" 
                                   required autocomplete="nom" autofocus>
                            
                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">{{ __('Adresse Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" placeholder="jean@exemple.com" 
                                   required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" placeholder="••••••••" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-register text-white shadow-sm">
                            {{ __('Créer mon compte') }}
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <span class="text-muted">Vous avez déjà un compte ?</span> 
                        <a href="{{ route('login') }}" class="login-link fw-bold">Connectez-vous</a>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-4">
            <small>© {{ date('Y') }} <strong>AgroLink Market</strong>. Tous droits réservés.</small>
        </p>
    </div>
</div>

@endsection