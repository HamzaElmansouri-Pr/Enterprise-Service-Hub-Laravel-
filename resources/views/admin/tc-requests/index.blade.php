@extends('admin.layouts.app')

@section('title', 'Service Requests')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Service Requests</h4>
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter"></i> Filters
                    </button>
                    <button type="button" class="btn btn-outline-info me-2" id="btn-save-view">
                        <i class="fas fa-save"></i> Save View
                    </button>
                    <a href="{{ route('admin.tc-requests.export') }}" class="btn btn-success me-2">
                        <i class="fas fa-file-csv"></i> Export to CSV
                    </a>
                    <form action="{{ route('admin.tc-requests.mark-all-read') }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-check-double"></i> Mark All Read
                        </button>
                    </form>
                </div>
            </div>

            <div class="collapse {{ request()->anyFilled(['search', 'status', 'is_read', 'date_from', 'date_to']) ? 'show' : '' }} mb-4" id="filterCollapse">
                <div class="card card-body bg-light">
                    <form method="GET" action="{{ route('admin.tc-requests.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Email, Desc...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Progress Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Read Status</label>
                            <select name="is_read" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>Read</option>
                                <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Unread</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Actions Bar -->
            <div id="bulk-actions-bar" class="bg-primary text-white p-3 rounded mb-4 d-none d-flex justify-content-between align-items-center shadow">
                <div>
                    <i class="fas fa-check-square me-2"></i>
                    <span id="selected-count" class="fw-bold">0</span> items selected
                </div>
                <form id="bulk-action-form" action="{{ route('admin.tc-requests.bulk-action') }}" method="POST" class="d-flex align-items-center mb-0">
                    @csrf
                    <input type="hidden" name="ids" id="bulk-ids">
                    <select name="action" class="form-select form-select-sm me-2 w-auto">
                        <option value="">Choose action...</option>
                        <option value="mark_read">Mark Read</option>
                        <option value="mark_unread">Mark Unread</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="submit" class="btn btn-light btn-sm text-primary fw-bold" onclick="return confirm('Are you sure you want to perform this bulk action?')">Apply</button>
                </form>
            </div>

            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="select-all-rows" class="form-check-input">
                                    </th>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Service</th>
                                    <th>Description</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Read</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tcRequests as $tcRequest)
                                <tr class="{{ !$tcRequest->is_read ? 'table-warning' : '' }}">
                                    <td>
                                        <input type="checkbox" value="{{ $tcRequest->id }}" class="form-check-input row-selector">
                                    </td>
                                    <td>{{ $tcRequest->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ $tcRequest->email }}
                                            @if(!$tcRequest->is_read)
                                            <span class="badge bg-primary ms-2">New</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($tcRequest->service)
                                            <span class="badge bg-info">{{ $tcRequest->service->title }}</span>
                                        @else
                                            <span class="text-muted">No Service Selected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span title="{{ $tcRequest->description }}">
                                            {{ Str::limit($tcRequest->description, 30) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($tcRequest->attached_file)
                                            <a href="{{ route('admin.tc-requests.download-file', $tcRequest) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div data-inline-edit="status" data-inline-type="select" data-value="{{ $tcRequest->status }}" data-inline-url="{{ route('admin.tc-requests.inline-update', $tcRequest) }}" class="d-inline-block">
                                            @php
                                                $colors = [
                                                    'pending' => 'bg-warning text-dark',
                                                    'reviewed' => 'bg-info',
                                                    'contacted' => 'bg-primary',
                                                    'completed' => 'bg-success',
                                                    'spam' => 'bg-danger'
                                                ];
                                            @endphp
                                            <span class="badge {{ $colors[$tcRequest->status] ?? 'bg-secondary' }}">
                                                {{ ucfirst($tcRequest->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($tcRequest->is_read)
                                            <form action="{{ route('admin.tc-requests.mark-unread', $tcRequest) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" title="Mark Unread">
                                                    <i class="fas fa-envelope-open"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.tc-requests.mark-read', $tcRequest) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning" title="Mark Read">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $tcRequest->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tc-requests.show', $tcRequest) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.tc-requests.destroy', $tcRequest) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this service request?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No service requests found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($tcRequests->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tcRequests->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
