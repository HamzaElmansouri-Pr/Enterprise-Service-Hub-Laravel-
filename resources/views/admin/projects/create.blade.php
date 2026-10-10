@extends('admin.layouts.app')

@section('title', 'Create Project')
@section('page-title', 'Create Project')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <x-admin.translatable-input name="title" label="Title" required="true" />

                    <div class="mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Leave empty to auto-generate">
                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Name</label>
                            <input type="text" name="client" class="form-control" value="{{ old('client') }}">
                            @error('client') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="hidden" name="categories_submitted" value="1">
                            <label class="form-label d-flex justify-content-between align-items-center mb-1">
                                <span>Categories (Optional)</span>
                                <a href="{{ route('admin.categories.create') }}" target="_blank" class="small text-primary text-decoration-none">
                                    <i class="fas fa-plus-circle me-1"></i>New Category
                                </a>
                            </label>
                            <div class="border rounded p-2 bg-light-subtle" style="max-height: 140px; overflow-y: auto;">
                                @forelse($categories as $cat)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $cat->id }}" id="cat_{{ $cat->id }}"
                                            {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="cat_{{ $cat->id }}">
                                            {{ get_content_value($cat->name) }}
                                        </label>
                                    </div>
                                @empty
                                    <div class="text-muted small p-1">
                                        No categories yet. <a href="{{ route('admin.categories.create') }}" target="_blank">Create one</a>.
                                    </div>
                                @endforelse
                            </div>
                            <div class="form-text small">Select one or more categories, or leave unselected.</div>
                            @error('category_ids') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <x-admin.ai-generator target="[name='description']" context_target="[name='title[en]']" type="case_study" label="Generate Case Study / Description" />
                    </div>
                    <x-admin.translatable-textarea name="description" label="Description" required="true" rows="8" :richtext="true" />

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Project Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <input type="text" name="image_url" class="form-control mt-2" value="{{ old('image_url') }}" placeholder="Or paste image URL (https://...)">
                            @error('image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Completion Date</label>
                            <input type="date" name="completion_date" class="form-control" value="{{ old('completion_date') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sorting Order</label>
                            <input type="number" name="order_index" class="form-control" value="{{ old('order_index', 0) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
