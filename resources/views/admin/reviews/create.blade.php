@extends('admin.layouts.app')

@section('title', 'Create Review')
@section('page-title', 'Create Review')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" required>
                        @error('client_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="client_company" class="form-control" value="{{ old('client_company') }}">
                            @error('client_company') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position / Role</label>
                            <input type="text" name="client_position" class="form-control" value="{{ old('client_position') }}">
                            @error('client_position') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Review Text <span class="text-danger">*</span></label>
                        <textarea name="review_text" class="form-control" rows="5" required>{{ old('review_text') }}</textarea>
                        @error('review_text') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select">
                                <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Stars</option>
                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars</option>
                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars</option>
                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars</option>
                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Star</option>
                            </select>
                            @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Image</label>
                            <input type="file" name="client_image" class="form-control" accept="image/*">
                            @error('client_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sorting Order</label>
                            <input type="number" name="order_index" class="form-control" value="{{ old('order_index', 0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label d-block">Featured</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured">
                                <label class="form-check-label" for="isFeatured">Featured on Home</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
