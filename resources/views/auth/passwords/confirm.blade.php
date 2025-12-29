@extends('layouts.app')

@section('content')

<style>
    body {
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .auth-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 160px); /* Ajusté pour centrer entre navbar et footer */
        padding: 20px;
    }

    .confirm-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
        width: 100%;
        max-width: 450px;
    }

    .confirm-header {
        background-color: #27ae60;
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

    .btn-confirm {
        background-color: #27ae60;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-confirm:hover {
        background-color: #219150;
        transform: translateY(-1px);
    }

    .forgot-link {
        color: #27ae60;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-wrapper">
    <div class="card confirm-card">
        <div class="card-header confirm-header">
            <i class="bi bi-leaf-fill me-2"></i>
            <span>AgroLink Market</span>
        </div>

        <div class="card-body p-4 p-md-5 text-center">
            <div class="mb-4">
                <i class="bi bi-shield-lock-fill text-muted" style="font-size: 3rem; color: #27ae60 !important;"></i>
                <h4 class="fw-bold mt-3">{{ __('Zone Sécurisée') }}</h4>
                <p class="text-muted small">
                    {{ __('Veuillez confirmer votre mot de passe avant de continuer.') }}
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-4 text-start">
                    <label for="password" class="form-label fw-bold small text-uppercase">{{ __('Mot de passe') }}</label>
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password" 
                           placeholder="••••••••">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-confirm text-white shadow-sm">
                        {{ __('Confirmer le mot de passe') }}
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="mt-3">
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection