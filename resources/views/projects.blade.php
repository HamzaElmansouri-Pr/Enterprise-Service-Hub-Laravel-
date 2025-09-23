@extends('layouts.app')

@section('title', 'Our Projects - SupremeIT')
@section('page-title', 'Our Projects')

@push('styles')
<style>
.case-studies-card-items {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.case-studies-card-items:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.thumb {
    position: relative;
    border-radius: 10px 10px 0 0;
}

.thumb img {
    transition: transform 0.3s ease;
}

.case-studies-card-items:hover .thumb img {
    transform: scale(1.05);
}

.gt-project-content {
    padding: 20px;
    background: #fff;
}

.gt-project-meta {
    margin-bottom: 15px;
}



.gt-project-date {
    color: #6c757d;
    font-size: 14px;
}

.gt-project-content h4 {
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: 600;
}

.gt-project-content h4 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.gt-project-content h4 a:hover {
    color: #007bff;
}

.gt-project-client {
    margin: 15px 0;
    font-size: 14px;
    color: #124aff;
}

.gt-project-tech {
    margin-top: 15px;
}

.tech-tag {
    display: inline-block;
    background: #f8f9fa;
    color: #495057;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    margin-right: 5px;
    margin-bottom: 5px;
    border: 1px solid #dee2e6;
}

.content {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 2;
}

.content .icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.9);
    color: #007bff;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.content .icon:hover {
    background: #007bff;
    color: white;
    transform: scale(1.1);
}

.project-placeholder {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
</style>
@endpush

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Our <span>Projects</span></h1>
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
                 Our Projects
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Projects Section Start -->
<section class="gt-projects-section fix section-padding">
    <div class="container">
        @if($page)
        <div class="gt-section-title style-3 text-center mb-5">
            <h6 class="wow fadeInUp tt-capitalize">{{ $page->subtitle ?? 'Our Work' }}</h6>
            <h2 class="char-animation">{{ $page->title ?? 'Our Projects' }}</h2>
            @if($page->description)
            <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">{{ $page->description }}</p>
            @endif
        </div>
        @endif

        <!-- Filter Buttons -->
        @if($categories->count() > 0)
        <div class="gt-filter-buttons text-center mb-5">
            <button class="gt-filter-btn active" data-filter="all">All Projects</button>
            @foreach($categories as $category)
            <button class="gt-filter-btn" data-filter="{{ Str::slug($category) }}">{{ $category }}</button>
            @endforeach
        </div>
        @endif

<section class="case-studies-section-4 fix section-padding">
    <div class="container">
        <div class="row g-4" id="projects-grid">
            @forelse($projects as $project)
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="case-studies-card-items mt-0 h-100 d-flex flex-column">
                    <div class="thumb" style="height: 500px ; overflow: hidden;">
                        @if($project->image)
                        <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" 
                             class="w-100 h-100" style="object-fit: cover;">
                        @else
                        <div class="project-placeholder d-flex align-items-center justify-content-center h-100 bg-light">
                            <i class="fas fa-project-diagram fa-3x text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="content">
                        <div class="title">
                            <h3><a href="{{ route('project.detail', $project) }}">{{ $project->title }}</a></h3>
                            <p> $projec->category

                        </div>
                        <a href="{{ route('project.detail',$project)}}" class="icon"><i class="fa-regular fa-arrow-up-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4>No projects available at the moment.</h4>
                    <p class="text-muted">Please check back later for our latest projects.</p>
                </div>
                 
            </div>
            @endforelse
        </div>

        <!-- CTA Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="gt-cta-box text-center">
                    <h3>Have a Project in Mind?</h3>
                    <p>Let's discuss your project requirements and bring your ideas to life.</p>
                    <a href="{{ route('contact') }}" class="gt-theme-btn">Start Your Project</a>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection



