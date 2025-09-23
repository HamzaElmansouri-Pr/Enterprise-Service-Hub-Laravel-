@extends('admin.layouts.app')

@section('title', 'Blog Management')
@section('page-title', 'Blog Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Blog Posts</h4>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Post
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($blogs->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Views</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td>
                            @if($blog->featured_image)
                                <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <strong>{{ $blog->title }}</strong>
                                @if($blog->excerpt)
                                <br>
                                <small class="text-muted">{{ Str::limit($blog->excerpt, 50) }}</small>
                                @endif
                            </div>
                        </td>
                        <td>{{ $blog->author ?? 'SupremeIT Team' }}</td>
                        <td>
                            @if($blog->category)
                                <span class="badge bg-info">{{ $blog->category }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.blogs.toggle-published', $blog) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $blog->is_published ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.blogs.toggle-featured', $blog) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $blog->is_featured ? 'btn-warning' : 'btn-outline-warning' }}">
                                    <i class="fas fa-star"></i>
                                    {{ $blog->is_featured ? 'Featured' : 'Not Featured' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $blog->views ?? 0 }}</span>
                        </td>
                        <td>
                            @if($blog->published_at)
                                {{ $blog->published_at->format('M d, Y') }}
                            @else
                                <span class="text-muted">Not Published</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $blogs->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-blog fa-3x text-muted mb-3"></i>
            <h4>No Blog Posts Found</h4>
            <p class="text-muted">Start by creating your first blog post.</p>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add New Post
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Quick Stats -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $blogs->total() }}</div>
                <div>Total Posts</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $blogs->where('is_published', true)->count() }}</div>
                <div>Published Posts</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $blogs->where('is_featured', true)->count() }}</div>
                <div>Featured Posts</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $blogs->sum('views') }}</div>
                <div>Total Views</div>
            </div>
        </div>
    </div>
</div>
@endsection
