@extends('layouts.acheteur')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="bi bi-person-circle me-2"></i> Informations du profil
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('acheteur.profil.update') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nom complet</label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                                       value="{{ old('nom', $user->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Adresse Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Téléphone</label>
                                <input type="text" name="telephone" class="form-control" 
                                       value="{{ old('telephone', $user->telephone) }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Adresse de livraison</label>
                                <textarea name="adresse" class="form-control" rows="3">{{ old('adresse', $user->adresse) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-3 text-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check2-circle me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection