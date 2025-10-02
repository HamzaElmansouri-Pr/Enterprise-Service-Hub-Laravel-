<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SupremeIT') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { 
                min-height: 100vh; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                background: #0f172a; 
            }
            .bg-overlay { 
                position: fixed; 
                inset: 0; 
                background: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}') center/cover no-repeat; 
                filter: brightness(.5); 
                z-index: -2; 
            }
            .bg-tint { 
                position: fixed; 
                inset: 0; 
                background: linear-gradient(135deg, rgba(16,185,129,.55), rgba(59,130,246,.55)); 
                z-index: -1; 
            }
            .login-container { 
                background: rgba(255,255,255,.96); 
                border-radius: 22px; 
                box-shadow: 0 25px 60px rgba(2,6,23,.35); 
                overflow: hidden; 
                max-width: 980px; 
                width: 100%; 
                margin: 20px; 
                display: grid; 
                grid-template-columns: 1.1fr .9fr; 
            }
            @media (max-width: 992px){ 
                .login-container { 
                    grid-template-columns: 1fr; 
                } 
            }
            .login-visual { 
                position: relative; 
                background: linear-gradient(135deg, rgba(16,185,129,.12), rgba(59,130,246,.12)); 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                padding: 40px; 
            }
            .brand { 
                display: flex; 
                flex-direction: column; 
                align-items: center; 
                gap: 14px; 
                color: #0f172a; 
            }
            .brand-logo { 
                width: 120px; 
                height: 120px; 
                display: inline-flex; 
                align-items: center; 
                justify-content: center; 
                background: #ffffff; 
                border-radius: 18px; 
                box-shadow: 0 10px 30px rgba(2,6,23,.1); 
            }
            .brand-title { 
                font-weight: 800; 
                font-size: 1.4rem; 
                letter-spacing: .3px; 
            }
            .brand-sub { 
                color: #64748b; 
                font-size: .95rem; 
                text-align: center; 
                max-width: 320px; 
            }
            .login-body { 
                padding: 42px 34px; 
            }
            .login-body h2 { 
                margin: 0 0 8px; 
                font-weight: 800; 
                color: #0f172a; 
            }
            .login-body p.helper { 
                margin: 0 0 26px; 
                color: #64748b; 
            }
            .form-group { 
                margin-bottom: 22px; 
            }
            .form-group label { 
                font-weight: 600; 
                color: #0f172a; 
                margin-bottom: 8px; 
            }
            .input-group-text { 
                background: #f1f5f9; 
                border: 2px solid #e2e8f0; 
                border-right: 0; 
                border-radius: 14px 0 0 14px; 
                color: #64748b; 
            }
            .input-group .form-control { 
                border-left: 0; 
                border-radius: 0 14px 14px 0; 
            }
            .form-control { 
                border: 2px solid #e2e8f0; 
                border-radius: 14px; 
                padding: 12px 14px; 
                transition: all .2s ease; 
            }
            .form-control:focus { 
                border-color: #3b82f6; 
                box-shadow: 0 0 0 .25rem rgba(59,130,246,.15); 
            }
            .btn-login { 
                background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%); 
                border: none; 
                border-radius: 12px; 
                padding: 12px 16px; 
                font-weight: 700; 
                letter-spacing: .2px; 
                color: #fff; 
                width: 100%; 
            }
            .btn-login:hover { 
                filter: brightness(1.05); 
                box-shadow: 0 10px 26px rgba(59,130,246,.35); 
            }
            .remember-forgot { 
                display: flex; 
                align-items: center; 
                justify-content: space-between; 
                margin-bottom: 16px; 
            }
            .form-check-input:checked { 
                background-color: #3b82f6; 
                border-color: #3b82f6; 
            }
            .link { 
                color:#3b82f6; 
                text-decoration:none; 
                font-weight:600; 
            }
            .link:hover{ 
                text-decoration:underline; 
            }
            .alert { 
                border-radius: 12px; 
                border: none; 
            }
        </style>
        
        @stack('styles')
    </head>
    <body>
        <div class="bg-overlay"></div>
        <div class="bg-tint"></div>

        <div class="login-container">
            <div class="login-visual">
                <div class="brand">
                    <div class="brand-logo">
                        <img src="{{ asset('assets/img/logo/black-logo-3.svg') }}" alt="SupremeIT" style="max-width:90px; height:auto;">
                    </div>
                    <div class="brand-title">Welcome Back</div>
                    <div class="brand-sub">Sign in to your account to access your dashboard and manage your profile.</div>
                </div>
            </div>

            <div class="login-body">
                <h2>Sign in</h2>
                <p class="helper">Use your credentials to continue</p>
                {{ $slot }}
            </div>
        </div>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
