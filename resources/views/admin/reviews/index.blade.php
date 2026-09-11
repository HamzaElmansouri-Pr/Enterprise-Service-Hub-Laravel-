@extends('admin.layouts.app')

@section('title', 'Reviews Management')
@section('page-title', 'Reviews Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Reviews (Testimonials)</h4>
    <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Review
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($reviews->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80">Image</th>
                        <th>Client</th>
                        <th>Company/Position</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>
                            @if($review->client_image)
                                <img src="{{ asset($review->client_image) }}" alt="img" 
                                     class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ get_content_value($review->client_name) }}</td>
                        <td>
                            <div class="small fw-bold">{{ $review->client_company }}</div>
                            <div class="small text-muted">{{ get_content_value($review->client_position) }}</div>
                        </td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                            @endfor
                        </td>
                        <td>
                            @if($review->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            @if($review->is_featured)
                                <i class="fas fa-check text-success"></i>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $review->order_index }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-quote-right fa-3x text-muted opacity-50"></i>
            </div>
            <h5 class="text-muted">No reviews found</h5>
            <p class="text-muted small">Add testimonials from your happy clients.</p>
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary mt-2">
                Create Review
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
