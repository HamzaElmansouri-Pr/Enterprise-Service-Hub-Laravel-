    <!-- Navigation -->
    <nav class="sticky top-0 w-full z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-100/50 transition-all duration-300 py-3" 
         x-data="{ mobileOpen: false, scrolled: false }"
         @@scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'py-2 shadow-md bg-white/95': scrolled, 'py-4': !scrolled }">
        
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group transition-transform duration-300 hover:scale-[1.02]">
                    @if(!empty($site_info['site_logo']))
                        <div class="relative">
                            <img src="{{ resolve_image_url($site_info['site_logo']) }}" 
                                 alt="{{ $site_info['site_name'] ?? 'Nova Agency' }}" 
                                 class="h-11 md:h-12 w-auto object-contain brightness-110 drop-shadow-sm">
                        </div>
                    @else
                        <div class="w-11 h-11 bg-gradient-to-tr from-brand-600 to-brand-400 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg group-hover:shadow-brand-500/20 transition-all duration-300 group-hover:rotate-3">
                            {{ substr($site_info['site_name'] ?? 'N', 0, 1) }}
                        </div>
                        <span class="text-2xl font-heading font-bold text-slate-900 tracking-tight">
                            @php
                                $siteName = $site_info['site_name'] ?? 'NovaAgency';
                            @endphp
                            @if($siteName === 'NovaAgency')
                                Nova<span class="text-brand-500">Agency</span>
                            @else
                                {{ $siteName }}
                            @endif
                        </span>
                    @endif
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-10">
                    @php
                        $navLinks = [
                            ['route' => 'home', 'label' => 'Home'],
                            ['route' => 'about', 'label' => 'About Us'],
                            ['route' => 'services', 'label' => 'Services'],
                            ['route' => 'projects', 'label' => 'Projects'],
                            ['route' => 'blog', 'label' => 'Blog'],
                        ];
                    @endphp

                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="relative font-semibold text-slate-700 hover:text-brand-600 transition-colors duration-300 group py-2">
                            {{ $link['label'] }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    @endforeach

                    <a href="{{ route('contact') }}#service" 
                       class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-brand-600 rounded-xl hover:bg-brand-500 group shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <span class="relative">Get Started</span>
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button @@click="mobileOpen = !mobileOpen" 
                        class="md:hidden p-2 rounded-lg bg-slate-50 text-slate-900 hover:bg-slate-100 transition-colors focus:outline-none">
                    <template x-if="!mobileOpen">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </template>
                    <template x-if="mobileOpen">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </template>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             @@click.away="mobileOpen = false"
             class="absolute top-full left-0 w-full bg-white shadow-2xl border-t border-slate-100 py-6 px-6 flex flex-col space-y-4 md:hidden rounded-b-2xl">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}" 
                   class="text-slate-700 font-bold text-lg hover:text-brand-600 px-2 py-1 transition-colors">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <hr class="border-slate-100 my-2">
            <a href="{{ route('contact') }}#service" 
               class="bg-brand-600 text-white px-6 py-4 rounded-xl text-center font-bold text-lg hover:bg-brand-500 shadow-lg shadow-brand-500/20 transition-all">
                Get Started
            </a>
        </div>
    </nav>