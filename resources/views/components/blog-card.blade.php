@props(['blog'])

<div class="col-xl-4 col-lg-6 col-md-6">
    <div class="blog-card-items style-2 mt-0 h-100 d-flex flex-column">
        <div class="thumb" style="height: 240px; overflow: hidden;">
                @if($blog->featured_image)
                <img src="{{ resolve_image_url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
            @else
                <div class="blog-placeholder d-flex align-items-center justify-content-center h-100 bg-light">
                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                </div>
            @endif
        </div>
        <div class="content">
            <ul class="post-meta d-flex align-items-center">
                    <li><i class="fa-regular fa-user"></i> {{ $blog->author }}</li>
                    @if($blog->published_at)
                    <li><i class="fa-regular fa-calendar-days"></i> {{ $blog->published_at->format('M d, Y') }}</li>
                    @endif
            </ul>
            <h3><a href="{{ route('blog.show', $blog) }}">{{ $blog->title }}</a></h3>
            <p>{{ Str::limit($blog->excerpt, 100) }}</p>
            <a href="{{ route('blog.show', $blog) }}" class="read-more">Read More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</div>
