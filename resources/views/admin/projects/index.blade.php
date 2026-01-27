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
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80">Image</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>
                            @if($project->image)
                                <img src="{{ asset($project->image) }}" alt="img" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $project->title }}</td>
                        <td>{{ $project->client ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $project->category ?? 'General' }}</span></td>
                        <td>
                            @if($project->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>{{ $project->order_index }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" 
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
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-project-diagram fa-3x text-muted opacity-50"></i>
            </div>
            <h5 class="text-muted">No projects found</h5>
            <p class="text-muted small">Share your success stories by adding a project.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mt-2">
                Create Project
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
