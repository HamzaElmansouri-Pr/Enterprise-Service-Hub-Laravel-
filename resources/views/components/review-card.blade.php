@props(['review'])

<div class="col-xl-4 col-lg-4 col-md-6">
    <div class="gt-feature-box h-100">
        <div class="d-flex align-items-center mb-3">
            <div class="me-3" style="width:56px;height:56px;overflow:hidden;border-radius:50%;background:#f1f3f5;display:flex;align-items:center;justify-content:center;">
                @if($review->client_image)
                    <img src="{{ resolve_image_url($review->client_image) }}" alt="{{ $review->client_name }}" class="w-100 h-100" style="object-fit:cover;" loading="lazy">
                @else
                    <i class="fas fa-user text-muted"></i>
                @endif
            </div>
            <div>
                <h5 class="mb-0">{{ $review->client_name }}</h5>
                <small class="text-muted">{{ $review->client_position }} @ {{ $review->client_company }}</small>
            </div>
        </div>
        <p class="mb-2">{{ Str::limit($review->review_text, 180) }}</p>
        @if($review->rating)
        <div class="text-warning">
            @for($i=0;$i<5;$i++)
                <i class="fa{{ $i < $review->rating ? 's' : 'r' }} fa-star"></i>
            @endfor
        </div>
        @endif
    </div>
</div>
