@props(['blog'])

<div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
    <div class="relative h-64 overflow-hidden">
        @if($blog->featured_image)
            <img src="{{ resolve_image_url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110">
        @else
            <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-newspaper text-4xl"></i>
            </div>
        @endif
        <div class="absolute top-4 left-4">
            <span class="bg-brand-600 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                {{ $blog->category ?? 'Technology' }}
            </span>
        </div>
    </div>
    
    <div class="p-6 md:p-8 flex flex-col flex-grow">
        <div class="flex items-center gap-4 mb-4 text-sm text-slate-500">
            <div class="flex items-center gap-1.5">
                <i class="fa-regular fa-user text-brand-500"></i>
                <span>{{ $blog->author }}</span>
            </div>
            @if($blog->published_at)
            <div class="flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-brand-500"></i>
                <span>{{ $blog->published_at->format('M d, Y') }}</span>
            </div>
            @endif
        </div>
        
        <h3 class="text-xl font-bold text-slate-900 mb-4 font-heading group-hover:text-brand-600 transition-colors">
            <a href="{{ route('blog.show', $blog) }}">{{ $blog->title }}</a>
        </h3>
        
        <p class="text-slate-600 mb-6 line-clamp-3">
            {{ Str::limit($blog->excerpt, 120) }}
        </p>
        
        <div class="mt-auto">
            <a href="{{ route('blog.show', $blog) }}" class="inline-flex items-center text-sm font-bold text-slate-900 hover:text-brand-600 transition-colors group/link">
                Read Article 
                <i class="fa-solid fa-arrow-right ml-2 transform transition-transform group-hover/link:translate-x-1"></i>
            </a>
        </div>
    </div>
</div>
