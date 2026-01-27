@extends('admin.layouts.app')

@section('title', 'Slider Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Slider Details</h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Slider
                        </a>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Sliders
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                @if($slider->image)
                                <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" 
                                     class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                                @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                                     style="height: 300px;">
                                    <i class="fas fa-image fa-3x text-white"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Slider Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Title:</strong> {{ $slider->title }}</p>
                                    @if($slider->subtitle)
                                    <p><strong>Subtitle:</strong> {{ $slider->subtitle }}</p>
                                    @endif
                                    @if($slider->description)
                                    <p><strong>Description:</strong> {{ $slider->description }}</p>
                                    @endif
                                    @if($slider->button_text)
                                    <p><strong>Button Text:</strong> {{ $slider->button_text }}</p>
                                    @endif
                                    @if($slider->button_url)
                                    <p><strong>Button URL:</strong> 
                                        <a href="{{ $slider->button_url }}" target="_blank">{{ $slider->button_url }}</a>
                                    </p>
                                    @endif
                                    <p><strong>Status:</strong> 
                                        <span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-warning' }}">
                                            {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                    <p><strong>Sort Order:</strong> {{ $slider->sort_order }}</p>
                                    <p><strong>Created:</strong> {{ $slider->created_at->format('M d, Y H:i') }}</p>
                                    <p><strong>Updated:</strong> {{ $slider->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
