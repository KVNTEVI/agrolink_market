@extends('layouts.app')

@section('content')

<style>
    body {
        min-height: 100vh;
        background-color: #f8f9fa; 
    }

    .login-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
    }

    .login-header {
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

    .btn-login {
        background-color: #27ae60;
        border: none;
        padding: 10px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: #219150;
        transform: translateY(-1px);
    }

    .forgot-link {
        color: #27ae60;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-6 col-lg-5">
        <div class="card login-card">
            <div class="card-header login-header">
                <i class="bi bi-leaf-fill me-2"></i>
                <span>AgroLink Market</span>
            </div>

            <div class="card-body p-4">
                <p class="text-center text-muted mb-4">Heureux de vous revoir !</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" 
                               placeholder="exemple@agro.com" required autofocus>

                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" placeholder="••••••••" required>

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-login text-white shadow-sm">
                            Se connecter
                        </button>
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