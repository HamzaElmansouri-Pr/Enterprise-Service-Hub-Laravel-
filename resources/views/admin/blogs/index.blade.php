@extends('admin.layouts.app')

@section('title', 'Blog Management')
@section('page-title', 'Blog Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Blog Posts</h4>
    <div>
        <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
            <i class="fas fa-filter"></i> Filters
        </button>
        <button type="button" class="btn btn-outline-info me-2" id="btn-save-view">
            <i class="fas fa-save"></i> Save View
        </button>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Add New Post
        </a>
    </div>
</div>

<div class="collapse {{ request()->anyFilled(['search', 'status', 'date_from', 'date_to']) ? 'show' : '' }} mb-4" id="filterCollapse">
    <div class="card card-body bg-light">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Title...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions Bar -->
<div id="bulk-actions-bar" class="bg-primary text-white p-3 rounded mb-4 d-none d-flex justify-content-between align-items-center shadow">
    <div>
        <i class="fas fa-check-square me-2"></i>
        <span id="selected-count" class="fw-bold">0</span> items selected
    </div>
    <form id="bulk-action-form" action="{{ route('admin.blogs.bulk-action') }}" method="POST" class="d-flex align-items-center mb-0">
        @csrf
        <input type="hidden" name="ids" id="bulk-ids">
        <select name="action" class="form-select form-select-sm me-2 w-auto">
            <option value="">Choose action...</option>
            <option value="publish">Publish Selected</option>
            <option value="draft">Draft Selected</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="submit" class="btn btn-light btn-sm text-primary fw-bold" onclick="return confirm('Are you sure you want to perform this bulk action?')">Apply</button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        @if($blogs->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox" class="form-check-input" id="select-all-rows"></th>
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
                        <td><input type="checkbox" class="form-check-input row-selector" value="{{ $blog->id }}"></td>
                        <td>
                            @if($blog->image)
                                <img src="{{ resolve_image_url($blog->image, ['w' => 100, 'h' => 100, 'c' => 'fill']) }}" alt="img" 
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
                            <div data-inline-edit="is_active" data-inline-type="select" data-value="{{ $blog->is_active ? '1' : '0' }}" data-inline-url="{{ route('admin.blogs.inline-update', $blog) }}" class="d-inline-block">
                                @if($blog->is_active)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                            <div class="small text-muted mt-1">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</div>
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
