@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="fas fa-envelope-open-text text-primary me-2"></i>
        Subscribers
    </h4>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.subscribers.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-secondary">Search</button>
        </form>
        <a href="{{ route('admin.subscribers.export') }}" class="btn btn-sm btn-success">
            <i class="fas fa-file-export me-1"></i> Export CSV
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Email</th>
                        <th>Status</th>
                        <th>Subscribed Date</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $sub)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $sub->email }}</td>
                        <td>
                            @if($sub->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Unsubscribed</span>
                            @endif
                        </td>
                        <td>{{ $sub->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.subscribers.toggle', $sub) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $sub->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $sub->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $sub->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.subscribers.destroy', $sub) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subscriber entirely?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fs-2 mb-2 opacity-50"></i>
                            <p class="mb-0">No subscribers found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subscribers->hasPages())
    <div class="card-footer bg-white border-0 pt-3">
        {{ $subscribers->links() }}
    </div>
    @endif
</div>
@endsection
