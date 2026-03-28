@extends('layouts.frontend')

@section('title', 'Nova Agency - Innovative IT Solutions')
@section('meta_description', 'Nova Agency provides cutting-edge IT services including cloud solutions, web development, and cybersecurity.')

@section('content')

<!-- HERO SECTION (Slider) -->
<section class="relative h-screen min-h-[600px] flex items-center overflow-hidden bg-dark-900" 
         x-data="{ activeSlide: 0, totalSlides: {{ $sliders->count() }}, slideInterval: null }" 
         x-init="if(totalSlides > 1) slideInterval = setInterval(() => { activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1 }, 6000)">
    
    @if($sliders->count() > 0)
        @foreach($sliders as $index => $slider)
        <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out"
             x-show="activeSlide === {{ $index }}"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="background-image: url('{{ resolve_image_url($slider->image) }}'); background-size: cover; background-position: center;">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-dark-900/90 via-dark-900/40 to-transparent"></div>

            <div class="container mx-auto px-4 md:px-6 h-full relative z-10 flex items-center">
                <div class="max-w-3xl pt-20">
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 bg-brand-500/10 border border-brand-500/20 rounded-full px-3 py-1 mb-6 backdrop-blur-sm"
                         x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-700 delay-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span class="text-brand-300 text-sm font-medium tracking-wide">Nova Agency Solutions</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 font-heading"
                        x-show="activeSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-700 delay-500"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        {{ $slider->title }}
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-lg md:text-xl text-slate-300 mb-10 max-w-2xl leading-relaxed"
                       x-show="activeSlide === {{ $index }}"
                       x-transition:enter="transition ease-out duration-700 delay-700"
                       x-transition:enter-start="opacity-0 translate-y-8"
                       x-transition:enter-end="opacity-100 translate-y-0">
                        {{ $slider->subtitle ?? $slider->description }}
                    </p>

                    <!-- Buttons -->
                    @if($slider->button_text)
                    <div class="flex flex-wrap gap-4"
                         x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-700 delay-900"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <a href="{{ $slider->button_url ?? '#' }}" 
                           class="bg-brand-600 hover:bg-brand-500 text-white px-8 py-3.5 rounded-lg font-semibold transition-all transform hover:-translate-y-1 shadow-lg shadow-brand-500/25 flex items-center gap-2">
                            <span>{{ $slider->button_text }}</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('services') }}" class="px-8 py-3.5 rounded-lg font-semibold text-white border border-white/20 hover:bg-white/10 transition-all backdrop-blur-sm">
                            Explore Services
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        @if($sliders->count() > 1)
        <!-- Previous Button (Left Side - Centered) -->
        <button @click="clearInterval(slideInterval); activeSlide = activeSlide === 0 ? totalSlides - 1 : activeSlide - 1; slideInterval = setInterval(() => { activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1 }, 6000)"
                class="absolute top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 text-white backdrop-blur-md transition-all duration-300 group focus:outline-none border border-white/10 hover:border-white/30 hover:-translate-x-1"
                style="left: 2rem;"
                aria-label="Previous Slide">
            <i class="fa-solid fa-chevron-left text-xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
        </button>

        <!-- Next Button (Right Side - Centered) -->
        <button @click="clearInterval(slideInterval); activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1; slideInterval = setInterval(() => { activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1 }, 6000)"
                class="absolute top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 text-white backdrop-blur-md transition-all duration-300 group focus:outline-none border border-white/10 hover:border-white/30 hover:translate-x-1"
                style="right: 2rem;"
                aria-label="Next Slide">
            <i class="fa-solid fa-chevron-right text-xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
        </button>

        <!-- Indicators (Bottom Centered) -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex gap-3">
            <template x-for="i in totalSlides">
                <button @click="clearInterval(slideInterval); activeSlide = i - 1; slideInterval = setInterval(() => { activeSlide = activeSlide === totalSlides - 1 ? 0 : activeSlide + 1 }, 6000)"
                        class="h-1.5 rounded-full transition-all duration-500 shadow-sm"
                        :class="activeSlide === i - 1 ? 'w-10 bg-brand-500' : 'w-2 bg-white/40 hover:bg-white/60'"
                        :aria-label="'Go to slide ' + i"></button>
            </template>
        </div>
        @endif

    @else
        <!-- Fallback static content -->
        <div class="absolute inset-0 bg-dark-900">
            <div class="container mx-auto px-4 h-full flex items-center justify-center">
                <h1 class="text-white text-4xl">Welcome to Nova Agency</h1>
            </div>
        </div>
    @endif
</section>

<!-- ABOUT SECTION -->
<section id="about" class="py-12 md:py-20 lg:py-32 bg-white overflow-hidden">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-16 items-center">
            <!-- Image Side -->
            <div class="relative group order-2 lg:order-1">
                <div class="absolute -inset-4 bg-gradient-to-tr from-brand-500 to-accent-500 rounded-2xl opacity-20 blur-xl group-hover:opacity-30 transition duration-500"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    @if(optional($about)->image)
                        <img src="{{ resolve_image_url(optional($about)->image) }}" alt="About Us" class="w-full h-auto object-cover transform transition duration-700 group-hover:scale-105">
                    @else
                        <!-- Fallback Image -->
                        <div class="w-full h-64 md:h-96 bg-slate-200 flex items-center justify-center">
                            <i class="fa-regular fa-image text-4xl text-slate-400"></i>
                        </div>
                    @endif
                </div>
                <!-- Float Card -->
                <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-xl shadow-xl max-w-xs hidden md:block border border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <i class="fa-solid fa-check text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Project Success</p>
                            <p class="text-xl font-bold text-slate-800">98% Rate</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Side -->
            <div class="order-1 lg:order-2">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">About Nova Agency</span>
                <h2 class="text-3xl md:text-5xl font-bold font-heading text-slate-900 mb-6 leading-tight">
                    {{ optional($about)->title ?? 'Deliver unforgettable customer experiences' }}
                </h2>
                <p class="text-slate-600 text-lg mb-8 leading-relaxed">
                    {{ optional($about)->description ?? 'We help businesses grow by providing top-notch IT solutions tailored to your specific needs.' }}
                </p>

                <!-- Features Grid -->
                @php($homeFeatures = optional($about)->meta_data['features'] ?? [])
                @if(!empty($homeFeatures))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    @foreach($homeFeatures as $feat)
                    <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-brand-50/50 transition-colors">
                        <div class="w-10 h-10 rounded bg-brand-100 text-brand-600 flex items-center justify-center shrink-0 mt-1">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 mb-1">{{ $feat['title'] }}</h4>
                            <p class="text-sm text-slate-500">{{ $feat['description'] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <a href="{{ route('about') }}" class="text-brand-600 font-semibold hover:text-brand-700 inline-flex items-center gap-2 group">
                    Learn more about us
                    <i class="fa-solid fa-arrow-right transform transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section class="py-12 md:py-20 bg-slate-50">
    <div class="container mx-auto px-4 md:px-6">
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-16">
            <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Our Expertise</span>
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-slate-900 mb-4">High-Impact IT Services</h2>
            <p class="text-slate-500">Comprehensive technology solutions designed to scale with your business.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm hover:shadow-xl transition-all duration-300 group border border-slate-100 hover:-translate-y-1">
                <div class="w-14 h-14 bg-brand-50 rounded-xl mb-6 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                    <i class="fa-solid {{ str_contains(strtolower($service->name ?? ''), 'cloud') ? 'fa-cloud' : (str_contains(strtolower($service->name ?? ''), 'web') ? 'fa-code' : 'fa-layer-group') }} text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 font-heading group-hover:text-brand-600 transition-colors">{{ $service->name }}</h3>
                <p class="text-slate-500 mb-6 line-clamp-3">
                    {{ $service->description }}
                </p>
                <a href="{{ route('services.show', $service->slug ?? '#') }}" class="inline-flex items-center text-sm font-semibold text-slate-900 hover:text-brand-600 transition-colors">
                    Read More <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PROJECTS -->
<section class="py-12 md:py-20 bg-dark-900 text-white">
    <div class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 md:mb-12">
            <div class="mb-4 md:mb-0">
                <span class="text-brand-400 font-bold tracking-wider uppercase text-sm mb-2 block">Our Portfolio</span>
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-white">Featured Projects</h2>
            </div>
            <a href="{{ route('projects') }}" class="hidden md:inline-flex items-center gap-2 text-white/70 hover:text-white transition-colors">
                View All Projects <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($projects as $project)
            <div class="group relative overflow-hidden rounded-2xl aspect-[4/3] cursor-pointer bg-dark-800">
                @if($project->image)
                <img src="{{ resolve_image_url($project->image) }}" alt="{{ $project->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-dark-900/90 via-dark-900/20 to-transparent opacity-90 transition-opacity"></div>
                
                <div class="absolute bottom-0 left-0 p-6 md:p-8 w-full translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <span class="text-brand-400 text-sm font-medium mb-2 block">{{ $project->category ?? 'Case Study' }}</span>
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-2">{{ $project->title }}</h3>
                    <p class="text-white/70 text-sm line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                        {{ $project->description }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('projects') }}" class="inline-flex items-center gap-2 text-brand-400 font-semibold hover:text-white transition-colors">
                View All Projects <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-20 bg-brand-600 relative overflow-hidden">
    <!-- Abstract Shapes -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-accent-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
        <h2 class="text-3xl md:text-5xl font-bold font-heading text-white mb-6">Ready to Transform Your Business?</h2>
        <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto mb-10">
            Let's discuss how Nova Agency can help you achieve your technology goals with our expert solutions.
        </p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="bg-white text-brand-600 px-8 py-4 rounded-lg font-bold hover:bg-brand-50 transition-colors shadow-lg">
                Get a Free Quote
            </a>
            <a href="{{ route('services') }}" class="border border-white/30 text-white px-8 py-4 rounded-lg font-bold hover:bg-white/10 transition-colors backdrop-blur-sm">
                View Services
            </a>
        </div>
    </div>
</section>

@endsection
