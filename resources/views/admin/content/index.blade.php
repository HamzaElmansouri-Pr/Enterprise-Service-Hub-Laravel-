@extends('admin.layouts.app')

@section('title', 'Content Architect')
@section('page-title', 'Website Content Architect')

@section('styles')
<style>
    .content-blueprint-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }
    .content-blueprint-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: var(--bs-primary);
    }
    .blueprint-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .blueprint-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.03);
        transition: background 0.2s;
    }
    .blueprint-item:last-child { border-bottom: none; }
    .blueprint-item:hover {
        background: rgba(var(--bs-primary-rgb), 0.02);
    }
    .blueprint-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        font-size: 1.2rem;
    }
    .status-badge {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.35em 0.8em;
        border-radius: 50px;
    }
    .category-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #6c757d;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .category-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #dee2e6;
        margin-left: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row align-items-end mb-5">
        <div class="col">
            <h6 class="text-primary fw-bold text-uppercase mb-1" style="letter-spacing: 2px;">System Dashboard</h6>
            <h2 class="fw-bold mb-0">Content Management <span class="text-muted fw-light">Architect</span></h2>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary px-4 shadow-sm">
                <i class="fas fa-sync-alt me-2"></i> Refresh Layout
            </button>
        </div>
    </div>

    @php
        $homeSections = [
            ['id' => 'home-hero', 'title' => 'Hero Banner', 'desc' => 'Main landing slider & CTA', 'icon' => 'fa-play-circle'],
            ['id' => 'home-about', 'title' => 'Introduction', 'desc' => 'Brief about us summary', 'icon' => 'fa-id-badge'],
            ['id' => 'services-list', 'title' => 'Our Expertise', 'desc' => 'Home services collection', 'icon' => 'fa-concierge-bell'],
            ['id' => 'projects-list', 'title' => 'Success Stories', 'desc' => 'Featured work showcase', 'icon' => 'fa-folder-open'],
            ['id' => 'reviews-list', 'title' => 'Testimonials', 'desc' => 'Customer feedback slider', 'icon' => 'fa-star'],
            ['id' => 'blog-list', 'title' => 'Latest News', 'desc' => 'Recent blog articles', 'icon' => 'fa-newspaper'],
            ['id' => 'cta-simple', 'title' => 'Call to Action', 'desc' => 'Conversion & contact bar', 'icon' => 'fa-paper-plane'],
            ['id' => 'home-partners', 'title' => 'Partners', 'desc' => 'Client logo marquee', 'icon' => 'fa-handshake'],
        ];

        $landingPages = [
            ['id' => 'about-main', 'title' => 'About Page', 'desc' => 'Detailed company history', 'icon' => 'fa-info-circle'],
            ['id' => 'about-stats', 'title' => 'Success Metrics', 'desc' => 'Animated counter numbers', 'icon' => 'fa-chart-bar'],
            ['id' => 'about-values', 'title' => 'Core Values', 'desc' => 'Philosophy & mission', 'icon' => 'fa-gem'],
            ['id' => 'about-team', 'title' => 'Our Team', 'desc' => 'Management profiles', 'icon' => 'fa-users'],
            ['id' => 'services-page-header', 'title' => 'Services Header', 'desc' => 'Top banner for services', 'icon' => 'fa-heading'],
            ['id' => 'projects-page-header', 'title' => 'Projects Header', 'desc' => 'Top banner for projects', 'icon' => 'fa-heading'],
        ];

        $globalModules = [
            ['id' => 'site-info', 'title' => 'Branding', 'desc' => 'Logo, Favicon & SEO', 'icon' => 'fa-fingerprint', 'category' => 'Global'],
            ['id' => 'contact-info', 'title' => 'Contact Hub', 'desc' => 'Support contact details', 'icon' => 'fa-headset', 'category' => 'Global'],
            ['id' => 'footer-content', 'title' => 'Footer', 'desc' => 'Site bottom information', 'icon' => 'fa-shoe-prints', 'category' => 'Global'],
        ];
    @endphp

    <div class="row">
        <!-- Main Website Column -->
        <div class="col-lg-5">
            <h6 class="category-label">Home Page Structure</h6>
            <div class="content-blueprint-card shadow-sm mb-5">
                <div class="blueprint-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-layer-group me-2"></i> Landing Page Modules</h6>
                    <span class="badge bg-primary rounded-pill small">{{ count($homeSections) }} Modules</span>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($homeSections as $item)
                        @php($sect = $sections[$item['id']][0] ?? null)
                        <a href="{{ route('admin.content.edit', $item['id']) }}" class="list-group-item blueprint-item d-flex align-items-center">
                            <div class="blueprint-icon me-3">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block fw-bold text-dark">{{ $item['title'] }}</span>
                                <span class="text-muted smallest">{{ $item['desc'] }}</span>
                            </div>
                            <div class="ms-3 text-end">
                                @if($sect && $sect->is_active)
                                    <span class="badge status-badge bg-success-subtle text-success border border-success-subtle"><i class="fas fa-circle me-1 small"></i> Live</span>
                                @else
                                    <span class="badge status-badge bg-secondary-subtle text-muted border border-secondary-subtle"><i class="fas fa-circle me-1 small"></i> Draft</span>
                                @endif
                                <div class="mt-1"><i class="fas fa-chevron-right text-muted x-small"></i></div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Internal & Support Column -->
        <div class="col-lg-4">
            <h6 class="category-label">Internal Architecture</h6>
            <div class="content-blueprint-card shadow-sm mb-4">
                <div class="blueprint-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-success"><i class="fas fa-sitemap me-2"></i> Page Templates</h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($landingPages as $item)
                        @php($sect = $sections[$item['id']][0] ?? null)
                        <a href="{{ route('admin.content.edit', $item['id']) }}" class="list-group-item blueprint-item d-flex align-items-center">
                            <div class="blueprint-icon me-3 bg-success-subtle text-success">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block fw-bold text-dark">{{ $item['title'] }}</span>
                                <span class="text-muted smallest">{{ $item['desc'] }}</span>
                            </div>
                            <div class="ms-3 text-end">
                                @if($sect && $sect->is_active)
                                    <span class="badge status-badge bg-success-subtle text-success border border-success-subtle">Live</span>
                                @else
                                    <span class="badge status-badge bg-secondary-subtle text-muted border border-secondary-subtle">Draft</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- System Settings Column -->
        <div class="col-lg-3">
            <h6 class="category-label">System Modules</h6>
            <div class="content-blueprint-card shadow-sm border-top border-warning border-3">
                <div class="blueprint-header">
                    <h6 class="mb-0 fw-bold text-warning"><i class="fas fa-cog me-2"></i> Core Config</h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($globalModules as $item)
                        @php($sect = $sections[$item['id']][0] ?? null)
                        <a href="{{ route('admin.content.edit', $item['id']) }}" class="list-group-item blueprint-item d-flex align-items-center">
                            <div class="blueprint-icon me-3 bg-warning-subtle text-warning">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block fw-bold text-dark">{{ $item['title'] }}</span>
                                <span class="text-muted smallest">{{ $item['desc'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="card mt-4 bg-primary text-white shadow-lg overflow-hidden border-0">
                <div class="card-body p-4 relative">
                    <i class="fas fa-rocket absolute opacity-10" style="font-size: 5rem; right: -1rem; bottom: -1rem;"></i>
                    <h5 class="fw-bold mb-3">Architect Tip</h5>
                    <p class="small mb-0 opacity-80 leading-relaxed">
                        Toggle sections to "Draft" to hide incomplete content while you build. Your changes reflect instantly in the "Blueprint" view.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
