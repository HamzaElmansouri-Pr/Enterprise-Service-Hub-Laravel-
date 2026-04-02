@props(['review'])

<div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-300">
    <div class="flex items-center gap-4 mb-6">
        <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-100 ring-2 ring-brand-500/10">
            @if($review->client_image)
                <img src="{{ resolve_image_url($review->client_image) }}" alt="{{ $review->client_name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>
            @endif
        </div>
        <div>
            <h4 class="font-bold text-slate-900">{{ $review->client_name }}</h4>
            <p class="text-sm text-slate-500">{{ $review->client_position }} @ {{ $review->client_company }}</p>
        </div>
    </div>
    
    <div class="mb-6 relative">
        <i class="fa-solid fa-quote-left text-brand-500/10 text-5xl absolute -top-4 -left-2"></i>
        <p class="text-slate-600 leading-relaxed italic relative z-10">
            "{{ Str::limit($review->review_text, 180) }}"
        </p>
    </div>

    @if($review->rating)
    <div class="flex items-center gap-1 text-amber-400">
        @for($i=0; $i<5; $i++)
            <i class="fa{{ $i < $review->rating ? '-solid' : '-regular' }} fa-star text-sm"></i>
        @endfor
    </div>
    @endif
</div>
