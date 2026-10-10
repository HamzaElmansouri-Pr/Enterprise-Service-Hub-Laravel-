@extends('admin.layouts.app')

@section('title', 'View Project')
@section('page-title', 'Project Details: ' . $project->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Project Information</h5>
                <div class="btn-group">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-2"></i>
                        Edit Project
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Projects
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($project->image)
                            <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" 
                                 class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded mb-3" 
                                 style="height: 200px;">
                                <i class="fas fa-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-3">{{ $project->title }}</h2>
                        
                        @if($project->subtitle)
                        <h5 class="text-muted mb-3">{{ $project->subtitle }}</h5>
                        @endif
                        
                        <div class="mb-3">
                            <h6>Description:</h6>
                            <p class="text-muted">{{ $project->description }}</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                @if($project->client)
                                <div class="mb-3">
                                    <h6>Client:</h6>
                                    <span class="text-muted">{{ $project->client }}</span>
                                </div>
                                @endif
                                
                                @if($project->categories->isNotEmpty())
                                <div class="mb-3">
                                    <h6>Categories:</h6>
                                    @foreach($project->categories as $c)
                                        <span class="badge bg-info text-dark me-1">{{ get_content_value($c->name) }}</span>
                                    @endforeach
                                </div>
                                @elseif($project->category)
                                <div class="mb-3">
                                    <h6>Category:</h6>
                                    <span class="badge bg-info">{{ $project->category }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($project->project_date)
                                <div class="mb-3">
                                    <h6>Project Date:</h6>
                                    <span class="text-muted">{{ $project->project_date->format('M d, Y') }}</span>
                                </div>
                                @endif
                                
                                @if($project->project_url)
                                <div class="mb-3">
                                    <h6>Project URL:</h6>
                                    <a href="{{ $project->project_url }}" target="_blank" class="text-primary">
                                        {{ $project->project_url }} <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Status:</h6>
                            <div class="d-flex gap-2">
                                <span class="badge {{ $project->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($project->is_featured)
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-star me-1"></i>Featured
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($project->technologies && count($project->technologies) > 0)
                <div class="mt-4">
                    <h6>Technologies Used:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($project->technologies as $technology)
                        <span class="badge bg-primary">{{ $technology }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($project->gallery && count($project->gallery) > 0)
                <div class="mt-4">
                    <h6>Project Gallery:</h6>
                    <div class="row g-2">
                        @foreach($project->gallery as $image)
                        <div class="col-md-3">
                            <img src="{{ asset($image) }}" alt="Gallery Image" 
                                 class="img-fluid rounded" style="height: 150px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($project->challenge || $project->solution || $project->result)
                <div class="row mt-4">
                    @if($project->challenge)
                    <div class="col-md-4">
                        <h6>Challenge:</h6>
                        <p class="text-muted">{{ $project->challenge }}</p>
                    </div>
                    @endif
                    
                    @if($project->solution)
                    <div class="col-md-4">
                        <h6>Solution:</h6>
                        <p class="text-muted">{{ $project->solution }}</p>
                    </div>
                    @endif
                    
                    @if($project->result)
                    <div class="col-md-4">
                        <h6>Result:</h6>
                        <p class="text-muted">{{ $project->result }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Project Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Sort Order:</strong><br>
                    <span class="badge bg-info">{{ $project->sort_order }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    <small class="text-muted">{{ $project->created_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    <small class="text-muted">{{ $project->updated_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Status:</strong><br>
                    <span class="badge {{ $project->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $project->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Featured:</strong><br>
                    <span class="badge {{ $project->is_featured ? 'bg-warning' : 'bg-light text-dark' }}">
                        {{ $project->is_featured ? 'Yes' : 'No' }}
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
                    <form action="{{ route('admin.projects.toggle-status', $project) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $project->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="fas fa-power-off me-2"></i>
                            {{ $project->is_active ? 'Deactivate' : 'Activate' }} Project
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.projects.toggle-featured', $project) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $project->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $project->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                    
                    @if($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View Live Project
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Danger Zone</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>
                        Delete Project
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
