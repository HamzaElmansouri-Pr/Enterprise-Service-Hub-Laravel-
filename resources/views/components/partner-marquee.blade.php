{{-- Partners Marquee Section --}}
@if(isset($partners) && $partners->count() > 0)
<section class="partner-section py-10 border-t border-slate-100 bg-slate-50/30 overflow-hidden">
    <div class="container mx-auto">
        @php($title = $partnersSection->getContent('partners_title'))
        @php($subtitle = $partnersSection->getContent('partners_subtitle'))
        
        @if($title || $subtitle)
        <div class="text-center mb-10">
            @if($title)
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2 font-heading">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <p class="text-slate-500 max-w-2xl mx-auto">{{ $subtitle }}</p>
            @endif
        </div>
        @endif

        <div class="marquee-wrapper relative overflow-hidden">
            {{-- Fade Edges --}}
            <div class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-slate-50/30 to-transparent z-10"></div>
            <div class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-slate-50/30 to-transparent z-10"></div>

            <div class="marquee-main flex items-center w-max">
                {{-- Content group (duplicated for seamless loop) --}}
                <div class="marquee-group flex shrink-0 items-center gap-20 pr-20">
                    @foreach($partners as $partner)
                    <div class="partner-brand">
                        <img src="{{ $partner->getLogoUrl() }}" alt="{{ $partner->name }}" 
                             class="h-12 w-32 object-contain hover:scale-110 transition-all duration-300">
                    </div>
                    @endforeach
                </div>
                
                {{-- Second group for seamless loop --}}
                <div class="marquee-group flex shrink-0 items-center gap-20 pr-20">
                    @foreach($partners as $partner)
                    <div class="partner-brand">
                        <img src="{{ $partner->getLogoUrl() }}" alt="{{ $partner->name }}" 
                             class="h-12 w-32 object-contain hover:scale-110 transition-all duration-300">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Seamless Marquee Animation */
.marquee-main {
    animation: marquee-scroll 40s linear infinite;
}

@keyframes marquee-scroll {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-50%);
    }
}

.marquee-wrapper:hover .marquee-main {
    animation-play-state: paused;
}

@media (max-width: 768px) {
    .marquee-group {
        gap: 40px;
        padding-right: 40px;
    }
    .partner-brand img {
        height: 35px;
        width: 100px;
    }
}
</style>
@endif
