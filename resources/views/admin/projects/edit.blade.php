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
                    
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

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
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="8" required>{{ old('description', $project->description) }}</textarea>
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Project Image</label>
                            @if($project->image)
                                <div class="mb-2">
                                    <img src="{{ asset($project->image) }}" class="rounded" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
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
