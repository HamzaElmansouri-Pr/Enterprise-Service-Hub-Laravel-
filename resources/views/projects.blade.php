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
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ resolve_image_url($page->image ?? 'assets/img/breadcrumb-bg.jpg') }}');">
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
        <!-- Filter and Search controls -->
        <div class="row mb-5 align-items-center justify-content-between g-4">
            <div class="col-lg-7">
                <div class="filter-controls d-flex flex-wrap gap-2">
                    <a href="{{ route('projects', ['search' => request('search')]) }}" 
                       class="filter-pill {{ !request('category') ? 'active' : '' }}">
                        All Projects
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('projects', ['category' => $category, 'search' => request('search')]) }}" 
                           class="filter-pill {{ request('category') == $category ? 'active' : '' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <form action="{{ route('projects') }}" method="GET" class="search-form">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="search-input-wrapper">
                        <i class="fa-regular fa-magnifying-glass search-icon"></i>
                        <input type="text" name="search" class="form-control premium-search" 
                               placeholder="Search projects..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('projects', ['category' => request('category')]) }}" class="clear-search">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
                <x-project-card :project="$project" class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s" />
            @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state wow fadeInUp">
                    <i class="fa-regular fa-folder-open fa-4x text-muted mb-4 d-block"></i>
                    <h3 class="mb-2">No projects found for your criteria.</h3>
                    <p class="text-muted mb-4">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('projects') }}" class="btn btn-primary rounded-pill px-4">
                        Clear all filters
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Premium Filter UI Style */
    .filter-controls {
        padding: 5px;
    }
    .filter-pill {
        padding: 8px 18px;
        border-radius: 40px;
        background: #f8f9fa;
        color: #2b2b2b;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid #eee;
        display: inline-block;
        text-decoration: none;
    }
    .filter-pill:hover {
        background: #007bff;
        color: #fff;
        transform: translateY(-2px);
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    .filter-pill.active {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    /* Premium Search Bar */
    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .premium-search {
        border-radius: 30px;
        padding: 12px 45px;
        border: 1px solid #eee;
        background: #fdfdfd;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .premium-search:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
        outline: none;
    }
    .search-icon {
        position: absolute;
        left: 18px;
        color: #999;
        font-size: 1rem;
    }
    .clear-search {
        position: absolute;
        right: 15px;
        color: #ddd;
        transition: color 0.3s;
        text-decoration: none;
    }
    .clear-search:hover {
        color: #dc3545;
    }

    /* Project card styling override to fit the grid */
    .case-studies-card-items {
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 0 !important;
    }

    /* Empty state animations */
    .empty-state {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection



