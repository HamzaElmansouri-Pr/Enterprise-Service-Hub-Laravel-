@extends('layouts.app')

@section('title', 'SupremeIT - Complete CRM Solution')
@section('body-class', 'body-bg-2')
@section('back-to-top-class', 'color-3')
@section('cursor-class', 'color-3')

@section('content')
<!-- Gt Hero Section Start -->
<section class="gt-hero-section gt-hero-3">
    <div class="hero-circle-shape">
        <img src="{{ asset('assets/img/home-3/hero-circle.png') }}" alt="img">
    </div>
    <div class="container">
        <div class="gt-hero-content">
            <h1 class="char-animation">
            @if($data['heroTitle'])
                {{ $data['heroTitle'] }}
            @else
                The complete CRM solution
                built for your success
            @endif
              
            </h1>
            <p class="wow fadeInUp" data-wow-delay=".3s">
            @if($data['heroSubtitle'])
                {{ $data['heroSubtitle'] }}
            @else
                {{-- All your customer data, tools, and insights in one unified platform. --}}
            @endif
            </p>
            <form action="#" class="wow fadeInUp" data-wow-delay=".5s">
                <input type="text"  placeholder="Enter Email">
                <button class="gt-theme-btn">
                    try for free
                </button>
            </form>
            <ul class="wow fadeInUp" data-wow-delay=".7s">
                <li>
                    <i class="fa-regular fa-circle-check"></i>
                    14-day free trial
                </li>
                <li>
                    <i class="fa-regular fa-circle-check"></i>
                    No credit card required
                </li>
                <li>
                    <i class="fa-regular fa-circle-check"></i>
                   Free support and migration
                </li>
            </ul>
        </div>
        {{-- <div class="gt-hero-image">
            <img src="{{ asset('assets/img/home-3/hero/hero-image.png') }}" alt="img">
            <div class="gt-hero-left">
                <img src="{{ asset('assets/img/home-3/hero/hero-left.png') }}" alt="img">
            </div>
            <div class="gt-hero-right">
                <img src="{{ asset('assets/img/home-3/hero/hero-right.png') }}" alt="img">
            </div>
        </div> --}}
        <style>
        /* Style for the main slider container */
.slider-container {
    position: relative;
    width: 100%;
    height: 591px;
    overflow: hidden; /* This hides images that are outside the view */
}

/* Style for each individual slider item */
.slider-item {
    display: none; /* Hide all slides by default */
    width: 100%;
    height:100%
    /* Add a transition for a smooth fade effect */
    transition: opacity 0.5s ease-in-out;
}

/* Show only the active slide */
.slider-item.active {
    display: block;
}

/* Basic button styling */
.prev-btn, .next-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 18px;
}

.prev-btn {
    left: 10px;
}

.next-btn {
    right: 10px;
}
        </style>
        <div class="gt-hero-image">
    <div class="slider-container">
        @foreach($sliders as $slider)
            <div class="slider-item active">
                <img  src="{{ asset($slider['image']) }}" alt="img">
            </div>
        @endforeach
        {{-- <div class="slider-item active">
            <img  src="{{ asset('assets/img/home-3/hero/hero-image.png') }}" alt="img">
        </div>
        <div class="slider-item">
            <img  src="{{ asset('assets/img/home-3/hero/hero-left.png') }}" alt="img">
        </div>
        <div class="slider-item">
            <img  src="{{ asset('assets/img/home-3/hero/hero-right.png') }}" alt="img">
        </div> --}}
    </div>

    <button class="prev-btn">Previous</button>
    <button class="next-btn">Next</button>
</div>
    </div>
</section>

