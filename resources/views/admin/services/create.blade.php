@extends('admin.layouts.app')

@section('title', 'Create Service')
@section('page-title', 'Create Service')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <x-admin.translatable-input name="title" label="Title" required="true" />

                    <div class="mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Leave empty to auto-generate">
                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <x-admin.translatable-input name="subtitle" label="Subtitle (Optional)" />

                    <div class="mb-3">
                        <x-admin.ai-generator target="[name='description']" context_target="[name='title[en]']" type="service_description" label="Generate Service Description" />
                    </div>
                    <x-admin.translatable-textarea name="description" label="Description" required="true" :richtext="true" />

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Featured Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            <input type="url" name="image_url" class="form-control mt-2" value="{{ old('image_url') }}" placeholder="Or paste image URL (https://...)">
                            @error('image_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon (Class Name or File)</label>
                            {{-- We can allow text or file. Complex UI, simplifying to text for now or file --}}
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                <input type="text" name="icon" class="form-control" placeholder="e.g. flaticon-settings" value="{{ old('icon') }}">
                            </div>
                             <div class="form-text">Enter a FontAwesome/Flaticon class OR upload below.</div>
                             <input type="file" name="icon" class="form-control mt-2" accept="image/*,.svg">
                             @error('icon') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
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
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
