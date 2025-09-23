@extends('admin.layouts.app')

@section('title', 'Service Request Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Service Request Details</h3>
                    <div class="d-flex gap-2">
                        @if($tcRequest->is_read)
                        <form action="{{ route('admin.tc-requests.mark-unread', $tcRequest) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-envelope"></i> Mark as Unread
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.tc-requests.mark-read', $tcRequest) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-envelope-open"></i> Mark as Read
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.tc-requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Service Requests
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Request Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>Project Description:</h6>
                                        <p class="text-muted">{{ $tcRequest->description }}</p>
                                    </div>
                                    
                                    @if($tcRequest->attached_file)
                                    <div class="mb-3">
                                        <h6>Attached File:</h6>
                                        <a href="{{ route('admin.tc-requests.download-file', $tcRequest) }}" 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-download"></i> Download File
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Request Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Email:</strong> 
                                        <a href="mailto:{{ $tcRequest->email }}">{{ $tcRequest->email }}</a>
                                    </p>
                                    <p><strong>Service:</strong> 
                                        @if($tcRequest->service)
                                            <span class="badge bg-info">{{ $tcRequest->service->title }}</span>
                                        @else
                                            <span class="text-muted">No Service Selected</span>
                                        @endif
                                    </p>
                                    <p><strong>Status:</strong> 
                                        <span class="badge {{ $tcRequest->is_read ? 'bg-success' : 'bg-warning' }}">
                                            {{ $tcRequest->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </p>
                                    <p><strong>Submitted:</strong> {{ $tcRequest->created_at->format('M d, Y H:i') }}</p>
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
