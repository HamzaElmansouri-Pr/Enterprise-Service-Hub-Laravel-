@extends('admin.layouts.app')

@section('title', 'Content Management')
@section('page-title', 'Content Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Website Content</h4>
    <a href="{{ route('admin.content.index') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Content
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>Section</th>
                        <th>Content Type</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-home text-primary me-2"></i>
                                <strong>Home Page</strong>
                            </div>
                        </td>
                        <td>Hero Section</td>
                        <td><span class="badge bg-info">Text & Image</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>{{ now()->subHours(2)->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.content.edit', 'home-hero') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-home text-primary me-2"></i>
                                <strong>Home Page</strong>
                            </div>
                        </td>
                        <td>About Section</td>
                        <td><span class="badge bg-secondary">Text & Image</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>{{ now()->subHours(3)->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.content.edit', 'home-about') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-home text-primary me-2"></i>
                                <strong>Home Page</strong>
                            </div>
                        </td>
                        <td>Features Section</td>
                        <td><span class="badge bg-warning">List Items</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>{{ now()->subHours(4)->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.content.edit', 'home-features') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle text-success me-2"></i>
                                <strong>About Page</strong>
                            </div>
                        </td>
                        <td>Main Content</td>
                        <td><span class="badge bg-info">Text & Image</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>{{ now()->subDays(1)->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.content.edit', 'about-main') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('about') }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-info me-2"></i>
                                <strong>Contact Page</strong>
                            </div>
                        </td>
                        <td>Contact Information</td>
                        <td><span class="badge bg-secondary">Contact Details</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>{{ now()->subDays(2)->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.content.edit', 'contact-info') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('contact') }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cog text-warning me-2"></i>
                                <strong>Global Settings</strong>
                            </div>
                        </td>
                        <td>Site Information</td>
                        <td><span class="badge bg-primary">Settings</span></td>
                        <td><span class="badge bg-success">Published</span></td>
                        <td>{{ now()->subDays(3)->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.content.edit', 'site-info') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Content Categories -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-home me-2"></i>
                    Home Page Content
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'home-hero') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-primary"></i>
                            Hero Section
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'home-features') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-primary"></i>
                            Features Section
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'home-about') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-primary"></i>
                            About Section
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'home-testimonials') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-primary"></i>
                            Testimonials
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    About Page Content
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'about-main') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-success"></i>
                            Main Content
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'about-team') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-success"></i>
                            Team Section
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'about-mission') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-success"></i>
                            Mission & Vision
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Global Content
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'site-info') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-warning"></i>
                            Site Information
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'footer-content') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-warning"></i>
                            Footer Content
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.content.edit', 'contact-info') }}" class="text-decoration-none">
                            <i class="fas fa-chevron-right me-2 text-warning"></i>
                            Contact Information
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
