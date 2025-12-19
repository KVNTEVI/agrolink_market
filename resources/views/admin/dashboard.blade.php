@extends('layouts.admin')

@section('admin-content')
<h3>Dashboard Admin</h3>

<div class="row">
    <div class="col-md-3">Utilisateurs: {{ $totalUtilisateurs }}</div>
    <div class="col-md-3">Produits: {{ $totalProduits }}</div>
</div>
@endsection
