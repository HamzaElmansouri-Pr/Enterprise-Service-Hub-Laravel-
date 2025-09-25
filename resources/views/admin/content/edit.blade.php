@extends('admin.layouts.app')

@section('title', 'Edit Content')
@section('page-title', 'Edit Content')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Edit Content: {{ ucfirst(str_replace('-', ' ', $contentType)) }}</h4>
    <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Content
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Content Editor
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.content.update', $contentType) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    @if($contentType === 'home-hero')
                        <div class="mb-4">
                            <label for="hero_title" class="form-label">Hero Title</label>
                            <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                   value="{{ $content['hero_title'] ?? 'The complete CRM solution built for your success' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                            <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="3">{{ $content['hero_subtitle'] ?? 'All your customer data, tools, and insights in one unified platform.' }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="hero_button_text" class="form-label">Button Text</label>
                            <input type="text" class="form-control" id="hero_button_text" name="hero_button_text" 
                                   value="{{ $content['hero_button_text'] ?? 'try for free' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="hero_image" class="form-label">Hero Image URL</label>
                            <input type="url" class="form-control" id="hero_image" name="hero_image" 
                                   value="{{ $content['hero_image'] ?? '' }}">
                        </div>
                        
                    @elseif($contentType === 'home-features')
                        <div class="mb-4">
                            <label for="features_title" class="form-label">Features Section Title</label>
                            <input type="text" class="form-control" id="features_title" name="features_title" 
                                   value="{{ $content['features_title'] ?? 'SupremeIT key benefits' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="features_subtitle" class="form-label">Features Subtitle</label>
                            <textarea class="form-control" id="features_subtitle" name="features_subtitle" rows="2">{{ $content['features_subtitle'] ?? 'Flexible experiences that scale with your growth and deliver faster time to value' }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Features List</label>
                            <div id="features-list">
                                @foreach($content['features'] ?? [
                                    ['title' => 'All-in-One CRM', 'description' => 'Automate your sales, marketing, and service in one platform.'],
                                    ['title' => 'Affordable', 'description' => 'Make the most of SupremeIT\'s modern features & integrations.'],
                                    ['title' => 'Next-Generation', 'description' => 'Automate your sales, marketing, and service in one platform.']
                                ] as $index => $feature)
                                <div class="feature-item border p-3 mb-3 rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Feature Title</label>
                                            <input type="text" class="form-control" name="features[{{ $index }}][title]" 
                                                   value="{{ $feature['title'] }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Actions</label>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-danger remove-feature">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Feature Description</label>
                                        <textarea class="form-control" name="features[{{ $index }}][description]" rows="2">{{ $feature['description'] }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-feature">
                                <i class="fas fa-plus me-2"></i>
                                Add Feature
                            </button>
                        </div>
                        
                    @elseif($contentType === 'about-main' || $contentType === 'home-about')
                        <div class="mb-4">
                            <label for="about_title" class="form-label">About Title</label>
                            <input type="text" class="form-control" id="about_title" name="about_title" 
                                   value="{{ $content['about_title'] ?? 'Deliver unforgettable customer experiences' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="about_subtitle" class="form-label">About Subtitle</label>
                            <input type="text" class="form-control" id="about_subtitle" name="about_subtitle" 
                                   value="{{ $content['about_subtitle'] ?? 'Why SupremeIT crm' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="about_description" class="form-label">About Description</label>
                            <textarea class="form-control" id="about_description" name="about_description" rows="4">{{ $content['about_description'] ?? 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.' }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">About Image</label>
                            <input type="file" class="form-control" name="about_image_file" accept="image/*">
                            @if(!empty($content['about_image']))
                            <div class="mt-2">
                                <img src="{{ $content['about_image'] }}" alt="About image" style="max-height:100px;">
                            </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="about_content" class="form-label">About HTML Content (optional)</label>
                            <textarea class="form-control" id="about_content" name="about_content" rows="6">{{ $content['about_content'] ?? '' }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Feature Highlights</label>
                            <div id="features-list">
                                @foreach(($content['features'] ?? []) as $index => $feature)
                                <div class="feature-item border p-3 mb-3 rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Feature Title</label>
                                            <input type="text" class="form-control" name="features[{{ $index }}][title]" value="{{ $feature['title'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Actions</label>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-danger remove-feature">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Feature Description</label>
                                        <textarea class="form-control" name="features[{{ $index }}][description]" rows="2">{{ $feature['description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-feature">
                                <i class="fas fa-plus me-2"></i>
                                Add Feature
                            </button>
                        </div>
                        
                    @elseif($contentType === 'contact-info')
                        <div class="mb-4">
                            <label for="contact_title" class="form-label">Contact Page Title</label>
                            <input type="text" class="form-control" id="contact_title" name="contact_title" 
                                   value="{{ $content['contact_title'] ?? 'Ready to get started?' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="contact_description" class="form-label">Contact Description</label>
                            <textarea class="form-control" id="contact_description" name="contact_description" rows="3">{{ $content['contact_description'] ?? 'Contact us today to learn more about how SupremeIT can help your business grow.' }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="contact_phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="contact_phone" name="contact_phone" 
                                           value="{{ $content['contact_phone'] ?? '+1 (555) 123-4567' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="contact_email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                           value="{{ $content['contact_email'] ?? 'info@supremeit.com' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="contact_address" class="form-label">Address</label>
                            <textarea class="form-control" id="contact_address" name="contact_address" rows="2">{{ $content['contact_address'] ?? '123 Business Street\nCity, State 12345' }}</textarea>
                        </div>
                        
                    @elseif($contentType === 'site-info')
                        <div class="mb-4">
                            <label for="site_name" class="form-label">Site Name</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" 
                                   value="{{ $content['site_name'] ?? 'SupremeIT' }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="site_description" class="form-label">Site Description</label>
                            <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ $content['site_description'] ?? 'SupremeIT provides cutting-edge technology solutions to help businesses grow and succeed in the digital world.' }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="site_keywords" class="form-label">SEO Keywords</label>
                            <input type="text" class="form-control" id="site_keywords" name="site_keywords" 
                                   value="{{ $content['site_keywords'] ?? 'CRM, business solutions, technology' }}">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="site_logo" class="form-label">Logo URL</label>
                                    <input type="url" class="form-control" id="site_logo" name="site_logo" 
                                           value="{{ $content['site_logo'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="site_favicon" class="form-label">Favicon URL</label>
                                    <input type="url" class="form-control" id="site_favicon" name="site_favicon" 
                                           value="{{ $content['site_favicon'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Content Preview
                </h6>
            </div>
            <div class="card-body">
                <div class="preview-content">
                    @if($contentType === 'home-hero')
                        <h5>{{ $content['hero_title'] ?? 'The complete CRM solution built for your success' }}</h5>
                        <p class="text-muted">{{ $content['hero_subtitle'] ?? 'All your customer data, tools, and insights in one unified platform.' }}</p>
                        <button class="btn btn-primary">{{ $content['hero_button_text'] ?? 'try for free' }}</button>
                    @elseif($contentType === 'home-features')
                        <h5>{{ $content['features_title'] ?? 'SupremeIT key benefits' }}</h5>
                        <p class="text-muted">{{ $content['features_subtitle'] ?? 'Flexible experiences that scale with your growth' }}</p>
                    @elseif($contentType === 'about-main' || $contentType === 'home-about')
                        <h5>{{ $content['about_title'] ?? 'Deliver unforgettable customer experiences' }}</h5>
                        <p class="text-muted">{{ $content['about_description'] ?? 'About description...' }}</p>
                        @if(!empty($content['features']))
                        <ul>
                            @foreach($content['features'] as $feat)
                            <li><strong>{{ $feat['title'] ?? '' }}</strong> - {{ $feat['description'] ?? '' }}</li>
                            @endforeach
                        </ul>
                        @endif
                    @elseif($contentType === 'contact-info')
                        <h5>{{ $content['contact_title'] ?? 'Ready to get started?' }}</h5>
                        <p class="text-muted">{{ $content['contact_description'] ?? 'Contact description...' }}</p>
                        <p><strong>Phone:</strong> {{ $content['contact_phone'] ?? '+1 (555) 123-4567' }}</p>
                        <p><strong>Email:</strong> {{ $content['contact_email'] ?? 'info@supremeit.com' }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Keep titles concise and engaging
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use clear, professional language
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Test changes on the live site
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Save frequently to avoid losing work
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add feature functionality
    const addFeatureBtn = document.getElementById('add-feature');
    const featuresList = document.getElementById('features-list');
    let featureIndex = {{ count($content['features'] ?? []) }};
    
    addFeatureBtn.addEventListener('click', function() {
        const featureHtml = `
            <div class="feature-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Feature Title</label>
                        <input type="text" class="form-control" name="features[${featureIndex}][title]" value="">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Actions</label>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger remove-feature">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <label class="form-label">Feature Description</label>
                    <textarea class="form-control" name="features[${featureIndex}][description]" rows="2"></textarea>
                </div>
            </div>
        `;
        
        featuresList.insertAdjacentHTML('beforeend', featureHtml);
        featureIndex++;
    });
    
    // Remove feature functionality
    featuresList.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
    });
    
    // Live preview updates
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            updatePreview();
        });
    });
    
    function updatePreview() {
        // This would update the preview in real-time
        // Implementation depends on the specific content type
    }
});
</script>
@endpush
