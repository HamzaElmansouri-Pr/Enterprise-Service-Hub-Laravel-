@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post: ' . $blog->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Blog Post Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" 
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
                                  placeholder="Brief description of the blog post...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="15" required>{{ old('content', $blog->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($blog->featured_image)
                    <div class="mb-3">
                        <label class="form-label">Current Featured Image</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" 
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
                                <label for="featured_image" class="form-label">
                                    {{ $blog->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                                </label>
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
                                       id="author" name="author" value="{{ old('author', $blog->author) }}">
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
                                    <option value="Technology" {{ old('category', $blog->category) == 'Technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="Web Development" {{ old('category', $blog->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile Development" {{ old('category', $blog->category) == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                                    <option value="Digital Marketing" {{ old('category', $blog->category) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                    <option value="Business" {{ old('category', $blog->category) == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Tutorials" {{ old('category', $blog->category) == 'Tutorials' ? 'selected' : '' }}>Tutorials</option>
                                    <option value="News" {{ old('category', $blog->category) == 'News' ? 'selected' : '' }}>News</option>
                                    <option value="Other" {{ old('category', $blog->category) == 'Other' ? 'selected' : '' }}>Other</option>
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
                                       id="published_at" name="published_at" 
                                       value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
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
                            @if($blog->tags && count($blog->tags) > 0)
                                @foreach($blog->tags as $index => $tag)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="tags[]" 
                                           value="{{ $tag }}" placeholder="Enter a tag">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="tags[]" placeholder="Enter a tag">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeTag(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTag()">
                            <i class="fas fa-plus"></i> Add Tag
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Post
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                       value="1" {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
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
                        <div>
                            <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-outline-info me-2">
                                <i class="fas fa-eye me-2"></i>
                                View Post
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Blog Post
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
                <h6 class="mb-0">Post Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Slug:</strong><br>
                    <code>{{ $blog->slug }}</code>
                </div>
                
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    <small class="text-muted">{{ $blog->created_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    <small class="text-muted">{{ $blog->updated_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">
                        {{ $blog->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Featured:</strong><br>
                    <span class="badge {{ $blog->is_featured ? 'bg-warning' : 'bg-light text-dark' }}">
                        {{ $blog->is_featured ? 'Yes' : 'No' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Views:</strong><br>
                    <span class="badge bg-primary">{{ $blog->views ?? 0 }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Likes:</strong><br>
                    <span class="badge bg-success">{{ $blog->likes ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.blogs.toggle-published', $blog) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $blog->is_published ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="fas fa-eye me-2"></i>
                            {{ $blog->is_published ? 'Unpublish' : 'Publish' }} Post
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.blogs.toggle-featured', $blog) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $blog->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $blog->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
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
