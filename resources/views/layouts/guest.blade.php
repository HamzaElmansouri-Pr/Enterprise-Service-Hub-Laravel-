<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Nova Agency') }} - Secure Auth</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Tailwind for helper classes -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            :root {
                --brand-primary: #10b981;
                --brand-secondary: #3b82f6;
                --dark-bg: #020617;
            }

            body {
                background-color: var(--dark-bg);
                font-family: 'Inter', sans-serif;
                overflow-x: hidden;
            }

            .font-heading { font-family: 'Outfit', sans-serif; }

            /* Animated Background Blobs */
            .blob-bg {
                position: fixed;
                inset: 0;
                z-index: -1;
                filter: blur(80px);
                opacity: 0.4;
            }

            .blob {
                position: absolute;
                border-radius: 50%;
                animation: animate-blob 15s infinite alternate ease-in-out;
            }

            .blob-1 {
                width: 500px;
                height: 500px;
                background: var(--brand-primary);
                top: -200px;
                left: -100px;
            }

            .blob-2 {
                width: 600px;
                height: 600px;
                background: var(--brand-secondary);
                bottom: -200px;
                right: -100px;
                animation-delay: -5s;
            }

            @keyframes animate-blob {
                0% { transform: translate(0, 0) scale(1); }
                100% { transform: translate(100px, 100px) scale(1.1); }
            }

            /* Auth Glass Card */
            .auth-card {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.05);
                border-radius: 24px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                overflow: hidden;
                width: 100%;
                max-width: 450px;
            }

            .auth-header {
                padding: 3rem 2rem 1.5rem;
                text-align: center;
            }

            .auth-body {
                padding: 0 2.5rem 3rem;
            }

            .brand-logo-container {
                width: 80px;
                height: 80px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            }

            /* Custom Premium Inputs */
            .premium-input-wrapper {
                position: relative;
                margin-bottom: 1.5rem;
            }

            .premium-input-icon {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: rgba(255,255,255,0.3);
                transition: color 0.3s;
            }

            .premium-input {
                width: 100%;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                padding: 0.85rem 1rem 0.85rem 2.8rem;
                border-radius: 12px;
                outline: none;
                transition: all 0.3s;
            }

            .premium-input:focus {
                border-color: var(--brand-primary);
                background: rgba(255, 255, 255, 0.06);
                box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            }

            .premium-input:focus + .premium-input-icon {
                color: var(--brand-primary);
            }

            /* Button Styling */
            .btn-architect {
                background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
                color: white;
                font-weight: 700;
                padding: 0.9rem;
                border-radius: 12px;
                border: none;
                width: 100%;
                transition: all 0.3s;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.9rem;
            }

            .btn-architect:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
                filter: brightness(1.1);
            }

            .text-dim { color: rgba(255, 255, 255, 0.5); }
            .link-premium {
                color: var(--brand-secondary);
                text-decoration: none;
                font-weight: 600;
                transition: opacity 0.3s;
            }
            .link-premium:hover { opacity: 0.8; }
        </style>
        
        @stack('styles')
    </head>
    <body class="antialiased">
        <!-- Animated Background -->
        <div class="blob-bg">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
        </div>

        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="brand-logo-container">
                        @php
                            $logoPath = public_path('assets/img/logo/white-logo-3.svg');
                            $hasLogo = file_exists($logoPath);
                        @endphp
                        
                        @if($hasLogo)
                            <img src="{{ asset('assets/img/logo/white-logo-3.svg') }}" alt="Nova Agency" style="max-width:50px; height:auto;">
                        @else
                            <!-- Styled Fallback Logo (Rocket/Architect Icon) -->
                            <div class="flex items-center justify-center text-emerald-400">
                                <i class="fas fa-rocket fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold text-white font-heading mb-1">Welcome Back</h2>
                    <p class="text-dim text-sm">Secure access to your project hub</p>
                </div>

                <div class="auth-body">
                    {{ $slot }}
                </div>

                <div class="px-10 pb-8 text-center border-t border-white/5 pt-6">
                    <p class="text-dim text-xs">
                        &copy; {{ date('Y') }} Nova Agency Architecture. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
