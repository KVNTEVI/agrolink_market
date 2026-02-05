@extends('layouts.admin')

@section('title', 'Profil Administrateur')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="mb-4">
                <h4 class="fw-bold text-dark mb-1">Mon Profil Administrateur</h4>
                <p class="text-muted small">Gérez vos accès et informations de sécurité.</p>
            </div>

            <div class="row g-4">
                {{-- Gauche : Aperçu --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <img src="{{ $user->image ? asset('images/utilisateurs/' . $user->image) : asset('images/default-admin.png') }}" 
                                 id="profile-img" class="rounded-circle shadow-sm object-fit-cover" 
                                 style="width: 100px; height: 100px; border: 2px solid #000;">
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->nom }}</h5>
                        <span class="badge bg-dark rounded-pill px-3 py-2">Administrateur</span>
                    </div>
                </div>

                {{-- Droite : Formulaire --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success border-0">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">PHOTO DE PROFIL</label>
                                    <input type="file" name="image" id="image-input" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">NOM COMPLET</label>
                                    <input type="text" name="nom" class="form-control" value="{{ $user->nom }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">EMAIL</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 rounded-pill mt-3">Enregistrer les modifications</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        border: 1px solid #000000 !important;
        border-radius: 8px !important;
        background-color: #fff !important;
    }
    .form-control:focus {
        border-color: #000 !important;
        box-shadow: 0 0 0 0.2rem rgba(0,0,0,0.1);
    }
    .object-fit-cover { object-fit: cover; }
</style>

<script>
    document.getElementById('image-input').onchange = evt => {
        const [file] = evt.target.files;
        if (file) {
            document.getElementById('profile-img').src = URL.createObjectURL(file);
        }
    }
</script>
@endsection