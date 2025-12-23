@extends('layouts.app')

@section('content')

<!-- HERO CONTACT -->
<section class="bg-success bg-opacity-10 py-5 text-center" style="background-color:#F9C79A;">
    <div class="container">
        <h2 class="text-success fw-bold">Contactez-nous</h2>
        <p class="mt-2">
            Une question ? Un partenariat ? L’équipe AgroLink Market est à votre écoute.
        </p>
    </div>
</section>

<!-- FORMULAIRE -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <!-- Message succès -->
                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <h4 class="text-center fw-bold mb-4">
                            Envoyer un message
                        </h4>

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf

                            <!-- Nom -->
                            <div class="mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="nom"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       value="{{ old('nom') }}"
                                       placeholder="Votre nom">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Adresse email</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="exemple@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message"
                                          rows="4"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Écrivez votre message ici...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bouton -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Envoyer le message
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
