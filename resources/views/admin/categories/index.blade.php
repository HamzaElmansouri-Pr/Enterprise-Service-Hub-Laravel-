@extends('admin.layouts.app')

@section('title', 'Categories Management')
@section('page-title', 'Categories Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Project Categories</h4>
        <p class="text-muted small mb-0">Organize projects into categories for better discovery and navigation.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Category
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="60">Order</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Projects</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $category->order_index }}</span>
                        </td>
                        <td>
                            <div class="fw-bold">{{ get_content_value($category->name) }}</div>
                            @if(is_array($category->name))
                                <div class="text-muted small">
                                    @foreach($category->name as $locale => $val)
                                        @if(!empty($val))
                                            <span class="badge bg-secondary-subtle text-secondary me-1">{{ strtoupper($locale) }}: {{ $val }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            <code>{{ $category->slug }}</code>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                <i class="fas fa-project-diagram me-1"></i>{{ $category->projects_count }} {{ Str::plural('project', $category->projects_count) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent text-decoration-none" title="Click to toggle status">
                                    @if($category->is_active)
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Active</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-pause-circle me-1"></i>Inactive</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this category? It will be removed from all attached projects.');">
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
        <div class="mt-4">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-tags fa-3x text-muted opacity-50"></i>
            </div>
            <h5 class="text-muted">No categories found</h5>
            <p class="text-muted small">Create categories to group your projects.</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">
                Create Category
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
