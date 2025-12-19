@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nos producteurs</h2>

    <div class="row">
        @foreach($producteurs as $producteur)
        <div class="col-6 col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>{{ $producteur->nom }}</h5>
                    <a href="{{ route('magazin.show', $producteur->id_utilisateur) }}"
                       class="btn btn-outline-success btn-sm">
                       Voir magasin
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
