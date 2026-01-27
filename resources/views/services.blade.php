@extends('layouts.app')

@section('title', $page->title . ' - SupremeIT')
@section('page-title', $page->title)

@push('styles')
<style>
    .service-single-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .service-single-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .service-single-card .icon {
        height: 200px;
        overflow: hidden;
        position: relative;
        border-radius: 10px 10px 0 0;
    }

    .service-single-card .icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .service-single-card:hover .icon img {
        transform: scale(1.05);
    }

    .service-placeholder {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #6c757d;
    }

    .service-single-card .content {
        padding: 20px;
        background: #fff;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .service-single-card .content h3 {
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: 600;
    }

    .service-single-card .content h3 a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .service-single-card .content h3 a:hover {
        color: #007bff;
    }

    .service-single-card .content p {
        flex-grow: 1;
        margin-bottom: 15px;
        color: #666;
        line-height: 1.6;
    }

    .arrow-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .arrow-btn:hover {
        background: #0056b3;
        color: white;
        transform: scale(1.1);
    }

    .gt-feature-box {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 30px 20px;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        height: 100%;
    }

    .gt-feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .gt-feature-icon {
        margin-bottom: 20px;
    }

    .gt-feature-box h4 {
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .gt-feature-box p {
        color: #666;
        line-height: 1.6;
        margin: 0;
    }
</style>
@endpush

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ $page->image ? asset($page->image) : asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $page->breadcrumb_title !!}</h1>
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
                 Our Services
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Services Section Start -->
<section class="gt-services-section fix section-padding">
    <div class="container">
        @if(isset($page))
        <x-section-title
            :subtitle="$page->subtitle ?? 'What We Offer'"
            :title="$page->title ?? 'Our Services'"
            :description="$page->description ?? null"
            alignment="text-center"
        />
        @endif

        <div class="row g-4 pt-4">
            @forelse($services as $service)
                <x-service-card :service="$service" />
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4>No services available at the moment.</h4>
                    <p class="text-muted">Please check back later for our latest services.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="gt-why-choose-section fix section-padding bg-light">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">Why Choose Us</h6>
            <h2 class="char-animation">What Makes Us Different</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="gt-feature-box text-center h-100 d-flex flex-column">
                    <div class="gt-feature-icon">
                        <i class="fas fa-rocket fa-3x text-primary"></i>
                    </div>
                    <h4>Fast Delivery</h4>
                    <p>We deliver projects on time with high quality standards and attention to detail.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="gt-feature-box text-center h-100 d-flex flex-column">
                    <div class="gt-feature-icon">
                        <i class="fas fa-headset fa-3x text-primary"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Our dedicated support team is available around the clock to help you succeed.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="gt-feature-box text-center h-100 d-flex flex-column">
                    <div class="gt-feature-icon">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h4>Secure & Reliable</h4>
                    <p>We use industry best practices to ensure your data and systems are secure.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

