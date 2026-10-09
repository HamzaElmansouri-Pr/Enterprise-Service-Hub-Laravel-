@extends('admin.layouts.app')

@section('title', 'Content Architect')
@section('page-title', 'Website Content Architect')

@section('styles')
<style>
    .content-blueprint-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }
    .content-blueprint-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: var(--bs-primary);
    }
    .blueprint-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .blueprint-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,0.03);
        transition: background 0.2s;
    }
    .blueprint-item:last-child { border-bottom: none; }
    .blueprint-item:hover {
        background: rgba(var(--bs-primary-rgb), 0.02);
    }
    .blueprint-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        font-size: 1.2rem;
    }
    .status-badge {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.35em 0.8em;
        border-radius: 50px;
    }
    .category-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #6c757d;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .category-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #dee2e6;
        margin-left: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row align-items-end mb-5">
        <div class="col">
            <h6 class="text-primary fw-bold text-uppercase mb-1" style="letter-spacing: 2px;">System Dashboard</h6>
            <h2 class="fw-bold mb-0">Content Management <span class="text-muted fw-light">Architect</span></h2>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary px-4 shadow-sm me-2" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-2"></i> Refresh Layout
            </button>
            <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#livePreviewModal">
                <i class="fas fa-desktop me-2"></i> Live Preview
            </button>
        </div>
    </div>

    <!-- Live Preview Modal -->
    <div class="modal fade" id="livePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <h5 class="modal-title fs-6"><i class="fas fa-desktop me-2"></i> Public Homepage Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-light">
                    <iframe id="livePreviewIframe" src="{{ url('/') }}" style="width:100%; height:100%; border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    @php
        $homeSections = [
            ['id' => 'home-hero', 'title' => 'Hero Banner', 'desc' => 'Main landing slider & CTA', 'icon' => 'fa-play-circle'],
            ['id' => 'home-about', 'title' => 'Introduction', 'desc' => 'Brief about us summary', 'icon' => 'fa-id-badge'],
            ['id' => 'services-list', 'title' => 'Our Expertise', 'desc' => 'Home services collection', 'icon' => 'fa-concierge-bell'],
            ['id' => 'projects-list', 'title' => 'Success Stories', 'desc' => 'Featured work showcase', 'icon' => 'fa-folder-open'],
            ['id' => 'reviews-list', 'title' => 'Testimonials', 'desc' => 'Customer feedback slider', 'icon' => 'fa-star'],
            ['id' => 'blog-list', 'title' => 'Latest News', 'desc' => 'Recent blog articles', 'icon' => 'fa-newspaper'],
            ['id' => 'cta-simple', 'title' => 'Call to Action', 'desc' => 'Conversion & contact bar', 'icon' => 'fa-paper-plane'],
            ['id' => 'home-partners', 'title' => 'Partners', 'desc' => 'Client logo marquee', 'icon' => 'fa-handshake'],
        ];

        $landingPages = [
            ['id' => 'about-main', 'title' => 'About Page', 'desc' => 'Detailed company info', 'icon' => 'fa-info-circle'],
            ['id' => 'about-history', 'title' => 'Company History', 'desc' => 'Milestones and journey', 'icon' => 'fa-history'],
            ['id' => 'about-stats', 'title' => 'Success Metrics', 'desc' => 'Animated counter numbers', 'icon' => 'fa-chart-bar'],
            ['id' => 'about-values', 'title' => 'Core Values', 'desc' => 'Philosophy & mission', 'icon' => 'fa-gem'],
            ['id' => 'about-team', 'title' => 'Our Team', 'desc' => 'Management profiles', 'icon' => 'fa-users'],
            ['id' => 'services-page-header', 'title' => 'Services Header', 'desc' => 'Top banner for services', 'icon' => 'fa-heading'],
            ['id' => 'projects-page-header', 'title' => 'Projects Header', 'desc' => 'Top banner for projects', 'icon' => 'fa-heading'],
            ['id' => 'blog-page-header', 'title' => 'Blog Header', 'desc' => 'Top banner for blog', 'icon' => 'fa-heading'],
            ['id' => 'contact-page-header', 'title' => 'Contact Header', 'desc' => 'Top banner for contact', 'icon' => 'fa-heading'],
        ];

        $globalModules = [
            ['id' => 'site-info', 'title' => 'Branding', 'desc' => 'Logo, Favicon & SEO', 'icon' => 'fa-fingerprint', 'category' => 'Global'],
            ['id' => 'contact-info', 'title' => 'Contact Hub', 'desc' => 'Support contact details', 'icon' => 'fa-headset', 'category' => 'Global'],
            ['id' => 'footer-content', 'title' => 'Footer', 'desc' => 'Site bottom information', 'icon' => 'fa-shoe-prints', 'category' => 'Global'],
        ];

        // Sort homeSections by order_index from the database
        usort($homeSections, function($a, $b) use ($sections) {
            $orderA = isset($sections[$a['id']][0]) ? $sections[$a['id']][0]->order_index : 999;
            $orderB = isset($sections[$b['id']][0]) ? $sections[$b['id']][0]->order_index : 999;
            return $orderA <=> $orderB;
        });
    @endphp

    <div class="row">
        <!-- Main Website Column -->
        <div class="col-lg-5">
            <h6 class="category-label">Home Page Structure</h6>
            <div class="content-blueprint-card shadow-sm mb-5">
                <div class="blueprint-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-layer-group me-2"></i> Landing Page Modules</h6>
                    <span class="badge bg-primary rounded-pill small">{{ count($homeSections) }} Modules</span>
                </div>
                <div class="list-group list-group-flush" id="homeSectionsSortable">
                    @foreach($homeSections as $item)
                        @php($sect = $sections[$item['id']][0] ?? null)
                        <div class="list-group-item blueprint-item d-flex align-items-center" data-id="{{ $item['id'] }}">
                            <div class="drag-handle text-muted me-2" style="cursor: grab;">
                                <i class="fas fa-grip-vertical"></i>
                            </div>
                            <div class="blueprint-icon me-3">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ route('admin.content.edit', $item['id']) }}" class="text-decoration-none">
                                    <span class="d-block fw-bold text-dark">{{ $item['title'] }}</span>
                                    <span class="text-muted smallest">{{ $item['desc'] }}</span>
                                </a>
                            </div>
                            <div class="ms-3 text-end">
                                @if($sect && $sect->is_active)
                                    <span class="badge status-badge status-toggle bg-success-subtle text-success border border-success-subtle" data-type="{{ $item['id'] }}" style="cursor: pointer;"><i class="fas fa-circle me-1 small"></i> Live</span>
                                @else
                                    <span class="badge status-badge status-toggle bg-secondary-subtle text-muted border border-secondary-subtle" data-type="{{ $item['id'] }}" style="cursor: pointer;"><i class="fas fa-circle me-1 small"></i> Draft</span>
                                @endif
                                <div class="mt-1"><a href="{{ route('admin.content.edit', $item['id']) }}" class="text-muted"><i class="fas fa-chevron-right x-small"></i></a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Internal & Support Column -->
        <div class="col-lg-4">
            <h6 class="category-label">Internal Architecture</h6>
            <div class="content-blueprint-card shadow-sm mb-4">
                <div class="blueprint-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-success"><i class="fas fa-sitemap me-2"></i> Page Templates</h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($landingPages as $item)
                        @php($sect = $sections[$item['id']][0] ?? null)
                        <a href="{{ route('admin.content.edit', $item['id']) }}" class="list-group-item blueprint-item d-flex align-items-center">
                            <div class="blueprint-icon me-3 bg-success-subtle text-success">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block fw-bold text-dark">{{ $item['title'] }}</span>
                                <span class="text-muted smallest">{{ $item['desc'] }}</span>
                            </div>
                            <div class="ms-3 text-end">
                                @if($sect && $sect->is_active)
                                    <span class="badge status-badge status-toggle bg-success-subtle text-success border border-success-subtle" data-type="{{ $item['id'] }}" style="cursor: pointer;">Live</span>
                                @else
                                    <span class="badge status-badge status-toggle bg-secondary-subtle text-muted border border-secondary-subtle" data-type="{{ $item['id'] }}" style="cursor: pointer;">Draft</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- System Settings Column -->
        <div class="col-lg-3">
            <h6 class="category-label">System Modules</h6>
            <div class="content-blueprint-card shadow-sm border-top border-warning border-3">
                <div class="blueprint-header">
                    <h6 class="mb-0 fw-bold text-warning"><i class="fas fa-cog me-2"></i> Core Config</h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($globalModules as $item)
                        @php($sect = $sections[$item['id']][0] ?? null)
                        <a href="{{ route('admin.content.edit', $item['id']) }}" class="list-group-item blueprint-item d-flex align-items-center">
                            <div class="blueprint-icon me-3 bg-warning-subtle text-warning">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block fw-bold text-dark">{{ $item['title'] }}</span>
                                <span class="text-muted smallest">{{ $item['desc'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js" nonce="{{ $cspNonce ?? '' }}"></script>

<script nonce="{{ $cspNonce ?? '' }}">
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.status-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const type = this.getAttribute('data-type');
            const url = `{{ url('admin/content') }}/${type}/toggle-active`;
            const badge = this;
            
            // Add loading state
            badge.style.opacity = '0.5';
            badge.style.pointerEvents = 'none';
            
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_active) {
                        badge.classList.remove('bg-secondary-subtle', 'text-muted');
                        badge.classList.add('bg-success-subtle', 'text-success');
                        badge.classList.replace('border-secondary-subtle', 'border-success-subtle');
                        badge.innerHTML = badge.innerHTML.includes('fa-circle') 
                            ? '<i class="fas fa-circle me-1 small"></i> Live' 
                            : 'Live';
                    } else {
                        badge.classList.remove('bg-success-subtle', 'text-success');
                        badge.classList.add('bg-secondary-subtle', 'text-muted');
                        badge.classList.replace('border-success-subtle', 'border-secondary-subtle');
                        badge.innerHTML = badge.innerHTML.includes('fa-circle') 
                            ? '<i class="fas fa-circle me-1 small"></i> Draft' 
                            : 'Draft';
                    }
                    // Refresh iframe if open
                    const iframe = document.getElementById('livePreviewIframe');
                    if(iframe) iframe.src = iframe.src;
                }
            })
            .catch(error => {
                console.error('Error toggling status:', error);
                alert('Failed to update status. Please try again.');
            })
            .finally(() => {
                badge.style.opacity = '1';
                badge.style.pointerEvents = 'auto';
            });
        });
    });

    // Initialize Sortable
    const sortableList = document.getElementById('homeSectionsSortable');
    if (sortableList) {
        new Sortable(sortableList, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function (evt) {
                const items = sortableList.querySelectorAll('.blueprint-item');
                const order = Array.from(items).map((item, index) => ({
                    type: item.getAttribute('data-id'),
                    order: index
                }));

                fetch('{{ route("admin.content.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        // Optional: show a small toast or notification
                        // Refresh iframe if open
                        const iframe = document.getElementById('livePreviewIframe');
                        if(iframe) iframe.src = iframe.src;
                    }
                })
                .catch(err => console.error('Error saving order', err));
            }
        });
    }

    // Refresh Live Preview when modal is opened
    const livePreviewModal = document.getElementById('livePreviewModal');
    if (livePreviewModal) {
        livePreviewModal.addEventListener('show.bs.modal', function () {
            const iframe = document.getElementById('livePreviewIframe');
            if(iframe) iframe.src = iframe.src; // Force reload
        });
    }
});
</script>
@endsection

