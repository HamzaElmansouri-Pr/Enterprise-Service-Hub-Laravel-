@extends('layouts.app')

@section('title', 'Our Blog - SupremeIT')
@section('page-title', 'Our Blog')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Our <span>Blog</span></h1>
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
                 Our Blog
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Blog Section Start -->
<section class="gt-blog-section fix section-padding">
    <div class="container">
        @if($page)
        <div class="gt-section-title style-3 text-center mb-5">
            <h6 class="wow fadeInUp tt-capitalize">{{ $page->subtitle ?? 'Latest News' }}</h6>
            <h2 class="char-animation">{{ $page->title ?? 'Our Blog' }}</h2>
            @if($page->description)
            <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">{{ $page->description }}</p>
            @endif
        </div>
        @endif

        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Featured Blog Posts -->
                @if($featuredBlogs->count() > 0)
                <div class="gt-featured-blogs mb-5">
                    <h4 class="mb-4">Featured Articles</h4>
                    <div class="row g-4">
                        @foreach($featuredBlogs as $blog)
                        <div class="col-md-6">
                            <div class="gt-blog-card featured">
                                <div class="gt-blog-thumb">
                                    @if($blog->featured_image)
                                    <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-100">
                                    @else
                                    <div class="blog-placeholder">
                                        <i class="fas fa-newspaper fa-3x"></i>
                                    </div>
                                    @endif
                                    <div class="gt-blog-overlay">
                                        <a href="{{ route('blog.detail', $blog) }}" class="gt-theme-btn">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="gt-blog-content">
                                    <div class="gt-blog-meta">
                                        <span class="gt-blog-date">{{ $blog->published_at->format('M d, Y') }}</span>
                                        @if($blog->category)
                                        <span class="gt-blog-category">{{ $blog->category }}</span>
                                        @endif
                                    </div>
                                    <h5><a href="{{ route('blog.detail', $blog) }}">{{ $blog->title }}</a></h5>
                                    <p>{{ Str::limit($blog->excerpt ?? $blog->content, 120) }}</p>
                                    <div class="gt-blog-footer">
                                        <div class="gt-blog-stats">
                                            <span><i class="fas fa-eye"></i> {{ $blog->views }}</span>
                                            <span><i class="fas fa-heart"></i> {{ $blog->likes }}</span>
                                        </div>
                                        <a href="{{ route('blog.detail', $blog) }}" class="gt-blog-link">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- All Blog Posts -->
                <div class="gt-all-blogs">
                    <h4 class="mb-4">All Articles</h4>
                    <div class="row g-4">
                        @forelse($blogs as $blog)
                        <div class="col-md-6">
                            <div class="gt-blog-card">
                                <div class="gt-blog-thumb">
                                    @if($blog->featured_image)
                                    <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-100">
                                    @else
                                    <div class="blog-placeholder">
                                        <i class="fas fa-newspaper fa-2x"></i>
                                    </div>
                                    @endif
                                    <div class="gt-blog-overlay">
                                        <a href="{{ route('blog.detail', $blog) }}" class="gt-theme-btn">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="gt-blog-content">
                                    <div class="gt-blog-meta">
                                        <span class="gt-blog-date">{{ $blog->published_at->format('M d, Y') }}</span>
                                        @if($blog->category)
                                        <span class="gt-blog-category">{{ $blog->category }}</span>
                                        @endif
                                    </div>
                                    <h5><a href="{{ route('blog.detail', $blog) }}">{{ $blog->title }}</a></h5>
                                    <p>{{ Str::limit($blog->excerpt ?? $blog->content, 100) }}</p>
                                    <div class="gt-blog-footer">
                                        <div class="gt-blog-stats">
                                            <span><i class="fas fa-eye"></i> {{ $blog->views }}</span>
                                            <span><i class="fas fa-heart"></i> {{ $blog->likes }}</span>
                                        </div>
                                        <a href="{{ route('blog.detail', $blog) }}" class="gt-blog-link">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <h4>No blog posts available at the moment.</h4>
                                <p class="text-muted">Please check back later for our latest articles.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($blogs->hasPages())
                    <div class="gt-pagination mt-5">
                        {{ $blogs->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="gt-blog-sidebar">
                    <!-- Search Widget -->
                    <div class="gt-sidebar-widget mb-4">
                        <h5>Search Articles</h5>
                        <form action="{{ route('blog') }}" method="GET" class="gt-search-form">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search articles..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    @if($categories->count() > 0)
                    <div class="gt-sidebar-widget mb-4">
                        <h5>Categories</h5>
                        <ul class="gt-category-list">
                            <li>
                                <a href="{{ route('blog') }}" class="{{ !request('category') ? 'active' : '' }}">
                                    All Articles
                                    <span class="count">{{ $blogs->total() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog', ['category' => $category]) }}" class="{{ request('category') === $category ? 'active' : '' }}">
                                    {{ $category }}
                                    <span class="count">{{ \App\Models\Blog::published()->where('category', $category)->count() }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Recent Posts Widget -->
                    <div class="gt-sidebar-widget mb-4">
                        <h5>Recent Posts</h5>
                        <div class="gt-recent-posts">
                            @foreach(\App\Models\Blog::published()->orderBy('published_at', 'desc')->take(5)->get() as $recentBlog)
                            <div class="gt-recent-item">
                                <a href="{{ route('blog.detail', $recentBlog) }}">
                                    <div class="d-flex align-items-center">
                                        @if($recentBlog->featured_image)
                                        <img src="{{ $recentBlog->featured_image }}" alt="{{ $recentBlog->title }}" class="recent-thumb">
                                        @else
                                        <div class="recent-thumb-placeholder">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        @endif
                                        <div class="recent-content">
                                            <h6>{{ Str::limit($recentBlog->title, 50) }}</h6>
                                            <span class="recent-date">{{ $recentBlog->published_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags Widget -->
                    <div class="gt-sidebar-widget">
                        <h5>Popular Tags</h5>
                        <div class="gt-tags">
                            @php
                                $allTags = \App\Models\Blog::published()->get()->pluck('tags')->flatten()->filter()->countBy()->sortDesc()->take(10);
                            @endphp
                            @foreach($allTags as $tag => $count)
                            <a href="{{ route('blog', ['tag' => $tag]) }}" class="gt-tag">
                                {{ $tag }} <span class="count">({{ $count }})</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="gt-newsletter-section fix section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="gt-newsletter-box">
                    <h3>Stay Updated</h3>
                    <p>Subscribe to our newsletter and never miss our latest articles and updates.</p>
                    <form class="gt-newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email address">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.gt-blog-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s;
    height: 100%;
}

.gt-blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.gt-blog-card.featured {
    border: 2px solid #667eea;
}

.gt-blog-thumb {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.gt-blog-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s;
}

.blog-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.gt-blog-card:hover .gt-blog-thumb img {
    transform: scale(1.1);
}

.gt-blog-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(102, 126, 234, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s;
}

.gt-blog-card:hover .gt-blog-overlay {
    opacity: 1;
}

.gt-blog-content {
    padding: 25px;
}

.gt-blog-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.gt-blog-date {
    color: #666;
    font-size: 0.9rem;
}

.gt-blog-category {
    background: #667eea;
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.gt-blog-content h5 {
    margin-bottom: 15px;
}

.gt-blog-content h5 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.gt-blog-content h5 a:hover {
    color: #667eea;
}

.gt-blog-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.gt-blog-stats {
    display: flex;
    gap: 15px;
}

.gt-blog-stats span {
    color: #666;
    font-size: 0.9rem;
}

.gt-blog-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.gt-blog-link:hover {
    color: #764ba2;
}

.gt-sidebar-widget {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.gt-sidebar-widget h5 {
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #667eea;
    padding-bottom: 10px;
}

.gt-search-form .input-group {
    border-radius: 25px;
    overflow: hidden;
}

.gt-category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.gt-category-list li {
    margin-bottom: 10px;
}

.gt-category-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s;
}

.gt-category-list a:hover,
.gt-category-list a.active {
    background: #667eea;
    color: white;
}

.gt-category-list .count {
    background: rgba(255,255,255,0.2);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.gt-recent-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.gt-recent-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.gt-recent-item a {
    text-decoration: none;
    color: inherit;
    transition: color 0.3s;
}

.gt-recent-item a:hover {
    color: #667eea;
}

.recent-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
}

.recent-thumb-placeholder {
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

.recent-content h6 {
    margin: 0 0 5px 0;
    font-size: 0.9rem;
    line-height: 1.4;
}

.recent-date {
    color: #666;
    font-size: 0.8rem;
}

.gt-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.gt-tag {
    background: #f8f9fa;
    color: #667eea;
    padding: 6px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.3s;
}

.gt-tag:hover {
    background: #667eea;
    color: white;
}

.gt-newsletter-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 50px 30px;
    border-radius: 15px;
}

.gt-newsletter-box h3 {
    margin-bottom: 15px;
}

.gt-newsletter-box p {
    margin-bottom: 25px;
    opacity: 0.9;
}

.gt-newsletter-form .input-group {
    border-radius: 25px;
    overflow: hidden;
    max-width: 400px;
    margin: 0 auto;
}

.gt-pagination {
    display: flex;
    justify-content: center;
}

.gt-pagination .pagination {
    margin: 0;
}

.gt-pagination .page-link {
    color: #667eea;
    border-color: #667eea;
}

.gt-pagination .page-link:hover {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
}

.gt-pagination .page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
}
</style>
@endpush
