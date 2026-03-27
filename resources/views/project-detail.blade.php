@extends('layouts.app')

@section('title', $project->title . ' - Nova Agency Projects')
@section('page-title', 'Project Details')

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
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('projects') }}">
                        Projects
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                 {{ $project->title }}
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Project Details Section Start -->
<section class="gt-project-details fix section-padding">
    <div class="container">
        <div class="project-details-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <div class="project-details-image mb-30">
                        <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="img-fluid rounded w-100" onerror="this.src='/assets/img/project/01.jpg'">
                    </div>
                    <div class="project-details-content">
                        <h3 class="mb-3">{{ $project->title }}</h3>
                        <p class="mb-4">{!! nl2br(e($project->description)) !!}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="project-sidebar">
                        <div class="project-info-box p-4 bg-light rounded mb-4">
                            <h4 class="mb-3">Project Info</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Client:</strong> {{ $project->client ?? 'N/A' }}</li>
                                <li class="mb-2"><strong>Category:</strong> {{ $project->category ?? 'General' }}</li>
                                <li class="mb-2"><strong>Date:</strong> {{ $project->completion_date ? $project->completion_date->format('F d, Y') : 'Ongoing' }}</li>
                            </ul>
                        </div>

                        @if(isset($relatedProjects) && $relatedProjects->count() > 0)
                        <div class="related-projects mt-5">
                            <h4 class="mb-3">Related Projects</h4>
                            @foreach($relatedProjects as $related)
                            <div class="related-project-item mb-3 d-flex align-items-center">
                                <div class="related-thumb me-3" style="width: 80px; height: 60px; flex-shrink: 0;">
                                    <img src="{{ asset($related->image) }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;" class="rounded">
                                </div>
                                <div class="related-content">
                                    <h6 class="mb-0"><a href="{{ route('projects.show', $related->slug) }}" class="text-dark text-decoration-none">{{ $related->title }}</a></h6>
                                    <small class="text-muted">{{ $related->category }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
