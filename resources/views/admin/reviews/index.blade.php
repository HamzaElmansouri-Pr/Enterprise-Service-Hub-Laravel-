@extends('admin.layouts.app')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Reviews Management</h3>
                    <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Review
                    </a>
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Rating</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($review->image)
                                            <img src="{{ asset($review->image) }}" alt="{{ $review->name }}" 
                                                 class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                            @else
                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            @endif
                                            {{ $review->name }}
                                        </div>
                                    </td>
                                    <td>{{ $review->email }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($review->title, 30) }}</td>
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
                                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this review?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
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
