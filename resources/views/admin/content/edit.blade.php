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
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Upload/Update Failed</h6>
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                <form action="{{ route('admin.content.update', $contentType) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- Global Section Toggle --}}
                    @php($section = \App\Models\Section::where('type', $contentType)->first())
                    <div class="mb-4 p-3 bg-light rounded border">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active_toggle" value="1">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ ($section && $section->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Enable this section on the website</label>
                        </div>
                        <small class="text-muted">Turn off to hide this entire section from the frontend.</small>
                    </div>
                    @if($contentType === 'home-hero')
                        <x-admin.translatable-input name="hero_title" label="Hero Title" :value="$content['hero_title'] ?? null" placeholder="The complete CRM solution built for your success" />
                        
                        <div class="mb-3 mt-3">
                            <x-admin.ai-generator target="[name='hero_subtitle']" context_target="[name='hero_title[en]']" type="hero_copy" label="Generate Subtitle" />
                        </div>
                        <x-admin.translatable-textarea name="hero_subtitle" label="Hero Subtitle" rows="3" :value="$content['hero_subtitle'] ?? null" placeholder="All your customer data, tools, and insights in one unified platform." />
                        
                        <x-admin.translatable-input name="hero_button_text" label="Button Text" :value="$content['hero_button_text'] ?? null" placeholder="try for free" />
                        
                        <div class="mb-4">
                            <label for="hero_image_file" class="form-label">Hero Image</label>
                            <input type="file" class="form-control" id="hero_image_file" name="hero_image_file" accept="image/*">
                            @if(!empty($content['hero_image']))
                            <div class="mt-2 text-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ resolve_image_url($content['hero_image']) }}" alt="Hero image" style="max-height:100px;" class="img-thumbnail">
                                    <button type="submit" form="delete-hero-image" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <small class="text-muted d-block">Current image</small>
                            </div>
                            @endif
                        </div>
                        
                    @elseif($contentType === 'home-features')
                        <x-admin.translatable-input name="features_title" label="Features Section Title" :value="$content['features_title'] ?? null" placeholder="Nova Agency key benefits" />
                        
                        <x-admin.translatable-textarea name="features_subtitle" label="Features Subtitle" rows="2" :value="$content['features_subtitle'] ?? null" placeholder="Flexible experiences that scale with your growth and deliver faster time to value" />
                        
                        <div class="mb-4">
                            <label class="form-label">Features List</label>
                            <div id="features-list">
                                @foreach($content['features'] ?? [
                                    ['title' => 'All-in-One CRM', 'description' => 'Automate your sales, marketing, and service in one platform.'],
                                    ['title' => 'Affordable', 'description' => 'Make the most of Nova Agency\'s modern features & integrations.'],
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
                        <x-admin.translatable-input name="about_title" label="About Title" :value="$content['about_title'] ?? null" placeholder="Deliver unforgettable customer experiences" />
                        
                        <x-admin.translatable-input name="about_subtitle" label="About Subtitle" :value="$content['about_subtitle'] ?? null" placeholder="Why Nova Agency crm" />
                        
                        <div class="mb-3 mt-3">
                            <x-admin.ai-generator target="#about_description" context_target="[name='about_title[en]']" type="section_writer" label="Generate Short Description" />
                        </div>
                        <div class="mb-4">
                            <label for="about_description" class="form-label">About Description</label>
                            <textarea class="form-control" id="about_description" name="about_description" rows="4">{{ $content['about_description'] ?? 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.' }}</textarea>
                        </div>
                        
                        <div class="mb-4 p-3 bg-light rounded border border-primary border-opacity-25">
                            <h6 class="fw-bold mb-3"><i class="fas fa-heading me-1 text-primary"></i> Page Header Banner</h6>
                            <label class="form-label">Banner Image (Top of Page)</label>
                            <input type="file" class="form-control" name="header_image_file" accept="image/*">
                            @if(!empty($content['header_image']))
                            <div class="mt-2 text-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ resolve_image_url($content['header_image']) }}" alt="Header banner" style="max-height:100px;" class="img-thumbnail">
                                    <button type="submit" form="delete-header-image" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this header image?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <small class="text-muted d-block">Current header image</small>
                            </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label">About Section Image</label>
                            <input type="file" class="form-control" name="about_image_file" accept="image/*">
                            @if(!empty($content['about_image']))
                            <div class="mt-2 text-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ resolve_image_url($content['about_image']) }}" alt="About image" style="max-height:100px;" class="img-thumbnail">
                                    <button type="submit" form="delete-about-image" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this about image?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <small class="text-muted d-block">Current section image</small>
                            </div>
                            @endif
                        </div>
                        <div class="mb-3 mt-3">
                            <x-admin.ai-generator target="[name='about_content']" context_target="[name='about_title[en]']" type="section_writer" label="Generate Detailed Content" />
                        </div>
                        <x-admin.translatable-textarea name="about_content" label="About HTML Content (optional)" rows="6" :richtext="true" :value="$content['about_content'] ?? null" />

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
                        <x-admin.translatable-input name="contact_title" label="Contact Page Title" :value="$content['contact_title'] ?? null" placeholder="Ready to get started?" />
                        
                        <div class="mb-3 mt-3">
                            <x-admin.ai-generator target="[name='contact_description']" context_target="[name='contact_title[en]']" type="section_writer" label="Generate Contact Info" />
                        </div>
                        <x-admin.translatable-textarea name="contact_description" label="Contact Description" rows="3" :value="$content['contact_description'] ?? null" placeholder="Contact us today to learn more about how Nova Agency can help your business grow." />
                        
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
                                           value="{{ $content['contact_email'] ?? 'test@gmail.com' }}">
                                </div>
                            </div>
                        </div>
                        
                        <x-admin.translatable-textarea name="contact_address" label="Address" rows="2" :value="$content['contact_address'] ?? null" placeholder="123 Business Street\\nCity, State 12345" />
                        
                        <div class="mb-4">
                            <label for="contact_logo_file" class="form-label">Contact Logo</label>
                            <input type="file" class="form-control" id="contact_logo_file" name="contact_logo_file" accept="image/*">
                            @if(!empty($content['contact_logo']))
                            <div class="mt-2 text-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ resolve_image_url($content['contact_logo']) }}" alt="Contact logo" style="max-height:100px;" class="img-thumbnail">
                                    <button type="submit" form="delete-contact-logo" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <small class="text-muted d-block">Current logo</small>
                            </div>
                            @endif
                        </div>
                        
                    @elseif($contentType === 'site-info')
                        <x-admin.translatable-input name="site_name" label="Site Name" :value="$content['site_name'] ?? null" placeholder="Nova Agency" />
                        
                        <div class="mb-3 mt-3">
                            <x-admin.ai-generator target="[name='site_description']" context_target="[name='site_name[en]']" type="section_writer" label="Generate Site Description" />
                        </div>
                        <x-admin.translatable-textarea name="site_description" label="Site Description" rows="3" :value="$content['site_description'] ?? null" placeholder="SupremeIT provides cutting-edge technology solutions to help businesses grow and succeed in the digital world." />
                        
                        <x-admin.translatable-input name="site_keywords" label="SEO Keywords" :value="$content['site_keywords'] ?? null" placeholder="CRM, business solutions, technology" />
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="site_logo_file" class="form-label">Site Logo</label>
                                    <input type="file" class="form-control" id="site_logo_file" name="site_logo_file" accept="image/*">
                                    @if(!empty($content['site_logo']))
                                    <div class="mt-2 text-start">
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <img src="{{ resolve_image_url($content['site_logo']) }}" alt="Site logo" style="max-height:100px;" class="img-thumbnail">
                                            <button type="submit" form="delete-site-logo" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                        <small class="text-muted d-block">Current logo</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="site_favicon_file" class="form-label">Site Favicon</label>
                                    <input type="file" class="form-control" id="site_favicon_file" name="site_favicon_file" accept="image/*,.ico">
                                    @if(!empty($content['site_favicon']))
                                    <div class="mt-2 text-start">
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <img src="{{ resolve_image_url($content['site_favicon']) }}" alt="Site favicon" style="max-height:32px;" class="img-thumbnail">
                                            <button type="submit" form="delete-site-favicon" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                        <small class="text-muted d-block">Current favicon</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-share-alt text-primary me-2"></i>Social Sharing & SEO</h5>

                        <x-admin.translatable-input name="twitter_handle" label="Twitter Handle" :value="$content['twitter_handle'] ?? null" placeholder="@novaagency" />
                        
                        <x-admin.translatable-textarea name="json_ld_organization" label="JSON-LD Structured Data (Organization)" rows="5" :value="$content['json_ld_organization'] ?? null" placeholder='{ "@context": "https://schema.org", "@type": "Organization", ... }' />
                        <small class="text-muted d-block mb-3">Optional. Advanced SEO JSON script injected into the page head.</small>

                        <div class="mb-4">
                            <label for="og_image_file" class="form-label">Default Social Share Image (OG:Image)</label>
                            <input type="file" class="form-control" id="og_image_file" name="og_image_file" accept="image/*">
                            @if(!empty($content['og_image']))
                            <div class="mt-2 text-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ resolve_image_url($content['og_image']) }}" alt="OG Image" style="max-height:100px;" class="img-thumbnail">
                                    <button type="submit" form="delete-og-image" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <small class="text-muted d-block">Current social share image (1200x630px recommended)</small>
                            </div>
                            @endif
                        </div>
                        
                    @elseif($contentType === 'home-partners')
                        <div class="mb-4">
                            <label for="partners_title" class="form-label">Partners Section Title (Optional)</label>
                            <input type="text" class="form-control" id="partners_title" name="partners_title" 
                                   value="{{ $content['partners_title'] ?? '' }}">
                        </div>
                        <x-admin.translatable-textarea name="partners_subtitle" label="Partners Subtitle (Optional)" rows="2" :value="$content['partners_subtitle'] ?? null" />
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Manage specific partner logos in the <a href="{{ route('admin.partners.index') }}" class="fw-bold">Partners Management</a> section.
                        </div>
                    @elseif($contentType === 'about-stats')
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3"><i class="fas fa-chart-line me-2"></i>Stats Section Header</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="stats_title" class="form-label">Main Title</label>
                                    <input type="text" class="form-control" id="stats_title" name="stats_title" 
                                           value="{{ $content['stats_title'] ?? 'Our Success in Numbers' }}" placeholder="e.g. Our Success in Numbers">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stats_subtitle" class="form-label">Badge/Subtitle</label>
                                    <input type="text" class="form-control" id="stats_subtitle" name="stats_subtitle" 
                                           value="{{ $content['stats_subtitle'] ?? 'By The Numbers' }}" placeholder="e.g. By The Numbers">
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border rounded bg-white shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 text-dark">
                                    <i class="fas fa-list-ol me-2"></i>Counter Items
                                </h5>
                                <button type="button" class="btn btn-primary btn-sm" id="add-stat">
                                    <i class="fas fa-plus me-2"></i>Add New Stat
                                </button>
                            </div>
                            <small class="text-muted d-block mb-4">
                                <i class="fas fa-info-circle me-1"></i> These numbers will animate when they appear on the screen. 
                                Find icons at <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a>.
                            </small>

                            <div id="stats-list">
                                @foreach($content['stats'] ?? [] as $index => $stat)
                                <div class="stat-item border p-3 mb-3 rounded bg-light hover-shadow-sm transition-all">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Icon Class</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="{{ $stat['icon'] ?? 'fa-solid fa-check' }}"></i></span>
                                                <input type="text" class="form-control" name="stats[{{ $index }}][icon]" value="{{ $stat['icon'] ?? '' }}" placeholder="fa-solid fa-users">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Number</label>
                                            <input type="text" class="form-control" name="stats[{{ $index }}][number]" value="{{ $stat['number'] ?? '' }}" placeholder="500">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold">Suffix</label>
                                            <input type="text" class="form-control" name="stats[{{ $index }}][suffix]" value="{{ $stat['suffix'] ?? '' }}" placeholder="+">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger remove-item w-100">
                                                <i class="fas fa-trash me-2"></i>Remove
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Label / Description</label>
                                            <input type="text" class="form-control" name="stats[{{ $index }}][label]" value="{{ $stat['label'] ?? '' }}" placeholder="e.g. Projects Finished">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($contentType === 'about-values')
                        <div class="mb-4">
                            <h5 class="fw-bold text-success mb-3"><i class="fas fa-gem me-2"></i>Company Values Header</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="values_title" class="form-label">Main Title</label>
                                    <input type="text" class="form-control" id="values_title" name="values_title" 
                                           value="{{ $content['values_title'] ?? 'The Principles That Drive Us' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="values_subtitle" class="form-label">Badge/Subtitle</label>
                                    <input type="text" class="form-control" id="values_subtitle" name="values_subtitle" 
                                           value="{{ $content['values_subtitle'] ?? 'Our Culture' }}">
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border rounded bg-white shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 text-dark">
                                    <i class="fas fa-star me-2"></i>Value Cards
                                </h5>
                                <button type="button" class="btn btn-success btn-sm" id="add-value">
                                    <i class="fas fa-plus me-2"></i>Add New Value
                                </button>
                            </div>

                            <div id="values-list">
                                @foreach($content['values'] ?? [] as $index => $value)
                                <div class="value-item border p-3 mb-3 rounded bg-light hover-shadow-sm transition-all">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Icon Class</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="{{ $value['icon'] ?? 'fa-solid fa-gem' }}"></i></span>
                                                <input type="text" class="form-control" name="values[{{ $index }}][icon]" value="{{ $value['icon'] ?? '' }}" placeholder="fa-solid fa-lightbulb">
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger remove-item w-100">
                                                <i class="fas fa-trash me-2"></i>Remove Card
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Value Title</label>
                                            <input type="text" class="form-control" name="values[{{ $index }}][title]" value="{{ $value['title'] ?? '' }}" placeholder="e.g. Innovation First">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Short Description</label>
                                            <textarea class="form-control" name="values[{{ $index }}][description]" rows="2" placeholder="e.g. We always stay ahead with cutting-edge tech.">{{ $value['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($contentType === 'about-history')
                        <div class="mb-4">
                            <h5 class="fw-bold text-info mb-3"><i class="fas fa-history me-2"></i>Company History Header</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="history_title" class="form-label">Main Title</label>
                                    <input type="text" class="form-control" id="history_title" name="history_title" 
                                           value="{{ $content['history_title'] ?? 'Our Journey' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="history_subtitle" class="form-label">Badge/Subtitle</label>
                                    <input type="text" class="form-control" id="history_subtitle" name="history_subtitle" 
                                           value="{{ $content['history_subtitle'] ?? 'Company Timeline' }}">
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border rounded bg-white shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 text-dark">
                                    <i class="fas fa-calendar-alt me-2"></i>Timeline Events
                                </h5>
                                <button type="button" class="btn btn-info text-white btn-sm" id="add-milestone">
                                    <i class="fas fa-plus me-2"></i>Add New Event
                                </button>
                            </div>

                            <div id="milestones-list">
                                @foreach($content['milestones'] ?? [] as $index => $milestone)
                                <div class="milestone-item border p-3 mb-3 rounded bg-light hover-shadow-sm transition-all">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Year / Date</label>
                                            <input type="text" class="form-control" name="milestones[{{ $index }}][year]" value="{{ $milestone['year'] ?? '' }}" placeholder="e.g. 2015">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small fw-bold">Event Title</label>
                                            <input type="text" class="form-control" name="milestones[{{ $index }}][title]" value="{{ $milestone['title'] ?? '' }}" placeholder="e.g. The Beginning">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger remove-item w-100">
                                                <i class="fas fa-trash me-2"></i>Remove
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Event Description</label>
                                            <textarea class="form-control" name="milestones[{{ $index }}][description]" rows="2">{{ $milestone['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($contentType === 'about-team')
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-users-cog me-2"></i>Team Section Header</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="team_title" class="form-label">Main Title</label>
                                    <input type="text" class="form-control" id="team_title" name="team_title" 
                                           value="{{ $content['team_title'] ?? 'The Experts Behind Our Success' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="team_subtitle" class="form-label">Badge/Subtitle</label>
                                    <input type="text" class="form-control" id="team_subtitle" name="team_subtitle" 
                                           value="{{ $content['team_subtitle'] ?? 'Our Team' }}">
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border rounded bg-white shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 text-dark">
                                    <i class="fas fa-id-card me-2"></i>Team Members
                                </h5>
                                <button type="button" class="btn btn-dark btn-sm" id="add-member">
                                    <i class="fas fa-plus me-2"></i>Add New Member
                                </button>
                            </div>

                            <div id="members-list">
                                @foreach($content['members'] ?? [] as $index => $member)
                                <div class="member-item border p-4 mb-4 rounded bg-light hover-shadow-sm transition-all border-start border-4 border-dark">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-bold">Full Name</label>
                                            <input type="text" class="form-control bg-white" name="members[{{ $index }}][name]" value="{{ $member['name'] ?? '' }}" placeholder="e.g. John Doe">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Position</label>
                                            <input type="text" class="form-control bg-white" name="members[{{ $index }}][position]" value="{{ $member['position'] ?? '' }}" placeholder="e.g. CEO & Founder">
                                        </div>
                                        <div class="col-md-3 d-flex flex-column gap-2 align-items-end">
                                            <button type="button" class="btn btn-outline-danger remove-item w-100">
                                                <i class="fas fa-user-minus me-2"></i>Delete
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm btn-save-item w-100" 
                                                    data-index="{{ $index }}" 
                                                    data-type="{{ $contentType }}" 
                                                    data-key="members" 
                                                    data-url="{{ route('admin.content.update-item', ['type' => $contentType, 'key' => 'members', 'index' => $index]) }}">
                                                <i class="fas fa-save me-2"></i>Save This Member
                                            </button>
                                        </div>
                                        
                                        <div class="col-12 mt-3">
                                            <h6 class="small text-uppercase fw-bold text-muted border-bottom pb-1 mb-3">Details & Social Links</h6>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">Upload Profile Photo</label>
                                                    <input type="file" class="form-control bg-white" name="members[{{ $index }}][image_file]" accept="image/*">
                                                    <small class="text-muted">Max size: 2MB. Recommended: Square (400x400).</small>
                                                </div>
                                                <div class="col-md-1 text-center mt-3 mt-md-0">
                                                    <span class="badge bg-secondary">OR</span>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="form-label small fw-bold">Image URL / Path</label>
                                                    <input type="text" class="form-control bg-white" name="members[{{ $index }}][image]" value="{{ $member['image'] ?? '' }}" placeholder="assets/img/team/01.jpg">
                                                </div>
                                            </div>
                                            <div class="mt-3 member-preview-container d-flex align-items-center gap-3 p-2 bg-white rounded border {{ empty($member['image']) ? 'd-none' : '' }}">
                                                <img src="{{ !empty($member['image']) ? asset($member['image']) : '' }}" alt="Member Preview" style="max-height: 80px;" class="img-thumbnail rounded-circle member-preview-img">
                                                <div>
                                                    <span class="small fw-bold d-block text-dark member-preview-label">Current Image:</span>
                                                    <code class="small text-muted member-preview-filename">{{ !empty($member['image']) ? basename($member['image']) : '' }}</code>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold"><i class="fab fa-facebook text-primary me-1"></i> Facebook</label>
                                            <input type="text" class="form-control bg-white" name="members[{{ $index }}][facebook]" value="{{ $member['facebook'] ?? '' }}" placeholder="URL">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold"><i class="fab fa-twitter text-info me-1"></i> Twitter</label>
                                            <input type="text" class="form-control bg-white" name="members[{{ $index }}][twitter]" value="{{ $member['twitter'] ?? '' }}" placeholder="URL">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold"><i class="fab fa-linkedin text-primary me-1"></i> LinkedIn</label>
                                            <input type="text" class="form-control bg-white" name="members[{{ $index }}][linkedin]" value="{{ $member['linkedin'] ?? '' }}" placeholder="URL">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($contentType === 'services-list')
                        <x-admin.translatable-input name="title" label="Services Section Title" :value="$content['title'] ?? null" placeholder="Our Awesome Services" />
                        
                        <x-admin.translatable-textarea name="subtitle" label="Services Subtitle" rows="2" :value="$content['subtitle'] ?? null" placeholder="What We Do" />

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <i class="fas fa-th-list me-2"></i>Select & Order Services for Home Page
                            </label>
                            <div class="row g-3" id="service-picker-grid">
                                @foreach(($services ?? []) as $service)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="card h-100 service-picker-card {{ $service->is_featured ? 'border-primary bg-light' : 'opacity-75' }}" 
                                             data-service-id="{{ $service->id }}"
                                             style="transition: all 0.3s ease; cursor: pointer;">
                                            <div class="card-body p-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input service-checkbox" type="checkbox" 
                                                           name="featured_services[{{ $loop->index }}][id]" 
                                                           value="{{ $service->id }}" 
                                                           id="service_{{ $service->id }}"
                                                           {{ $service->is_featured ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold text-dark" for="service_{{ $service->id }}">
                                                        {{ $service->title }}
                                                    </label>
                                                </div>
                                                <div class="order-input-group {{ $service->is_featured ? '' : 'd-none' }}">
                                                    <label class="small text-muted mb-1 d-block">Display Order</label>
                                                    <input type="number" class="form-control form-control-sm service-order" 
                                                           name="featured_services[{{ $loop->index }}][order]" 
                                                           value="{{ $service->featured_order ?? 0 }}" 
                                                           min="0" placeholder="Order">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-3">
                                <i class="fas fa-info-circle me-1"></i> Checked services will appear on the home page in the order specified.
                            </small>
                        </div>

                    @elseif($contentType === 'projects-list')
                        <div class="mb-4">
                            <label for="title" class="form-label">Section Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ $content['title'] ?? '' }}">
                        </div>

                        <x-admin.translatable-textarea name="subtitle" label="Section Subtitle" rows="2" :value="$content['subtitle'] ?? null" />

                        <div class="mb-4">
                            <label class="form-label d-block mb-3">Select Projects to Feature</label>
                            <div class="row g-3" id="project-picker-grid">
                                @foreach(($projects ?? []) as $project)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="card h-100 picker-card {{ $project->is_featured ? 'border-primary bg-light' : 'opacity-75 shadow-sm' }}" 
                                             data-id="{{ $project->id }}"
                                             style="transition: all 0.3s ease; cursor: pointer; border-width: 2px;">
                                            <div class="card-body p-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input item-checkbox" type="checkbox" 
                                                           name="featured_projects[{{ $loop->index }}][id]" 
                                                           value="{{ $project->id }}" 
                                                           id="project_{{ $project->id }}"
                                                           {{ $project->is_featured ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold text-dark" for="project_{{ $project->id }}">
                                                        {{ $project->title }}
                                                    </label>
                                                </div>
                                                <div class="order-input-group {{ $project->is_featured ? '' : 'd-none' }}">
                                                    <label class="small text-muted mb-1 d-block">Display Order</label>
                                                    <input type="number" class="form-control form-control-sm item-order" 
                                                           name="featured_projects[{{ $loop->index }}][order]" 
                                                           value="{{ $project->featured_order ?? 0 }}" 
                                                           min="0" placeholder="Order">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-3">
                                <i class="fas fa-info-circle me-1"></i> Selection will appear on the home page in the defined order.
                            </small>
                        </div>

                    @elseif($contentType === 'reviews-list')
                        <x-admin.translatable-input name="title" label="Reviews Section Title" :value="$content['title'] ?? null" placeholder="What our clients say" />
                        <x-admin.translatable-input name="subtitle" label="Reviews Subtitle" :value="$content['subtitle'] ?? null" placeholder="Testimonials" />
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Manage specific customer reviews in the <a href="{{ route('admin.reviews.index') }}" class="fw-bold">Reviews Management</a> section.
                        </div>

                    @elseif($contentType === 'blog-list')
                        <x-admin.translatable-input name="title" label="Blog Section Title" :value="$content['title'] ?? null" placeholder="Direct from the Blog" />
                        <x-admin.translatable-input name="subtitle" label="Blog Subtitle" :value="$content['subtitle'] ?? null" placeholder="Latest News" />
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            The blog section automatically displays your latest published posts from the <a href="{{ route('admin.blogs.index') }}" class="fw-bold">Blog Management</a>.
                        </div>

                    @elseif($contentType === 'cta-simple')
                        <x-admin.translatable-input name="title" label="CTA Title" :value="$content['title'] ?? null" placeholder="Ready to Transform Your Business?" />
                        <x-admin.translatable-textarea name="description" label="CTA Description" rows="3" :value="$content['description'] ?? null" placeholder="Let's discuss how Nova Agency can help you achieve your technology goals with our expert solutions." />
                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.translatable-input name="button_text" label="Button Text" :value="$content['button_text'] ?? null" placeholder="Get a Free Quote" />
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="button_url" class="form-label">Button URL (Optional)</label>
                                    <input type="text" class="form-control" id="button_url" name="button_url" 
                                           value="{{ $content['button_url'] ?? '' }}" placeholder="/contact">
                                </div>
                            </div>
                        </div>

                    @elseif(str_contains($contentType, 'page-header'))
                        <div class="mb-4">
                            <label for="title" class="form-label">Page Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ $content['title'] ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label for="breadcrumb_title" class="form-label">Breadcrumb Title (Supports HTML)</label>
                            <textarea class="form-control" id="breadcrumb_title" name="breadcrumb_title" rows="2">{{ $content['breadcrumb_title'] ?? '' }}</textarea>
                            <small class="text-muted">Example: Our &lt;span&gt;Portfolio&lt;/span&gt;</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Header Background Image</label>
                            <input type="file" class="form-control" name="image_file" accept="image/*">
                            @if(!empty($content['image']))
                            <div class="mt-2 text-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ resolve_image_url($content['image']) }}" alt="Header image" style="max-height:100px;" class="img-thumbnail">
                                    <button type="submit" form="delete-header-image" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </div>
                                <small class="text-muted d-block">Current image</small>
                            </div>
                            @endif
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

                {{-- Hidden Deletion Forms --}}
                <form id="delete-header-image" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'header_image']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="delete-about-image" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'about_image']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="delete-hero-image" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'hero_image']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="delete-site-logo" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'site_logo']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="delete-site-favicon" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'site_favicon']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="delete-og-image" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'og_image']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <form id="delete-contact-logo" action="{{ route('admin.content.destroy-image', ['type' => $contentType, 'key' => 'contact_logo']) }}" method="POST">
                    @csrf
                    @method('DELETE')
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
                    @elseif($contentType === 'services-list')
                        <h5>{{ $content['title'] ?? 'Our Awesome Services' }}</h5>
                        <p class="text-muted">{{ $content['subtitle'] ?? 'What We Do' }}</p>
                        <div class="mt-3">
                            @if(!empty($content['featured_services']))
                                <div class="small fw-bold mb-2">Selected Services:</div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(collect($content['featured_services'])->sortBy('order') as $fService)
                                        @php($s = ($services ?? collect())->firstWhere('id', $fService['id']))
                                        <span class="badge bg-primary">{{ $s->title ?? 'Service #'.$fService['id'] }}</span>
                                    @endforeach
                                @else
                                <span class="text-muted small">All active services will be shown (Default).</span>
                            @endif
                        </div>
                    @elseif($contentType === 'contact-info')
                        <h5>{{ $content['contact_title'] ?? 'Ready to get started?' }}</h5>
                        <p class="text-muted">{{ $content['contact_description'] ?? 'Contact description...' }}</p>
                        <p><strong>Phone:</strong> {{ $content['contact_phone'] ?? '+1 (555) 123-4567' }}</p>
                        <p><strong>Email:</strong> {{ $content['contact_email'] ?? 'info@supremeit.com' }}</p>
                    @elseif($contentType === 'reviews-list')
                        <span class="badge bg-primary mb-2">{{ $content['subtitle'] ?? 'Testimonials' }}</span>
                        <h5>{{ $content['title'] ?? 'What our clients say' }}</h5>
                    @elseif($contentType === 'blog-list')
                        <span class="badge bg-primary mb-2">{{ $content['subtitle'] ?? 'Latest News' }}</span>
                        <h5>{{ $content['title'] ?? 'Direct from the Blog' }}</h5>
                    @elseif($contentType === 'cta-simple')
                        <div class="p-3 bg-primary text-white rounded shadow-sm">
                            <h6 class="fw-bold mb-2">{{ $content['title'] ?? 'Ready to Transform Your Business?' }}</h6>
                            <p class="small mb-3 opacity-90">{{ $content['description'] ?? 'CTA description...' }}</p>
                            <button class="btn btn-sm btn-light text-primary fw-bold">{{ $content['button_text'] ?? 'Get a Free Quote' }}</button>
                        </div>
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

@push('hidden-forms')
    <form id="delete-hero-image" action="{{ route('admin.content.destroy-image', [$contentType, 'hero_image']) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <form id="delete-about-image" action="{{ route('admin.content.destroy-image', [$contentType, 'about_image']) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <form id="delete-contact-logo" action="{{ route('admin.content.destroy-image', [$contentType, 'contact_logo']) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <form id="delete-site-logo" action="{{ route('admin.content.destroy-image', [$contentType, 'site_logo']) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <form id="delete-site-favicon" action="{{ route('admin.content.destroy-image', [$contentType, 'site_favicon']) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <form id="delete-header-image" action="{{ route('admin.content.destroy-image', [$contentType, 'image']) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add feature functionality
    const addFeatureBtn = document.getElementById('add-feature');
    const featuresList = document.getElementById('features-list');
    let featureIndex = {{ count($content['features'] ?? []) }};
    
    if (addFeatureBtn && featuresList) {
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
    }

    // New dynamic list handlers
    function setupDynamicList(btnId, listId, itemName, templateFn) {
        const btn = document.getElementById(btnId);
        const list = document.getElementById(listId);
        if (!btn || !list) return;

        let index = list.children.length;

        btn.addEventListener('click', function() {
            list.insertAdjacentHTML('beforeend', templateFn(index));
            index++;
        });

        list.addEventListener('click', function(e) {
            if (e.target.closest('.remove-item')) {
                e.target.closest(`.${itemName}-item`).remove();
            }
        });
    }

    setupDynamicList('add-stat', 'stats-list', 'stat', (i) => `
        <div class="stat-item border p-3 mb-3 rounded bg-light hover-shadow-sm transition-all animate__animated animate__fadeIn">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Icon Class</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fa-solid fa-check"></i></span>
                        <input type="text" class="form-control" name="stats[${i}][icon]" placeholder="fa-solid fa-users">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Number</label>
                    <input type="text" class="form-control" name="stats[${i}][number]" placeholder="500">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Suffix</label>
                    <input type="text" class="form-control" name="stats[${i}][suffix]" placeholder="+">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item w-100">
                        <i class="fas fa-trash me-2"></i>Remove
                    </button>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Label / Description</label>
                    <input type="text" class="form-control" name="stats[${i}][label]" placeholder="e.g. Projects Finished">
                </div>
            </div>
        </div>
    `);

    setupDynamicList('add-value', 'values-list', 'value', (i) => `
        <div class="value-item border p-3 mb-3 rounded bg-light hover-shadow-sm transition-all animate__animated animate__fadeIn">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Icon Class</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fa-solid fa-gem"></i></span>
                        <input type="text" class="form-control" name="values[${i}][icon]" placeholder="fa-solid fa-lightbulb">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item w-100">
                        <i class="fas fa-trash me-2"></i>Remove Card
                    </button>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Value Title</label>
                    <input type="text" class="form-control" name="values[${i}][title]" placeholder="e.g. Innovation First">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Short Description</label>
                    <textarea class="form-control" name="values[${i}][description]" rows="2" placeholder="e.g. We always stay ahead with cutting-edge tech."></textarea>
                </div>
            </div>
        </div>
    `);

    setupDynamicList('add-milestone', 'milestones-list', 'milestone', (i) => `
        <div class="milestone-item border p-3 mb-3 rounded bg-light hover-shadow-sm transition-all animate__animated animate__fadeIn">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Year / Date</label>
                    <input type="text" class="form-control" name="milestones[${i}][year]" placeholder="e.g. 2015">
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Event Title</label>
                    <input type="text" class="form-control" name="milestones[${i}][title]" placeholder="e.g. The Beginning">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item w-100">
                        <i class="fas fa-trash me-2"></i>Remove
                    </button>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Event Description</label>
                    <textarea class="form-control" name="milestones[${i}][description]" rows="2"></textarea>
                </div>
            </div>
        </div>
    `);

    setupDynamicList('add-member', 'members-list', 'member', (i) => `
        <div class="member-item border p-4 mb-4 rounded bg-light hover-shadow-sm transition-all border-start border-4 border-dark animate__animated animate__fadeIn">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Full Name</label>
                    <input type="text" class="form-control bg-white" name="members[${i}][name]" placeholder="e.g. John Doe">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Position</label>
                    <input type="text" class="form-control bg-white" name="members[${i}][position]" placeholder="e.g. CEO & Founder">
                </div>
                <div class="col-md-3 d-flex flex-column gap-2 align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-item w-100">
                        <i class="fas fa-user-minus me-2"></i>Delete
                    </button>
                    <button type="button" class="btn btn-success btn-sm btn-save-item w-100" 
                            data-index="${i}" 
                            data-type="{{ $contentType }}" 
                            data-key="members" 
                            data-url="/admin/content/{{ $contentType }}/item/members/${i}">
                        <i class="fas fa-save me-2"></i>Save This Member
                    </button>
                </div>
                
                <div class="col-12 mt-3">
                    <h6 class="small text-uppercase fw-bold text-muted border-bottom pb-1 mb-3">Details & Social Links</h6>
                </div>

                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Upload Profile Photo</label>
                            <input type="file" class="form-control bg-white member-file-input" name="members[${i}][image_file]" accept="image/*">
                        </div>
                        <div class="col-md-1 text-center mt-3 mt-md-0">
                            <span class="badge bg-secondary">OR</span>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Image URL / Path</label>
                            <input type="text" class="form-control bg-white member-url-input" name="members[${i}][image]" placeholder="assets/img/team/new.jpg">
                        </div>
                    </div>
                    <div class="mt-3 member-preview-container d-flex align-items-center gap-3 p-2 bg-white rounded border d-none">
                        <img src="" alt="Member Preview" style="max-height: 80px;" class="img-thumbnail rounded-circle member-preview-img">
                        <div>
                            <span class="small fw-bold d-block text-dark member-preview-label">New Image Preview:</span>
                            <code class="small text-muted member-preview-filename"></code>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold"><i class="fab fa-facebook text-primary me-1"></i> Facebook</label>
                    <input type="text" class="form-control bg-white" name="members[${i}][facebook]" placeholder="URL">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold"><i class="fab fa-twitter text-info me-1"></i> Twitter</label>
                    <input type="text" class="form-control bg-white" name="members[${i}][twitter]" placeholder="URL">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold"><i class="fab fa-linkedin text-primary me-1"></i> LinkedIn</label>
                    <input type="text" class="form-control bg-white" name="members[${i}][linkedin]" placeholder="URL">
                </div>
            </div>
        </div>
    `);
    
    // Unified Image Preview functionality (Delegated)
    document.addEventListener('change', function(e) {
        if (e.target.matches('input[type="file"]') && e.target.name.includes('members')) {
            const input = e.target;
            const itemContainer = input.closest('.member-item');
            const previewContainer = itemContainer.querySelector('.member-preview-container');
            const previewImg = previewContainer.querySelector('.member-preview-img');
            const previewLabel = previewContainer.querySelector('.member-preview-label');
            const previewFilename = previewContainer.querySelector('.member-preview-filename');
            
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewLabel.textContent = 'Selected Image (Unsaved):';
                    previewFilename.textContent = file.name;
                    previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Also update preview if URL is changed manually (for paths)
        if (e.target.matches('input[type="text"]') && e.target.name.includes('[image]')) {
            const input = e.target;
            const itemContainer = input.closest('.member-item');
            const previewContainer = itemContainer.querySelector('.member-preview-container');
            const previewImg = previewContainer.querySelector('.member-preview-img');
            const previewLabel = previewContainer.querySelector('.member-preview-label');
            const previewFilename = previewContainer.querySelector('.member-preview-filename');
            
            if (input.value) {
                // If it's a relative path, we might need a helper, but full URLs work fine
                previewImg.src = input.value.startsWith('http') || input.value.startsWith('/') 
                                 ? input.value 
                                 : '/' + input.value;
                previewLabel.textContent = 'From URL (Unsaved):';
                previewFilename.textContent = input.value.split('/').pop();
                previewContainer.classList.remove('d-none');
            }
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

    // Handle Individual Item Save via AJAX
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-save-item')) {
            const btn = e.target.closest('.btn-save-item');
            const itemContainer = btn.closest('.member-item');
            const url = btn.dataset.url;
            const index = btn.dataset.index;
            
            // Show loading state
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
            btn.disabled = true;
            
            // Prepare FormData
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            // Get all inputs within this member-item
            const inputs = itemContainer.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                if (input.type === 'file') {
                    if (input.files.length > 0) {
                        formData.append('item_file', input.files[0]);
                    }
                } else {
                    // We need to extract the field name without the array wrappers for the specific update
                    // Example: members[0][name] -> name
                    const nameMatch = input.name.match(/\[([^\]]+)\]$/);
                    if (nameMatch) {
                        formData.append('item[' + nameMatch[1] + ']', input.value);
                    }
                }
            });
            
            // Send AJAX
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update image preview using the unified component
                    const previewContainer = itemContainer.querySelector('.member-preview-container');
                    const previewImg = previewContainer.querySelector('.member-preview-img');
                    const previewLabel = previewContainer.querySelector('.member-preview-label');
                    const previewFilename = previewContainer.querySelector('.member-preview-filename');
                    
                    if (data.image_url) {
                        previewImg.src = data.image_url;
                        previewLabel.textContent = 'Current Image:';
                        previewFilename.textContent = data.item.image.split('/').pop();
                        previewContainer.classList.remove('d-none');
                        
                        // Update the text input value too
                        const urlInput = itemContainer.querySelector('input[name*="[image]"]');
                        if (urlInput) urlInput.value = data.item.image;
                    }
                    
                    // Show success state
                    btn.innerHTML = '<i class="fas fa-check me-2"></i>Saved!';
                    btn.classList.replace('btn-success', 'btn-outline-success');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.classList.replace('btn-outline-success', 'btn-success');
                        btn.disabled = false;
                    }, 2000);
                } else {
                    alert('Error: ' + (data.message || 'Could not save item.'));
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred.');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            });
        }
    // Picker Interactivity (Shared for Services & Projects)
    document.querySelectorAll('[id$="-picker-grid"]').forEach(grid => {
        // Initialize: disable inputs for unchecked items
        grid.querySelectorAll('.card').forEach(card => {
            const checkbox = card.querySelector('.form-check-input');
            const inputs = card.querySelectorAll('input');
            inputs.forEach(input => {
                if (input !== checkbox) input.disabled = !checkbox.checked;
            });
        });

        grid.addEventListener('click', function(e) {
            const card = e.target.closest('.card');
            if (!card) return;

            // Prevent card toggle if clicking inputs directly
            if (e.target.closest('input')) return;

            const checkbox = card.querySelector('.form-check-input');
            const orderGroup = card.querySelector('.order-input-group');
            const inputs = card.querySelectorAll('input');
            
            // Toggle checkbox if not clicking the checkbox/label itself
            if (e.target !== checkbox && !e.target.closest('.form-check-label')) {
                checkbox.checked = !checkbox.checked;
            }

            // Update UI & Toggle Inputs
            if (checkbox.checked) {
                card.classList.add('border-primary', 'bg-light');
                card.classList.remove('opacity-75', 'shadow-sm');
                if (orderGroup) orderGroup.classList.remove('d-none');
                inputs.forEach(input => (input.disabled = false));
            } else {
                card.classList.remove('border-primary', 'bg-light');
                card.classList.add('opacity-75', 'shadow-sm');
                if (orderGroup) orderGroup.classList.add('d-none');
                inputs.forEach(input => {
                    if (input !== checkbox) input.disabled = true;
                });
            }
        });
    });
});
</script>
@endpush
