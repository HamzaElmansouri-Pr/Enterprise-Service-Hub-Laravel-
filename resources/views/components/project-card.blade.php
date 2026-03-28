@props(['project'])

<div {{ $attributes->merge(['class' => 'col-xl-6 col-lg-6 col-md-6']) }}>
    <div class="case-studies-card-items mt-0 h-100 d-flex flex-column">
        <div class="thumb" style="height: 420px; overflow: hidden;">
            @if($project->image)
            <img src="{{ resolve_image_url($project->image) }}" alt="{{ $project->title }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
            @else
            <div class="project-placeholder d-flex align-items-center justify-content-center h-100 bg-light">
                <i class="fas fa-project-diagram fa-3x text-muted"></i>
            </div>
            @endif
        </div>
        <div class="content">
            <div class="title">
                <h3><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3>
                @if($project->category)
                <p>{{ $project->category }}</p>
                @endif
            </div>
            <a href="{{ route('projects.show', $project) }}" class="icon"><i class="fa-regular fa-arrow-up-right"></i></a>
        </div>
    </div>
</div>
