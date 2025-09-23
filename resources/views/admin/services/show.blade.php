@extends('admin.layouts.app')

@section('title', 'View Service')
@section('page-title', 'Service Details: ' . $service->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Service Information</h5>
                <div class="btn-group">
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-2"></i>
                        Edit Service
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Services
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($service->image)
                            <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" 
                                 class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                        @elseif($service->icon)
                            <div class="d-flex align-items-center justify-content-center bg-light rounded mb-3" 
                                 style="height: 200px;">
                                <i class="{{ $service->icon }} text-primary" style="font-size: 4rem;"></i>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded mb-3" 
                                 style="height: 200px;">
                                <i class="fas fa-cog text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-3">{{ $service->title }}</h2>
                        
                        @if($service->subtitle)
                        <h5 class="text-muted mb-3">{{ $service->subtitle }}</h5>
                        @endif
                        
                        <div class="mb-3">
                            <h6>Description:</h6>
                            <p class="text-muted">{{ $service->description }}</p>
                        </div>
                        
                        @if($service->price)
                        <div class="mb-3">
                            <h6>Pricing:</h6>
                            <span class="h4 text-success">${{ number_format($service->price, 2) }}</span>
                            @if($service->price_unit)
                                <span class="text-muted">/ {{ $service->price_unit }}</span>
                            @endif
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <h6>Status:</h6>
                            <div class="d-flex gap-2">
                                <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($service->is_featured)
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-star me-1"></i>Featured
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($service->features && count($service->features) > 0)
                <div class="mt-4">
                    <h6>Features:</h6>
                    <div class="row">
                        @foreach($service->features as $feature)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>{{ $feature }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        @if($service->tcRequests()->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Service Requests ({{ $service->tcRequests()->count() }})</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service->tcRequests()->latest()->take(5)->get() as $request)
                            <tr>
                                <td>{{ $request->name }}</td>
                                <td>{{ $request->email }}</td>
                                <td>{{ $request->phone }}</td>
                                <td>
                                    <span class="badge {{ $request->status == 'pending' ? 'bg-warning' : ($request->status == 'completed' ? 'bg-success' : 'bg-info') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.tc-requests.show', $request) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($service->tcRequests()->count() > 5)
                <div class="text-center mt-3">
                    <a href="{{ route('admin.tc-requests.index', ['service' => $service->id]) }}" class="btn btn-outline-primary">
                        View All Requests
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Service Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <div class="h4 text-primary">{{ $service->tcRequests()->count() }}</div>
                            <small class="text-muted">Total Requests</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <div class="h4 text-success">{{ $service->tcRequests()->where('status', 'completed')->count() }}</div>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <div class="h4 text-warning">{{ $service->tcRequests()->where('status', 'pending')->count() }}</div>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <div class="h4 text-info">{{ $service->tcRequests()->where('status', 'in_progress')->count() }}</div>
                            <small class="text-muted">In Progress</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Service Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Sort Order:</strong><br>
                    <span class="badge bg-info">{{ $service->sort_order }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    <small class="text-muted">{{ $service->created_at->format('M d, Y H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    <small class="text-muted">{{ $service->updated_at->format('M d, Y H:i') }}</small>
                </div>
                
                @if($service->icon)
                <div class="mb-3">
                    <strong>Icon Class:</strong><br>
                    <code>{{ $service->icon }}</code>
                </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $service->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                            <i class="fas fa-power-off me-2"></i>
                            {{ $service->is_active ? 'Deactivate' : 'Activate' }} Service
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.services.toggle-featured', $service) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $service->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $service->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('service.detail', $service) }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
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
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>
                        Delete Service
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
