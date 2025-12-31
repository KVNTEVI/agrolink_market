@extends('layouts.acheteur')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white p-3 border-0">
                    <h5 class="fw-bold mb-0">Discussion avec {{ $conversation->producteur->nom }}</h5>
                </div>
                
                <div class="card-body bg-light" style="height: 450px; overflow-y: auto;">
                    @foreach($conversation->messages as $msg)
                    <div class="mb-3 d-flex {{ $msg->expediteur_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded-4 {{ $msg->expediteur_id == Auth::id() ? 'bg-dark text-white' : 'bg-white shadow-sm' }}" style="max-width: 80%;">
                            @if($msg->prix_propose)
                                <p class="mb-1"><strong>Offre proposée : {{ $msg->prix_propose }} FCFA</strong></p>
                            @endif
                            {{ $msg->contenu }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="card-footer bg-white p-3">
                    @if($conversation->statut == 'ouverte')
                    <form action="{{ route('messages.store', $conversation->id_conversation) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="number" name="prix_propose" class="form-control rounded-pill mb-2" placeholder="Proposer un prix (facultatif)">
                            <textarea name="contenu" class="form-control rounded-4" rows="2" placeholder="Votre message..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-pill">Envoyer le message</button>
                    </form>
                    @else
                    <div class="alert alert-success rounded-pill text-center">Cette négociation est terminée.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection