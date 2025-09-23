@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards Row 1 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_users'] ?? '0' }}</div>
                        <div class="text-white-50">Total Users</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_services'] ?? '0' }}</div>
                        <div class="text-white-50">Services</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cogs fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_projects'] ?? '0' }}</div>
                        <div class="text-white-50">Projects</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-project-diagram fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_blogs'] ?? '0' }}</div>
                        <div class="text-white-50">Blog Posts</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-blog fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stats Cards Row 2 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_contacts'] ?? '0' }}</div>
                        <div class="text-white-50">Contact Forms</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_tc_requests'] ?? '0' }}</div>
                        <div class="text-white-50">Service Requests</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_reviews'] ?? '0' }}</div>
                        <div class="text-white-50">Reviews</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_sliders'] ?? '0' }}</div>
                        <div class="text-white-50">Sliders</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-images fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Alert Cards -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number text-warning">{{ $stats['unread_contacts'] ?? '0' }}</div>
                        <div class="text-muted">Unread Contacts</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope-open fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number text-info">{{ $stats['unread_tc_requests'] ?? '0' }}</div>
                        <div class="text-muted">Unread Service Requests</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stats-number text-danger">{{ $stats['pending_tc_requests'] ?? '0' }}</div>
                        <div class="text-muted">Pending Requests</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary w-100 p-3">
                            <i class="fas fa-cogs fa-2x mb-2"></i>
                            <div>Services</div>
                            <small class="text-muted">Manage services</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-success w-100 p-3">
                            <i class="fas fa-project-diagram fa-2x mb-2"></i>
                            <div>Projects</div>
                            <small class="text-muted">Manage projects</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-info w-100 p-3">
                            <i class="fas fa-blog fa-2x mb-2"></i>
                            <div>Blog Posts</div>
                            <small class="text-muted">Manage blog content</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-warning w-100 p-3">
                            <i class="fas fa-star fa-2x mb-2"></i>
                            <div>Reviews</div>
                            <small class="text-muted">Manage client reviews</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary w-100 p-3">
                            <i class="fas fa-images fa-2x mb-2"></i>
                            <div>Sliders</div>
                            <small class="text-muted">Manage homepage sliders</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-dark w-100 p-3">
                            <i class="fas fa-envelope fa-2x mb-2"></i>
                            <div>Contacts</div>
                            <small class="text-muted">View contact messages</small>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.tc-requests.index') }}" class="btn btn-outline-danger w-100 p-3">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <div>Service Requests</div>
                            <small class="text-muted">Manage TC requests</small>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.content.index') }}" class="btn btn-outline-primary w-100 p-3">
                            <i class="fas fa-edit fa-2x mb-2"></i>
                            <div>Content Management</div>
                            <small class="text-muted">Edit website content</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    @if($recentContacts->count() > 0)
                    <h6 class="text-muted mb-3">Recent Contacts</h6>
                    @foreach($recentContacts as $contact)
                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon me-3">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">{{ $contact->name }}</div>
                            <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    
                    @if($recentTcRequests->count() > 0)
                    <h6 class="text-muted mb-3 mt-4">Recent Service Requests</h6>
                    @foreach($recentTcRequests as $request)
                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon me-3">
                            <i class="fas fa-file-alt text-info"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">{{ $request->service ? $request->service->title : 'Service Request' }}</div>
                            <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    
                    @if($recentBlogs->count() > 0)
                    <h6 class="text-muted mb-3 mt-4">Recent Blog Posts</h6>
                    @foreach($recentBlogs as $blog)
                    <div class="activity-item d-flex mb-3">
                        <div class="activity-icon me-3">
                            <i class="fas fa-blog text-success"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">{{ Str::limit($blog->title, 30) }}</div>
                            <small class="text-muted">{{ $blog->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Website Content Overview -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-globe me-2"></i>
                    Website Content Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="content-section">
                            <h6 class="text-primary">
                                <i class="fas fa-home me-2"></i>
                                Home Page
                            </h6>
                            <p class="text-muted mb-2">Main landing page content</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Published</span>
                                <a href="{{ route('admin.content.edit', 'home') }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="content-section">
                            <h6 class="text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                About Page
                            </h6>
                            <p class="text-muted mb-2">Company information and team</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Published</span>
                                <a href="{{ route('admin.content.edit', 'about') }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="content-section">
                            <h6 class="text-primary">
                                <i class="fas fa-envelope me-2"></i>
                                Contact Page
                            </h6>
                            <p class="text-muted mb-2">Contact information and form</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Published</span>
                                <a href="{{ route('admin.content.edit', 'contact') }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- System Information -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-server me-2"></i>
                    System Information
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Laravel Version:</strong></td>
                        <td>{{ app()->version() }}</td>
                    </tr>
                    <tr>
                        <td><strong>PHP Version:</strong></td>
                        <td>{{ PHP_VERSION }}</td>
                    </tr>
                    <tr>
                        <td><strong>Server:</strong></td>
                        <td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Database:</strong></td>
                        <td>{{ config('database.default') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Quick Stats
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="stat-item">
                            <div class="h4 text-primary mb-1">{{ $stats['today_visitors'] ?? '0' }}</div>
                            <small class="text-muted">Today's Visitors</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-item">
                            <div class="h4 text-success mb-1">{{ $stats['this_week_visitors'] ?? '0' }}</div>
                            <small class="text-muted">This Week</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-item">
                            <div class="h4 text-info mb-1">{{ $stats['this_month_visitors'] ?? '0' }}</div>
                            <small class="text-muted">This Month</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-item">
                            <div class="h4 text-warning mb-1">{{ $stats['total_contacts'] ?? '0' }}</div>
                            <small class="text-muted">Contact Forms</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
