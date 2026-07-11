@extends('admin.layouts.app')

@section('title', 'Trash Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-trash me-2 text-danger"></i> Trash Management
                    </h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Module Selector -->
                    <ul class="nav nav-tabs mb-4">
                        @php
                            $modules = [
                                'services' => 'Services',
                                'projects' => 'Projects',
                                'blogs' => 'Blogs',
                                'contacts' => 'Contacts',
                                'tc-requests' => 'TC Requests',
                                'reviews' => 'Reviews',
                                'sliders' => 'Sliders',
                            ];
                        @endphp
                        
                        @foreach($modules as $key => $label)
                            <li class="nav-item">
                                <a class="nav-link {{ $type === $key ? 'active' : '' }}" href="{{ route('admin.trash.index', ['type' => $key]) }}">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title / Name / Email</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if(isset($item->title))
                                                {{ $item->title }}
                                            @elseif(isset($item->name))
                                                {{ $item->name }}
                                            @elseif(isset($item->email))
                                                {{ $item->email }}
                                            @elseif(isset($item->client_name))
                                                {{ $item->client_name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">
                                                {{ $item->deleted_at->format('M d, Y H:i') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Restore Button -->
                                                <form action="{{ route('admin.trash.restore', ['type' => $type, 'id' => $item->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore" onclick="return confirm('Restore this item?')">
                                                        <i class="fas fa-trash-restore"></i> Restore
                                                    </button>
                                                </form>
                                                
                                                <!-- Force Delete Button -->
                                                <form action="{{ route('admin.trash.force-delete', ['type' => $type, 'id' => $item->id]) }}" method="POST" class="d-inline ms-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Permanently Delete" onclick="return confirm('WARNING: This will permanently delete this item. Are you sure?')">
                                                        <i class="fas fa-times"></i> Delete Permanently
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                            <p class="text-muted">No trashed items found in this module.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($items->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $items->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
