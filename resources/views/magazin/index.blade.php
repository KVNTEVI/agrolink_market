@extends('layouts.app')

@section('content')

{{-- NOUVEL EN-TÊTE HARMONISÉ --}}
<section class="bg-success bg-opacity-10 py-5 text-center">
    <div class="container">
        <h2 class="text-success fw-bold">Nos Producteurs</h2>
        <p class="mt-2 text-dark">
            Découvrez les passionnés qui nourrissent notre communauté. Des produits frais, directement de la terre à votre table.
        </p>
    </div>
</section>

{{-- SECTION STYLISÉE --}}
<section class="py-5" style="background-color: rgba(25, 135, 84, 0.05);">

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('magazin.index') }}" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white border">
                    <input type="text" name="search" class="form-control border-0 px-4 py-2" 
                        placeholder="Rechercher un producteur..." value="{{ request('search') }}">
                    <button class="btn btn-success px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-4">

            @forelse($producteurs as $producteur)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border-0 producer-card">
                        {{-- Fond décoratif en haut de la carte --}}
                        <div class="card-header-accent"></div>
                        
                        <div class="card-body p-4 position-relative">
                            {{-- Image avec contour blanc et ombre --}}
                            <div class="avatar-wrapper">
                                <img src="{{ asset('images/utilisateurs/' . $producteur->image) }}" 
                                class="rounded-circle profile-img shadow" 
                                alt="{{ $producteur->nom }}">
                            </div>

                            <h5 class="fw-bold mt-3 text-dark mb-1">
                                {{ $producteur->nom }}
                            </h5>

                            <p class="text-success small fw-medium mb-3">
                                <i class="bi bi-patch-check-fill"></i> Producteur certifié
                            </p>

                            <div class="d-flex justify-content-center gap-2 mb-4">
                                <span class="badge bg-light text-muted border fw-normal rounded-pill">Agro-Écologie</span>
                                <span class="badge bg-light text-muted border fw-normal rounded-pill">Local</span>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('magazin.show', $producteur->id_utilisateur) }}"
                                   class="btn btn-producer rounded-pill py-2 fw-bold">
                                    <i class="bi bi-person-circle me-1"></i> Voir le profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-people display-1 text-muted opacity-25"></i>
                    <p class="text-muted mt-3 fs-5">Aucun producteur disponible pour le moment.</p>
                </div>
            @endforelse

        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $producteurs->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>

<style>
    /* Carte Principale */
    .producer-card {
        border-radius: 20px !important;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
        position: relative;
        background: #ffffff;
    }

    .producer-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(25, 135, 84, 0.15) !important;
    }

    /* Accent de couleur en haut */
    .card-header-accent {
        height: 80px;
        background: linear-gradient(135deg, #198754 0%, #2fb380 100%);
    }

    /* Placement de l'image de profil */
    .avatar-wrapper {
        margin-top: -65px;
        margin-bottom: 10px;
    }

    .profile-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 5px solid #ffffff;
        transition: transform 0.3s ease;
    }

    .producer-card:hover .profile-img {
        transform: scale(1.08);
    }

    /* Bouton personnalisé */
    .btn-producer {
        background-color: #f0fdf4;
        color: #198754;
        border: 1px solid rgba(25, 135, 84, 0.2);
        transition: all 0.3s ease;
    }

    .btn-producer:hover {
        background-color: #198754;
        color: #ffffff;
        transform: scale(1.02);
    }

    /* Typographie */
    .producer-card h5 {
        letter-spacing: -0.5px;
    }

    /* Masquer le texte "Showing X to Y of Z results" */
.pagination nav div:first-child p.text-muted {
    display: none !important;
}

/* Personnalisation de la pagination en vert */
.pagination .page-link {
    color: #198754 !important; /* Vert success */
    border-radius: 8px !important;
    margin: 0 3px;
    border-color: #dee2e6;
    background-color: white;
}

.pagination .page-item.active .page-link {
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: white !important;
}

.pagination .page-link:hover {
    background-color: #f0fdf4;
    color: #146c43 !important;
}
</style>

@endsection