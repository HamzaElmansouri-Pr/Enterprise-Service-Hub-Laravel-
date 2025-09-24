@extends('layouts.app')

@section('title', $service->title . ' - SupremeIT')
@section('page-title', $service->title)

@section('content')
<!-- Gt Breadcrumb Section Start (matching classes/tags) -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Services <span>Details</span> </h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                 Services Details 
                </li>
            </ul>
        </div>
    </div>
</div>

<section class="service-details-section section-padding">
    <div class="container">
        <div class="service-details-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="details-image">
                        <img src="{{ $service->image ? asset($service->image) : asset('assets/img/inner/service/service-details-1.jpg') }}" alt="{{ $service->title }}">
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-12 col-lg-4">
                    <div class="main-sidebar sticky-style">
                        <div class="single-sidebar-widget">
                            <div class="wid-title">
                                <h4>All Services</h4>
                            </div>
                            <div class="service-widget-categories">
                                <ul>
                                    <li class="active"><a href="{{ route('services') }}">{{ $service->title }}</a><span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                    <li><a href="{{ route('services') }}">All Services</a> <span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="service-details-content">
                        <h3>
                            {{ $service->title }}
                        </h3>
                        @if(!empty($service->subtitle))
                        <p class="mb-4">
                            {{ $service->subtitle }}
                        </p>
                        @endif
                        @if(!empty($service->description))
                        <p class="mb-4">
                            {!! nl2br(e($service->description)) !!}
                        </p>
                        @endif
                        <h3>
                            What We Provide
                        </h3>
                        <p class="mb-5">
                            We provide tailored solutions for your business needs.
                        </p>
                        <div class="thumb">
                            <img src="{{ $service->image ? asset($service->image) : asset('assets/img/inner/service/service-details-2.jpg') }}" alt="{{ $service->title }}">
                        </div>
                        <h3>
                            The Challange
                        </h3>
                        <p>
                            @if(!empty($service->description))
                                {!! nl2br(e($service->description)) !!}
                            @else
                                We tailor our solution to your goals and constraints to deliver impact.
                            @endif
                        </p>
                        <div class="details-list-items">
                            @php $features = is_array($service->features) ? $service->features : []; @endphp
                            @if(count($features))
                            <ul class="details-list">
                                @foreach($features as $index => $feature)
                                    @if($index % 2 === 0)
                                    <li><i class="fa-solid fa-circle-check"></i>{{ $feature }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            <ul class="details-list">
                                @foreach($features as $index => $feature)
                                    @if($index % 2 === 1)
                                    <li><i class="fa-solid fa-circle-check"></i>{{ $feature }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            @else
                            <ul class="details-list">
                                <li><i class="fa-solid fa-circle-check"></i>Quality delivery</li>
                                <li><i class="fa-solid fa-circle-check"></i>Clear communication</li>
                            </ul>
                            <ul class="details-list">
                                <li><i class="fa-solid fa-circle-check"></i>On-time milestones</li>
                                <li><i class="fa-solid fa-circle-check"></i>Post-launch support</li>
                            </ul>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="gt-faq-wrapper mt-5">
                        <div class="accordion style-inner" id="accordionExample2">
                            <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                                <h2 class="accordion-header" id="headingOne1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                        What is {{ config('app.name') }}?
                                    </button>
                                </h2>
                                <div id="collapseOne1" class="accordion-collapse collapse" aria-labelledby="headingOne1" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p>
                                            We provide {{ strtolower($service->title) }} services tailored to your needs.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                <h2 class="accordion-header" id="headingfour2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour2" aria-expanded="true" aria-controls="collapsefour2">
                                        Do you offer a free consultation?
                                    </button>
                                </h2>
                                <div id="collapsefour2" class="accordion-collapse collapse show" aria-labelledby="headingfour2" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p>
                                            Yes, contact us to schedule a discovery call.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow fadeInUp" data-wow-delay=".7s">
                                <h2 class="accordion-header" id="headingTwo3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                                        How quickly can we start?
                                    </button>
                                </h2>
                                <div id="collapseTwo3" class="accordion-collapse collapse" aria-labelledby="headingTwo3" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p>
                                            Typically within one week after scoping your requirements.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                                <h2 class="accordion-header" id="headingthree4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree4" aria-expanded="false" aria-controls="collapsethree4">
                                        What deliverables will I receive?
                                    </button>
                                </h2>
                                <div id="collapsethree4" class="accordion-collapse collapse" aria-labelledby="headingthree4" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p>
                                            A complete implementation plan, assets, and documentation.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                <h2 class="accordion-header" id="headingthree1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree1" aria-expanded="false" aria-controls="collapsethree1">
                                        What does pricing look like?
                                    </button>
                                </h2>
                                <div id="collapsethree1" class="accordion-collapse collapse" aria-labelledby="headingthree1" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <p>
                                            {{ $service->price ? 'Starting at $'.number_format($service->price, 2).($service->price_unit ? ' / '.$service->price_unit : '') : 'Contact us for a custom quote.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

