@extends('admin.layouts.app')

@section('title', 'Service Requests')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Service Requests</h3>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.tc-requests.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-check-double"></i> Mark All as Read
                            </button>
                        </form>
                    </div>
                </div>
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
                                    <th>
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Service</th>
                                    <th>Description</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tcRequests as $tcRequest)
                                <tr class="{{ !$tcRequest->is_read ? 'table-warning' : '' }}">
                                    <td>
                                        <input type="checkbox" name="tc_request_ids[]" value="{{ $tcRequest->id }}" class="form-check-input tc-request-checkbox">
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
                                    <td>{{ Str::limit($tcRequest->description, 50) }}</td>
                                    <td>
                                        @if($tcRequest->attached_file)
                                            <a href="{{ route('admin.tc-requests.download-file', $tcRequest) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">No File</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tcRequest->is_read)
                                            <form action="{{ route('admin.tc-requests.mark-unread', $tcRequest) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-envelope-open"></i> Read
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.tc-requests.mark-read', $tcRequest) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-envelope"></i> Unread
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
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No service requests found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- @if($tcRequests->count() > 0)
                    <div class="mt-3">
                        <form action="{{ route('admin.tc-requests.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tc_request_ids" id="selectedTcRequests">
                            <button type="submit" class="btn btn-danger" id="bulkDeleteBtn" disabled>
                                <i class="fas fa-trash"></i> Delete Selected
                            </button>
                        </form>
                    </div>
                    @endif --}}

                    @if($tcRequests->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tcRequests->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const tcRequestCheckboxes = document.querySelectorAll('.tc-request-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedTcRequestsInput = document.getElementById('selectedTcRequests');

    selectAllCheckbox.addEventListener('change', function() {
        tcRequestCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkDeleteButton();
    });

    tcRequestCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkDeleteButton();
        });
    });

    function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.tc-request-checkbox:checked');
        const checkedIds = Array.from(checkedBoxes).map(cb => cb.value);
        
        selectedTcRequestsInput.value = JSON.stringify(checkedIds);
        bulkDeleteBtn.disabled = checkedIds.length === 0;
    }
});
</script>
@endsection
