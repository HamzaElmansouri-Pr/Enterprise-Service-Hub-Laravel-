@extends('admin.layouts.app')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service: ' . $service->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" required>
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $service->slug) }}" placeholder="Leave empty to auto-generate">
                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subtitle (Optional)</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $service->subtitle) }}">
                        @error('subtitle') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="5" required>{{ old('description', $service->description) }}</textarea>
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Featured Image</label>
                            @if($service->image)
                                <div class="mb-2">
                                    <img src="{{ resolve_image_url($service->image) }}" class="rounded" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                <input type="text" name="icon" class="form-control" placeholder="e.g. flaticon-settings" 
                                       value="{{ old('icon', Str::startsWith($service->icon, 'storage/') ? '' : $service->icon) }}">
                            </div>
                             <div class="form-text">Current: {{ $service->icon }}</div>
                             <input type="file" name="icon" class="form-control mt-2" accept="image/*,.svg">
                             @error('icon') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sorting Order</label>
                            <input type="number" name="order_index" class="form-control" value="{{ old('order_index', $service->order_index) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ $service->is_active ? 'checked' : '' }}>
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
                            <div class="mb-3">
                                <label class="form-label">Meta Title (SEO)</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $service->meta_title) }}" placeholder="Leave empty to use service title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3" placeholder="Brief summary for search engines">{{ old('meta_description', $service->meta_description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Social Share Image (OG Image)</label>
                                @if($service->og_image)
                                    <div class="mb-2">
                                        <img src="{{ resolve_image_url($service->og_image) }}" class="rounded shadow-sm" style="max-height: 80px;">
                                    </div>
                                @endif
                                <input type="file" name="og_image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
