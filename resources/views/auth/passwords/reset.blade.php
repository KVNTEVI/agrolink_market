@extends('layouts.app')

@section('content')

<style>
    body {
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .reset-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
    }

    .reset-header {
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

    .btn-reset {
        background-color: #198754;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-reset:hover {
        background-color: #198754;
        transform: translateY(-1px);
    }

    .form-label {
        font-weight: 500;
        color: #444;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh; padding: 20px 0;">
    <div class="col-md-7 col-lg-5">
        <div class="card reset-card">
            <div class="card-header reset-header">
                <i class="bi bi-leaf-fill me-2"></i>
                <span>AgroLink Market</span>
            </div>

            <div class="card-body p-4 p-md-5">
                <h4 class="text-center mb-4 fw-bold">{{ __('Réinitialiser le mot de passe') }}</h4>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Adresse Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ $email ?? old('email') }}" 
                               required autocomplete="email" autofocus placeholder="votre@email.com">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Nouveau mot de passe') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="new-password" placeholder="••••••••">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                        <input id="password-confirm" type="password" class="form-control" 
                               name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-reset text-white shadow-sm">
                            {{ __('Mettre à jour le mot de passe') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-4">
            <small>© {{ date('Y') }} <strong>AgroLink Market</strong></small>
        </p>
    </div>
</div>

@endsection