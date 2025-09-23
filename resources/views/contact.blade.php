@extends('layouts.app')

@section('title', 'Contact Us - SupremeIT')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Contact <span>Us</span></h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                 Contact Us
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Contact Section Start -->
<section class="gt-contact-section fix section-padding">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">get in touch</h6>
            <h2 class="char-animation">
                Ready to get started?
            </h2>
            <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">
                Contact us today to learn more about how SupremeIT can help your business grow.
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="gt-contact-form">
                    <!-- Contact Form Tabs -->
                    <div class="contact-tabs mb-4">
                        <ul class="nav nav-tabs" id="contactTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                    General Inquiry
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab">
                                    Service Request
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="contactTabsContent">
                        <!-- General Contact Form -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required 
                                                   style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required 
                                                   style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="tel" name="phone" placeholder="Your Phone" value="{{ old('phone') }}" 
                                                   style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}" 
                                                   style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea name="message" placeholder="Your Message" rows="5" required 
                                                      style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="gt-theme-btn">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Service Request Form -->
                        <div class="tab-pane fade" id="service" role="tabpanel">
                            <form action="{{ route('tc-request.submit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Your Email Address" value="{{ old('email') }}" required 
                                                   style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="service_id" style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">
                                                <option value="">Select a Service (Optional)</option>
                                                @foreach($services as $service)
                                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea name="description" placeholder="Describe your project requirements in detail..." rows="5" required 
                                                      style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000 !important;">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="attached_file" class="form-label">Attach Files (Optional)</label>
                                            <input type="file" name="attached_file" accept=".pdf,.doc,.docx,.txt">
                                            <small class="form-text text-muted">Supported formats: PDF, DOC, DOCX, TXT (Max 10MB)</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="gt-theme-btn">Submit Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="gt-contact-info">
                    <div class="gt-contact-info-item">
                        <div class="gt-contact-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="gt-contact-info-content">
                            <h4>Our Location</h4>
                            <p>123 Business Street<br>City, State 12345</p>
                        </div>
                    </div>
                    <div class="gt-contact-info-item">
                        <div class="gt-contact-info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="gt-contact-info-content">
                            <h4>Phone Number</h4>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div class="gt-contact-info-item">
                        <div class="gt-contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="gt-contact-info-content">
                            <h4>Email Address</h4>
                            <p>info@supremeit.com</p>
                        </div>
                    </div>
                    <div class="gt-contact-info-item">
                        <div class="gt-contact-info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="gt-contact-info-content">
                            <h4>Business Hours</h4>
                            <p>Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Services -->
                <div class="gt-quick-services mt-4">
                    <h5>Our Services</h5>
                    <ul class="services-list">
                        @foreach($services->take(5) as $service)
                        <li>
                            <a href="{{ route('service.detail', $service) }}">
                                <i class="fas fa-arrow-right"></i>
                                {{ $service->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('services') }}" class="gt-theme-btn w-100">View All Services</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.contact-tabs .nav-tabs {
    border-bottom: 2px solid #eee;
    margin-bottom: 30px;
}

.contact-tabs .nav-link {
    border: none;
    color: #000;
    font-weight: 500;
    padding: 12px 24px;
    margin-right: 10px;
    border-radius: 8px 8px 0 0;
    transition: all 0.3s;
}

.contact-tabs .nav-link:hover {
    color: #667eea;
    background: #f8f9fa;
}

.contact-tabs .nav-link.active {
    color: #667eea;
    background: white;
    border-bottom: 2px solid #667eea;
}

/* Form Input Styling - Ensure Black Text */
.gt-contact-form input[type="text"],
.gt-contact-form input[type="email"],
.gt-contact-form input[type="tel"],
.gt-contact-form textarea,
.gt-contact-form select,
.gt-contact-form .form-group input,
.gt-contact-form .form-group textarea,
.gt-contact-form .form-group select {
    color: #000 !important;
    background-color: #fff !important;
    -webkit-text-fill-color: #000 !important;
    -webkit-opacity: 1 !important;
    opacity: 1 !important;
}

.gt-contact-form input[type="text"]:focus,
.gt-contact-form input[type="email"]:focus,
.gt-contact-form input[type="tel"]:focus,
.gt-contact-form textarea:focus,
.gt-contact-form select:focus,
.gt-contact-form .form-group input:focus,
.gt-contact-form .form-group textarea:focus,
.gt-contact-form .form-group select:focus {
    color: #000 !important;
    background-color: #fff !important;
    border-color: #667eea !important;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
    -webkit-text-fill-color: #000 !important;
    -webkit-opacity: 1 !important;
    opacity: 1 !important;
}

.gt-contact-form input[type="text"]::placeholder,
.gt-contact-form input[type="email"]::placeholder,
.gt-contact-form input[type="tel"]::placeholder,
.gt-contact-form textarea::placeholder {
    color: #6c757d !important;
    -webkit-text-fill-color: #6c757d !important;
}

.gt-contact-form select option {
    color: #000 !important;
    background-color: #fff !important;
}

/* Additional overrides for any theme-specific styling */
.gt-contact-form input,
.gt-contact-form textarea,
.gt-contact-form select {
    color: #000 !important;
    background-color: #fff !important;
    -webkit-text-fill-color: #000 !important;
    -webkit-opacity: 1 !important;
    opacity: 1 !important;
}

.gt-contact-form input:focus,
.gt-contact-form textarea:focus,
.gt-contact-form select:focus {
    color: #000 !important;
    background-color: #fff !important;
    -webkit-text-fill-color: #000 !important;
    -webkit-opacity: 1 !important;
    opacity: 1 !important;
}

.gt-quick-services {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.gt-quick-services h5 {
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #667eea;
    padding-bottom: 10px;
}

.services-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
}

.services-list li {
    margin-bottom: 10px;
}

.services-list a {
    display: flex;
    align-items: center;
    color: #666;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.3s;
}

.services-list a:hover {
    background: #f8f9fa;
    color: #667eea;
}

.services-list i {
    margin-right: 10px;
    color: #667eea;
    font-size: 0.8rem;
}
</style>
@endpush