<!-- sider js -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const sliderItems = document.querySelectorAll('.slider-item');
    let currentIndex = 0;

    // Function to show a specific slide
    function showSlide(index) {
        // Hide all slides
        sliderItems.forEach(item => {
            item.classList.remove('active');
        });
        
        // Show the slide at the specified index
        sliderItems[index].classList.add('active');
    }

    // Event listener for the "Next" button
    nextBtn.addEventListener('click', () => {
        currentIndex++;
        if (currentIndex >= sliderItems.length) {
            currentIndex = 0; // Loop back to the first slide
        }
        showSlide(currentIndex);
    });

    // Event listener for the "Previous" button
    prevBtn.addEventListener('click', () => {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = sliderItems.length - 1; // Loop to the last slide
        }
        showSlide(currentIndex);
    });

    // Initial call to show the first slide
    showSlide(currentIndex);
});
</script>

<!-- Gt Brand Section Start -->

{{-- <div class="gt-brand-section section-padding pb-0">
    <div class="container">
        <div class="gt-brand-wrapper">
            <h5 class="color-3 pt-0 char-animation">TRUSTED BY <b>15,000+</b> CUSTOMERS</h5>
            <div class="swiper gt-brand-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="gt-brand-image text-center hover-2">
                            <img src="{{ asset('assets/img/home-1/brand/brand-01.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gt-brand-image text-center hover-2">
                            <img src="{{ asset('assets/img/home-1/brand/brand-02.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gt-brand-image text-center hover-2">
                            <img src="{{ asset('assets/img/home-1/brand/brand-03.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gt-brand-image text-center hover-2">
                            <img src="{{ asset('assets/img/home-1/brand/brand-04.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gt-brand-image text-center hover-2">
                            <img src="{{ asset('assets/img/home-1/brand/brand-05.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gt-brand-image text-center hover-2">
                            <img src="{{ asset('assets/img/home-1/brand/brand-06.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Gt About Section Start -->
<section class="gt-about-section fix section-padding pt-0">
    <div class="container">
        <div class="gt-about-wrapper-3 section-padding pb-0">
            <div class="clicp-shape">
                <img src="{{ asset('assets/img/new-add/clip-path.png') }}" alt="img">
            </div>
            <div class="row g-4">
                <div class="col-xl-6">
                    <div class="gt-about-content">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="tt-capitalize wow fadeInUp">Why SupremeIT crm</h6>
                            <h2 class="char-animation">
                                Deliver unforgettable
                                customer experiences
                            </h2>
                        </div>
                        <p class="gt-text wow fadeInUp" data-wow-delay=".3s">
                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                        </p>
                        <ul class="gt-list-items wow fadeInUp" data-wow-delay=".5s">
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>All-in-One CRM</h4>
                                    <span>
                                        Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.
                                    </span>
                                </div>
                            </li>
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>Affordable</h4>
                                    <span>
                                       Make the most of SupremeIT's modern features & integrations, easy implementation and great support at an affordable price.
                                    </span>
                                </div>
                            </li>
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>Next-Generation</h4>
                                    <span>
                                       Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="gt-about-image agn-choose-5-img">
                       
                        <div class="crm-imagewow wow fadeInRight" data-wow-delay=".3s">
                            <img src="{{ asset('assets/img/new-add/crm-img.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Gt Feature Section Start -->
<section class="gt-feature-section-3 fix section-padding pt-0">
    <div class="gt-feature-focus-wrapper section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="gt-feature-image">
                        <img src="{{ asset('assets/img/home-3/feature-focus.png') }}" alt="img" class="appear_left">
                        <div class="bg-shape">
                            <img src="{{ asset('assets/img/home-3/focus-bg.png') }}" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gt-feature-content">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="text-white tt-capitalize wow fadeInUp">Smarter Automation</h6>
                            <h2 class="text-white char-animation">
                                Automate the busy work,
                                focus on what matters
                            </h2>
                        </div>
                        <div class="gt-counter-items">
                            <div class="gt-counter wow fadeInUp" data-wow-delay=".3s">
                                <h2>
                                   <span class="gt-count">92</span> %
                                </h2>
                                <p>Improvement in Customer Satisfaction</p>
                            </div>
                            <div class="gt-counter wow fadeInUp" data-wow-delay=".5s">
                                <h2>
                                   <span class="gt-count">48</span> %
                                </h2>
                                <p>Reduction in Operational Costs</p>
                            </div>
                        </div>
                        <p class="text text-white wow fadeInUp" data-wow-delay=".7s">
                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                        </p>
                        <div class="gt-btn-all wow fadeInUp" data-wow-delay=".9s">
                            <a href="{{ route('contact') }}" class="gt-theme-btn style-3">get started</a>
                            <a href="{{ route('contact') }}" class="gt-theme-btn style-3 style-border">view demo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gt Feature Benefit Section Start -->
<section class="gt-feature-benefit-section section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">key features</h6>
            <h2 class="char-animation">
               SupremeIT key benefits
            </h2>
            <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">
                Flexible experiences that scale with your growth and <br> deliver faster time to value
            </p>
        </div>
        <div class="gt-feature-benefit-wrapper">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="gt-feature-benefit-items">
                        <div class="bg-shape">
                            <img src="{{ asset('assets/img/new-add/bg-share.png') }}" alt="">
                        </div>
                        <ul>
                            <li class="sticky-fixed-panel2">
                                <div class="gt-benefit-content">
                                    <h3>Centralized customer data</h3>
                                    <p>
                                        Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                                    </p>
                                    <span class="gt-number">
                                        01
                                    </span>
                                </div>
                            </li>
                            <li class="sticky-fixed-panel2">
                                <div class="gt-benefit-content">
                                    <h3>Sales pipeline tracking</h3>
                                    <p>
                                        Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                                    </p>
                                    <span class="gt-number">
                                        02
                                    </span>
                                </div>
                            </li>
                            <li class="sticky-fixed-panel2">
                                <div class="gt-benefit-content">
                                    <h3>Automated follow-ups & reminders</h3>
                                    <p>
                                        Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                                    </p>
                                    <span class="gt-number">
                                        03
                                    </span>
                                </div>
                            </li>
                            <li class="sticky-fixed-panel2">
                                <div class="gt-benefit-content">
                                    <h3>Task & activity management</h3>
                                    <p>
                                        Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                                    </p>
                                    <span class="gt-number">
                                        04
                                    </span>
                                </div>
                            </li>
                            <li class="sticky-fixed-panel2">
                                <div class="gt-benefit-content">
                                    <h3>Real-time reporting & analytics</h3>
                                    <p>
                                        Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                                    </p>
                                    <span class="gt-number">
                                        05
                                    </span>
                                </div>
                            </li>
                            <li class="sticky-fixed-panel2">
                                <div class="gt-benefit-content">
                                    <h3>Seamless integrations</h3>
                                    <p>
                                        Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                                    </p>
                                    <span class="gt-number">
                                        06
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gt-feature-box-image sticky-style">
                        <div class="bg-shape">
                            <img src="{{ asset('assets/img/home-3/benefit-bg.png') }}" alt="img">
                        </div>
                        <div class="image-1 top_view_2 itop_view_2 item-hover">
                            <img src="{{ asset('assets/img/home-3/benefit-img-1.png') }}" alt="img">
                        </div>
                        <div class="image-2 wow fadeInUp top_view_2 item-hover">
                            <img src="{{ asset('assets/img/home-3/benefit-img-2.png') }}" alt="img">
                        </div>
                        <div class="image-3 top_view_2 top_view_2 item-hover">
                             <img src="{{ asset('assets/img/home-3/benefit-img-3.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gt Contact Management Section Start -->
<section class="gt-contact-management-section pb-0 fix section-padding bg-cover" style="background-image: url('{{ asset('assets/img/home-3/contact-managenment-bg.jpg') }}');">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">Contact Management</h6>
            <h2 class="char-animation">
             Build powerful customer relationships
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="gt-contact-managenment-image text-center mt-30 top_view_2 item-hover">
                    <div class="shape-3">
                        <img src="{{ asset('assets/img/new-add/shape3.png') }}" alt="">
                    </div>
                    <img src="{{ asset('assets/img/home-3/customer-img.png') }}" alt="img" class="w-100">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gt Product Tour Section Start -->
<section class="gt-product-tour-section fix section-padding">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
                <h6 class="wow fadeInUp tt-capitalize">supremeit screenshots</h6>
                <h2 class="char-animation">
                    Take a product tour
                </h2>
            </div>
        <div class="gt-product-tour-wrapper">
            <div class="swiper gt-product-tour-slider">
                <div class="swiper-wrapper">
                     <div class="swiper-slide">
                        <div class="gt-product-tour-image">
                            <img src="{{ asset('assets/img/home-3/product-tour/product-tour-01.png') }}" alt="img">
                        </div>
                    </div>
                <div class="swiper-slide">
                    <div class="gt-product-tour-image">
                        <img src="{{ asset('assets/img/home-3/product-tour/product-tour-02.png') }}" alt="img">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="gt-product-tour-image">
                        <img src="{{ asset('assets/img/home-3/product-tour/product-tour-03.png') }}" alt="img">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="gt-product-tour-image">
                        <img src="{{ asset('assets/img/home-3/product-tour/product-tour-03.png') }}" alt="img">
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="gt-product-dot">
            <span class="dot-content">
                <span>SupremeIT dashboard</span>
            </span>
            <span class="dot-content">
               <span>Anomaly detection</span>
            </span>
            <span class="dot-content">
              <span>Best time to contact</span>
            </span>
            <span class="dot-content">
              <span>Sentiment analysis</span>
            </span>
        </div>
    </div>
</section>

<!-- Gt Why Choose Section Start -->
<section class="gt-why-choose-us-section-3">
    <div class="gt-why-choose-us-wrapper-3 section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="gt-choose-us-image appear_left">
                        <img src="{{ asset('assets/img/home-3/choose-us.png') }}" alt="img">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gt-choose-us-content">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="text-white tt-capitalize wow fadeInUp">Why SupremeIT crm</h6>
                            <h2 class="text-white char-animation">
                               Stop using slow, bulky CRMs. choose SupremeIT
                            </h2>
                        </div>
                        <div class="faq-items mt-0 ms-0">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                                    <h2 class="accordion-header" id="headingfour">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                       Flexible and transparent pricing
                                        </button>
                                    </h2>
                                    <div id="collapsefour" class="accordion-collapse collapse show" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Built for the way sales teams actually sell
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-0 wow fadeInUp" data-wow-delay=".7s">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                       Designed for small businesses and startups
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        <p>
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="gt-theme-btn style-3 wow fadeInUp" data-wow-delay=".9s">get started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gt Web App Section Start -->
<section class="gt-web-app-section fix section-padding">
    <div class="container">
        <div class="gt-web-app-wrapper">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="gt-web-app-content">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="wow fadeInUp tt-capitalize">integration web apps</h6>
                            <h2 class="char-animation">
                               Everything you need to <br> close a deal, all in one spot
                            </h2>
                        </div>
                        <p class="web-text wow fadeInUp" data-wow-delay=".3s">
                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                        </p>
                        <div class="gt-client-box-items top_view_2 item-hover">
                            <p>
                                Keep all your contacts, deals, and interactions in one place. No more hunting through emails or spreadsheets — get a 360° view of every customer.
                            </p>
                            <div class="gt-info">
                                <img src="{{ asset('assets/img/home-3/client.png') }}" alt="img">
                                <span><b>Erika Neeley,</b> Women Rocking Business</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="gt-web-app-image agn-choose-5-img">
                        <div class="web-app wow fadeInRight" data-wow-delay=".3s">
                            <img src="{{ asset('assets/img/new-add/web-app.png') }}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
