@extends('layouts.app')

@section('title', $blog->title . ' - SupremeIT Blog')
@section('page-title', $blog->title)

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $blog->title }}</h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('blog') }}">Blog</a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>{{ Str::limit($blog->title, 30) }}</li>
            </ul>
        </div>
    </div>
</div>

<!-- Blog Detail Section Start -->
<section class="gt-blog-detail-section fix section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="gt-blog-detail-content">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                    <div class="gt-blog-featured-image mb-4">
                        <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-100 rounded">
                    </div>
                    @endif

                    <!-- Blog Meta -->
                    <div class="gt-blog-meta mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="gt-blog-author">
                                    <div class="d-flex align-items-center">
                                        <div class="author-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="author-info">
                                            <h6>{{ $blog->author }}</h6>
                                            <span class="text-muted">{{ $blog->published_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="gt-blog-stats text-md-end">
                                    <span class="stat-item">
                                        <i class="fas fa-eye"></i>
                                        {{ $blog->views }} views
                                    </span>
                                    <span class="stat-item">
                                        <i class="fas fa-heart"></i>
                                        {{ $blog->likes }} likes
                                    </span>
                                    <span class="stat-item">
                                        <i class="fas fa-clock"></i>
                                        {{ $blog->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Content -->
                    <div class="gt-blog-content">
                        <h1 class="gt-blog-title">{{ $blog->title }}</h1>
                        
                        @if($blog->excerpt)
                        <div class="gt-blog-excerpt">
                            <p class="lead">{{ $blog->excerpt }}</p>
                        </div>
                        @endif

                        <div class="gt-blog-body">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    <!-- Blog Tags -->
                    @if($blog->tags && count($blog->tags) > 0)
                    <div class="gt-blog-tags mb-4">
                        <h6>Tags:</h6>
                        <div class="gt-tags">
                            @foreach($blog->tags as $tag)
                            <a href="{{ route('blog', ['tag' => $tag]) }}" class="gt-tag">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Social Share -->
                    <div class="gt-social-share mb-5">
                        <h6>Share this article:</h6>
                        <div class="gt-share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="gt-share-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="gt-share-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="gt-share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($blog->title) }}" target="_blank" class="gt-share-btn pinterest">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Author Bio -->
                    <div class="gt-author-bio mb-5">
                        <div class="gt-author-card">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="gt-author-avatar">
                                        <i class="fas fa-user fa-3x"></i>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="gt-author-info">
                                        <h5>{{ $blog->author }}</h5>
                                        <p class="text-muted">Content Writer at SupremeIT</p>
                                        <p>Passionate about technology and helping businesses grow through innovative solutions. With years of experience in the industry, I love sharing insights and best practices.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Articles -->
                    @if($relatedBlogs->count() > 0)
                    <div class="gt-related-articles">
                        <h4>Related Articles</h4>
                        <div class="row g-4">
                            @foreach($relatedBlogs as $relatedBlog)
                            <div class="col-md-6">
                                <div class="gt-blog-card">
                                    <div class="gt-blog-thumb">
                                        @if($relatedBlog->featured_image)
                                        <img src="{{ $relatedBlog->featured_image }}" alt="{{ $relatedBlog->title }}" class="w-100">
                                        @else
                                        <div class="blog-placeholder">
                                            <i class="fas fa-newspaper fa-2x"></i>
                                        </div>
                                        @endif
                                        <div class="gt-blog-overlay">
                                            <a href="{{ route('blog.detail', $relatedBlog) }}" class="gt-theme-btn">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="gt-blog-content">
                                        <div class="gt-blog-meta">
                                            <span class="gt-blog-date">{{ $relatedBlog->published_at->format('M d, Y') }}</span>
                                            @if($relatedBlog->category)
                                            <span class="gt-blog-category">{{ $relatedBlog->category }}</span>
                                            @endif
                                        </div>
                                        <h5><a href="{{ route('blog.detail', $relatedBlog) }}">{{ $relatedBlog->title }}</a></h5>
                                        <p>{{ Str::limit($relatedBlog->excerpt ?? $relatedBlog->content, 100) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="gt-blog-sidebar">
                    <!-- Table of Contents -->
                    <div class="gt-sidebar-widget mb-4">
                        <h5>Table of Contents</h5>
                        <div class="gt-toc">
                            <ul id="toc-list">
                                <!-- This will be populated by JavaScript -->
                            </ul>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="gt-sidebar-widget mb-4">
                        <h5>Categories</h5>
                        <ul class="gt-category-list">
                            <li>
                                <a href="{{ route('blog') }}" class="{{ !request('category') ? 'active' : '' }}">
                                    All Articles
                                </a>
                            </li>
                            @foreach(\App\Models\Blog::published()->distinct()->pluck('category')->filter() as $category)
                            <li>
                                <a href="{{ route('blog', ['category' => $category]) }}" class="{{ request('category') === $category ? 'active' : '' }}">
                                    {{ $category }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Posts Widget -->
                    <div class="gt-sidebar-widget mb-4">
                        <h5>Recent Posts</h5>
                        <div class="gt-recent-posts">
                            @foreach(\App\Models\Blog::published()->where('id', '!=', $blog->id)->orderBy('published_at', 'desc')->take(5)->get() as $recentBlog)
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

                    <!-- Newsletter Widget -->
                    <div class="gt-sidebar-widget">
                        <h5>Newsletter</h5>
                        <p>Subscribe to our newsletter for the latest updates and articles.</p>
                        <form class="gt-newsletter-form">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Enter your email">
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.gt-blog-detail-content {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.gt-blog-featured-image img {
    border-radius: 10px;
}

.gt-blog-author .author-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.gt-blog-author .author-info h6 {
    margin: 0 0 5px 0;
    color: #333;
}

.gt-blog-stats .stat-item {
    margin-right: 20px;
    color: #666;
    font-size: 0.9rem;
}

.gt-blog-stats .stat-item i {
    margin-right: 5px;
    color: #667eea;
}

.gt-blog-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.2;
}

.gt-blog-excerpt .lead {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 30px;
}

.gt-blog-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.gt-blog-body h1,
.gt-blog-body h2,
.gt-blog-body h3,
.gt-blog-body h4,
.gt-blog-body h5,
.gt-blog-body h6 {
    margin-top: 30px;
    margin-bottom: 15px;
    color: #333;
}

.gt-blog-body p {
    margin-bottom: 20px;
}

.gt-blog-body ul,
.gt-blog-body ol {
    margin-bottom: 20px;
    padding-left: 30px;
}

.gt-blog-body blockquote {
    border-left: 4px solid #667eea;
    padding-left: 20px;
    margin: 30px 0;
    font-style: italic;
    color: #666;
}

.gt-blog-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
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
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s;
}

.gt-tag:hover {
    background: #667eea;
    color: white;
}

.gt-share-buttons {
    display: flex;
    gap: 10px;
}

.gt-share-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: white;
    transition: all 0.3s;
}

.gt-share-btn.facebook {
    background: #3b5998;
}

.gt-share-btn.twitter {
    background: #1da1f2;
}

.gt-share-btn.linkedin {
    background: #0077b5;
}

.gt-share-btn.pinterest {
    background: #bd081c;
}

.gt-share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.gt-author-card {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.gt-author-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.gt-author-info h5 {
    margin-bottom: 10px;
    color: #333;
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

.gt-toc ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.gt-toc li {
    margin-bottom: 8px;
}

.gt-toc a {
    color: #666;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s;
}

.gt-toc a:hover {
    color: #667eea;
}

.gt-category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.gt-category-list li {
    margin-bottom: 8px;
}

.gt-category-list a {
    display: block;
    padding: 8px 12px;
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.gt-category-list a:hover,
.gt-category-list a.active {
    background: #667eea;
    color: white;
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

.gt-blog-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s;
}

.gt-blog-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.gt-blog-thumb {
    position: relative;
    height: 150px;
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
    padding: 20px;
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
    margin-bottom: 10px;
}

.gt-blog-content h5 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.gt-blog-content h5 a:hover {
    color: #667eea;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Table of Contents
    const headings = document.querySelectorAll('.gt-blog-body h1, .gt-blog-body h2, .gt-blog-body h3, .gt-blog-body h4, .gt-blog-body h5, .gt-blog-body h6');
    const tocList = document.getElementById('toc-list');
    
    if (headings.length > 0) {
        headings.forEach((heading, index) => {
            // Add ID to heading
            const id = 'heading-' + index;
            heading.id = id;
            
            // Create TOC item
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#' + id;
            a.textContent = heading.textContent;
            a.style.paddingLeft = (parseInt(heading.tagName.charAt(1)) - 1) * 15 + 'px';
            li.appendChild(a);
            tocList.appendChild(li);
        });
    } else {
        tocList.innerHTML = '<li>No headings found</li>';
    }
});
</script>
@endpush
