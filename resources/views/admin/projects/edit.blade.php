@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('page-title', 'Edit Project: ' . $project->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Project Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $project->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}" min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                               id="subtitle" name="subtitle" value="{{ old('subtitle', $project->subtitle) }}">
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client" class="form-label">Client</label>
                                <input type="text" class="form-control @error('client') is-invalid @enderror" 
                                       id="client" name="client" value="{{ old('client', $project->client) }}">
                                @error('client')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Web Development" {{ old('category', $project->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile App" {{ old('category', $project->category) == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="E-commerce" {{ old('category', $project->category) == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="UI/UX Design" {{ old('category', $project->category) == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="Digital Marketing" {{ old('category', $project->category) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                    <option value="Other" {{ old('category', $project->category) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_date" class="form-label">Project Date</label>
                                <input type="date" class="form-control @error('project_date') is-invalid @enderror" 
                                       id="project_date" name="project_date" value="{{ old('project_date', $project->project_date?->format('Y-m-d')) }}">
                                @error('project_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_url" class="form-label">Project URL</label>
                                <input type="url" class="form-control @error('project_url') is-invalid @enderror" 
                                       id="project_url" name="project_url" value="{{ old('project_url', $project->project_url) }}" 
                                       placeholder="https://example.com">
                                @error('project_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Current Image Display -->
                    @if($project->image)
                    <div class="mb-3">
                        <label class="form-label">Current Main Image</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" 
                                 class="rounded me-3" style="width: 100px; height: 75px; object-fit: cover;">
                            <div>
                                <p class="mb-1"><strong>Current Image</strong></p>
                                <small class="text-muted">Upload a new image to replace this one</small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">
                            {{ $project->image ? 'Replace Main Image' : 'Main Project Image' }}
                        </label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">Recommended size: 800x600px. Max size: 2MB</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Gallery Display -->
                    @if($project->gallery && count($project->gallery) > 0)
                    <div class="mb-3">
                        <label class="form-label">Current Gallery Images</label>
                        <div class="row g-2">
                            @foreach($project->gallery as $index => $galleryImage)
                            <div class="col-md-2">
                                <img src="{{ asset($galleryImage) }}" alt="Gallery Image {{ $index + 1 }}" 
                                     class="img-fluid rounded" style="height: 80px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Upload new images to replace the gallery</small>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="gallery" class="form-label">
                            {{ $project->gallery ? 'Replace Gallery Images' : 'Gallery Images' }}
                        </label>
                        <input type="file" class="form-control @error('gallery') is-invalid @enderror" 
                               id="gallery" name="gallery[]" accept="image/*" multiple>
                        <div class="form-text">Select multiple images for project gallery. Max size: 2MB each</div>
                        @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Technologies Used</label>
                        <div id="technologies-container">
                            @if($project->technologies && count($project->technologies) > 0)
                                @foreach($project->technologies as $index => $technology)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="technologies[]" 
                                           value="{{ $technology }}" placeholder="Enter a technology">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeTechnology(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="technologies[]" placeholder="Enter a technology">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeTechnology(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTechnology()">
                            <i class="fas fa-plus"></i> Add Technology
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="challenge" class="form-label">Challenge</label>
                                <textarea class="form-control @error('challenge') is-invalid @enderror" 
                                          id="challenge" name="challenge" rows="3">{{ old('challenge', $project->challenge) }}</textarea>
                                @error('challenge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="solution" class="form-label">Solution</label>
                                <textarea class="form-control @error('solution') is-invalid @enderror" 
                                          id="solution" name="solution" rows="3">{{ old('solution', $project->solution) }}</textarea>
                                @error('solution')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="result" class="form-label">Result</label>
                                <textarea class="form-control @error('result') is-invalid @enderror" 
                                          id="result" name="result" rows="3">{{ old('result', $project->result) }}</textarea>
                                @error('result')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Project
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Project
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Projects
                        </a>
                        <div>
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-info me-2">
                                <i class="fas fa-eye me-2"></i>
                                View Project
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Project
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
                <h6 class="mb-0">Project Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    <small class="text-muted">{{ $project->created_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    <small class="text-muted">{{ $project->updated_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge {{ $project->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $project->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Featured:</strong><br>
                    <span class="badge {{ $project->is_featured ? 'bg-warning' : 'bg-light text-dark' }}">
                        {{ $project->is_featured ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.projects.toggle-status', $project) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $project->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="fas fa-power-off me-2"></i>
                            {{ $project->is_active ? 'Deactivate' : 'Activate' }} Project
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.projects.toggle-featured', $project) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $project->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $project->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
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
function addTechnology() {
    const container = document.getElementById('technologies-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="technologies[]" placeholder="Enter a technology">
        <button type="button" class="btn btn-outline-danger" onclick="removeTechnology(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeTechnology(button) {
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
