    <!-- Navigation -->
    <!-- Navigation -->
    <nav class="relative w-full z-50 bg-white shadow-sm border-b border-slate-100 transition-all duration-300 py-3" 
         x-data="{ mobileOpen: false }">
        
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    @if(!empty($site_info['site_logo']))
                        <img src="{{ resolve_image_url($site_info['site_logo']) }}" alt="{{ $site_info['site_name'] ?? 'Nova Agency' }}" class="h-10 w-auto">
                    @else
                        <div class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:bg-brand-500 transition-colors">
                            {{ substr($site_info['site_name'] ?? 'N', 0, 1) }}
                        </div>
                        <span class="text-2xl font-heading font-bold text-slate-900">
                            @php($siteName = $site_info['site_name'] ?? 'NovaAgency')
                            @if($siteName === 'NovaAgency')
                                Nova<span class="text-brand-500">Agency</span>
                            @else
                                {{ $siteName }}
                            @endif
                        </span>
                    @endif
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-medium text-slate-700 hover:text-brand-600 transition-colors">Home</a>
                    <a href="{{ route('about') }}" class="font-medium text-slate-700 hover:text-brand-600 transition-colors">About Us</a>
                    <a href="{{ route('services') }}" class="font-medium text-slate-700 hover:text-brand-600 transition-colors">Services</a>
                    <a href="{{ route('projects') }}" class="font-medium text-slate-700 hover:text-brand-600 transition-colors">Projects</a>
                    <a href="{{ route('blog') }}" class="font-medium text-slate-700 hover:text-brand-600 transition-colors">Blog</a>
                    <a href="{{ route('contact') }}#service" 
                       class="px-5 py-2.5 rounded-lg font-semibold transition-all shadow-lg bg-brand-600 text-white hover:bg-brand-500">
                        Get Started
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl text-slate-900"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="mobileOpen = false"
             class="absolute top-full left-0 w-full bg-white shadow-xl border-t border-slate-100 py-4 px-4 flex flex-col space-y-4 md:hidden">
            <a href="{{ route('home') }}" class="text-slate-700 font-medium hover:text-brand-600">Home</a>
            <a href="{{ route('about') }}" class="text-slate-700 font-medium hover:text-brand-600">About Us</a>
            <a href="{{ route('services') }}" class="text-slate-700 font-medium hover:text-brand-600">Services</a>
            <a href="{{ route('projects') }}" class="text-slate-700 font-medium hover:text-brand-600">Projects</a>
            <a href="{{ route('blog') }}" class="text-slate-700 font-medium hover:text-brand-600">Blog</a>
            <a href="{{ route('contact') }}#service" class="bg-brand-600 text-white px-5 py-3 rounded-lg text-center font-semibold hover:bg-brand-500">Get Started</a>
        </div>
    </nav>