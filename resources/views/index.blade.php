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

    <button class="prev-btn" aria-label="Previous slide"><i class="fa-solid fa-chevron-left"></i></button>
    <button class="next-btn" aria-label="Next slide"><i class="fa-solid fa-chevron-right"></i></button>
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

<!-- Home Content Sections (About, Services, Projects, Reviews, TC, Contact) -->
<section class="gt-about-section fix section-padding pt-0">
    <div class="container">
        <div class="gt-about-wrapper-3 section-padding pb-0">
            <div class="row g-4 align-items-center">
                <div class="col-xl-6 order-xl-1 order-1">
                    <div class="gt-about-content">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="tt-capitalize wow fadeInUp">{{ optional($about)->subtitle ?? 'Why SupremeIT crm' }}</h6>
                            <h2 class="char-animation">{{ optional($about)->title ?? 'Deliver unforgettable customer experiences' }}</h2>
                        </div>
                        <p class="gt-text wow fadeInUp" data-wow-delay=".3s">{{ optional($about)->description ?? "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage" }}</p>
                        @php($homeFeatures = optional($about)->meta_data['features'] ?? [])
                        @if(!empty($homeFeatures))
                        <ul class="gt-list-items wow fadeInUp" data-wow-delay=".5s">
                            @foreach($homeFeatures as $feat)
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>{{ $feat['title'] ?? '' }}</h4>
                                    <span>{{ $feat['description'] ?? '' }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <ul class="gt-list-items wow fadeInUp" data-wow-delay=".5s">
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>All-in-One CRM</h4>
                                    <span>Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.</span>
                                </div>
                            </li>
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>Affordable</h4>
                                    <span>Make the most of SupremeIT's modern features & integrations, easy implementation and great support at an affordable price.</span>
                                </div>
                            </li>
                            <li>
                                <span class="gt-circle-box"></span>
                                <div class="gt-content">
                                    <h4>Next-Generation</h4>
                                    <span>Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.</span>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 order-xl-0 order-0">
                    <div class="gt-about-image agn-choose-5-img home-about-circle-wrapper d-flex align-items-center justify-content-center">
                        <style>
                            .agn-choose-5-img { position: relative; }
                            .home-about-circle { width: 100%; aspect-ratio: 1 / 1; border-radius: 50%; overflow: hidden; }
                            .home-about-circle img { width: 100%; height: 100%; object-fit: cover; display: block; }
                        </style>
                        <div class="crm-imagewow wow fadeInRight" data-wow-delay=".3s">
                            <div class="home-about-circle">
                                @if(optional($about)->image)
                                    <img src="{{ asset($about->image) }}" alt="About image">
                                @else
                                    <img src="{{ asset('assets/img/new-add/crm-img.png') }}" alt="About image">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

<!-- Our Services Section Start -->
<section class="gt-services-section fix section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">our services</h6>
            <h2 class="char-animation">What We Offer</h2>
        </div>
        <div class="row g-4">
            @forelse($services as $service)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="service-single-card h-100 d-flex flex-column">
                    <div class="icon">
                        @if($service->image)
                        <img src="{{ asset($service->image) }}" alt="{{ $service->title }}">
                        @else
                        <div class="service-placeholder d-flex align-items-center justify-content-center">
                            <i class="{{ $service->icon ?? 'fas fa-cog' }} fa-3x"></i>
                        </div>
                        @endif
                    </div>
                    <div class="content">
                        <h3><a href="{{ route('service.detail', $service) }}">{{ $service->title }}</a></h3>
                        @if($service->subtitle)
                        <p class="text-muted">{{ $service->subtitle }}</p>
                        @endif
                        <p>{{ Str::limit($service->description, 110) }}</p>
                        <a href="{{ route('service.detail', $service) }}" class="arrow-btn"><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4>No services available at the moment.</h4>
                </div>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('services') }}" class="gt-theme-btn">view all services</a>
        </div>
    </div>
</section>

<!-- Our Projects Section Start -->
<section class="case-studies-section-4 fix section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">our projects</h6>
            <h2 class="char-animation">Recent Work</h2>
        </div>
        <div class="row g-4">
            @forelse($projects as $project)
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="case-studies-card-items mt-0 h-100 d-flex flex-column">
                    <div class="thumb" style="height: 420px; overflow: hidden;">
                        @if($project->image)
                        <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                        <div class="project-placeholder d-flex align-items-center justify-content-center h-100 bg-light">
                            <i class="fas fa-project-diagram fa-3x text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="content">
                        <div class="title">
                            <h3><a href="{{ route('project.detail', $project) }}">{{ $project->title }}</a></h3>
                            @if($project->category)
                            <p>{{ $project->category }}</p>
                            @endif
                        </div>
                        <a href="{{ route('project.detail', $project) }}" class="icon"><i class="fa-regular fa-arrow-up-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4>No projects available at the moment.</h4>
                </div>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('projects') }}" class="gt-theme-btn">view all projects</a>
        </div>
    </div>
</section>

<!-- Reviews Section Start -->
<section class="gt-testimonial-section fix section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">client reviews</h6>
            <h2 class="char-animation">What our clients say</h2>
        </div>
        <div class="row g-4">
            @forelse($reviews as $review)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="gt-feature-box h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3" style="width:56px;height:56px;overflow:hidden;border-radius:50%;background:#f1f3f5;display:flex;align-items:center;justify-content:center;">
                            @if($review->client_image)
                                <img src="{{ asset($review->client_image) }}" alt="{{ $review->client_name }}" class="w-100 h-100" style="object-fit:cover;">
                            @else
                                <i class="fas fa-user text-muted"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $review->client_name }}</h5>
                            <small class="text-muted">{{ $review->client_position }} @ {{ $review->client_company }}</small>
                        </div>
                    </div>
                    <p class="mb-2">{{ Str::limit($review->review_text, 180) }}</p>
                    @if($review->rating)
                    <div class="text-warning">
                        @for($i=0;$i<5;$i++)
                            <i class="fa{{ $i < $review->rating ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4>No reviews available at the moment.</h4>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- TC Request Section Start -->
<section class="gt-contact-section fix section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">request a quote</h6>
            <h2 class="char-animation">Tell us about your project</h2>
            <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">
                Ready to start? Contact us and we’ll get back to you quickly.
            </p>
            <div class="mt-4">
                <a href="{{ route('contact') }}" class="gt-theme-btn">Go to Contact Page</a>
            </div>
        </div>
    </div>
</section>

{{-- <!-- Contact Section Start -->
<section class="gt-contact-section fix section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">get in touch</h6>
            <h2 class="char-animation">Ready to get started?</h2>
            <div class="mt-4">
                <a href="{{ route('contact') }}" class="gt-theme-btn">Go to Contact Page</a>
            </div>
        </div>
    </div>
</section> --}}






@endsection
