@extends('layouts.app')

@section('title', $blog->title . ' - Blog Details')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Blog Details</h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                   Blog <span>Details</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- News Standard Section Start -->
<section class="news-standard-section section-padding">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                  <div class="news-post-details">
                        <div class="single-news-post">
                            <div class="post-featured-thumb">
                                <img src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('assets/img/news/details-1.jpg') }}" alt="{{ $blog->title }}">
                            </div>
                            <div class="post-content">
                                <ul class="post-list d-flex align-items-center">
                                    <li>
                                        <i class="fa-regular fa-user"></i>
                                        By {{ $blog->author ?? 'Admin' }}
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-calendar-days"></i>
                                        {{ $blog->published_at ? $blog->published_at->format('d M, Y') : $blog->created_at->format('d M, Y') }}
                                    </li>
                                    @if($blog->category)
                                    <li>
                                        <i class="fa-solid fa-tag"></i>
                                        {{ $blog->category }}
                                    </li>
                                    @endif
                                </ul>
                                <h3>{{ $blog->title }}</h3>
                                @if($blog->excerpt)
                                <p class="mb-3">
                                    {{ $blog->excerpt }}
                                </p>
                                @endif
                                
                                @if($blog->content)
                                <div class="blog-content">
                                    {!! $blog->content !!}
                                </div>
                                @else
                                <p class="mb-3">
                                    The is ipsum dolor sit amet consectetur adipiscing elit. Fusce eleifend porta arcu In hac habitasse the is platea augue thelorem turpoi dictumst. In lacus libero faucibus at malesuada sagittis placerat eros sed istincidunt augue ac ante rutrum sed the is sodales augue consequat.
                                </p>
                                <p class="mt-4 mb-5">
                                    Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu. Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet. Pellentesque commodo lacus at sodales sodales. Quisque sagittis orci ut diam condimentum, vel euismod erat placerat. In iaculis arcu eros.
                                </p>
                                @endif
                                
                                @if($blog->featured_image || $additionalImages ?? false)
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="details-image">
                                            <img src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('assets/img/news/details-2.jpg') }}" alt="img">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="details-image">
                                            <img src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('assets/img/news/details-3.jpg') }}" alt="img">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($blog->excerpt || $blog->content)
                                <div class="hilight-text mt-4">
                                    <p>
                                        @if($blog->excerpt)
                                            {{ Str::limit($blog->excerpt, 150) }}
                                        @else
                                            Pellentesque sollicitudin congue dolor non aliquam. Morbi volutpat, nisi vel ultricies urnacondimentum, sapien neque lobortis tortor, quis efficitur mi ipsum eu metus. Praesent eleifend orci sit amet est vehicula.
                                        @endif
                                    </p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                        <path d="M7.71428 20.0711H0.5V5.64258H14.9286V20.4531L9.97665 30.3568H3.38041L8.16149 20.7947L8.5233 20.0711H7.71428Z" stroke="#6A47ED"></path>
                                        <path d="M28.2846 20.0711H21.0703V5.64258H35.4989V20.4531L30.547 30.3568H23.9507L28.7318 20.7947L29.0936 20.0711H28.2846Z" stroke="#6A47ED"></path>
                                    </svg>
                                </div>
                                @endif
                                
                                <p class="pt-5">
                                    @if($blog->content && strlen(strip_tags($blog->content)) > 400)
                                        {{ Str::limit(strip_tags($blog->content), 400) }}
                                    @else
                                        Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore of magna aliqua. Ut enim ad minim veniam, made of owl the quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea dolor commodo consequat. Duis aute irure and dolor in reprehenderit.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row tag-share-wrap mt-4 mb-5">
                            <div class="col-lg-8 col-12">
                                <div class="tagcloud"> 
                                    <span>Tags:</span>
                                    @if($blog->tags && count($blog->tags) > 0)
                                        @foreach($blog->tags as $tag)
                                        <a href="{{ route('blog', ['tag' => $tag]) }}">{{ $tag }}</a>
                                        @endforeach
                                    @else
                                        <a href="javascript:void(0)">{{ $blog->category ?? 'Technology' }}</a>
                                        <a href="javascript:void(0)">Business</a>
                                        <a href="javascript:void(0)">Digital</a>
                                    @endif                            
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 mt-3 mt-lg-0 text-lg-end">
                                <div class="social-share">
                                    <span class="me-3">Share:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>                                    
                                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($blog->title) }}" target="_blank"><i class="fab fa-youtube"></i></a>                                    
                                </div>
                            </div>
                        </div>
                       
                    </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="main-sidebar sticky-style">
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>Search</h4>
                        </div>
                        <div class="search-widget">
                            <form action="{{ route('blog') }}" method="GET">
                                <input type="text" name="search" placeholder="Search here" value="{{ request('search') }}">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>All Categories</h4>
                        </div>
                        <div class="news-widget-categories">
                            <ul>
                                @if($blogCategories && $blogCategories->count() > 0)
                                    @foreach($blogCategories as $category)
                                    <li class="{{ $blog->category === $category->category ? 'active' : '' }}">
                                        <a href="{{ route('blog', ['category' => $category->category]) }}">{{ $category->category }}</a> 
                                        <span>({{ $category->count }})</span>
                                    </li>
                                    @endforeach
                                @else
                                <li><a href="{{ route('blog') }}">Digital Agency</a> <span>(7)</span></li>
                                <li><a href="{{ route('blog') }}">Business</a> <span>(4)</span></li>
                                <li class="{{ $blog->category === 'Technology' ? 'active' : '' }}"><a href="{{ route('blog', ['category' => 'Technology']) }}">Technology</a> <span>(5)</span></li>
                                <li><a href="{{ route('blog') }}">Social Marketing</a> <span>(3)</span></li>
                                <li><a href="{{ route('blog') }}">System</a> <span>(6)</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>Recent Post</h4>
                        </div>
                        <div class="recent-post-area">
                            @if($recentBlogs && $recentBlogs->count() > 0)
                                @foreach($recentBlogs as $recentBlog)
                                <div class="recent-items">
                                    <div class="recent-thumb">
                                        <img src="{{ $recentBlog->featured_image ? asset($recentBlog->featured_image) : asset('assets/img/news/pp3.jpg') }}" alt="img">
                                    </div>
                                    <div class="recent-content">
                                        <ul>
                                            <li>
                                                <i class="fa-solid fa-calendar-days"></i>
                                                {{ $recentBlog->published_at ? $recentBlog->published_at->format('d M, Y') : $recentBlog->created_at->format('d M, Y') }}
                                            </li>
                                        </ul>
                                        <h6>
                                            <a href="{{ route('blog.detail', $recentBlog) }}">
                                                {{ Str::limit($recentBlog->title, 50) }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="recent-items">
                                <div class="recent-thumb">
                                    <img src="{{ asset('assets/img/news/pp3.jpg') }}" alt="img">
                                </div>
                                <div class="recent-content">
                                    <ul>
                                        <li>
                                            <i class="fa-solid fa-calendar-days"></i>
                                            14 Feb, 2025
                                        </li>
                                    </ul>
                                    <h6>
                                        <a href="javascript:void(0)">
                                            Which Yoga Hybrid is Right <br> for Your?
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <div class="recent-items">
                                <div class="recent-thumb">
                                    <img src="{{ asset('assets/img/news/pp4.jpg') }}" alt="img">
                                </div>
                                <div class="recent-content">
                                    <ul>
                                        <li>
                                            <i class="fa-solid fa-calendar-days"></i>
                                            12 Mar, 2025
                                        </li>
                                    </ul>
                                    <h6>
                                        <a href="javascript:void(0)">
                                            Keep Your Business Safe <br> Ensure High Availability
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <div class="recent-items">
                                <div class="recent-thumb">
                                    <img src="{{ asset('assets/img/news/pp5.jpg') }}" alt="img">
                                </div>
                                <div class="recent-content">
                                    <ul>
                                        <li>
                                            <i class="fa-solid fa-calendar-days"></i>
                                            23 Feb, 2025
                                        </li>
                                    </ul>
                                    <h6>
                                        <a href="javascript:void(0)">
                                            Tackling the Changes of <br> Retell Industry
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="single-sidebar-widget">
                        <div class="wid-title">
                            <h4>Tag</h4>
                        </div>
                        <div class="news-widget-categories">
                            <div class="tagcloud">
                                @if($popularTags && $popularTags->count() > 0)
                                    @foreach($popularTags as $tag)
                                    <a href="{{ route('blog', ['tag' => $tag]) }}">{{ $tag }}</a>
                                    @endforeach
                                @else
                                <a href="javascript:void(0)">Security</a>     
                                <a href="javascript:void(0)">Business</a>
                                <a href="javascript:void(0)">Digital</a>
                                <a href="javascript:void(0)">Technology</a>
                                <a href="javascript:void(0)">Change</a>
                                <a href="javascript:void(0)">Video</a>
                                <a href="javascript:void(0)">UI/UX Design</a>
                                <a href="javascript:void(0)">Startup</a>
                                <a href="javascript:void(0)">Services</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
