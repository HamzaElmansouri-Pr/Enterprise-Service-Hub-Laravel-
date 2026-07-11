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
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80">Icon</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>
                            @if($service->image)
                                <img src="{{ resolve_image_url($service->image, ['w' => 100, 'h' => 100, 'c' => 'fill']) }}" alt="img" 
                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @elseif($service->icon)
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="width: 50px; height: 50px;">
                                     {{-- Check if icon is a path or class --}}
                                     @if(Str::startsWith($service->icon, 'storage/'))
                                        <img src="{{ asset($service->icon) }}" style="width:30px;height:30px;">
                                     @else
                                        <i class="{{ $service->icon }} text-primary fa-lg"></i>
                                     @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $service->title }}</td>
                        <td class="text-muted small">{{ $service->slug }}</td>
                        <td>
                            @if($service->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>{{ $service->order_index }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" 
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
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-cogs fa-3x text-muted opacity-50"></i>
            </div>
            <h5 class="text-muted">No services found</h5>
            <p class="text-muted small">Get started by creating your first service.</p>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary mt-2">
                Create Service
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
