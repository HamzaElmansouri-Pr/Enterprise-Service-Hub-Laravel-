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
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80">Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td>
                            @if($blog->image)
                                <img src="{{ asset($blog->image) }}" alt="img" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-rss text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">
                            {{ Str::limit($blog->title, 40) }}
                            <div class="small text-muted">{{ $blog->slug }}</div>
                        </td>
                        <td>{{ $blog->author ? $blog->author->name : 'Unknown' }}</td>
                        <td><span class="badge bg-light text-dark">{{ $blog->category ?? 'General' }}</span></td>
                        <td>
                            @if($blog->is_active)
                                <span class="badge bg-success">Published</span>
                                <div class="small text-muted">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</div>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
        <div class="mt-4">
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-newspaper fa-3x text-muted opacity-50"></i>
            </div>
            <h5 class="text-muted">No blog posts found</h5>
            <p class="text-muted small">Share insights and news with your audience.</p>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mt-2">
                Create Post
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
