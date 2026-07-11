@extends('admin.layouts.app')

@section('title', 'Create Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create New Slider</h3>
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

                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Details Section -->
                        <div class="card mb-4 border-light shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0 text-primary"><i class="fas fa-info-circle me-2"></i>Basic Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <x-admin.translatable-input name="title" label="Main Title" required="true" placeholder="e.g. Innovating Your Digital Future" />
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <x-admin.translatable-input name="subtitle" label="Subtitle" placeholder="Small text above or below title" />
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <x-admin.ai-generator target="[name='description']" context_target="[name='title[en]']" type="hero_copy" label="Generate Slider Description" />
                                        </div>
                                        <x-admin.translatable-textarea name="description" label="Description / Paragraph" rows="3" placeholder="Longer descriptive text..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Actions Section -->
                        <div class="card mb-4 border-light shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0 text-success"><i class="fas fa-mouse-pointer me-2"></i>Call to Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-light mb-3">
                                            <h6 class="fw-bold mb-3">Primary Button</h6>
                                            <x-admin.translatable-input name="button_text" label="Button Text" placeholder="e.g. Get Started" />
                                            <div class="mb-0">
                                                <label for="button_url" class="form-label">Button URL</label>
                                                <input type="text" class="form-control bg-white" id="button_url" name="button_url" value="{{ old('button_url') }}" placeholder="e.g. /services">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-light mb-3">
                                            <h6 class="fw-bold mb-3">Secondary Button (Optional)</h6>
                                            <x-admin.translatable-input name="secondary_button_text" label="Secondary Button Text" placeholder="e.g. Contact Us" />
                                            <div class="mb-0">
                                                <label for="secondary_button_url" class="form-label">Secondary Button URL</label>
                                                <input type="text" class="form-control bg-white" id="secondary_button_url" name="secondary_button_url" value="{{ old('secondary_button_url') }}" placeholder="e.g. /contact">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aesthetics & Positioning -->
                        <div class="card mb-4 border-light shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0 text-info"><i class="fas fa-palette me-2"></i>Aesthetics & Positioning</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="alignment" class="form-label">Text Alignment</label>
                                            <select class="form-select" id="alignment" name="alignment">
                                                <option value="left" {{ old('alignment') == 'left' ? 'selected' : '' }}>Left (Default)</option>
                                                <option value="center" {{ old('alignment') == 'center' ? 'selected' : '' }}>Center</option>
                                                <option value="right" {{ old('alignment') == 'right' ? 'selected' : '' }}>Right</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="text_theme" class="form-label">Text Theme</label>
                                            <select class="form-select" id="text_theme" name="text_theme">
                                                <option value="light" {{ old('text_theme') == 'light' ? 'selected' : '' }}>Light (White text)</option>
                                                <option value="dark" {{ old('text_theme') == 'dark' ? 'selected' : '' }}>Dark (Slate text)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="overlay_opacity" class="form-label">Overlay Opacity</label>
                                            <select class="form-select" id="overlay_opacity" name="overlay_opacity">
                                                <option value="light" {{ old('overlay_opacity') == 'light' ? 'selected' : '' }}>Light</option>
                                                <option value="medium" {{ old('overlay_opacity') == 'medium' || !old('overlay_opacity') ? 'selected' : '' }}>Medium (Default)</option>
                                                <option value="dark" {{ old('overlay_opacity') == 'dark' ? 'selected' : '' }}>Heavy Dark</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                            <x-admin.translatable-input name="badge_text" label="Floating Badge" placeholder="e.g. New! or Partnered" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="title_color" class="form-label">Title Color</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" id="title_color" name="title_color" value="{{ old('title_color', '#ffffff') }}" title="Choose title color">
                                                <input type="text" class="form-control" value="{{ old('title_color', '#ffffff') }}" oninput="document.getElementById('title_color').value = this.value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="subtitle_color" class="form-label">Subtitle Color</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" id="subtitle_color" name="subtitle_color" value="{{ old('subtitle_color', '#e2e8f0') }}" title="Choose subtitle color">
                                                <input type="text" class="form-control" value="{{ old('subtitle_color', '#e2e8f0') }}" oninput="document.getElementById('subtitle_color').value = this.value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="description_color" class="form-label">Description Color</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" id="description_color" name="description_color" value="{{ old('description_color', '#cbd5e1') }}" title="Choose description color">
                                                <input type="text" class="form-control" value="{{ old('description_color', '#cbd5e1') }}" oninput="document.getElementById('description_color').value = this.value">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media & Status Section -->
                        <div class="card mb-4 border-light shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0 text-warning"><i class="fas fa-photo-video me-2"></i>Media & Visibility</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Slider Image Background</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <input type="text" class="form-control mt-2" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="Or paste image URL (https://...)">
                                            <div class="form-text">Recommended: 1920x1080px. Background for video fallback.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="video_url" class="form-label">Background Video URL (Direct Link)</label>
                                            <input type="url" class="form-control" id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="e.g. https://domain.com/video.mp4">
                                            <div class="form-text">Must be a direct link to .mp4 or .webm for autoplay support.</div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="form-check form-switch card p-3 bg-light">
                                            <div class="ms-4">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="is_active">
                                                    Active & Visible on Frontend
                                                </label>
                                                <p class="text-muted small mb-0">Uncheck to hide this slide from the homepage without deleting it.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-rocket me-2"></i> Launch Slide
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
