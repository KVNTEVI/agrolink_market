@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 bg-dark text-white">
            Admin Menu
        </aside>

        <main class="col-md-10">
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection
