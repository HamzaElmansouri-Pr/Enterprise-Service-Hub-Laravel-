<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nova Agency') }} - Authentication</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Custom UI Elements */
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .mesh-bg {
            background-color: #020617;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,0.2) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,0.2) 0, transparent 50%);
        }

        .input-premium {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-premium:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .input-icon {
            color: rgba(255, 255, 255, 0.4);
            transition: color 0.3s ease;
        }
        .input-premium:focus + .input-icon,
        .input-premium:not(:placeholder-shown) + .input-icon {
            color: #3b82f6;
        }

        .btn-glow {
            position: relative;
        }
        .btn-glow::after {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899, #3b82f6);
            z-index: -1;
            filter: blur(12px);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: inherit;
        }
        .btn-glow:hover::after {
            opacity: 0.6;
        }

        /* Subtle floating animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: 3s;
        }
    </style>
</head>
<body class="antialiased mesh-bg text-slate-300 min-h-screen flex items-center justify-center selection:bg-blue-500 selection:text-white">
    
    <div class="w-full min-h-screen flex">
        
        <!-- Left Side: Branding / Visuals -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12">
            <!-- Decorative Elements -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-blue-600/20 blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-purple-600/20 blur-[120px]"></div>
            
            <div class="relative z-10">
                @php
                    $logoPath = public_path('assets/img/logo/white-logo-3.svg');
                    $hasLogo = file_exists($logoPath);
                @endphp
                
                <a href="/" class="inline-block transition-transform hover:scale-105">
                    @if($hasLogo)
                        <img src="{{ asset('assets/img/logo/white-logo-3.svg') }}" alt="Nova Agency" class="h-10">
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-purple-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <i class="fas fa-layer-group text-white text-lg"></i>
                            </div>
                            <span class="text-2xl font-bold text-white font-heading tracking-tight">Nova Agency</span>
                        </div>
                    @endif
                </a>
            </div>

            <div class="relative z-10 max-w-lg mt-auto mb-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-6 animate-float">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Enterprise Dashboard
                </div>
                <h1 class="text-5xl font-heading font-bold text-white mb-6 leading-tight">
                    Manage your digital universe with <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">precision.</span>
                </h1>
                <p class="text-slate-400 text-lg leading-relaxed mb-8">
                    Access high-level analytics, securely manage client projects, and control your agency's architecture from one unified command center.
                </p>
                
                <!-- Floating Glass Cards -->
                <div class="flex gap-4 animate-float-delayed">
                    <div class="glass-panel p-4 rounded-2xl flex items-center gap-4 w-48">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Secure</p>
                            <p class="text-slate-400 text-xs">End-to-end encrypted</p>
                        </div>
                    </div>
                    <div class="glass-panel p-4 rounded-2xl flex items-center gap-4 w-48">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Lightning Fast</p>
                            <p class="text-slate-400 text-xs">Optimized routing</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-slate-500 text-sm">
                &copy; {{ date('Y') }} Nova Agency. All rights reserved.
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
            <!-- Mobile Logo (hidden on desktop) -->
            <div class="absolute top-8 left-8 lg:hidden">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-layer-group text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-white font-heading tracking-tight">Nova</span>
                </div>
            </div>

            <div class="w-full max-w-md">
                <div class="glass-panel p-8 sm:p-10 rounded-3xl relative z-10 shadow-2xl shadow-black/50">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-white font-heading mb-2">Welcome Back</h2>
                        <p class="text-slate-400 text-sm">Enter your credentials to access the dashboard</p>
                    </div>

                    {{ $slot }}

                </div>
            </div>
        </div>

    </div>

</body>
</html>
