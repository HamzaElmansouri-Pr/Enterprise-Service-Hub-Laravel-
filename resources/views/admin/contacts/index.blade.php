@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Contact Messages</h3>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.contacts.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-check-double"></i> Mark All as Read
                            </button>
                        </form>
                    </div>
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
                                    <th>
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                                    <td>
                                        <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" class="form-check-input contact-checkbox">
                                    </td>
                                    <td>{{ $contact->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ $contact->name }}
                                            @if(!$contact->is_read)
                                            <span class="badge bg-primary ms-2">New</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($contact->subject ?? 'No Subject', 30) }}</td>
                                    <td>
                                        @if($contact->is_read)
                                            <form action="{{ route('admin.contacts.mark-unread', $contact) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-envelope-open"></i> Read
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-envelope"></i> Unread
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $contact->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this contact message?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No contact messages found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contacts->count() > 0)
                    <div class="mt-3">
                        <form action="{{ route('admin.contacts.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="contact_ids" id="selectedContacts">
                            <button type="submit" class="btn btn-danger" id="bulkDeleteBtn" disabled>
                                <i class="fas fa-trash"></i> Delete Selected
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($contacts->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $contacts->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const contactCheckboxes = document.querySelectorAll('.contact-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedContactsInput = document.getElementById('selectedContacts');

    selectAllCheckbox.addEventListener('change', function() {
        contactCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkDeleteButton();
    });

    contactCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkDeleteButton();
        });
    });

    function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
        const checkedIds = Array.from(checkedBoxes).map(cb => cb.value);
        
        selectedContactsInput.value = JSON.stringify(checkedIds);
        bulkDeleteBtn.disabled = checkedIds.length === 0;
    }
});
</script>
@endsection
