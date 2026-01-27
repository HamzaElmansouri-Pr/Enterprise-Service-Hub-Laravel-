@extends('layouts.app')

@section('title', $page->title . ' - Nova Agency')
@section('page-title', $page->title)

@push('styles')
<style>
    .project-card {
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
        position: relative;
        height: 300px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .project-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .project-card:hover img {
        transform: scale(1.1);
    }
    .project-overlay {
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 50%;
    }
    .project-card h4 {
        color: #fff;
        margin-bottom: 5px;
        font-size: 1.25rem;
    }
    .project-card p {
        color: #e0e0e0;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    .project-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }
</style>
@endpush

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ $page->image ? asset($page->image) : asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $page->breadcrumb_title !!}</h1>
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
                 Projects
                </li>
            </ul>
        </div>
    </div>
</div>

<section class="gt-projects-section fix section-padding">
    <div class="container">
        <div class="row">
            @forelse($projects as $project)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="project-card">
                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" onerror="this.src='/assets/img/project/01.jpg'">
                    <a href="{{ route('project.detail', $project->slug) }}" class="project-link"></a>
                    <div class="project-overlay">
                        <h4>{{ $project->title }}</h4>
                        <p>{{ $project->category }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <h3>No projects found.</h3>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection



