@extends('admin.layouts.app')

@section('title', 'Sliders Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Sliders Management</h3>
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Slider
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Button Text</th>
                                    <th>Status</th>
                                    <th>Sort Order</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td>
                                        @if($slider->image)
                                        <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" 
                                             class="img-thumbnail" width="80" height="50" style="object-fit: cover;">
                                        @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                             style="width: 80px; height: 50px;">
                                            <i class="fas fa-image text-white"></i>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($slider->title, 30) }}</td>
                                    <td>{{ Str::limit($slider->subtitle, 30) }}</td>
                                    <td>{{ $slider->button_text ?? 'N/A' }}</td>
                                    <td>
                                        <form action="{{ route('admin.sliders.toggle-active', $slider) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $slider->is_active ? 'btn-success' : 'btn-warning' }}">
                                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $slider->sort_order }}</td>
                                    <td>{{ $slider->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this slider?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No sliders found.</p>
                                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add First Slider
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($sliders->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sliders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
