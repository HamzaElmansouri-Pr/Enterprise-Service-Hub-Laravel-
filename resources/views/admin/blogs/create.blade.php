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
                            <x-admin.translatable-input name="title" label="Title" required="true" :value="['en' => request('title')]" />

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                                @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <x-admin.translatable-textarea name="excerpt" label="Excerpt (Small Summary)" rows="3" />

                            <div class="mb-3">
                                <x-admin.ai-generator target="[name='content']" context_target="[name='title[en]']" type="blog_body" label="Generate Blog Post" />
                            </div>
                            <x-admin.translatable-textarea name="content" label="Content" required="true" rows="10" :richtext="true" :value="['en' => request('content')]" />
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
                                <label class="form-label">Featured Image URL</label>
                                <div class="input-group mb-2">
                                    <input type="url" name="featured_image_url" id="featured_image_url" class="form-control" value="{{ old('featured_image_url') }}" placeholder="https://...">
                                    <button class="btn btn-outline-primary" type="button" onclick="openMediaPicker('featured_image_url', 'featured_image_preview')">
                                        <i class="fas fa-photo-video"></i> Browse
                                    </button>
                                </div>
                                @error('featured_image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                
                                <label class="form-label small text-muted">Or upload new file (Legacy)</label>
                                <input type="file" name="featured_image" class="form-control form-control-sm" accept="image/*">
                                @error('featured_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                
                                <img src="" id="featured_image_preview" class="img-fluid mt-2 rounded d-none" style="max-height: 200px; object-fit: cover;">
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

@include('admin.media.partials.picker')

@push('scripts')
@endpush
@endsection
