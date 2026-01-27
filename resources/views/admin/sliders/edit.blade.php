@extends('admin.layouts.app')

@section('title', 'Edit Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Slider</h3>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Sliders
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $slider->title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                           value="{{ old('sort_order', $slider->sort_order) }}" min="0">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $slider->description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" class="form-control" id="button_text" name="button_text" value="{{ old('button_text', $slider->button_text) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_url" class="form-label">Button URL</label>
                                    <input type="url" class="form-control" id="button_url" name="button_url" value="{{ old('button_url', $slider->button_url) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Slider Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    @if($slider->image)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" 
                                             class="img-thumbnail" style="max-height: 200px;">
                                        <p class="text-muted small">Current image</p>
                                    </div>
                                    @endif
                                    <div class="form-text">Recommended size: 1920x1080px. Max size: 2MB</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Slider
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
