@extends('admin.layouts.app')

@section('title', 'Edit Partner')
@section('page-title', 'Edit Partner: ' . $partner->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to List
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label">Partner Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $partner->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Current Logo</label>
                        <div class="mb-2 p-3 border rounded text-center bg-light">
                            <img src="{{ $partner->getLogoUrl() }}" alt="{{ $partner->name }}" 
                                 style="max-height: 80px; max-width: 100%; object-fit: contain;">
                        </div>
                        <label for="logo" class="form-label">Change Logo (Optional)</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" name="logo">
                        <div class="form-text">Keep empty to retain the current logo.</div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="url" class="form-label">Website URL (Optional)</label>
                        <input type="url" class="form-control @error('url') is-invalid @enderror" 
                               id="url" name="url" value="{{ old('url', $partner->url) }}" placeholder="https://example.com">
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="order_index" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('order_index') is-invalid @enderror" 
                                   id="order_index" name="order_index" value="{{ old('order_index', $partner->order_index) }}" min="0">
                            @error('order_index')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Visible on Website</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 text-uppercase fw-bold">
                            Update Partner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
