@extends('layouts.app')

@section('title', $project->title . ' - SupremeIT')
@section('page-title', $project->title)

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $project->title }}</h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('projects') }}">Projects</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>{{ $project->title }}</li>
            </ul>
        </div>
    </div>
</div>

<!-- Project Detail Section Start -->
<section class="gt-project-detail-section fix section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="gt-project-detail-content">
                    @if($project->image)
                    <div class="gt-project-image mb-4">
                        <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="w-100 rounded">
                    </div>
                    @endif

                    <div class="gt-project-header mb-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h2>{{ $project->title }}</h2>
                                @if($project->subtitle)
                                <p class="lead text-muted">{{ $project->subtitle }}</p>
                                @endif
                            </div>
                            @if($project->is_featured)
                            <span class="badge bg-warning">Featured Project</span>
                            @endif
                        </div>
                        
                        <div class="gt-project-meta mb-4">
                            <div class="row">
                                @if($project->client)
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <strong>Client:</strong>
                                        <span>{{ $project->client }}</span>
                                    </div>
                                </div>
                                @endif
                                @if($project->category)
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <strong>Category:</strong>
                                        <span>{{ $project->category }}</span>
                                    </div>
                                </div>
                                @endif
                                @if($project->project_date)
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <strong>Date:</strong>
                                        <span>{{ $project->project_date->format('F Y') }}</span>
                                    </div>
                                </div>
                                @endif
                                @if($project->project_url)
                                <div class="col-md-6">
                                    <div class="meta-item">
                                        <strong>Live Demo:</strong>
                                        <a href="{{ $project->project_url }}" target="_blank" class="text-primary">View Project</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="gt-project-description mb-5">
                        <h4>Project Overview</h4>
                        <div class="content">
                            {!! nl2br(e($project->description)) !!}
                        </div>
                    </div>

                    @if($project->technologies && count($project->technologies) > 0)
                    <div class="gt-project-technologies mb-5">
                        <h4>Technologies Used</h4>
                        <div class="tech-tags">
                            @foreach($project->technologies as $tech)
                            <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($project->gallery && count($project->gallery) > 0)
                    <div class="gt-project-gallery mb-5">
                        <h4>Project Gallery</h4>
                        <div class="row g-3">
                            @foreach($project->gallery as $image)
                            <div class="col-md-4">
                                <img src="{{ asset($image) }}" alt="Project Image" class="w-100 rounded gallery-img" data-bs-toggle="modal" data-bs-target="#galleryModal">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($project->challenge || $project->solution || $project->result)
                    <div class="gt-project-process mb-5">
                        <h4>Project Process</h4>
                        <div class="row">
                            @if($project->challenge)
                            <div class="col-md-4">
                                <div class="process-item">
                                    <div class="process-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <h5>Challenge</h5>
                                    <p>{{ $project->challenge }}</p>
                                </div>
                            </div>
                            @endif
                            @if($project->solution)
                            <div class="col-md-4">
                                <div class="process-item">
                                    <div class="process-icon">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>
                                    <h5>Solution</h5>
                                    <p>{{ $project->solution }}</p>
                                </div>
                            </div>
                            @endif
                            @if($project->result)
                            <div class="col-md-4">
                                <div class="process-item">
                                    <div class="process-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <h5>Result</h5>
                                    <p>{{ $project->result }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- CTA Section -->
                    <div class="gt-project-cta">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('contact') }}" class="gt-theme-btn w-100">
                                    <i class="fas fa-envelope me-2"></i>
                                    Start Similar Project
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('projects') }}" class="gt-theme-btn style-3 w-100">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    View All Projects
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="gt-project-sidebar">
                    <!-- Project Info Card -->
                    <div class="gt-sidebar-card mb-4">
                        <h5>Project Information</h5>
                        <div class="gt-project-info">
                            @if($project->client)
                            <div class="info-item">
                                <strong>Client:</strong>
                                <span>{{ $project->client }}</span>
                            </div>
                            @endif
                            @if($project->category)
                            <div class="info-item">
                                <strong>Category:</strong>
                                <span>{{ $project->category }}</span>
                            </div>
                            @endif
                            @if($project->project_date)
                            <div class="info-item">
                                <strong>Completed:</strong>
                                <span>{{ $project->project_date->format('M Y') }}</span>
                            </div>
                            @endif
                            @if($project->project_url)
                            <div class="info-item">
                                <strong>Status:</strong>
                                <span class="text-success">Live</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="gt-sidebar-card mb-4">
                        <h5>Like This Project?</h5>
                        <p>Let's discuss how we can create something similar for your business.</p>
                        <a href="{{ route('contact') }}" class="gt-theme-btn w-100">
                            <i class="fas fa-phone me-2"></i>
                            Get Started
                        </a>
                    </div>

                    <!-- Related Projects -->
                    @if($relatedProjects->count() > 0)
                    <div class="gt-sidebar-card">
                        <h5>Related Projects</h5>
                        <div class="gt-related-projects">
                            @foreach($relatedProjects as $relatedProject)
                            <div class="gt-related-item">
                                <a href="{{ route('project.detail', $relatedProject) }}">
                                    <div class="d-flex align-items-center">
                                        @if($relatedProject->image)
                                        <img src="{{ $relatedProject->image }}" alt="{{ $relatedProject->title }}" class="related-thumb">
                                        @else
                                        <div class="related-thumb-placeholder">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                        @endif
                                        <div class="related-content">
                                            <h6>{{ $relatedProject->title }}</h6>
                                            @if($relatedProject->category)
                                            <span class="category">{{ $relatedProject->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Modal -->
@if($project->gallery && count($project->gallery) > 0)
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Project Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($project->gallery as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $image }}" class="d-block w-100" alt="Project Image">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.gt-project-detail-content {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.gt-project-image img {
    border-radius: 10px;
}

.gt-project-meta .meta-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.gt-project-meta .meta-item:last-child {
    border-bottom: none;
}

.tech-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tech-tag {
    background: #667eea;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.gallery-img {
    cursor: pointer;
    transition: transform 0.3s;
}

.gallery-img:hover {
    transform: scale(1.05);
}

.process-item {
    text-align: center;
    padding: 20px;
}

.process-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 1.5rem;
}

.process-item h5 {
    margin-bottom: 15px;
    color: #333;
}

.gt-project-cta {
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

.gt-project-info .info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.gt-project-info .info-item:last-child {
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

.related-content .category {
    color: #667eea;
    font-size: 0.8rem;
    font-weight: 500;
}
</style>
@endpush
