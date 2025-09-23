@extends('layouts.app')

@section('title', $service->title . ' - SupremeIT')
@section('page-title', $service->title)

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $service->title }}</h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('services') }}">Services</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>{{ $service->title }}</li>
            </ul>
        </div>
    </div>
</div>

<!-- Service Detail Section Start -->
<section class="gt-service-detail-section fix section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="gt-service-detail-content">
                    @if($service->image)
                    <div class="gt-service-image mb-4">
                        <img src="{{ $service->image }}" alt="{{ $service->title }}" class="w-100 rounded">
                    </div>
                    @endif

                    <div class="gt-service-header mb-4">
                        <h2>{{ $service->title }}</h2>
                        @if($service->subtitle)
                        <p class="lead text-muted">{{ $service->subtitle }}</p>
                        @endif
                        @if($service->price)
                        <div class="gt-service-price mb-3">
                            <span class="price">${{ number_format($service->price, 0) }}</span>
                            @if($service->price_unit)
                            <span class="unit">/{{ $service->price_unit }}</span>
                            @endif
                        </div>
                        @endif
                    </div>

                    <div class="gt-service-description mb-5">
                        <h4>Service Description</h4>
                        <div class="content">
                            {!! nl2br(e($service->description)) !!}
                        </div>
                    </div>

                    @if($service->features && count($service->features) > 0)
                    <div class="gt-service-features mb-5">
                        <h4>What's Included</h4>
                        <div class="row">
                            @foreach($service->features as $feature)
                            <div class="col-md-6 mb-3">
                                <div class="gt-feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ $feature }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- CTA Section -->
                    <div class="gt-service-cta">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('contact') }}" class="gt-theme-btn w-100">
                                    <i class="fas fa-envelope me-2"></i>
                                    Get a Quote
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('tc-request') }}" class="gt-theme-btn style-3 w-100">
                                    <i class="fas fa-file-alt me-2"></i>
                                    Request Service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="gt-service-sidebar">
                    <!-- Service Info Card -->
                    <div class="gt-sidebar-card mb-4">
                        <h5>Service Information</h5>
                        <div class="gt-service-info">
                            @if($service->price)
                            <div class="info-item">
                                <strong>Price:</strong>
                                <span>${{ number_format($service->price, 0) }}{{ $service->price_unit ? '/' . $service->price_unit : '' }}</span>
                            </div>
                            @endif
                            <div class="info-item">
                                <strong>Category:</strong>
                                <span>{{ $service->category ?? 'General' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Availability:</strong>
                                <span class="text-success">Available</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="gt-sidebar-card mb-4">
                        <h5>Need Help?</h5>
                        <p>Have questions about this service? Our team is here to help.</p>
                        <a href="{{ route('contact') }}" class="gt-theme-btn w-100">
                            <i class="fas fa-phone me-2"></i>
                            Contact Us
                        </a>
                    </div>

                    <!-- Related Services -->
                    @if($relatedServices->count() > 0)
                    <div class="gt-sidebar-card">
                        <h5>Related Services</h5>
                        <div class="gt-related-services">
                            @foreach($relatedServices as $relatedService)
                            <div class="gt-related-item">
                                <a href="{{ route('service.detail', $relatedService) }}">
                                    <div class="d-flex align-items-center">
                                        @if($relatedService->image)
                                        <img src="{{ $relatedService->image }}" alt="{{ $relatedService->title }}" class="related-thumb">
                                        @else
                                        <div class="related-thumb-placeholder">
                                            <i class="{{ $relatedService->icon ?? 'fas fa-cog' }}"></i>
                                        </div>
                                        @endif
                                        <div class="related-content">
                                            <h6>{{ $relatedService->title }}</h6>
                                            @if($relatedService->price)
                                            <span class="price">${{ number_format($relatedService->price, 0) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="gt-faq-section fix section-padding bg-light">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">Frequently Asked Questions</h6>
            <h2 class="char-animation">Common Questions About {{ $service->title }}</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                What is included in this service?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                This service includes all the features listed above, along with our standard support and maintenance. Specific inclusions may vary based on your requirements.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                How long does it take to complete?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                The timeline depends on the complexity of your project. We typically complete most projects within 2-4 weeks, but we'll provide a detailed timeline during our consultation.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Do you provide ongoing support?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we provide ongoing support and maintenance for all our services. Our support team is available 24/7 to help you with any issues or questions.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.gt-service-detail-content {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.gt-service-image img {
    border-radius: 10px;
}

.gt-service-price .price {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
}

.gt-service-price .unit {
    color: #666;
    font-size: 1rem;
}

.gt-feature-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
}

.gt-service-cta {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    margin-top: 30px;
}

.gt-sidebar-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.gt-sidebar-card h5 {
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #667eea;
    padding-bottom: 10px;
}

.gt-service-info .info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.gt-service-info .info-item:last-child {
    border-bottom: none;
}

.gt-related-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.gt-related-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.gt-related-item a {
    text-decoration: none;
    color: inherit;
    transition: color 0.3s;
}

.gt-related-item a:hover {
    color: #667eea;
}

.related-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
}

.related-thumb-placeholder {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    margin-right: 15px;
}

.related-content h6 {
    margin: 0 0 5px 0;
    font-size: 0.9rem;
}

.related-content .price {
    color: #667eea;
    font-weight: 500;
    font-size: 0.8rem;
}

.accordion-button {
    background: white;
    border: none;
    font-weight: 500;
}

.accordion-button:not(.collapsed) {
    background: #667eea;
    color: white;
}

.accordion-button:focus {
    box-shadow: none;
    border: none;
}
</style>
@endpush
