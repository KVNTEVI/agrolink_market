@extends('layouts.acheteur')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            
            <div class="mb-4">
                <h4 class="fw-bold text-success mb-1">Paramètres du compte</h4>
                <p class="text-muted small">Gérez vos informations, votre sécurité et votre photo de profil.</p>
            </div>

            <div class="row g-4">
                {{-- COLONNE GAUCHE --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <div id="image-preview-container">
                                @if($user->image)
                                    <img src="{{ asset('images/utilisateurs/' . $user->image) }}" id="profile-img" class="rounded-circle shadow-sm object-fit-cover" style="width: 100px; height: 100px;">
                                @else
                                    <div id="profile-placeholder" class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                                        <i class="bi bi-person-fill" style="font-size: 3rem;"></i>
                                    </div>
                                    <img src="" id="profile-img" class="rounded-circle shadow-sm object-fit-cover d-none" style="width: 100px; height: 100px;">
                                @endif
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->nom }}</h5>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25">Compte Acheteur</span>
                    </div>

                    {{-- Section Sécurité --}}
                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
                        <h6 class="fw-bold text-dark mb-3 px-2">Actions rapides</h6>
                        <button type="button" class="btn btn-light btn-sm w-100 text-start rounded-3 mb-2 py-2" data-bs-toggle="modal" data-bs-target="#modalPassword">
                            <i class="bi bi-shield-lock me-2 text-primary"></i> Changer le mot de passe
                        </button>

                        <form action="{{ route('acheteur.profil.delete') }}" method="POST" onsubmit="return confirm('ATTENTION : Cette action est irréversible. Supprimer votre compte ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm w-100 text-start rounded-3 py-2 text-danger border-0">
                                <i class="bi bi-trash me-2"></i> Désactiver le compte
                            </button>
                        </form>
                    </div>
                </div>

                {{-- COLONNE DROITE --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-success"></i> Modifier mes informations</h5>
                        </div>
                        
                        <div class="card-body px-4 pb-4">
                            <form action="{{ route('acheteur.profil.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-3">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Photo de profil</label>
                                        <input type="file" name="image" id="image-input" class="form-control bg-light py-2">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Nom complet</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                            <input type="text" name="nom" class="form-control bg-light py-2" value="{{ old('nom', $user->nom) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                                            <input type="email" name="email" class="form-control bg-light py-2" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Téléphone</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-telephone text-muted"></i></span>
                                            <input type="text" name="telephone" class="form-control bg-light py-2" value="{{ old('telephone', $user->telephone) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Adresse de livraison</label>
                                        <textarea name="adresse" class="form-control bg-light py-2" rows="3">{{ old('adresse', $user->adresse) }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 text-end">
                                    <button type="submit" class="btn btn-success px-5 rounded shadow-sm py-2"><i class="bi bi-save me-2"></i>Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL POUR LE MOT DE PASSE --}}
<div class="modal fade" id="modalPassword" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="fw-bold mb-0">Changer mon mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('acheteur.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control bg-light" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control bg-light" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control bg-light" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success w-100 rounded-pill">Valider le changement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Application de la bordure noire 1px sur tous les éléments de saisie */
    .form-control, .input-group-text {
        border: 1px solid #bbbbbb !important;
        background-color: #ffffff !important;
    }

    /* Style des groupes d'entrée (icônes + champs) */
    .input-group-text {
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
    }

    .input-group .form-control {
        border-radius: 0 10px 10px 0 !important;
    }

    /* Focus (quand on clique dans le champ) */
    .form-control:focus {
        border-color: #198754 !important;
        box-shadow: 0 0 0 0.1rem rgba(25, 135, 84, 0.25) !important;
    }

    .object-fit-cover { object-fit: cover; }
</style>

<script>
    document.getElementById('image-input').onchange = evt => {
        const [file] = document.getElementById('image-input').files;
        if (file) {
            const preview = document.getElementById('profile-img');
            const placeholder = document.getElementById('profile-placeholder');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
            if(placeholder) placeholder.classList.add('d-none');
        }
    }
</script>
@endsection