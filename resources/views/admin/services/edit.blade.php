@extends('admin.layouts.app')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service: ' . $service->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Service Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $service->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                               id="subtitle" name="subtitle" value="{{ old('subtitle', $service->subtitle) }}">
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($service->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" 
                                 class="rounded me-3" style="width: 100px; height: 75px; object-fit: cover;">
                            <div>
                                <p class="mb-1"><strong>Current Image</strong></p>
                                <small class="text-muted">Upload a new image to replace this one</small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">
                                    {{ $service->image ? 'Replace Image' : 'Service Image' }}
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <div class="form-text">Recommended size: 400x300px. Max size: 2MB</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon Class</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon', $service->icon) }}" 
                                       placeholder="e.g., fas fa-cog">
                                <div class="form-text">Font Awesome icon class (if no image provided)</div>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $service->price) }}" 
                                       step="0.01" min="0">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price_unit" class="form-label">Price Unit</label>
                                <select class="form-control @error('price_unit') is-invalid @enderror" 
                                        id="price_unit" name="price_unit">
                                    <option value="">Select Unit</option>
                                    <option value="per month" {{ old('price_unit', $service->price_unit) == 'per month' ? 'selected' : '' }}>Per Month</option>
                                    <option value="per project" {{ old('price_unit', $service->price_unit) == 'per project' ? 'selected' : '' }}>Per Project</option>
                                    <option value="per hour" {{ old('price_unit', $service->price_unit) == 'per hour' ? 'selected' : '' }}>Per Hour</option>
                                    <option value="one-time" {{ old('price_unit', $service->price_unit) == 'one-time' ? 'selected' : '' }}>One Time</option>
                                    <option value="custom" {{ old('price_unit', $service->price_unit) == 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                                @error('price_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Features</label>
                        <div id="features-container">
                            @if($service->features && count($service->features) > 0)
                                @foreach($service->features as $index => $feature)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" 
                                           value="{{ $feature }}" placeholder="Enter a feature">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" placeholder="Enter a feature">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFeature()">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Service
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Service
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Services
                        </a>
                        <div>
                            <a href="{{ route('admin.services.show', $service) }}" class="btn btn-outline-info me-2">
                                <i class="fas fa-eye me-2"></i>
                                View Service
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Service
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Service Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    <small class="text-muted">{{ $service->created_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    <small class="text-muted">{{ $service->updated_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Featured:</strong><br>
                    <span class="badge {{ $service->is_featured ? 'bg-warning' : 'bg-light text-dark' }}">
                        {{ $service->is_featured ? 'Yes' : 'No' }}
                    </span>
                </div>
                
                @if($service->tcRequests()->count() > 0)
                <div class="mb-3">
                    <strong>Service Requests:</strong><br>
                    <span class="badge bg-info">{{ $service->tcRequests()->count() }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $service->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="fas fa-power-off me-2"></i>
                            {{ $service->is_active ? 'Deactivate' : 'Activate' }} Service
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.services.toggle-featured', $service) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $service->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $service->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="Enter a feature">
        <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeFeature(button) {
    button.parentElement.remove();
}

// Image preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview functionality here
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
