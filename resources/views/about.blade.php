@extends('layouts.app')

@section('title', 'About Us - SupremeIT')
@section('cta-class', 'before-white')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">About <span>Us</span></h1>
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
                 About Us
                </li>
            </ul>
        </div>
    </div>
</div>

 <!-- Gt Brand Section Start -->
<div class="gt-brand-section section-padding pb-0">
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
</div>

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

<!-- Gt Web App Section Start -->
<section class="gt-web-app-section fix section-padding section-bg-4">
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

<!-- Gt News Section Start -->
<section class="gt-news-section-4 fix section-padding">
    <div class="container">
        <div class="gt-news-wrapper-4">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="gt-news-left">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="wow fadeInUp tt-capitalize">supremeit news</h6>
                            <h2>
                                Check Out Latest News Update & Articles
                            </h2>
                        </div>
                        <p class="gt-news-text wow fadeInUp" data-wow-delay=".3s">
                            Stay updated with our latest news, insights, and success stories to discover how we're helping businesses grow through smart marketing.
                        </p>
                        <a href="#" class="gt-theme-btn style-4 wow fadeInUp" data-wow-delay=".5s">view all news</a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="gt-news-box-items-3 style-3">
                                <div class="gt-thumb">
                                    <img src="{{ asset('assets/img/home-4/news/news-01.jpg') }}" alt="img">
                                    <img src="{{ asset('assets/img/home-4/news/news-01.jpg') }}" alt="img">
                                </div>
                                <div class="gt-content">
                                    <ul> 
                                        <li>
                                            Jun 28, 2025
                                        </li>
                                        <li>
                                            Seen 250
                                        </li>
                                    </ul>
                                    <h4>
                                        <a href="#">Why Loading Speed Can Make or Break Your App's Success</a>
                                    </h4>
                                    <span>
                                        <img src="{{ asset('assets/img/home-3/news/info.png') }}" alt="img">
                                        SupremeIT admin
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                            <div class="gt-news-box-items-3 style-3">
                                <div class="gt-thumb">
                                    <img src="{{ asset('assets/img/home-4/news/news-02.jpg') }}" alt="img">
                                    <img src="{{ asset('assets/img/home-4/news/news-02.jpg') }}" alt="img">
                                </div>
                                <div class="gt-content">
                                    <ul> 
                                        <li>
                                            Jun 28, 2025
                                        </li>
                                        <li>
                                            Seen 250
                                        </li>
                                    </ul>
                                    <h4>
                                        <a href="#">How to Integrate Analytics for Better App Landing Insights</a>
                                    </h4>
                                    <span>
                                        <img src="{{ asset('assets/img/home-3/news/info.png') }}" alt="img">
                                        SupremeIT admin
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
