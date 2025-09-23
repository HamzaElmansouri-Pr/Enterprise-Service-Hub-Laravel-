@extends('admin.layouts.app')

@section('title', 'Create Project')
@section('page-title', 'Create New Project')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Project Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                               id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client" class="form-label">Client</label>
                                <input type="text" class="form-control @error('client') is-invalid @enderror" 
                                       id="client" name="client" value="{{ old('client') }}">
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
                                    <option value="Web Development" {{ old('category') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile App" {{ old('category') == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="E-commerce" {{ old('category') == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="UI/UX Design" {{ old('category') == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="Digital Marketing" {{ old('category') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
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
                                       id="project_date" name="project_date" value="{{ old('project_date') }}">
                                @error('project_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_url" class="form-label">Project URL</label>
                                <input type="url" class="form-control @error('project_url') is-invalid @enderror" 
                                       id="project_url" name="project_url" value="{{ old('project_url') }}" 
                                       placeholder="https://example.com">
                                @error('project_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Main Project Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">Recommended size: 800x600px. Max size: 2MB</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gallery" class="form-label">Gallery Images</label>
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
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="technologies[]" placeholder="Enter a technology">
                                <button type="button" class="btn btn-outline-danger" onclick="removeTechnology(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
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
                                          id="challenge" name="challenge" rows="3">{{ old('challenge') }}</textarea>
                                @error('challenge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="solution" class="form-label">Solution</label>
                                <textarea class="form-control @error('solution') is-invalid @enderror" 
                                          id="solution" name="solution" rows="3">{{ old('solution') }}</textarea>
                                @error('solution')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="result" class="form-label">Result</label>
                                <textarea class="form-control @error('result') is-invalid @enderror" 
                                          id="result" name="result" rows="3">{{ old('result') }}</textarea>
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
                                       value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Project
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Create Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Help & Tips</h6>
            </div>
            <div class="card-body">
                <h6>Project Creation Tips:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i> Use clear, descriptive titles</li>
                    <li><i class="fas fa-check text-success me-2"></i> Add compelling descriptions</li>
                    <li><i class="fas fa-check text-success me-2"></i> Include relevant technologies</li>
                    <li><i class="fas fa-check text-success me-2"></i> Use high-quality images</li>
                    <li><i class="fas fa-check text-success me-2"></i> Add project challenges and solutions</li>
                </ul>
                
                <hr>
                
                <h6>Image Guidelines:</h6>
                <ul class="list-unstyled small">
                    <li><strong>Main Image:</strong> 800x600px recommended</li>
                    <li><strong>Gallery:</strong> Multiple images showing different angles</li>
                    <li><strong>Format:</strong> JPG, PNG, GIF, SVG supported</li>
                    <li><strong>Size:</strong> Max 2MB per image</li>
                </ul>
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
