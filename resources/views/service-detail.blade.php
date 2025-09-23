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


<!-- FAQ Section -->

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
