@extends('layouts.acheteur')

@section('title', 'Mes Notifications')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-success">
                <i class="bi bi-bell me-2"></i> Historique des notifications
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($allNotifications as $notification)
                    <div class="list-group-item list-group-item-action p-3 {{ $notification->read_at ? 'opacity-75' : 'bg-light border-start border-success border-4' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1 fw-semibold text-dark">
                                    {{ $notification->data['message'] ?? 'Notification' }}
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        Marquer comme lu
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-bell-slash fs-1 d-block mb-3"></i>
                        Aucune notification pour le moment.
                    </div>
                @endforelse
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $allNotifications->links() }}
        </div>
    </div>
</div>
@endsection