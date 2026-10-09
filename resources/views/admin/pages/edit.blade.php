@extends('admin.layouts.app')

@section('title', 'Edit Page SEO')
@section('page-title', 'Edit SEO: ' . $page->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label text-muted">Page Slug (URL Identifier)</label>
                        <input type="text" class="form-control" value="{{ $page->slug }}" disabled>
                        <small class="form-text">The slug is fixed for core pages.</small>
                    </div>

                    <h5 class="mb-3 border-bottom pb-2">Page Basic Information</h5>
                    <div class="mb-4">
                        <label class="form-label">Page Title</label>
                        <input type="text" name="title[en]" class="form-control" value="{{ $page->getTranslation('title', 'en') }}" required>
                        <small class="form-text">Used internally or as fallback.</small>
                    </div>

                    <h5 class="mb-3 border-bottom pb-2 text-primary">SEO Settings (Meta Tags)</h5>
                    
                    <!-- Meta Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Meta Title (Browser Tab / Search Engine Title)</label>
                        <div class="row g-2">
                            <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">EN</span>
                                    <input type="text" name="meta_title[en]" class="form-control" value="{{ $page->getTranslation('meta_title', 'en', false) }}" placeholder="e.g. Home | Enterprise Service Hub">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">FR</span>
                                    <input type="text" name="meta_title[fr]" class="form-control" value="{{ $page->getTranslation('meta_title', 'fr', false) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">AR</span>
                                    <input type="text" name="meta_title[ar]" class="form-control" value="{{ $page->getTranslation('meta_title', 'ar', false) }}" dir="rtl">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Meta Description (Search Engine Snippet)</label>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small text-muted mb-1">English</label>
                                <textarea name="meta_description[en]" class="form-control" rows="3" placeholder="Brief summary of the page for search results...">{{ $page->getTranslation('meta_description', 'en', false) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">French</label>
                                <textarea name="meta_description[fr]" class="form-control" rows="3">{{ $page->getTranslation('meta_description', 'fr', false) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted mb-1">Arabic</label>
                                <textarea name="meta_description[ar]" class="form-control" rows="3" dir="rtl">{{ $page->getTranslation('meta_description', 'ar', false) }}</textarea>
                            </div>
                        </div>
                        <small class="form-text text-muted">Keep meta descriptions under 160 characters for best SEO results.</small>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update SEO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
