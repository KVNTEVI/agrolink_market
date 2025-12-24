@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold">
        <i class="bi bi-bell"></i> Notifications
    </h4>
    <p class="text-muted mb-0">Historique de vos alertes</p>
</div>

@if($notifications->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted"></i>
        <p class="text-muted mt-3">Aucune notification</p>
    </div>
@else
<div class="list-group shadow-sm">
    @foreach($notifications as $notification)

        <div class="list-group-item d-flex justify-content-between align-items-start
            {{ $notification->read_at ? '' : 'bg-light' }}">

            <div>
                <div class="fw-semibold">
                    {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                </div>

                <small class="text-muted">
                    {{ $notification->created_at->diffForHumans() }}
                </small>
            </div>

            @if(!$notification->read_at)
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-success">
                        <i class="bi bi-check2"></i>
                    </button>
                </form>
            @endif
        </div>

    @endforeach
</div>
@endif

@endsection
