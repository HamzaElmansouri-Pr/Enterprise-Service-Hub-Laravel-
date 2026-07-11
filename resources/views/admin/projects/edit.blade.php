@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('page-title', 'Edit Project: ' . $project->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <x-admin.translatable-input name="title" label="Title" required="true" :value="$project" />

                    <div class="mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $project->slug) }}" placeholder="Leave empty to auto-generate">
                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Name</label>
                            <input type="text" name="client" class="form-control" value="{{ old('client', $project->client) }}">
                            @error('client') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" value="{{ old('category', $project->category) }}">
                            @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <x-admin.ai-generator target="[name='description']" context_target="[name='title[en]']" type="case_study" label="Generate Case Study / Description" />
                    </div>
                    <x-admin.translatable-textarea name="description" label="Description" required="true" rows="8" :richtext="true" :value="$project" />

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Project Image</label>
                            @if($project->image)
                                <div class="mb-2">
                                    <img src="{{ resolve_image_url($project->image) }}" class="rounded" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <input type="text" name="image_url" class="form-control mt-2"
                                   value="{{ old('image_url', (str_starts_with($project->image ?? '', 'http://') || str_starts_with($project->image ?? '', 'https://')) ? $project->image : '') }}"
                                   placeholder="Or paste image URL (https://...)">
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            @error('image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Completion Date</label>
                            <input type="date" name="completion_date" class="form-control" 
                                   value="{{ old('completion_date', $project->completion_date ? $project->completion_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sorting Order</label>
                            <input type="number" name="order_index" class="form-control" value="{{ old('order_index', $project->order_index) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ $project->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Metadata -->
                    <div class="card bg-light border-0 shadow-none mt-4">
                        <div class="card-header bg-transparent border-0 ps-0">
                            <h5 class="mb-0">SEO & Social Metadata</h5>
                        </div>
                        <div class="card-body ps-0 pe-0">
                            <h6 class="fw-bold mb-3">SEO & Social Meta</h6>
                            <x-admin.seo-analyzer title_target="[name='title[en]']" content_target="[name='description[en]']" />
                            <x-admin.translatable-input name="meta_title" label="Meta Title (SEO)" placeholder="Leave empty to use project title" :value="$project" />
                            
                            <x-admin.translatable-textarea name="meta_description" label="Meta Description" placeholder="Brief summary for search engines" rows="3" :value="$project" />
                            <div class="mb-3">
                                <label class="form-label">Social Share Image (OG Image)</label>
                                @if($project->og_image)
                                    <div class="mb-2">
                                        <img src="{{ resolve_image_url($project->og_image) }}" class="rounded shadow-sm" style="max-height: 80px;">
                                    </div>
                                @endif
                                <input type="file" name="og_image" class="form-control" accept="image/*">
                                <input type="text" name="og_image_url" class="form-control mt-2"
                                       value="{{ old('og_image_url', (str_starts_with($project->og_image ?? '', 'http://') || str_starts_with($project->og_image ?? '', 'https://')) ? $project->og_image : '') }}"
                                       placeholder="Or paste OG image URL (https://...)">
                                <div class="form-text">Recommended size: 1200x630px. If empty, the project image will be used.</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
