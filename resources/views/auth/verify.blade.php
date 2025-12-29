@extends('layouts.app')

@section('content')

<style>
    body {
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .verify-card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
    }

    .verify-header {
        background-color: #27ae60;
        color: white;
        text-align: center;
        padding: 1.5rem;
        font-size: 1.4rem;
        font-weight: bold;
        border-radius: 15px 15px 0 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-box {
        font-size: 3rem;
        color: #27ae60;
        margin-bottom: 1.5rem;
    }

    .btn-resend {
        color: #27ae60;
        font-weight: bold;
        text-decoration: none;
        border: none;
        background: none;
        padding: 0;
    }

    .btn-resend:hover {
        color: #219150;
        text-decoration: underline;
    }

    .alert-success-custom {
        background-color: #d1e7dd;
        border-left: 5px solid #27ae60;
        color: #0f5132;
        border-radius: 8px;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-7 col-lg-6">
        <div class="card verify-card text-center">
            <div class="card-header verify-header">
                <i class="bi bi-leaf-fill me-2"></i>
                <span>AgroLink Market</span>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="icon-box">
                    <i class="bi bi-envelope-check"></i>
                </div>

                <h3 class="mb-3 fw-bold">Vérifiez votre boîte mail</h3>

                @if (session('resent'))
                    <div class="alert alert-success-custom mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                    </div>
                @endif

                <p class="text-muted fs-5">
                    {{ __('Avant de continuer, veuillez consulter vos e-mails pour trouver le lien de vérification.') }}
                </p>
                
                <hr class="my-4" style="opacity: 0.1;">

                <p class="mb-0 text-muted">
                    {{ __('Si vous n\'avez pas reçu l\'e-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn-resend align-baseline">
                            {{ __('cliquez ici pour en demander un autre') }}
                        </button>.
                    </form>
                </p>
            </div>
        </div>

        <p class="text-center text-muted mt-4">
            <small>© {{ date('Y') }} <strong>AgroLink Market</strong></small>
        </p>
    </div>
</div>

@endsection