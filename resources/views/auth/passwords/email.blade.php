@extends('layouts.app')

@section('content')

<style>
    /* On s'assure que le wrapper prend toute la hauteur moins le header/footer */
    .auth-wrapper {
        display: flex;
        align-items: center; /* Centrage vertical */
        justify-content: center; /* Centrage horizontal */
        min-height: calc(100vh - 150px); /* Ajuste selon la taille de ton navbar/footer */
        padding: 20px;
    }

    .forgot-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
        width: 100%;
        max-width: 450px; /* Evite que la carte soit trop large sur grand écran */
    }

    .forgot-header {
        background-color: #198754;
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

    .btn-send {
        background-color: #198754;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-send:hover {
        background-color: #198754;
        transform: translateY(-1px);
    }

    .alert-status {
        background-color: #d1e7dd;
        border-left: 5px solid #198754;
        color: #0f5132;
        border-radius: 8px;
    }

    .back-to-login {
        color: #198754;
        text-decoration: none;
        font-weight: 500;
    }

    .back-to-login:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-wrapper">
    <div class="card forgot-card">
        <div class="card-header forgot-header">
            <i class="bi bi-leaf-fill me-2"></i>
            <span>AgroLink Market</span>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-shield-lock text-muted" style="font-size: 3rem;"></i>
                <h4 class="fw-bold mt-2">{{ __('Mot de passe oublié ?') }}</h4>
                <p class="text-muted small">Entrez votre email pour recevoir un lien de réinitialisation.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-status mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <small>{{ session('status') }}</small>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold small text-uppercase">{{ __('Adresse Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" 
                           required autocomplete="email" autofocus placeholder="exemple@agro.com">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-send text-white shadow-sm">
                        {{ __('Envoyer le lien') }}
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="back-to-login small">
                        <i class="bi bi-arrow-left me-1"></i> {{ __('Retour à la connexion') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection