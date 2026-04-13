@extends('admin.layouts.app')

@section('title', 'Create Blog Post')
@section('page-title', 'Create Blog Post')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                                @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Excerpt (Small Summary)</label>
                                <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt') }}</textarea>
                                @error('excerpt') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
                                @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="isPublished" checked>
                                            <label class="form-check-label" for="isPublished">Published</label>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label small">Publish Date</label>
                                            <input type="date" name="published_at" class="form-control form-control-sm" value="{{ old('published_at') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                @error('featured_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                <input type="url" name="featured_image_url" class="form-control mt-2" value="{{ old('featured_image_url') }}" placeholder="Or paste image URL (https://...)">
                                @error('featured_image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Technology">
                                @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Author Name (Optional Override)</label>
                                <input type="text" name="author" class="form-control" value="{{ old('author') }}" placeholder="Leave empty for current user">
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Publish Post</button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary mt-2">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
