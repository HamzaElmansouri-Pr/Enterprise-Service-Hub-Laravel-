@extends('layouts.app')

@section('title', 'About Us - Nova Agency')
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
                            <h6 class="tt-capitalize wow fadeInUp">{{ optional($page)->subtitle ?? 'Why Nova Agency crm' }}</h6>
                            <h2 class="char-animation">
                                {{ optional($page)->title ?? 'Deliver unforgettable customer experiences' }}
                            </h2>
                        </div>
                        @if(optional($page)->description)
                        <p class="gt-text wow fadeInUp" data-wow-delay=".3s">{{ $page->description }}</p>
                        @endif
                        @if(optional($page)->content)
                        <div class="wow fadeInUp" data-wow-delay=".5s">{!! $page->content !!}</div>
                        @endif
                        @php($features = optional($page)->meta_data['features'] ?? [])
                        @if(!empty($features))
                        <ul class="gt-list-items wow fadeInUp" data-wow-delay=".5s">
                            @foreach($features as $feat)
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>{{ $feat['title'] ?? '' }}</h4>
                                    <span>{{ $feat['description'] ?? '' }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="gt-about-image agn-choose-5-img">
                        <style>
                            .agn-choose-5-img { position: relative; }
                            .about-aspect-circle { width: 100%; aspect-ratio: 1 / 1; border-radius: 50%; overflow: hidden; }
                            .about-aspect-circle img { width: 100%; height: 100%; object-fit: cover; display: block; }
                        </style>
                        <div class="crm-imagewow wow fadeInRight" data-wow-delay=".3s">
                            <div class="about-aspect-circle">
                                @if($page->image)
                                    <img src="{{ asset($page->image) }}" alt="">
                                @else
                                    <img src="{{ asset('assets/img/new-add/crm-img.png') }}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

 <!-- Gt Feature Section Start -->
{{-- <section class="gt-feature-section-3 fix section-padding pt-0">
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
</section> --}}


@endsection
