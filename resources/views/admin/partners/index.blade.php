@extends('admin.layouts.app')

@section('title', 'Partners')
@section('page-title', 'Partners Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Partner List</h4>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Partner
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80">Logo</th>
                        <th>Name</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $partner)
                    <tr>
                        <td>
                            <img src="{{ $partner->getLogoUrl() }}" alt="{{ $partner->name }}" 
                                 class="img-thumbnail" style="height: 50px; width: 50px; object-fit: contain;">
                        </td>
                        <td><strong>{{ $partner->name }}</strong></td>
                        <td>
                            @if($partner->url)
                                <a href="{{ $partner->url }}" target="_blank">{{ $partner->url }}</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($partner->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $partner->order_index }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this partner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No partners found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $partners->links() }}
        </div>
    </div>
</div>
@endsection
