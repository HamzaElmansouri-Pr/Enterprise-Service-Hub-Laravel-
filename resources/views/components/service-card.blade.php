@props(['service'])

<div class="col-xl-4 col-lg-6 col-md-6">
    <div class="service-single-card h-100 d-flex flex-column">
        <div class="icon">
            @if($service->image)
            <img src="{{ resolve_image_url($service->image) }}" alt="{{ $service->title }}" loading="lazy">
            @else
            <div class="service-placeholder d-flex align-items-center justify-content-center">
                <i class="{{ $service->icon ?? 'fas fa-cog' }} fa-3x"></i>
            </div>
            @endif
        </div>
        <div class="content">
            <h3><a href="{{ route('services.show', $service) }}">{{ $service->title }}</a></h3>
            @if($service->subtitle)
            <p class="text-muted">{{ $service->subtitle }}</p>
            @endif
            <p>{{ Str::limit($service->description, 110) }}</p>
            <a href="{{ route('services.show', $service) }}" class="arrow-btn"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</div>
