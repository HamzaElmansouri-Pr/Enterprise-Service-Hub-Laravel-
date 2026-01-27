@extends('layouts.app')

@section('title', $blog->title . ' - Nova Agency Blog')
@section('page-title', 'Blog Details')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ Str::limit($blog->title, 40) }}</h1>
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
                    <a href="{{ route('blog') }}">
                        Blog
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                 Details
                </li>
            </ul>
        </div>
    </div>
</div>

<section class="gt-blog-details-section fix section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-details-wrapper">
                    <div class="blog-details-thumb mb-30">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-100 rounded" onerror="this.src='/assets/img/news/01.jpg'">
                    </div>
                    <div class="blog-meta-items mb-3">
                        <span class="me-4"><i class="fa-solid fa-user text-primary me-2"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                        <span class="me-4"><i class="fa-solid fa-calendar-days text-primary me-2"></i> {{ $blog->published_at ? $blog->published_at->format('d F, Y') : '' }}</span>
                        <span><i class="fa-solid fa-folder text-primary me-2"></i> {{ $blog->category ?? 'General' }}</span>
                    </div>
                    <h2 class="mb-4">{{ $blog->title }}</h2>
                    <div class="blog-details-content">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-wrapper">
                    @if(isset($recentBlogs) && $recentBlogs->count() > 0)
                    <div class="sidebar-widget bg-light p-4 rounded mb-4">
                        <h4 class="mb-4">Recent Posts</h4>
                        <div class="recent-posts">
                            @foreach($recentBlogs as $recent)
                            <div class="recent-post-item d-flex align-items-center mb-3">
                                <div class="recent-thumb me-3" style="width: 70px; height: 70px; flex-shrink: 0;">
                                    <img src="{{ asset($recent->image) }}" alt="{{ $recent->title }}" class="w-100 h-100 object-fit-cover rounded" onerror="this.src='/assets/img/news/01.jpg'">
                                </div>
                                <div class="recent-content">
                                    <h6 class="mb-1"><a href="{{ route('blog.detail', $recent->slug) }}" class="text-dark text-decoration-none">{{ Str::limit($recent->title, 40) }}</a></h6>
                                    <small class="text-muted">{{ $recent->published_at ? $recent->published_at->format('M d, Y') : '' }}</small>
                                </div>
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
@endsection
