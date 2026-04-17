@extends('admin-backend.main.panel')
@section('title', 'Notifications')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">All Notifications</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        @php $payload = (array) ($notification->payload ?? []); @endphp
                        <tr>
                            <td>{{ $notification->id }}</td>
                            <td>{{ str_replace('_', ' ', ucfirst($notification->type)) }}</td>
                            <td>
                                @if (($notification->type ?? '') === 'new_order')
                                    Order #{{ $payload['order_id'] ?? 'N/A' }} |
                                    {{ $payload['email'] ?? 'N/A' }} |
                                    ${{ number_format((float) ($payload['total'] ?? 0), 2) }}
                                @else
                                    {{ json_encode($payload) }}
                                @endif
                            </td>
                            <td>
                                @if($notification->is_read)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unread</span>
                                @endif
                            </td>
                            <td>{{ $notification->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No notifications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
