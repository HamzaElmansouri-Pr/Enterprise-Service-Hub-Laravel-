@extends('admin.layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
@php($user = auth()->user())
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Edit Profile</h4>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Settings
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    Profile Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user?->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user?->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror mt-2"
                               id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="Or paste image URL (https://...)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('image_url')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        @if($user && $user->image)
                        <div class="mt-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ resolve_image_url($user->image) }}" alt="Current Profile Image" 
                                     class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <p class="mb-1"><strong>Current Image:</strong></p>
                                    <small class="text-muted">Upload a new image to replace the current one</small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteImage()">
                                    <i class="fas fa-trash me-1"></i>
                                    Remove Image
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="mt-2">
                            <small class="text-muted">No profile image uploaded yet</small>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Profile Preview
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($user->image)
                        <img src="{{ resolve_image_url($user->image) }}" alt="Profile Image" 
                             class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user text-white" style="font-size: 2.5rem;"></i>
                        </div>
                    @endif
                </div>
                <h6 class="card-title">{{ $user->name }}</h6>
                <p class="text-muted">{{ $user->email }}</p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use a clear, professional photo
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Keep your email address current
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use your real name for better recognition
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Supported formats: JPG, PNG, GIF, SVG
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Delete Image Form -->
<form id="delete-image-form" action="{{ route('admin.settings.delete-image') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteImage() {
    if (confirm('Are you sure you want to remove your profile image?')) {
        document.getElementById('delete-image-form').submit();
    }
}

// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update preview in sidebar
            const previewImg = document.querySelector('.card-body img');
            if (previewImg) {
                previewImg.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
