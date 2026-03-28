    <footer class="bg-dark-900 border-t border-white/5 pt-20 pb-10 text-slate-300">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                        @if(!empty($site_info['site_logo']))
                            <img src="{{ resolve_image_url($site_info['site_logo']) }}" alt="{{ $site_info['site_name'] ?? 'Nova Agency' }}" class="h-10 w-auto">
                        @else
                            <div class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($site_info['site_name'] ?? 'N', 0, 1) }}
                            </div>
                            <span class="text-2xl font-heading font-bold text-white">
                                @php($siteName = $site_info['site_name'] ?? 'NovaAgency')
                                @if($siteName === 'NovaAgency')
                                    Nova<span class="text-brand-500">Agency</span>
                                @else
                                    {{ $siteName }}
                                @endif
                            </span>
                        @endif
                    </a>
                    <p class="text-slate-400 mb-6 leading-relaxed">
                        Transforming businesses through innovative technology solutions. Your partner in digital excellence.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white hover:bg-brand-600 transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white hover:bg-brand-600 transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white hover:bg-brand-600 transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 font-heading">Company</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('about') }}" class="hover:text-brand-400 transition-colors">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Services</a></li>
                        <li><a href="{{ route('projects') }}" class="hover:text-brand-400 transition-colors">Projects</a></li>
                        <li><a href="{{ route('blog') }}" class="hover:text-brand-400 transition-colors">Latest News</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-brand-400 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 font-heading">Services</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Web Development</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Cloud Solutions</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Cybersecurity</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Digital Marketing</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-brand-400 transition-colors">Product Design</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-bold font-heading text-white mb-6">Stay Updated</h3>
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
                <p class="text-slate-500 text-sm">© {{ date('Y') }} Nova Agency. All rights reserved.</p>
                <div class="flex space-x-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>