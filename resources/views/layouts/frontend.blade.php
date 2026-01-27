<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'SupremeIT - Professional IT Solutions & Consulting')">

    <title>@yield('title', 'SupremeIT') | IT Solutions</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-800 bg-white selection:bg-brand-500 selection:text-white flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300" 
         x-data="{ scanned: false, mobileOpen: false }" 
         @scroll.window="scanned = (window.pageYOffset > 20) ? true : false"
         :class="scanned ? 'bg-white/90 backdrop-blur-md shadow-md py-3' : 'bg-transparent py-5'">
        
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:bg-brand-500 transition-colors">
                        S
                    </div>
                    <span class="text-2xl font-heading font-bold" 
                          :class="scanned ? 'text-slate-900' : 'text-white'">
                        Supreme<span class="text-brand-500">IT</span>
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    @foreach([
                        ['label' => 'Home', 'url' => route('home')],
                        ['label' => 'About Us', 'url' => route('about')],
                        ['label' => 'Services', 'url' => route('services')],
                        ['label' => 'Projects', 'url' => route('projects')],
                        //['label' => 'Blog', 'url' => route('blog')],
                        ['label' => 'Contact', 'url' => route('contact')]
                    ] as $link)
                    <a href="{{ $link['url'] }}" 
                       class="font-medium hover:text-brand-500 transition-colors relative group"
                       :class="scanned ? 'text-slate-600' : 'text-white/90 hover:text-white'">
                       {{ $link['label'] }}
                       <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-500 transition-all group-hover:w-full"></span>
                    </a>
                    @endforeach
                </div>

                <!-- CTA Button -->
                <div class="hidden md:block">
                    <a href="{{ route('contact') }}" 
                       class="px-6 py-2.5 rounded-full font-semibold transition-all transform hover:scale-105 shadow-lg"
                       :class="scanned ? 'bg-brand-600 text-white hover:bg-brand-700' : 'bg-white text-brand-700 hover:bg-gray-50'">
                        Get Started
                    </a>
                </div>

                <!-- Mobile Trigger -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-2xl focus:outline-none"
                        :class="scanned ? 'text-slate-800' : 'text-white'">
                    <i class="fa-solid" :class="mobileOpen ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-collapse 
             class="md:hidden bg-white border-t border-gray-100 absolute w-full shadow-xl">
            <div class="flex flex-col p-4 space-y-4">
                @foreach([
                    ['label' => 'Home', 'url' => route('home')],
                    ['label' => 'About Us', 'url' => route('about')],
                    ['label' => 'Services', 'url' => route('services')],
                    ['label' => 'Projects', 'url' => route('projects')],
                    ['label' => 'Contact', 'url' => route('contact')]
                ] as $link)
                <a href="{{ $link['url'] }}" class="block text-slate-600 font-medium hover:text-brand-600 hover:bg-gray-50 p-2 rounded">
                    {{ $link['label'] }}
                </a>
                @endforeach
                <a href="{{ route('contact') }}" class="block text-center bg-brand-600 text-white font-bold py-3 rounded-lg mt-4">
                    Get Started Now
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 text-white pt-20 pb-10 border-t border-white/10">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-brand-500 rounded flex items-center justify-center text-white font-bold">S</div>
                        <span class="text-xl font-heading font-bold">SupremeIT</span>
                    </div>
                    <p class="text-slate-400 mb-6 leading-relaxed">
                        Transforming businesses through innovative technology solutions. We build the future of digital infrastructure.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-brand-500 transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-brand-500 transition-colors"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-brand-500 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-lg font-bold mb-6 font-heading">Company</h3>
                    <ul class="space-y-3 text-slate-400">
                        <li><a href="{{ route('about') }}" class="hover:text-brand-400 transition-colors">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Services</a></li>
                        <li><a href="{{ route('projects') }}" class="hover:text-brand-400 transition-colors">Our Process</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Careers</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-bold mb-6 font-heading">Services</h3>
                    <ul class="space-y-3 text-slate-400">
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Web Development</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Cloud Solutions</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Cyber Security</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Product Design</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-bold mb-6 font-heading">Stay Updated</h3>
                    <p class="text-slate-400 mb-4">Subscribe to our newsletter for the latest tech insights.</p>
                    <form class="flex flex-col space-y-3">
                        <input type="email" placeholder="Email address" class="bg-white/5 border border-white/10 rounded px-4 py-2.5 focus:outline-none focus:border-brand-500 focus:bg-white/10 text-white transition-all">
                        <button class="bg-brand-600 hover:bg-brand-500 text-white font-semibold py-2.5 rounded transition-all">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} SupremeIT. All rights reserved.</p>
                <div class="flex space-x-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
