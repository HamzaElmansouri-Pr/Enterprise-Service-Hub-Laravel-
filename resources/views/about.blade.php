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
    /* Elite Pro Color Palette */
    :root {
        --gt-primary-color: #2563eb; /* Pro Royal Blue */
        --gt-primary-color-rgb: 37, 99, 235;
        --gt-secondary-color: #0f172a; /* Slate 900 */
        --elite-bg-light: #f8fafc;
        --elite-bg-card: #ffffff;
        --elite-border: rgba(15, 23, 42, 0.06);
        --elite-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
        --elite-shadow-hover: 0 30px 60px -20px rgba(37, 99, 235, 0.15);
        --elite-text-heading: #0f172a;
        --elite-text-body: #475569;
    }

    /* Section General */
    .section-header { margin-bottom: 50px; }
    .gt-section-title.style-3 h6 { color: var(--gt-primary-color); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; display: block; font-size: 14px; }
    .gt-section-title.style-3 h2 { font-size: 42px; line-height: 1.25; font-weight: 800; color: var(--elite-text-heading); margin-bottom: 20px; letter-spacing: -1px; }

    /* Enhanced About Main Section */
    .gt-about-content .gt-text { 
        font-size: 18px; 
        line-height: 1.8; 
        color: var(--elite-text-body); 
        margin-bottom: 35px; 
        position: relative;
        padding-left: 20px;
        border-left: 4px solid var(--gt-primary-color);
        background: linear-gradient(90deg, rgba(37, 99, 235, 0.03) 0%, rgba(255,255,255,0) 100%);
        padding: 15px 20px;
        border-radius: 0 8px 8px 0;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }
    
    .feature-card-mini {
        background: var(--elite-bg-card);
        padding: 30px;
        border-radius: 16px;
        border: 1px solid var(--elite-border);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        gap: 15px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
    }
    
    .feature-card-mini:hover {
        transform: translateY(-8px);
        box-shadow: var(--elite-shadow-hover);
        border-color: rgba(37, 99, 235, 0.2);
    }
    
    .feature-card-mini .icon-box {
        width: 54px;
        height: 54px;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0.02));
        color: var(--gt-primary-color);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .feature-card-mini h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: var(--elite-text-heading);
    }
    
    .feature-card-mini p {
        font-size: 15px;
        color: var(--elite-text-body);
        line-height: 1.6;
        margin: 0;
    }

    /* Stats Section */
    .about-stats-section { background: var(--elite-bg-light); padding: 80px 0; border-radius: 30px; margin: 40px 0; border: 1px solid var(--elite-border); }
    .stat-card { text-align: center; padding: 30px; transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .stat-card:hover { transform: translateY(-10px); }
    .stat-icon { font-size: 40px; color: var(--gt-primary-color); margin-bottom: 20px; display: inline-block; filter: drop-shadow(0 4px 6px rgba(37, 99, 235, 0.2)); }
    .stat-number { font-size: 52px; font-weight: 800; color: var(--elite-text-heading); margin-bottom: 5px; letter-spacing: -2px; }
    .stat-label { font-size: 15px; font-weight: 600; color: var(--gt-primary-color); text-transform: uppercase; letter-spacing: 2px; }

    /* Values Section */
    .value-card { background: var(--elite-bg-card); padding: 40px; border-radius: 20px; box-shadow: var(--elite-shadow); height: 100%; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid var(--elite-border); }
    .value-card:hover { border-color: rgba(37, 99, 235, 0.3); transform: translateY(-8px); box-shadow: var(--elite-shadow-hover); }
    .value-icon { width: 64px; height: 64px; background: linear-gradient(135deg, var(--gt-primary-color), #60a5fa); color: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 25px; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); }
    .value-card h4 { font-size: 22px; font-weight: 700; margin-bottom: 15px; color: var(--elite-text-heading); }
    .value-card p { color: var(--elite-text-body); line-height: 1.7; margin-bottom: 0; }

    /* Timeline Section */
    .timeline-wrapper { position: relative; padding: 40px 0; }
    .timeline-wrapper::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: var(--elite-border); transform: translateX(-50%); }
    .timeline-item { margin-bottom: 60px; position: relative; }
    .timeline-dot { position: absolute; left: 50%; top: 0; width: 24px; height: 24px; background: var(--gt-primary-color); border-radius: 50%; transform: translateX(-50%); z-index: 1; border: 5px solid var(--elite-bg-light); box-shadow: 0 0 0 1px var(--elite-border); }
    .timeline-content { width: 45%; padding: 35px; background: var(--elite-bg-card); border-radius: 20px; box-shadow: var(--elite-shadow); position: relative; border: 1px solid var(--elite-border); transition: transform 0.3s ease; }
    .timeline-content:hover { transform: translateY(-5px); box-shadow: var(--elite-shadow-hover); border-color: rgba(37,99,235,0.2); }
    .timeline-item:nth-child(even) .timeline-content { margin-left: auto; }
    .timeline-year { font-weight: 800; color: var(--gt-primary-color); font-size: 20px; margin-bottom: 12px; display: inline-block; background: rgba(37,99,235,0.1); padding: 4px 12px; border-radius: 8px; }
    .timeline-content h4 { font-size: 22px; font-weight: 700; margin-bottom: 12px; color: var(--elite-text-heading); }
    .timeline-content p { color: var(--elite-text-body); line-height: 1.7; }
    
    /* Team Section */
    .team-card { position: relative; border-radius: 24px; overflow: hidden; margin-bottom: 30px; box-shadow: var(--elite-shadow); border: 1px solid var(--elite-border); }
    .team-img { position: relative; aspect-ratio: 3/4; overflow: hidden; background: var(--elite-bg-light); }
    .team-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
    .team-card:hover .team-img img { transform: scale(1.08); }
    .team-info { padding: 30px 25px; text-align: center; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); position: relative; z-index: 2; margin-top: -60px; width: 90%; margin-left: auto; margin-right: auto; border-radius: 16px; box-shadow: 0 -10px 20px rgba(0,0,0,0.03); border: 1px solid rgba(255,255,255,0.5); }
    .team-info h4 { font-size: 20px; font-weight: 800; margin-bottom: 8px; color: var(--elite-text-heading); }
    .team-info span { color: var(--gt-primary-color); font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
    .team-social { margin-top: 20px; display: flex; justify-content: center; gap: 12px; }
    .team-social a { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: var(--elite-bg-light); color: var(--elite-text-body); transition: all 0.3s ease; }
    .team-social a:hover { background: var(--gt-primary-color); color: #fff; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(37,99,235,0.3); }

    /* CTA Section */
    .cta-wrapper { background: linear-gradient(135deg, var(--gt-secondary-color) 0%, #1e293b 100%) !important; padding: 80px 60px !important; border-radius: 30px !important; text-align: center; color: #fff; box-shadow: 0 30px 60px -15px rgba(15,23,42,0.4) !important; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); }
    .cta-wrapper::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(37,99,235,0.2) 0%, rgba(0,0,0,0) 70%); z-index: 0; }
    .cta-wrapper > * { position: relative; z-index: 1; }
    .cta-wrapper h2 { font-size: 42px; font-weight: 800; letter-spacing: -1px; }
    .cta-wrapper p { font-size: 18px; color: #94a3b8 !important; }
    
    @media (max-width: 768px) {
        .timeline-wrapper::before { left: 24px; }
        .timeline-dot { left: 24px; }
        .timeline-content { width: calc(100% - 70px); margin-left: 70px !important; }
        .gt-section-title.style-3 h2 { font-size: 32px; }
        .stat-number { font-size: 42px; }
        .cta-wrapper { padding: 40px 30px !important; }
        .cta-wrapper h2 { font-size: 32px; }
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
