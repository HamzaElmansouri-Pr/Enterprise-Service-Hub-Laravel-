@extends('admin.layouts.app')

@section('title', 'Review Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Review Details</h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Review
                        </a>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Reviews
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($review->image)
                                <img src="{{ asset($review->image) }}" alt="{{ $review->name }}" 
                                     class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                <div class="bg-secondary rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                                @endif
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5>Review Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Name:</strong> {{ $review->name }}</p>
                                    <p><strong>Email:</strong> {{ $review->email }}</p>
                                    @if($review->company)
                                    <p><strong>Company:</strong> {{ $review->company }}</p>
                                    @endif
                                    @if($review->position)
                                    <p><strong>Position:</strong> {{ $review->position }}</p>
                                    @endif
                                    <p><strong>Rating:</strong> 
                                        <div class="d-flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                    </p>
                                    <p><strong>Status:</strong> 
                                        <span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning' }}">
                                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </p>
                                    <p><strong>Featured:</strong> 
                                        <span class="badge {{ $review->is_featured ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $review->is_featured ? 'Yes' : 'No' }}
                                        </span>
                                    </p>
                                    <p><strong>Created:</strong> {{ $review->created_at->format('M d, Y H:i') }}</p>
                                    <p><strong>Updated:</strong> {{ $review->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Review Content</h5>
                                </div>
                                <div class="card-body">
                                    <h4 class="mb-3">{{ $review->title }}</h4>
                                    <div class="mb-3">
                                        <p class="text-muted">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
