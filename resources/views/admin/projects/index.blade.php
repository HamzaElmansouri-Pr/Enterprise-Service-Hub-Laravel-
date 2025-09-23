@extends('admin.layouts.app')

@section('title', 'Projects Management')
@section('page-title', 'Projects Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Projects</h4>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Project
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($projects->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Category</th>
                        <th>Project Date</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Sort Order</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>
                            @if($project->image)
                                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" 
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
                                <strong>{{ $project->title }}</strong>
                                @if($project->subtitle)
                                <br>
                                <small class="text-muted">{{ $project->subtitle }}</small>
                                @endif
                            </div>
                        </td>
                        <td>{{ $project->client ?? '-' }}</td>
                        <td>
                            @if($project->category)
                                <span class="badge bg-info">{{ $project->category }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($project->project_date)
                                {{ $project->project_date->format('M d, Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.projects.toggle-status', $project) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $project->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.projects.toggle-featured', $project) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $project->is_featured ? 'btn-warning' : 'btn-outline-warning' }}">
                                    <i class="fas fa-star"></i>
                                    {{ $project->is_featured ? 'Featured' : 'Not Featured' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $project->sort_order }}</span>
                        </td>
                        <td>{{ $project->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this project?')">
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
            {{ $projects->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
            <h4>No Projects Found</h4>
            <p class="text-muted">Start by creating your first project.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add New Project
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
                <div class="stats-number">{{ $projects->total() }}</div>
                <div>Total Projects</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $projects->where('is_active', true)->count() }}</div>
                <div>Active Projects</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $projects->where('is_featured', true)->count() }}</div>
                <div>Featured Projects</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $projects->whereNotNull('project_url')->count() }}</div>
                <div>With Live URLs</div>
            </div>
        </div>
    </div>
</div>
@endsection
