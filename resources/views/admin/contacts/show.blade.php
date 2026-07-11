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
                                        @if($contact->replied_at)
                                            <span class="badge bg-success">Replied</span>
                                        @elseif($contact->is_read)
                                            <span class="badge bg-info">Read</span>
                                        @else
                                            <span class="badge bg-warning">Unread</span>
                                        @endif
                                    </p>
                                    <p><strong>Received:</strong> {{ $contact->created_at->format('M d, Y H:i') }}</p>
                                    @if($contact->replied_at)
                                    <p><strong>Replied:</strong> {{ $contact->replied_at->format('M d, Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h5 class="mb-0">Reply to Inquiry</h5>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" id="inquiry_context" value="{{ 'Contact Name: ' . $contact->name . '. Inquiry: ' . $contact->message }}">
                                    
                                    <x-admin.ai-generator 
                                        target="[name='reply_message']" 
                                        context_target="#inquiry_context" 
                                        type="email_reply" 
                                        label="Draft Reply with AI" 
                                    />

                                    <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="reply_message" class="form-label">Message Content</label>
                                            <textarea name="reply_message" id="reply_message" rows="8" class="form-control" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-1"></i> Send Reply
                                        </button>
                                    </form>
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
