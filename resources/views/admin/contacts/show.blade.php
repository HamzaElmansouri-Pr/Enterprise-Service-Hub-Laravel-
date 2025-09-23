@extends('admin.layouts.app')

@section('title', 'Contact Message Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Contact Message Details</h3>
                    <div class="d-flex gap-2">
                        @if($contact->is_read)
                        <form action="{{ route('admin.contacts.mark-unread', $contact) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-envelope"></i> Mark as Unread
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-envelope-open"></i> Mark as Read
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Contacts
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Message Content</h5>
                                </div>
                                <div class="card-body">
                                    @if($contact->subject)
                                    <h4 class="mb-3">{{ $contact->subject }}</h4>
                                    @endif
                                    <div class="mb-3">
                                        <p class="text-muted">{{ $contact->message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Name:</strong> {{ $contact->name }}</p>
                                    <p><strong>Email:</strong> 
                                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                    </p>
                                    @if($contact->phone)
                                    <p><strong>Phone:</strong> 
                                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                    </p>
                                    @endif
                                    <p><strong>Status:</strong> 
                                        <span class="badge {{ $contact->is_read ? 'bg-success' : 'bg-warning' }}">
                                            {{ $contact->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </p>
                                    <p><strong>Received:</strong> {{ $contact->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
