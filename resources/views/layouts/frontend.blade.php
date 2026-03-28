<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', $meta_description ?? 'Nova Agency - Professional IT Solutions & Consulting')">
    <meta property="og:title" content="@yield('title', 'Nova Agency') | IT Solutions">
    <meta property="og:description" content="@yield('meta_description', $meta_description ?? 'Nova Agency')">
    <meta property="og:image" content="@yield('og_image', asset($og_image ?? 'images/og-default.jpg'))">
    <meta name="twitter:card" content="summary_large_image">

    <title>@yield('meta_title', 'Nova Agency | IT Solutions')</title>

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

    @include('partials.frontend-header')

    <!-- Main Content -->

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.frontend-footer')

    @stack('scripts')
</body>
</html>
