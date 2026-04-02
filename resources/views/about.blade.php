@extends('layouts.app')

@section('title', 'About Us - Nova Agency')
@section('cta-class', 'before-white')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset($page->image ?? 'assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $page->breadcrumb_title ?? 'About <span>Us</span>' !!}</h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li>About Us</li>
            </ul>
        </div>
    </div>
</div>

<style>
    /* Section General */
    .section-header { margin-bottom: 50px; }
    .gt-section-title.style-3 h6 { color: var(--gt-primary-color); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; display: block; }
    .gt-section-title.style-3 h2 { font-size: 42px; line-height: 1.2; font-weight: 800; color: #1a1a1a; margin-bottom: 20px; }

    /* Enhanced About Main Section */
    .gt-about-content .gt-text { 
        font-size: 18px; 
        line-height: 1.8; 
        color: #555; 
        margin-bottom: 35px; 
        position: relative;
        padding-left: 20px;
        border-left: 4px solid var(--gt-primary-color);
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }
    
    .feature-card-mini {
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        gap: 15px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .feature-card-mini:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--gt-primary-color);
    }
    
    .feature-card-mini .icon-box {
        width: 50px;
        height: 50px;
        background: rgba(var(--gt-primary-color-rgb), 0.1);
        color: var(--gt-primary-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .feature-card-mini h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: #1a1a1a;
    }
    
    .feature-card-mini p {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    /* Stats Section */
    .about-stats-section { background: #f8f9fa; padding: 80px 0; border-radius: 50px; margin: 40px 0; }
    .stat-card { text-align: center; padding: 30px; transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-10px); }
    .stat-icon { font-size: 40px; color: var(--gt-primary-color); margin-bottom: 20px; display: inline-block; }
    .stat-number { font-size: 48px; font-weight: 800; color: #1a1a1a; margin-bottom: 5px; }
    .stat-label { font-size: 16px; font-weight: 600; color: #666; text-transform: uppercase; letter-spacing: 1px; }

    /* Values Section */
    .value-card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); height: 100%; transition: all 0.3s ease; border: 1px solid #eee; }
    .value-card:hover { border-color: var(--gt-primary-color); transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .value-icon { width: 60px; height: 60px; background: rgba(var(--gt-primary-color-rgb), 0.1); color: var(--gt-primary-color); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 25px; }
    .value-card h4 { font-size: 22px; font-weight: 700; margin-bottom: 15px; color: #1a1a1a; }
    .value-card p { color: #666; line-height: 1.7; margin-bottom: 0; }

    /* Timeline Section */
    .timeline-wrapper { position: relative; padding: 40px 0; }
    .timeline-wrapper::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: #eee; transform: translateX(-50%); }
    .timeline-item { margin-bottom: 60px; position: relative; }
    .timeline-dot { position: absolute; left: 50%; top: 0; width: 20px; height: 20px; background: var(--gt-primary-color); border-radius: 50%; transform: translateX(-50%); z-index: 1; border: 4px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .timeline-content { width: 45%; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); position: relative; }
    .timeline-item:nth-child(even) .timeline-content { margin-left: auto; }
    .timeline-year { font-weight: 800; color: var(--gt-primary-color); font-size: 18px; margin-bottom: 10px; display: block; }
    .timeline-content h4 { font-size: 20px; font-weight: 700; margin-bottom: 10px; }
    
    /* Team Section */
    .team-card { position: relative; border-radius: 20px; overflow: hidden; margin-bottom: 30px; }
    .team-img { position: relative; aspect-ratio: 3/4; overflow: hidden; }
    .team-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .team-card:hover .team-img img { transform: scale(1.1); }
    .team-info { padding: 25px; text-align: center; background: #fff; position: relative; z-index: 2; margin-top: -40px; width: 85%; margin-left: auto; margin-right: auto; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .team-info h4 { font-size: 20px; font-weight: 700; margin-bottom: 5px; }
    .team-info span { color: var(--gt-primary-color); font-weight: 600; font-size: 14px; text-transform: uppercase; }
    .team-social { margin-top: 15px; display: flex; justify-content: center; gap: 15px; }
    .team-social a { color: #ccc; transition: color 0.3s; }
    .team-social a:hover { color: var(--gt-primary-color); }

    @media (max-width: 768px) {
        .timeline-wrapper::before { left: 20px; }
        .timeline-dot { left: 20px; }
        .timeline-content { width: calc(100% - 60px); margin-left: 60px !important; }
        .gt-section-title.style-3 h2 { font-size: 32px; }
    }
</style>

<!-- Main About Section -->
@if(!empty($page->about->title))
<section class="gt-about-section fix section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-xl-6">
                <div class="gt-about-content">
                    <div class="gt-section-title style-3 mb-0">
                        <h6 class="wow fadeInUp">{{ $page->about->subtitle ?? 'Our Identity' }}</h6>
                        <h2 class="char-animation">{{ $page->about->title ?? 'Pioneering Digital Excellence' }}</h2>
                    </div>
                    @if(!empty($page->about->description))
                        <div class="gt-text wow fadeInUp" data-wow-delay=".3s">
                            {!! nl2br(e($page->about->description)) !!}
                        </div>
                    @endif
                    @if(!empty($page->about->content))
                        <div class="wow fadeInUp" data-wow-delay=".5s">{!! $page->about->content !!}</div>
                    @endif
                    
                    @php($features = $page->about->meta_data['features'] ?? [])
                    @if(!empty($features))
                    <div class="features-grid wow fadeInUp" data-wow-delay=".5s">
                        @foreach($features as $feat)
                        <div class="feature-card-mini">
                            <div class="icon-box">
                                @if(str_contains(strtolower($feat['title'] ?? ''), 'innovation'))
                                    <i class="fa-solid fa-lightbulb"></i>
                                @elseif(str_contains(strtolower($feat['title'] ?? ''), 'centric'))
                                    <i class="fa-solid fa-user-gear"></i>
                                @elseif(str_contains(strtolower($feat['title'] ?? ''), 'excellence'))
                                    <i class="fa-solid fa-award"></i>
                                @else
                                    <i class="fa-solid fa-check-to-slot"></i>
                                @endif
                            </div>
                            <div class="content">
                                <h4>{{ $feat['title'] ?? '' }}</h4>
                                <p>{{ $feat['description'] ?? '' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xl-6">
                <div class="gt-about-image text-center">
                    <div class="about-aspect-circle wow fadeInRight" data-wow-delay=".3s" style="max-width: 500px; margin: 0 auto; border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.15);">
                        <img src="{{ asset($page->about->image ?? 'assets/img/about/about-5.png') }}" alt="About Image" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Stats Section -->
@if(!empty($page->stats->items))
<section class="about-stats-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach($page->stats->items as $stat)
            <div class="col-lg-3 col-md-6">
                <div class="stat-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <div class="stat-icon"><i class="{{ $stat['icon'] ?? 'fa-solid fa-check' }}"></i></div>
                    <div class="stat-number"><span class="gt-count">{{ $stat['number'] ?? '0' }}</span>{{ $stat['suffix'] ?? '' }}</div>
                    <div class="stat-label">{{ $stat['label'] ?? '' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Core Values Section -->
@if(!empty($page->values->items))
<section class="values-section section-padding">
    <div class="container">
        <div class="section-header text-center">
            <div class="gt-section-title style-3">
                <h6 class="wow fadeInUp">{{ $page->values->subtitle ?? 'Our Values' }}</h6>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $page->values->title ?? 'The Tenets That Drive Us' }}</h2>
            </div>
        </div>
        <div class="row g-4">
            @foreach($page->values->items as $value)
            <div class="col-lg-4">
                <div class="value-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 }}s">
                    <div class="value-icon"><i class="{{ $value['icon'] ?? 'fa-solid fa-gem' }}"></i></div>
                    <h4>{{ $value['title'] ?? '' }}</h4>
                    <p>{{ $value['description'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- History/Timeline Section -->
@if(!empty($page->history->milestones))
<section class="history-section section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <div class="gt-section-title style-3">
                <h6 class="wow fadeInUp">{{ $page->history->subtitle ?? 'Our Journey' }}</h6>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $page->history->title ?? 'From Startup to Powerhouse' }}</h2>
            </div>
        </div>
        <div class="timeline-wrapper">
            @foreach($page->history->milestones as $milestone)
            <div class="timeline-item wow {{ $loop->iteration % 2 == 0 ? 'fadeInRight' : 'fadeInLeft' }}">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">{{ $milestone['year'] ?? '' }}</span>
                    <h4>{{ $milestone['title'] ?? '' }}</h4>
                    <p>{{ $milestone['description'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Team Section -->
@if(!empty($page->team->members))
<section class="team-section section-padding">
    <div class="container">
        <div class="section-header text-center">
            <div class="gt-section-title style-3">
                <h6 class="wow fadeInUp">{{ $page->team->subtitle ?? 'Meet The Team' }}</h6>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $page->team->title ?? 'The Experts Behind Our Success' }}</h2>
            </div>
        </div>
        <div class="row g-4">
            @foreach($page->team->members as $member)
            <div class="col-lg-3 col-md-6">
                <div class="team-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <div class="team-img">
                        <img src="{{ asset($member['image'] ?? 'assets/img/team/01.jpg') }}" alt="{{ $member['name'] ?? '' }}">
                    </div>
                    <div class="team-info">
                        <h4>{{ $member['name'] ?? '' }}</h4>
                        <span>{{ $member['position'] ?? '' }}</span>
                        <div class="team-social">
                            @if(!empty($member['facebook']))<a href="{{ $member['facebook'] }}"><i class="fa-brands fa-facebook-f"></i></a>@endif
                            @if(!empty($member['twitter']))<a href="{{ $member['twitter'] }}"><i class="fa-brands fa-twitter"></i></a>@endif
                            @if(!empty($member['linkedin']))<a href="{{ $member['linkedin'] }}"><i class="fa-brands fa-linkedin-in"></i></a>@endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section section-padding pt-0">
    <div class="container">
        <div class="cta-wrapper bg-cover wow fadeInUp" style="background: var(--gt-primary-color); padding: 60px; border-radius: 30px; text-align: center; color: #fff;">
            <h2 class="text-white mb-3 wow fadeInUp">Ready to build something together?</h2>
            <p class="text-white opacity-75 mb-4 wow fadeInUp" data-wow-delay=".2s">Get in touch with us today to discuss your next big project.</p>
            <div class="gt-btn-all justify-content-center wow fadeInUp" data-wow-delay=".4s">
                <a href="{{ route('contact') }}" class="gt-theme-btn style-3">Get Started Now <i class="fa-solid fa-arrow-right-long ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

@endsection
