@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">User Details</h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <div class="bg-primary rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5>User Information</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Name:</strong> {{ $user->name }}</p>
                                    <p><strong>Email:</strong> {{ $user->email }}</p>
                                    <p><strong>Role:</strong> 
                                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-info' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </p>
                                    <p><strong>Status:</strong> 
                                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-warning' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                    <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y H:i') }}</p>
                                    <p><strong>Updated:</strong> {{ $user->updated_at->format('M d, Y H:i') }}</p>
                                    
                                    @if($user->id === auth()->id())
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i> This is your account.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Account Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>User ID:</strong> {{ $user->id }}</p>
                                            <p><strong>Email Verified:</strong> 
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-warning">Not Verified</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Last Login:</strong> 
                                                {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}
                                            </p>
                                            <p><strong>Login Count:</strong> {{ $user->login_count ?? 0 }}</p>
                                        </div>
                                    </div>
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
