@extends('admin.layouts.app')

@section('title', 'Services Management')
@section('page-title', 'Services Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Services</h4>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Service
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($services->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Sort Order</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @elseif($service->icon)
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="width: 50px; height: 50px;">
                                    <i class="{{ $service->icon }} text-primary"></i>
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-cog text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <strong>{{ $service->title }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                            </div>
                        </td>
                        <td>{{ $service->subtitle ?? '-' }}</td>
                        <td>
                            @if($service->price)
                                <span class="fw-bold text-success">${{ number_format($service->price, 2) }}</span>
                                @if($service->price_unit)
                                    <small class="text-muted">/ {{ $service->price_unit }}</small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $service->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.services.toggle-featured', $service) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $service->is_featured ? 'btn-warning' : 'btn-outline-warning' }}">
                                    <i class="fas fa-star"></i>
                                    {{ $service->is_featured ? 'Featured' : 'Not Featured' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $service->sort_order }}</span>
                        </td>
                        <td>{{ $service->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this service?')">
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
            {{ $services->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
            <h4>No Services Found</h4>
            <p class="text-muted">Start by creating your first service.</p>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add New Service
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
                <div class="stats-number">{{ $services->total() }}</div>
                <div>Total Services</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $services->where('is_active', true)->count() }}</div>
                <div>Active Services</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $services->where('is_featured', true)->count() }}</div>
                <div>Featured Services</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="stats-number">{{ $services->where('price', '>', 0)->count() }}</div>
                <div>Paid Services</div>
            </div>
        </div>
    </div>
</div>
@endsection
