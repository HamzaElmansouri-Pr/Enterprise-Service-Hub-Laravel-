@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
@php($user = auth()->user())
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Admin Settings
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    @if($user && $user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" 
                                             class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto" 
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6 class="card-title">{{ $user?->name }}</h6>
                                <p class="text-muted mb-3">{{ $user?->email }}</p>
                                <a href="{{ route('admin.settings.edit-profile') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-lock text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="card-title">Password Security</h6>
                                <p class="text-muted mb-3">Update your password for better security</p>
                                <a href="{{ route('admin.settings.edit-password') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-key me-1"></i>
                                    Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row">
                    <div class="col-12">
                        <h6 class="mb-3">Account Information</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name:</td>
                                        <td>{{ $user?->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email:</td>
                                        <td>{{ $user?->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Member Since:</td>
                                        <td>{{ optional($user?->created_at)->format('F j, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Last Updated:</td>
                                        <td>{{ optional($user?->updated_at)->format('F j, Y g:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.settings.edit-profile') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Profile
                    </a>
                    <a href="{{ route('admin.settings.edit-password') }}" class="btn btn-outline-warning">
                        <i class="fas fa-key me-2"></i>
                        Change Password
                    </a>
                    <a href="{{ route('admin.settings.2fa') }}" class="btn btn-outline-info">
                        <i class="fas fa-shield-alt me-2"></i>
                        Two-Factor Authentication
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    Security Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use a strong, unique password
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Update your password regularly
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Keep your profile information current
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Log out when finished
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
