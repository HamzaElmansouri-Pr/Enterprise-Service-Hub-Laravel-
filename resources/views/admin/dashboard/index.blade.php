@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- High Priority Dashboard Heartbeat --}}
@if(($stats['unread_contacts'] ?? 0) > 0 || ($stats['pending_tc_requests'] ?? 0) > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center alert-card-pulse py-3">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <h5 class="alert-heading mb-1 fw-bold">Action Required: New Inquiries Pending</h5>
                <p class="mb-0">You have <strong>{{ ($stats['unread_contacts'] ?? 0) + ($stats['unread_tc_requests'] ?? 0) }}</strong> unread messages and <strong>{{ $stats['pending_tc_requests'] ?? 0 }}</strong> pending service requests that need your attention.</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-danger btn-sm px-3 rounded-pill me-2">View Contacts</a>
                <a href="{{ route('admin.tc-requests.index') }}" class="btn btn-dark btn-sm px-3 rounded-pill">View Requests</a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Analytics Time Range Selector -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>Overview</h5>
    <div class="btn-group shadow-sm" role="group" aria-label="Time Range">
        <a href="{{ route('admin.dashboard', ['range' => '7d']) }}" class="btn btn-sm {{ $range == '7d' ? 'btn-primary' : 'btn-light' }}">7 Days</a>
        <a href="{{ route('admin.dashboard', ['range' => '30d']) }}" class="btn btn-sm {{ $range == '30d' ? 'btn-primary' : 'btn-light' }}">30 Days</a>
        <a href="{{ route('admin.dashboard', ['range' => '90d']) }}" class="btn btn-sm {{ $range == '90d' ? 'btn-primary' : 'btn-light' }}">90 Days</a>
        <a href="{{ route('admin.dashboard', ['range' => '1y']) }}" class="btn btn-sm {{ $range == '1y' ? 'btn-primary' : 'btn-light' }}">1 Year</a>
    </div>
</div>

<div class="row">
    <!-- Stats Cards Row 1 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_users'] ?? '0' }}</div>
                    <div class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Total Users</div>
                </div>
                <i class="fas fa-users text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 p-6 text-white shadow-xl shadow-teal-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-teal-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_services'] ?? '0' }}</div>
                    <div class="text-teal-100 text-sm font-semibold uppercase tracking-wider">Services</div>
                </div>
                <i class="fas fa-cogs text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 p-6 text-white shadow-xl shadow-cyan-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-cyan-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_projects'] ?? '0' }}</div>
                    <div class="text-cyan-100 text-sm font-semibold uppercase tracking-wider">Projects</div>
                </div>
                <i class="fas fa-project-diagram text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 p-6 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-orange-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_blogs'] ?? '0' }}</div>
                    <div class="text-orange-100 text-sm font-semibold uppercase tracking-wider">Blog Posts</div>
                </div>
                <i class="fas fa-blog text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stats Cards Row 2 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 p-6 text-white shadow-xl shadow-slate-800/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-800/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_contacts'] ?? '0' }}</div>
                    <div class="text-slate-300 text-sm font-semibold uppercase tracking-wider">Inquiries</div>
                </div>
                <i class="fas fa-envelope text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/5 blur-xl"></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 p-6 text-white shadow-xl shadow-red-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-red-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_tc_requests'] ?? '0' }}</div>
                    <div class="text-red-100 text-sm font-semibold uppercase tracking-wider">Service Leads</div>
                </div>
                <i class="fas fa-star text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-indigo-400 to-violet-600 p-6 text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-indigo-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_reviews'] ?? '0' }}</div>
                    <div class="text-indigo-100 text-sm font-semibold uppercase tracking-wider">Client Reviews</div>
                </div>
                <i class="fas fa-quote-right text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="rounded-2xl bg-gradient-to-br from-fuchsia-500 to-pink-600 p-6 text-white shadow-xl shadow-pink-500/20 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-pink-500/30 group h-100">
            <div class="d-flex justify-content-between align-items-center z-10 relative">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['total_partners'] ?? '0' }}</div>
                    <div class="text-pink-100 text-sm font-semibold uppercase tracking-wider">Elite Partners</div>
                </div>
                <i class="fas fa-handshake text-5xl opacity-80 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12"></i>
            </div>
            <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
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
                                <a href="{{ route('admin.content.edit', 'home-hero') }}" class="btn btn-sm btn-outline-primary">Edit</a>
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
                                <a href="{{ route('admin.content.edit', 'about-main') }}" class="btn btn-sm btn-outline-primary">Edit</a>
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
                                <a href="{{ route('admin.content.edit', 'contact-info') }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Advanced Analytics: Submissions Timeline -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-area me-2 text-primary"></i>
                    Submissions Timeline
                </h5>
            </div>
            <div class="card-body">
                <canvas id="analyticsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Distribution Doughnut Chart -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-pie me-2 text-info"></i>
                    Inquiry Distribution
                </h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <canvas id="distributionChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Content Publishing Timeline (Bar Chart) -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-bar me-2 text-success"></i>
                    Content Publishing Timeline (Blogs)
                </h5>
            </div>
            <div class="card-body">
                <canvas id="publishingChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top Performing Blogs -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-trophy me-2 text-warning"></i>
                    Top Performing Content
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Blog Title</th>
                                <th>Published</th>
                                <th class="text-center">Engagement (Comments)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topBlogs as $blog)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($blog->image)
                                            <img src="{{ asset('storage/' . $blog->image) }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light text-muted d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-decoration-none fw-bold text-dark text-truncate" style="max-width: 200px;" title="{{ $blog->title }}">
                                            {{ Str::limit($blog->title, 25) }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ $blog->comments_count }} <i class="fas fa-comment ms-1"></i></span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No blog content available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- AI Content Analytics & Insights -->
    <div class="col-12 mb-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-robot me-2"></i>
                    AI Content Analytics & Insights
                </h5>
                <button class="btn btn-sm btn-light ai-insights-refresh" title="Refresh Insights">
                    <i class="fas fa-sync-alt text-primary"></i>
                </button>
            </div>
            <div class="card-body" id="ai-insights-container">
                <div class="ai-insights-loader w-full py-4">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-medium text-sm">
                            <i class="fas fa-magic fa-spin me-2"></i> Nova AI is analyzing your content strategy...
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-pulse">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="space-y-3">
                                <div class="h-4 bg-gray-200 rounded w-full"></div>
                                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                                <div class="h-4 bg-gray-200 rounded w-4/5"></div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                            <div class="space-y-3">
                                <div class="h-4 bg-gray-200 rounded w-full"></div>
                                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row ai-insights-content d-none">
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary fw-bold border-bottom pb-2"><i class="fas fa-chart-line me-2"></i>Performance Predictions</h6>
                        <ul class="list-group list-group-flush" id="ai-predictions-list">
                            <!-- Injected by JS -->
                        </ul>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <h6 class="text-danger fw-bold border-bottom pb-2"><i class="fas fa-exclamation-circle me-2"></i>Content Gap Analysis</h6>
                        <ul class="list-group list-group-flush" id="ai-gaps-list">
                            <!-- Injected by JS -->
                        </ul>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <h6 class="text-info fw-bold border-bottom pb-2"><i class="fas fa-book-reader me-2"></i>Readability Score</h6>
                        <div class="text-center py-3">
                            <h2 class="display-4 fw-bold text-info mb-0" id="ai-readability-score">-</h2>
                            <p class="text-muted mt-2" id="ai-readability-notes">Analyzing readability...</p>
                        </div>
                    </div>
                    
                    <div class="col-md-8 mb-4">
                        <h6 class="text-success fw-bold border-bottom pb-2"><i class="fas fa-calendar-alt me-2"></i>Suggested Content Calendar</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Format</th>
                                        <th>Suggested Topic</th>
                                    </tr>
                                </thead>
                                <tbody id="ai-calendar-body">
                                    <!-- Injected by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-danger d-none ai-insights-error mb-0">
                    <i class="fas fa-times-circle me-2"></i> <span class="error-text"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script nonce="{{ $cspNonce ?? '' }}">
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Configs & Globals
        Chart.defaults.color = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? '#adb5bd' : '#6c757d';
        Chart.defaults.borderColor = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
        
        const chartData = @json($chartData);
        
        // 1. Area Chart: Submissions Timeline
        const areaCtx = document.getElementById('analyticsChart').getContext('2d');
        
        // Create Gradient for Contacts
        const gradientContacts = areaCtx.createLinearGradient(0, 0, 0, 300);
        gradientContacts.addColorStop(0, 'rgba(78, 115, 223, 0.4)');
        gradientContacts.addColorStop(1, 'rgba(78, 115, 223, 0.05)');

        // Create Gradient for TC Requests
        const gradientTc = areaCtx.createLinearGradient(0, 0, 0, 300);
        gradientTc.addColorStop(0, 'rgba(231, 74, 59, 0.4)');
        gradientTc.addColorStop(1, 'rgba(231, 74, 59, 0.05)');

        new Chart(areaCtx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Contact Forms',
                        data: chartData.contacts,
                        borderColor: '#4e73df',
                        backgroundColor: gradientContacts,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#4e73df'
                    },
                    {
                        label: 'Service Requests',
                        data: chartData.tcRequests,
                        borderColor: '#e74a3b',
                        backgroundColor: gradientTc,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#e74a3b',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#e74a3b'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // 2. Doughnut Chart: Distribution
        const doughnutCtx = document.getElementById('distributionChart').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Contact Inquiries', 'Service Requests'],
                datasets: [{
                    data: [chartData.distribution.contacts, chartData.distribution.tc_requests],
                    backgroundColor: ['#4e73df', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#be2617'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });

        // 3. Bar Chart: Content Publishing
        const barCtx = document.getElementById('publishingChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Published Blogs',
                    data: chartData.blogs,
                    backgroundColor: '#1cc88a',
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        
        // AI Insights Logic
        const insightsContainer = document.getElementById('ai-insights-container');
        const loader = insightsContainer.querySelector('.ai-insights-loader');
        const content = insightsContainer.querySelector('.ai-insights-content');
        const errorBox = insightsContainer.querySelector('.ai-insights-error');
        const errorText = errorBox.querySelector('.error-text');
        const refreshBtn = document.querySelector('.ai-insights-refresh');
        
        function loadInsights(forceRefresh = false) {
            loader.classList.remove('d-none');
            content.classList.add('d-none');
            errorBox.classList.add('d-none');
            
            const url = '{{ route("admin.dashboard.insights") }}' + (forceRefresh ? '?refresh=1' : '');
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    loader.classList.add('d-none');
                    
                    if (data.error) {
                        errorText.textContent = data.error;
                        errorBox.classList.remove('d-none');
                        return;
                    }
                    
                    // Render Predictions
                    const predictionsList = document.getElementById('ai-predictions-list');
                    predictionsList.innerHTML = '';
                    (data.performance_predictions || []).forEach(item => {
                        predictionsList.innerHTML += `<li class="list-group-item px-0"><i class="fas fa-arrow-up text-success me-2"></i>${item}</li>`;
                    });
                    
                    // Render Gaps
                    const gapsList = document.getElementById('ai-gaps-list');
                    gapsList.innerHTML = '';
                    (data.content_gap_analysis || []).forEach(item => {
                        gapsList.innerHTML += `<li class="list-group-item px-0"><i class="fas fa-search text-warning me-2"></i>${item}</li>`;
                    });
                    
                    // Render Readability
                    if (data.readability_scores) {
                        document.getElementById('ai-readability-score').textContent = data.readability_scores.score;
                        document.getElementById('ai-readability-notes').textContent = data.readability_scores.notes;
                    }
                    
                    // Render Calendar
                    const calendarBody = document.getElementById('ai-calendar-body');
                    calendarBody.innerHTML = '';
                    (data.suggested_calendar || []).forEach(item => {
                        const typeBadge = item.type.toLowerCase().includes('blog') ? 'bg-info' : 'bg-secondary';
                        calendarBody.innerHTML += `
                            <tr>
                                <td class="fw-bold">${item.date}</td>
                                <td><span class="badge ${typeBadge}">${item.type}</span></td>
                                <td>${item.topic}</td>
                            </tr>
                        `;
                    });
                    
                    content.classList.remove('d-none');
                })
                .catch(err => {
                    loader.classList.add('d-none');
                    errorText.textContent = "A network error occurred while loading insights.";
                    errorBox.classList.remove('d-none');
                });
        }
        
        // Auto-load on page ready
        loadInsights();
        
        // Refresh button
        refreshBtn.addEventListener('click', () => {
            loadInsights(true);
        });

        // Animated Counters for Stat Cards
        const counters = document.querySelectorAll('.text-4xl.font-bold.mb-1');
        const speed = 200; // The lower the slower

        counters.forEach(counter => {
            const updateCount = () => {
                // If data-target hasn't been set, initialize it
                if (!counter.hasAttribute('data-target')) {
                    const value = parseInt(counter.innerText.replace(/,/g, '')) || 0;
                    counter.setAttribute('data-target', value);
                    counter.innerText = '0';
                }
                
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText.replace(/,/g, '');
                
                // Lower inc to slow and higher to speed up
                const inc = Math.max(1, Math.ceil(target / speed));
                
                // Check if target is reached
                if (count < target) {
                    counter.innerText = (count + inc).toLocaleString();
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            
            // Start the animation when element is visible (IntersectionObserver could be used, but since it's on top, setTimeout is fine)
            setTimeout(updateCount, 100);
        });
    });
</script>
@endpush

@endsection
