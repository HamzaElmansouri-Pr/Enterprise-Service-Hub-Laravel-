@extends('admin.layouts.app')

@section('title', 'View Blog Post')
@section('page-title', 'Blog Post: ' . $blog->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Blog Post Information</h5>
                <div class="btn-group">
                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-2"></i>
                        Edit Post
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Blog Posts
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($blog->featured_image)
                            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" 
                                 class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded mb-3" 
                                 style="height: 200px;">
                                <i class="fas fa-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-3">{{ $blog->title }}</h2>
                        
                        @if($blog->excerpt)
                        <div class="mb-3">
                            <h6>Excerpt:</h6>
                            <p class="text-muted">{{ $blog->excerpt }}</p>
                        </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6>Author:</h6>
                                    <span class="text-muted">{{ $blog->author ?? 'Nova Agency Team' }}</span>
                                </div>
                                
                                @if($blog->category)
                                <div class="mb-3">
                                    <h6>Category:</h6>
                                    <span class="badge bg-info">{{ $blog->category }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6>Views:</h6>
                                    <span class="badge bg-primary">{{ $blog->views ?? 0 }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Likes:</h6>
                                    <span class="badge bg-success">{{ $blog->likes ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Status:</h6>
                            <div class="d-flex gap-2">
                                <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                                @if($blog->is_featured)
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-star me-1"></i>Featured
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($blog->published_at)
                        <div class="mb-3">
                            <h6>Published:</h6>
                            <span class="text-muted">{{ $blog->published_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                @if($blog->tags && count($blog->tags) > 0)
                <div class="mt-4">
                    <h6>Tags:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($blog->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="mt-4">
                    <h6>Content:</h6>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Post Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <div class="h4 text-primary">{{ $blog->views ?? 0 }}</div>
                            <small class="text-muted">Views</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <div class="h4 text-success">{{ $blog->likes ?? 0 }}</div>
                            <small class="text-muted">Likes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Post Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Slug:</strong><br>
                    <code>{{ $blog->slug }}</code>
                </div>
                
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    <small class="text-muted">{{ $blog->created_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    <small class="text-muted">{{ $blog->updated_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">
                        {{ $blog->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Featured:</strong><br>
                    <span class="badge {{ $blog->is_featured ? 'bg-warning' : 'bg-light text-dark' }}">
                        {{ $blog->is_featured ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.blogs.toggle-published', $blog) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $blog->is_published ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="fas fa-eye me-2"></i>
                            {{ $blog->is_published ? 'Unpublish' : 'Publish' }} Post
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.blogs.toggle-featured', $blog) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $blog->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $blog->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('blog.detail', $blog) }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View on Website
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Danger Zone</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this blog post? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>
                        Delete Blog Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
