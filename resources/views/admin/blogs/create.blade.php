@extends('admin.layouts.app')

@section('title', 'Create Blog Post')
@section('page-title', 'Create New Blog Post')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Blog Post Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug') }}" 
                               placeholder="auto-generated-from-title">
                        <div class="form-text">Leave empty to auto-generate from title</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Brief description of the blog post...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="featured_image" class="form-label">Featured Image</label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*">
                                <div class="form-text">Recommended size: 1200x630px. Max size: 2MB</div>
                                @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                       id="author" name="author" value="{{ old('author', 'SupremeIT Team') }}">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="Web Development" {{ old('category') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile Development" {{ old('category') == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                                    <option value="Digital Marketing" {{ old('category') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                    <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Tutorials" {{ old('category') == 'Tutorials' ? 'selected' : '' }}>Tutorials</option>
                                    <option value="News" {{ old('category') == 'News' ? 'selected' : '' }}>News</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="published_at" class="form-label">Publish Date</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                       id="published_at" name="published_at" value="{{ old('published_at') }}">
                                <div class="form-text">Leave empty to publish immediately</div>
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div id="tags-container">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="tags[]" placeholder="Enter a tag">
                                <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTag()">
                            <i class="fas fa-plus"></i> Add Tag
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Post
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                       value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publish Immediately
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Blog Posts
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Create Blog Post
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
                <h6>Blog Writing Tips:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i> Write engaging, informative content</li>
                    <li><i class="fas fa-check text-success me-2"></i> Use clear headings and subheadings</li>
                    <li><i class="fas fa-check text-success me-2"></i> Add relevant tags for SEO</li>
                    <li><i class="fas fa-check text-success me-2"></i> Include a compelling excerpt</li>
                    <li><i class="fas fa-check text-success me-2"></i> Use high-quality featured images</li>
                </ul>
                
                <hr>
                
                <h6>SEO Guidelines:</h6>
                <ul class="list-unstyled small">
                    <li><strong>Title:</strong> 50-60 characters</li>
                    <li><strong>Excerpt:</strong> 150-160 characters</li>
                    <li><strong>Tags:</strong> 3-5 relevant tags</li>
                    <li><strong>Content:</strong> At least 300 words</li>
                </ul>
                
                <hr>
                
                <h6>Image Guidelines:</h6>
                <ul class="list-unstyled small">
                    <li><strong>Size:</strong> 1200x630px recommended</li>
                    <li><strong>Format:</strong> JPG, PNG, GIF, SVG</li>
                    <li><strong>File Size:</strong> Max 2MB</li>
                    <li><strong>Quality:</strong> High resolution</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addTag() {
    const container = document.getElementById('tags-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="tags[]" placeholder="Enter a tag">
        <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeTag(button) {
    button.parentElement.remove();
}

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    if (!document.getElementById('slug').value) {
        document.getElementById('slug').value = slug;
    }
});

// Image preview
document.getElementById('featured_image').addEventListener('change', function(e) {
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
