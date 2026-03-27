@extends('layouts.app')

@section('title', $page->title . ' - Nova Agency')
@section('page-title', $page->title)

@push('styles')
<style>
    .blog-card {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .blog-thumb {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    .blog-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .blog-card:hover .blog-thumb img {
        transform: scale(1.1);
    }
    .blog-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .blog-meta {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    .blog-meta i {
        color: #007bff;
        margin-right: 5px;
    }
    .blog-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    .blog-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .blog-title a:hover {
        color: #007bff;
    }
    .blog-btn {
        margin-top: auto;
        color: #007bff;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .blog-btn i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }
    .blog-btn:hover i {
        transform: translateX(5px);
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
                 Blog
                </li>
            </ul>
        </div>
    </div>
</div>

<section class="gt-blog-section fix section-padding">
    <div class="container">
        <div class="row g-4">
            @forelse($blogs as $blog)
            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="blog-card">
                    <div class="blog-thumb">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" onerror="this.src='/assets/img/news/01.jpg'">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-user"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                            <span><i class="fa-solid fa-calendar-days"></i> {{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</span>
                        </div>
                        <h3 class="blog-title">
                            <a href="{{ route('blog.show', $blog->slug) }}">{{ Str::limit($blog->title, 55) }}</a>
                        </h3>
                        <p>{{ Str::limit($blog->excerpt ?? $blog->content, 100) }}</p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="blog-btn">Read More <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <h3>No articles found.</h3>
            </div>
            @endforelse
        </div>
        
        <div class="row pt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
