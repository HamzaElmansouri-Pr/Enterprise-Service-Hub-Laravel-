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

<div class="row">
    <!-- Home Page Column -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card content-card-elite h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="text-uppercase small fw-bold"><i class="fas fa-home me-2 text-primary"></i> Home Page</span>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-link text-muted p-0"><i class="fas fa-external-link-alt"></i></a>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.content.edit', 'home-hero') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Hero Section</span>
                        <span class="text-muted smallest">Main banner with video/image</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'home-features') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Features Section</span>
                        <span class="text-muted smallest">Core services highlights</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'home-about') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">About Section</span>
                        <span class="text-muted smallest">Company intro on home</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'services-list') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Featured Services</span>
                        <span class="text-muted smallest">Choose & order home services</span>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Custom</span>
                </a>
                <a href="{{ route('admin.content.edit', 'projects-list') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Featured Projects</span>
                        <span class="text-muted smallest">Choose & order home projects</span>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Custom</span>
                </a>
                <a href="{{ route('admin.content.edit', 'home-partners') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Partners Marquee</span>
                        <span class="text-muted smallest">Client logo slider</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
            </div>
        </div>
    </div>

    <!-- About Page Column -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card content-card-elite h-100 border-top border-success border-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="text-uppercase small fw-bold"><i class="fas fa-info-circle me-2 text-success"></i> About Page</span>
                <a href="{{ route('about') }}" target="_blank" class="btn btn-sm btn-link text-muted p-0"><i class="fas fa-external-link-alt"></i></a>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.content.edit', 'about-main') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">General Information</span>
                        <span class="text-muted smallest">Main vision & mission</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'about-stats') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Elite Stats Counter</span>
                        <span class="text-muted smallest">Success metrics numbers</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'about-values') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Core Values</span>
                        <span class="text-muted smallest">Company principles</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'about-history') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Company Timeline</span>
                        <span class="text-muted smallest">Historical milestones</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'about-team') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Management Team</span>
                        <span class="text-muted smallest">Leadership profiles</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Services & Projects Column -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card content-card-elite mb-4 border-top border-info border-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="text-uppercase small fw-bold"><i class="fas fa-concierge-bell me-2 text-info"></i> Landing Pages</span>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.content.edit', 'services-page-header') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Services Header</span>
                        <span class="text-muted smallest">Main title & breadcrumb</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
                <a href="{{ route('admin.content.edit', 'projects-page-header') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Projects Header</span>
                        <span class="text-muted smallest">Main title & breadcrumb</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Live</span>
                </a>
            </div>
        </div>

        <div class="card content-card-elite border-top border-warning border-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="text-uppercase small fw-bold"><i class="fas fa-globe me-2 text-warning"></i> Global Sections</span>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.content.edit', 'site-info') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Site Branding</span>
                        <span class="text-muted smallest">Logos & Meta data</span>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Global</span>
                </a>
                <a href="{{ route('admin.content.edit', 'contact-info') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Contact Details</span>
                        <span class="text-muted smallest">Phones, emails & office</span>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Global</span>
                </a>
                <a href="{{ route('admin.content.edit', 'footer-content') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block fw-semibold">Footer Content</span>
                        <span class="text-muted smallest">Copyright & Bottom links</span>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Global</span>
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
