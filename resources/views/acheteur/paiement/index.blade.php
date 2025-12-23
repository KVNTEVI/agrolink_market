@extends('layouts.app')

@section('title', 'Historique des paiements')

@section('content')
<div class="container py-4">

    {{-- 🔙 Retour --}}
    <a href="{{ route('acheteur.commandes.index') }}"
       class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left"></i> Mes commandes
    </a>

    {{-- 💳 Titre --}}
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-cash-stack fs-3 text-success me-2"></i>
        <h4 class="mb-0 fw-bold">Historique des paiements</h4>
    </div>

    {{-- ✅ Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ❌ Aucun paiement --}}
    @if($paiements->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-receipt fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Aucun paiement effectué pour le moment.</p>
        </div>
    @else

    {{-- 📋 Tableau --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Commande</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>

            @foreach($paiements as $paiement)
                <tr>
                    {{-- Commande --}}
                    <td class="fw-semibold">
                        #{{ $paiement->commande->id_commande }}
                    </td>

                    {{-- Montant --}}
                    <td class="fw-bold text-success">
                        {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                    </td>

                    {{-- Mode --}}
                    <td>
                        <i class="bi bi-phone"></i>
                        {{ ucfirst($paiement->mode) }}
                    </td>

                    {{-- Statut --}}
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Payé
                        </span>
                    </td>

                    {{-- Date --}}
                    <td class="text-muted">
                        {{ $paiement->created_at->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    @endif
</div>
@endsection
