@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <x-admin.translatable-input name="title" label="Title" required="true" :value="$blog" />

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $blog->slug) }}">
                                @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <x-admin.translatable-textarea name="excerpt" label="Excerpt (Small Summary)" rows="3" :value="$blog" />

                            <div class="mb-3">
                                <x-admin.ai-generator target="[name='content']" context_target="[name='title[en]']" type="blog_body" label="Generate Blog Post" />
                            </div>
                            <x-admin.translatable-textarea name="content" label="Content" required="true" rows="10" :richtext="true" :value="$blog" />
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="isPublished" {{ $blog->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isPublished">Published</label>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label small">Publish Date</label>
                                            <input type="date" name="published_at" class="form-control form-control-sm" 
                                                   value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Metadata -->
                            <div class="mb-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="mb-3">SEO & Social Metadata</h6>
                                        <x-admin.seo-analyzer title_target="[name='title[en]']" content_target="[name='content[en]']" />
                                        <div class="mb-3">
                                            <x-admin.translatable-input name="meta_title" label="Meta Title (SEO)" placeholder="Leave empty to use blog title" :value="$blog" />
                                        </div>
                                        <div class="mb-3">
                                            <x-admin.translatable-textarea name="meta_description" label="Meta Description" placeholder="Brief summary for search engines" rows="3" :value="$blog" />
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label small">Social Image (OG)</label>
                                            @if($blog->og_image)
                                                <img src="{{ resolve_image_url($blog->og_image) }}" class="rounded d-block mb-2" style="max-height: 50px;">
                                            @endif
                                            <input type="file" name="og_image" class="form-control form-control-sm" accept="image/*">
                                            <input type="url" name="og_image_url" class="form-control form-control-sm mt-2"
                                                   value="{{ old('og_image_url', (str_starts_with($blog->og_image ?? '', 'http://') || str_starts_with($blog->og_image ?? '', 'https://')) ? $blog->og_image : '') }}"
                                                   placeholder="Or paste OG image URL (https://...)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Featured Image</label>
                                @if($blog->image)
                                    <div class="mb-2">
                                        <img src="{{ resolve_image_url($blog->image) }}" class="rounded img-fluid">
                                    </div>
                                @endif
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                <input type="url" name="featured_image_url" class="form-control mt-2"
                                       value="{{ old('featured_image_url', (str_starts_with($blog->image ?? '', 'http://') || str_starts_with($blog->image ?? '', 'https://')) ? $blog->image : '') }}"
                                       placeholder="Or paste featured image URL (https://...)">
                                @error('featured_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                @error('featured_image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" value="{{ old('category', $blog->category) }}">
                                @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" class="form-control" value="{{ $blog->author ? $blog->author->name : 'Unknown' }}" disabled>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Update Post</button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary mt-2">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
@endpush
@endsection
