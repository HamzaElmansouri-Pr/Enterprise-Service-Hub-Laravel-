<div {{ $attributes->merge(['class' => 'gt-section-title style-3 ' . ($alignment ?? '')]) }}>
    <h6 class="wow fadeInUp tt-capitalize">{{ $subtitle }}</h6>
    <h2 class="char-animation">{{ $title }}</h2>
    @if(isset($description))
    <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">
        {{ $description }}
    </p>
    @endif
    {{ $slot }}
</div>
