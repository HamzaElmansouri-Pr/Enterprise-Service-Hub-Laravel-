@extends('admin.layouts.app')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">Reviews Management</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Review
                            </a>
                            <a href="{{ route('admin.reviews.show-import') }}" class="btn btn-info">
                                <i class="fas fa-upload"></i> Import
                            </a>
                            <a href="{{ route('admin.reviews.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="search" placeholder="Search reviews..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="featured" class="form-select">
                                <option value="">All Featured</option>
                                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured</option>
                                <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="rating" class="form-select">
                                <option value="">All Ratings</option>
                                @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Bulk Actions -->
                    @if($reviews->count() > 0)
                    <div class="mb-3">
                        <form action="{{ route('admin.reviews.bulk-approve') }}" method="POST" class="d-inline" id="bulk-approve-form">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirmBulkAction('approve')">
                                <i class="fas fa-check"></i> Bulk Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.reviews.bulk-delete') }}" method="POST" class="d-inline" id="bulk-delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirmBulkAction('delete')">
                                <i class="fas fa-trash"></i> Bulk Delete
                            </button>
                        </form>
                        <small class="text-muted ms-2">Select reviews to perform bulk actions</small>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                    </th>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Company</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Project Type</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input review-checkbox" value="{{ $review->id }}">
                                    </td>
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($review->client_image)
                                            <img src="{{ asset($review->client_image) }}" alt="{{ $review->client_name }}" 
                                                 class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                            @else
                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $review->client_name }}</div>
                                                @if($review->client_position)
                                                <small class="text-muted">{{ $review->client_position }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $review->client_company ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            <span class="ms-1">({{ $review->rating }})</span>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($review->review_text, 50) }}</td>
                                    <td>
                                        @if($review->project_type)
                                        <span class="badge bg-info">{{ $review->project_type }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.reviews.toggle-approved', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $review->is_approved ? 'btn-success' : 'btn-warning' }}">
                                                {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.reviews.toggle-featured', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $review->is_featured ? 'btn-primary' : 'btn-outline-primary' }}">
                                                {{ $review->is_featured ? 'Featured' : 'Not Featured' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this review?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No reviews found.</p>
                                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add First Review
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($reviews->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reviews->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const reviewCheckboxes = document.querySelectorAll('.review-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        reviewCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Update select all checkbox when individual checkboxes change
    reviewCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.review-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === reviewCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < reviewCheckboxes.length;
        });
    });
});

function confirmBulkAction(action) {
    const checkedCheckboxes = document.querySelectorAll('.review-checkbox:checked');
    
    if (checkedCheckboxes.length === 0) {
        alert('Please select at least one review to ' + action + '.');
        return false;
    }
    
    const actionText = action === 'delete' ? 'delete' : 'approve';
    const confirmMessage = `Are you sure you want to ${actionText} ${checkedCheckboxes.length} selected review(s)?`;
    
    if (confirm(confirmMessage)) {
        // Add selected IDs to the form
        const form = document.getElementById(`bulk-${action}-form`);
        
        // Remove existing hidden inputs
        form.querySelectorAll('input[name="review_ids[]"]').forEach(input => input.remove());
        
        // Add new hidden inputs for selected reviews
        checkedCheckboxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'review_ids[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });
        
        return true;
    }
    
    return false;
}
</script>
@endpush
