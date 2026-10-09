<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard') - ELMA Core</title>
    
    <!-- Dark Mode Init -->
    <script nonce="{{ $cspNonce ?? '' }}">
        const storedTheme = localStorage.getItem('admin-theme');
        if (storedTheme) {
            document.documentElement.setAttribute('data-bs-theme', storedTheme);
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
    </script>

    <!-- Bootstrap CSS -->
    @if(app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- TinyMCE Rich Text Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 15px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        .sidebar.collapsed .nav-link span {
            display: none;
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }
        
        .main-content.expanded {
            margin-left: 70px;
        }
        
        .top-navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 30px;
            margin-bottom: 30px;
        }
        
        .content-area {
            padding: 0 30px 30px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-card .card-body {
            padding: 2rem;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: #495057;
        }
        
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: bold;
        }
        
        .sidebar.collapsed .sidebar-brand h4 {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-brand::after {
            content: "S";
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .sidebar-heading {
            padding: 0.75rem 1.25rem 0.25rem;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .sidebar.collapsed .sidebar-heading {
            display: none;
        }

        /* Quick Find Search Styles */
        .search-container {
            position: relative;
            width: 400px;
            max-width: 100%;
        }

        .search-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border-radius: 50px;
            border: 1px solid rgba(0,0,0,0.08);
            background: rgba(0,0,0,0.03);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            color: #adb5bd;
            font-size: 0.9rem;
        }

        .search-shortcut {
            position: absolute;
            right: 1rem;
            font-size: 0.7rem;
            color: #adb5bd;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 1px 4px;
            pointer-events: none;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            margin-top: 0.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .search-results.active {
            display: block;
        }

        .search-result-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            transition: all 0.1s ease;
            border-bottom: 1px solid rgba(0,0,0,0.02);
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item i {
            width: 30px;
            text-align: center;
            margin-right: 0.75rem;
            color: var(--primary-color);
            font-size: 1rem;
        }

        .search-result-item .result-info {
            flex-grow: 1;
        }

        .search-result-item .result-title {
            font-weight: 500;
            font-size: 0.9rem;
            display: block;
        }

        .search-result-item .result-type {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #adb5bd;
            letter-spacing: 0.05rem;
        }

        .search-result-item.selected, .search-result-item:hover {
            background: rgba(0,0,0,0.03);
            color: var(--primary-color);
        }

        .search-results-section {
            padding: 0.5rem 1rem 0.2rem;
            font-size: 0.7rem;
            color: #adb5bd;
            text-transform: uppercase;
            font-weight: bold;
            background: rgba(0,0,0,0.01);
        }
        /* Quick Actions Menu Styles */
        .quick-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(var(--primary-color-rgb), 0.3);
            transition: all 0.3s ease;
        }

        .quick-action-btn:hover {
            transform: scale(1.1);
            background: #2b2b2b;
            color: white;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .quick-action-dropdown .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
            padding: 0.5rem;
            min-width: 200px;
        }

        .quick-action-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .quick-action-dropdown .dropdown-item i {
            width: 25px;
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .quick-action-dropdown .dropdown-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: bold;
            color: #adb5bd;
            letter-spacing: 0.05rem;
            padding: 0.5rem 1rem;
        }
        /* Dashboard & Content Overhaul Styles */
        .alert-card-pulse {
            border-left: 5px solid;
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% { border-left-color: rgba(220, 53, 69, 0.5); }
            50% { border-left-color: rgba(220, 53, 69, 1); }
            100% { border-left-color: rgba(220, 53, 69, 0.5); }
        }

        .stat-card-elite {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            color: white;
            position: relative;
        }

        .stat-card-elite:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .stat-card-elite i {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 5rem;
            opacity: 0.15;
            transition: all 0.3s ease;
        }

        .stat-card-elite:hover i {
            transform: scale(1.1) rotate(-10deg);
        }

        .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
        .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); }
        .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); }
        .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); }
        .bg-gradient-danger { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%); }
        .bg-gradient-dark { background: linear-gradient(135deg, #5a5c69 0%, #373840 100%); }

        .content-card-elite {
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .content-card-elite:hover {
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
            border-color: var(--primary-color);
        }

        .content-card-elite .card-header {
            background: rgba(0,0,0,0.02);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 700;
        }

        .content-card-elite .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .content-card-elite .list-group-item:first-child { border-top: none; }
        .content-card-elite .list-group-item:last-child { border-bottom: none; }
        /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background-color: #121212;
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .main-content {
            background-color: #1e1e1e;
        }
        [data-bs-theme="dark"] .top-navbar {
            background-color: #1a1a1a;
            border-bottom: 1px solid #333;
        }
        [data-bs-theme="dark"] .card {
            background-color: #242424;
            border-color: #333;
        }
        [data-bs-theme="dark"] .card-header {
            background-color: #2a2a2a;
            border-bottom-color: #333;
        }
        [data-bs-theme="dark"] .bg-white {
            background-color: #242424 !important;
        }
        [data-bs-theme="dark"] .text-dark {
            color: #e0e0e0 !important;
        }
        [data-bs-theme="dark"] .sidebar {
            background: linear-gradient(135deg, #1f1c2c 0%, #000000 100%);
        }
        [data-bs-theme="dark"] .table {
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .table-light {
            background-color: #333;
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .form-control, [data-bs-theme="dark"] .form-select {
            background-color: #333;
            border-color: #444;
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .form-control:focus, [data-bs-theme="dark"] .form-select:focus {
            background-color: #444;
            color: #fff;
        }
        [data-bs-theme="dark"] .modal-content {
            background-color: #242424;
        }
        [data-bs-theme="dark"] .modal-header, [data-bs-theme="dark"] .modal-footer {
            border-color: #333;
        }
        /* RTL Support */
        [dir="rtl"] .sidebar {
            left: auto;
            right: 0;
        }
        [dir="rtl"] .sidebar .nav-link i {
            margin-right: 0;
            margin-left: 10px;
        }
        [dir="rtl"] .main-content {
            margin-left: 0;
            margin-right: 250px;
        }
        [dir="rtl"] .main-content.expanded {
            margin-left: 0;
            margin-right: 70px;
        }
        [dir="rtl"] .ms-3 {
            margin-left: 0 !important;
            margin-right: 1rem !important;
        }
        [dir="rtl"] .me-2, [dir="rtl"] .me-3 {
            margin-right: 0 !important;
            margin-left: .5rem !important;
        }
        [dir="rtl"] .search-icon {
            left: auto;
            right: 15px;
        }
        [dir="rtl"] .search-input {
            padding-left: 50px;
            padding-right: 45px;
        }
        [dir="rtl"] .search-shortcut {
            right: auto;
            left: 10px;
        }

        /* AI Assistant FAB and Chat Styles */
        .ai-fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
            cursor: pointer;
            z-index: 1050;
            transition: all 0.3s ease;
            border: none;
        }
        .ai-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(118, 75, 162, 0.6);
        }
        
        #aiChatOffcanvas {
            width: 400px;
            border-left: none;
            box-shadow: -5px 0 25px rgba(0,0,0,0.1);
        }
        
        .chat-body {
            height: calc(100vh - 140px);
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fa;
        }
        [data-bs-theme="dark"] .chat-body {
            background: #1e1e1e;
        }
        
        .chat-message {
            margin-bottom: 1rem;
            max-width: 85%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 0.95rem;
            line-height: 1.4;
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        
        .chat-message.user {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }
        
        .chat-message.ai {
            background: white;
            color: #333;
            border: 1px solid rgba(0,0,0,0.05);
            margin-right: auto;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        [data-bs-theme="dark"] .chat-message.ai {
            background: #2a2a2a;
            color: #e0e0e0;
            border-color: #333;
        }
        
        .chat-input-container {
            padding: 1rem;
            background: white;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        [data-bs-theme="dark"] .chat-input-container {
            background: #242424;
            border-top-color: #333;
        }
        
        .typing-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 8px 12px;
            background: rgba(0,0,0,0.05);
            border-radius: 12px;
            margin-bottom: 1rem;
        }
        [data-bs-theme="dark"] .typing-indicator {
            background: rgba(255,255,255,0.1);
        }
        
        .typing-dot {
            width: 6px;
            height: 6px;
            background: #adb5bd;
            border-radius: 50%;
            animation: typingBounce 1.4s infinite ease-in-out both;
        }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        
        @keyframes typingBounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>ELMA Core Admin</h4>
        </div>
        
        <nav class="nav flex-column">
            <div class="sidebar-heading">{{ __('admin.sidebar.main') }}</div>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>{{ __('admin.sidebar.dashboard') }}</span>
            </a>

            <div class="sidebar-heading">{{ __('admin.sidebar.inbox_requests') }}</div>
            <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-envelope"></i>
                <span>{{ __('admin.sidebar.contacts') }}</span>
                @if(\App\Models\Contact::where('is_read', false)->count() > 0)
                <span class="badge bg-danger ms-2">{{ \App\Models\Contact::where('is_read', false)->count() }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.tc-requests.*') ? 'active' : '' }}" href="{{ route('admin.tc-requests.index') }}">
                <i class="fas fa-file-alt"></i>
                <span>{{ __('admin.sidebar.service_requests') }}</span>
                @if(\App\Models\TcRequest::where('is_read', false)->count() > 0)
                <span class="badge bg-danger ms-2">{{ \App\Models\TcRequest::where('is_read', false)->count() }}</span>
                @endif
            </a>

            <div class="sidebar-heading">{{ __('admin.sidebar.website_content') }}</div>
            <a class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}">
                <i class="fas fa-photo-video"></i>
                <span>{{ __('admin.sidebar.media_library') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}" href="{{ route('admin.content.index') }}">
                <i class="fas fa-edit"></i>
                <span>{{ __('admin.sidebar.cms_manager') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                <i class="fas fa-cogs"></i>
                <span>{{ __('admin.sidebar.services') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                <i class="fas fa-project-diagram"></i>
                <span>{{ __('admin.sidebar.projects') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                <i class="fas fa-blog"></i>
                <span>{{ __('admin.sidebar.blog_posts') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                <i class="fas fa-comments"></i>
                <span>{{ __('admin.sidebar.comments') }}</span>
                @if(\App\Models\Comment::where('status', 'pending')->count() > 0)
                <span class="badge bg-warning text-dark ms-2">{{ \App\Models\Comment::where('status', 'pending')->count() }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                <i class="fas fa-star"></i>
                <span>{{ __('admin.sidebar.reviews') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                <i class="fas fa-images"></i>
                <span>{{ __('admin.sidebar.sliders') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" href="{{ route('admin.subscribers.index') }}">
                <i class="fas fa-envelope-open-text"></i>
                <span>{{ __('admin.sidebar.subscribers') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}">
                <i class="fas fa-handshake"></i>
                <span>{{ __('admin.sidebar.partners') }}</span>
            </a>

            @if(Auth::user()->isAdmin())
            <div class="sidebar-heading">{{ __('admin.sidebar.administration') }}</div>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users"></i>
                <span>{{ __('admin.sidebar.users') }}</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}" href="{{ route('admin.activity-logs.index') }}">
                <i class="fas fa-clipboard-list"></i>
                <span>Activity Logs</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.trash.*') ? 'active' : '' }}" href="{{ route('admin.trash.index') }}">
                <i class="fas fa-trash"></i>
                <span>{{ __('admin.sidebar.trash') }}</span>
            </a>
            @endif
            <hr style="border-color: rgba(255, 255, 255, 0.1); margin: 20px 15px;">
            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>{{ __('admin.sidebar.view_website') }}</span>
            </a>
            <a class="nav-link logout-btn" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i>
                <span>{{ __('admin.sidebar.logout') }}</span>
            </a>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-dark" id="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- Global Search Bar -->
                    <div class="search-container ms-3 d-none d-lg-block">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" id="global-search" placeholder="Quick Find..." autocomplete="off">
                            <span class="search-shortcut">Ctrl+K</span>
                        </div>
                        <div class="search-results" id="search-results"></div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Language Dropdown -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe"></i> 
                            <span class="d-none d-md-inline ms-1">{{ strtoupper(app()->getLocale()) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item {{ app()->getLocale() == 'fr' ? 'active' : '' }}" href="{{ route('lang.switch', 'fr') }}">Français</a></li>
                            <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                        </ul>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button class="btn btn-link text-dark me-3" id="theme-toggle" title="Toggle Dark Mode">
                        <i class="fas fa-moon fs-5"></i>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div class="dropdown me-3" id="notifications-dropdown">
                        @php
                            $unreadNotifications = Auth::user()->unreadNotifications()->take(5)->get();
                            $unreadCount = Auth::user()->unreadNotifications()->count();
                        @endphp
                        <button class="btn btn-link text-dark text-decoration-none position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="notification-bell">
                            <i class="fas fa-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ $unreadCount > 0 ? '' : 'd-none' }}" id="notification-badge">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-0" style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top">
                                <h6 class="mb-0 fw-bold">Notifications</h6>
                                @if($unreadCount > 0)
                                <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm text-decoration-none p-0">Mark all read</button>
                                </form>
                                @endif
                            </div>
                            <div id="notification-list">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ $notification->data['action_url'] ?? '#' }}" class="dropdown-item p-3 border-bottom text-wrap notification-item" data-id="{{ $notification->id }}" onclick="markNotificationAsRead('{{ $notification->id }}')">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3 text-primary mt-1">
                                                <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold fs-6">{{ $notification->data['title'] }}</h6>
                                                <p class="mb-1 small text-muted">{{ $notification->data['message'] }}</p>
                                                <small class="text-secondary">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-muted" id="no-notifications">
                                        <i class="fas fa-check-circle fs-3 mb-2 text-success"></i>
                                        <p class="mb-0">You're all caught up!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Add Menu -->
                    <div class="dropdown quick-action-dropdown me-3 d-none d-sm-block">
                        <button class="quick-action-btn" type="button" data-bs-toggle="dropdown" title="Add New Item">
                            <i class="fas fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">Quick Create</li>
                            <li><a class="dropdown-item" href="{{ route('admin.services.create') }}"><i class="fas fa-cogs"></i> New Service</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.projects.create') }}"><i class="fas fa-project-diagram"></i> New Project</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.blogs.create') }}"><i class="fas fa-blog"></i> New Blog Post</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.partners.create') }}"><i class="fas fa-handshake"></i> New Partner</a></li>
                        </ul>
                    </div>

                    <span class="text-muted me-3 d-none d-md-inline-block">Welcome, {{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->image)
                                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile" 
                                     class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle"></i>
                            @endif
                        </button>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.settings.edit-profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-btn" href="{{ route('logout') }}">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @php
                $savedViews = Auth::user()->preferences ?? [];
                $currentRoutePrefix = Route::currentRouteName() . '_';
                $routeViews = collect($savedViews)->filter(function($val, $key) use ($currentRoutePrefix) {
                    return str_starts_with($key, $currentRoutePrefix);
                });
            @endphp
            @if($routeViews->count() > 0)
                <div class="mb-4 d-flex align-items-center flex-wrap gap-2">
                    <span class="text-muted small fw-bold text-uppercase me-2"><i class="fas fa-bookmark me-1"></i> Saved Views:</span>
                    <a href="{{ request()->url() }}" class="btn btn-sm {{ request()->query() ? 'btn-outline-secondary' : 'btn-secondary' }} rounded-pill px-3">Default</a>
                    @foreach($routeViews as $key => $view)
                        <div class="btn-group shadow-sm rounded-pill">
                            <a href="{{ request()->url() }}{{ $view['url'] }}" class="btn btn-sm {{ request()->fullUrl() == request()->url() . $view['url'] ? 'btn-primary' : 'btn-light' }} rounded-start-pill px-3 border-end-0">
                                {{ $view['name'] }}
                            </a>
                            <button type="button" class="btn btn-sm {{ request()->fullUrl() == request()->url() . $view['url'] ? 'btn-primary' : 'btn-light' }} rounded-end-pill dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <form action="{{ route('admin.settings.preferences') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $key }}">
                                        <input type="hidden" name="value" value="">
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i> Delete View
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    
    <!-- AI Assistant Floating Action Button -->
    <button class="ai-fab" type="button" data-bs-toggle="offcanvas" data-bs-target="#aiChatOffcanvas" aria-controls="aiChatOffcanvas" title="Nova AI Assistant">
        <i class="fas fa-magic"></i>
    </button>

    <!-- Toast Notifications Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1060;" id="liveToastContainer">
    </div>

    <!-- AI Assistant Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="aiChatOffcanvas" aria-labelledby="aiChatOffcanvasLabel">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title fw-bold" id="aiChatOffcanvasLabel">
                <i class="fas fa-robot me-2"></i> Nova Assistant
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column">
            <!-- Chat Messages -->
            <div class="chat-body" id="ai-chat-body">
                <div class="chat-message ai">
                    Hello {{ Auth::user()->name }}! I am Nova, your AI assistant. How can I help you manage the dashboard today?
                    <br><br>
                    <em>Try asking: "Create a blog post about our new services" or "Show me unread messages."</em>
                </div>
            </div>
            
            <!-- Chat Input -->
            <div class="chat-input-container mt-auto">
                <form id="ai-assistant-form">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-pill" id="ai-assistant-input" placeholder="Type your command..." autocomplete="off" required>
                        <button class="btn btn-primary rounded-pill ms-2" type="submit" id="ai-assistant-submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Admin JS -->
    <script nonce="{{ $cspNonce ?? '' }}">
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Logout functionality
        document.querySelectorAll('.logout-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            });
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // AI Assistant Logic
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('ai-assistant-form');
            const chatInput = document.getElementById('ai-assistant-input');
            const chatBody = document.getElementById('ai-chat-body');
            const submitBtn = document.getElementById('ai-assistant-submit');
            
            function scrollToBottom() {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
            
            function appendMessage(text, sender) {
                const div = document.createElement('div');
                div.className = `chat-message ${sender}`;
                div.innerHTML = text;
                chatBody.appendChild(div);
                scrollToBottom();
            }
            
            function showTyping() {
                const div = document.createElement('div');
                div.className = 'typing-indicator';
                div.id = 'ai-typing';
                div.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
                chatBody.appendChild(div);
                scrollToBottom();
            }
            
            function hideTyping() {
                const indicator = document.getElementById('ai-typing');
                if (indicator) indicator.remove();
            }
            
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;
                
                // Append User Message
                appendMessage(message, 'user');
                chatInput.value = '';
                submitBtn.disabled = true;
                
                showTyping();
                
                // Call Assistant Endpoint
                fetch('{{ route("admin.ai.assistant") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    hideTyping();
                    submitBtn.disabled = false;
                    
                    if (data.message) {
                        appendMessage(data.message, 'ai');
                    } else {
                        appendMessage("Executing command...", 'ai');
                    }
                    
                    if (data.action === 'navigate' && data.url) {
                        setTimeout(() => {
                            window.location.href = data.url;
                        }, 1500);
                    }
                })
                .catch(err => {
                    hideTyping();
                    submitBtn.disabled = false;
                    appendMessage("Sorry, I encountered an error. Please try again.", 'ai');
                    console.error("AI Assistant Error:", err);
                });
            });
        });

        // TinyMCE Initialization
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '.richtext-editor',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
                toolbar: 'ai_generate | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code',
                menubar: false,
                height: 500,
                skin: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'oxide-dark' : 'oxide',
                content_css: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'default',
                images_upload_handler: function (blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '{{ route("admin.media.store") }}');
                        
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        
                        xhr.upload.onprogress = (e) => {
                            progress(e.loaded / e.total * 100);
                        };
                        
                        xhr.onload = function() {
                            if (xhr.status === 403) {
                                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                                return;
                            }
                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('HTTP Error: ' + xhr.status);
                                return;
                            }
                            const json = JSON.parse(xhr.responseText);
                            if (!json || typeof json.url !== 'string') {
                                reject('Invalid JSON: ' + xhr.responseText);
                                return;
                            }
                            resolve(json.url);
                        };
                        
                        xhr.onerror = function () {
                            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                        };
                        
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        
                        xhr.send(formData);
                    });
                },
                setup: function (editor) {
                    // Custom AI Generator Button
                    editor.ui.registry.addButton('ai_generate', {
                        icon: 'sparkles', // Built-in icon
                        tooltip: 'Generate content with AI',
                        onAction: function () {
                            // Find the closest context field or use page title
                            let contextEl = document.querySelector('input[name="title[en]"]') || 
                                          document.querySelector('input[name="hero_title[en]"]') ||
                                          document.querySelector('input[name="features_title[en]"]');
                            
                            let context = contextEl ? contextEl.value : prompt('Enter a topic for the AI to write about:');
                            if (!context) {
                                alert('Please provide a context or topic.');
                                return;
                            }
                            
                            const locale = editor.getElement().getAttribute('data-locale') || 'en';
                            
                            editor.setProgressState(true);
                            
                            fetch('{{ route("admin.ai.generate") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ 
                                    type: 'blog_body', // Default fallback
                                    context: context,
                                    tone: 'professional',
                                    length: 'medium',
                                    language: locale
                                })
                            })
                            .then(async response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                const reader = response.body.getReader();
                                const decoder = new TextDecoder("utf-8");
                                
                                editor.setContent(''); // clear existing
                                
                                while (true) {
                                    const { value, done } = await reader.read();
                                    if (done) break;
                                    const chunk = decoder.decode(value, { stream: true });
                                    const lines = chunk.split("\n");
                                    for (let line of lines) {
                                        if (line.startsWith('data: ')) {
                                            const dataStr = line.substring(6).trim();
                                            if (dataStr === '[DONE]') break;
                                            try {
                                                const data = JSON.parse(dataStr);
                                                if (data.chunk) {
                                                    // Append safely (insert at end of content might be tricky with HTML, but for raw text chunking into editor it's ok)
                                                    // TinyMCE doesn't have an append method, so we set content. 
                                                    // Because of streaming HTML, appending dynamically is hard.
                                                    // Let's use standard insertContent or get/set.
                                                    let current = editor.getContent({format: 'html'});
                                                    editor.setContent(current + data.chunk);
                                                }
                                            } catch (e) {}
                                        }
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('AI error:', error);
                                alert('Failed to generate AI content.');
                            })
                            .finally(() => {
                                editor.setProgressState(false);
                            });
                        }
                    });

                    // Trigger native change events when TinyMCE content changes
                    editor.on('change', function () {
                        editor.save();
                        editor.getElement().dispatchEvent(new Event('change', { bubbles: true }));
                    });
                    
                    editor.on('input', function() {
                        editor.save();
                        editor.getElement().dispatchEvent(new Event('input', { bubbles: true }));
                    });
                }
            });
        }
    </script>
    
    @stack('hidden-forms')
    @stack('scripts')

    <script nonce="{{ $cspNonce ?? '' }}">
        // Global Search Functionality
        const searchInput = document.getElementById('global-search');
        const searchResults = document.getElementById('search-results');
        let selectedIndex = -1;

        if (searchInput && searchResults) {
            // shortcut Ctrl+K to focus search
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'k') {
                    e.preventDefault();
                    searchInput.focus();
                }
                
                if (searchResults.classList.contains('active')) {
                    const items = searchResults.querySelectorAll('.search-result-item');
                    
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex + 1) % items.length;
                        updateSelection(items);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                        updateSelection(items);
                    } else if (e.key === 'Enter') {
                        if (selectedIndex > -1) {
                            e.preventDefault();
                            items[selectedIndex].click();
                        }
                    } else if (e.key === 'Escape') {
                        closeSearch();
                    }
                }
            });

            function updateSelection(items) {
                items.forEach((item, idx) => {
                    if (idx === selectedIndex) {
                        item.classList.add('selected');
                        item.scrollIntoView({ block: 'nearest' });
                    } else {
                        item.classList.remove('selected');
                    }
                });
            }

            function closeSearch() {
                searchResults.classList.remove('active');
                selectedIndex = -1;
            }

            // Close search on click outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    closeSearch();
                }
            });

            let debounceTimer;
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                if (query.length < 2) {
                    closeSearch();
                    return;
                }

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });

            function performSearch(query) {
                // 1. Get Static matches from sidebar
                const staticResults = [];
                document.querySelectorAll('.sidebar .nav-link:not([target="_blank"])').forEach(link => {
                    const titleEl = link.querySelector('span');
                    if (titleEl && titleEl.textContent.toLowerCase().includes(query.toLowerCase())) {
                        staticResults.push({
                            title: titleEl.textContent,
                            type: 'Page',
                            url: link.href,
                            icon: link.querySelector('i').className
                        });
                    }
                });

                // 2. Fetch from Backend
                fetch(`{{ route('admin.search.query') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        renderResults(staticResults, data);
                    });
            }

            function renderResults(staticResults, dynamicResults) {
                if (staticResults.length === 0 && dynamicResults.length === 0) {
                    searchResults.innerHTML = '<div class="p-3 text-center text-muted small">No results found for your query.</div>';
                } else {
                    let html = '';
                    
                    if (staticResults.length > 0) {
                        html += '<div class="search-results-section">Admin Sections</div>';
                        staticResults.forEach(res => {
                            html += `
                                <a href="${res.url}" class="search-result-item">
                                    <i class="${res.icon}"></i>
                                    <div class="result-info">
                                        <span class="result-title">${res.title}</span>
                                        <span class="result-type">${res.type}</span>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    if (dynamicResults.length > 0) {
                        html += '<div class="search-results-section">Records (Services, Projects, Blogs)</div>';
                        dynamicResults.forEach(res => {
                            html += `
                                <a href="${res.url}" class="search-result-item">
                                    <i class="${res.icon}"></i>
                                    <div class="result-info">
                                        <span class="result-title">${res.title}</span>
                                        <span class="result-type">${res.type}</span>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    searchResults.innerHTML = html;
                }
                
                searchResults.classList.add('active');
                selectedIndex = -1;
            }

            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    searchResults.classList.add('active');
                }
            });
        }

        // Theme Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');

        function updateThemeIcon() {
            if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                themeToggleBtn.classList.replace('text-dark', 'text-warning');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                themeToggleBtn.classList.replace('text-warning', 'text-dark');
            }
        }

        updateThemeIcon(); // Initial set

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('admin-theme', newTheme);
            
            updateThemeIcon();

            // Save to backend
            fetch(`{{ route('admin.settings.theme') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ theme: newTheme })
            }).catch(e => console.error('Failed to save theme preference', e));
        });

        // Notifications Logic
        function markNotificationAsRead(id) {
            fetch(`{{ url('admin/notifications') }}/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }
    </script>
    
    <!-- Laravel Echo (Vite) -->
    @vite(['resources/js/echo.js'])
    
    <script nonce="{{ $cspNonce ?? '' }}">
        // Setup Echo Listener if Echo is loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (window.Echo) {
                const userId = {{ Auth::id() }};
                window.Echo.private(`App.Models.User.${userId}`)
                    .notification((notification) => {
                        console.log('Received notification:', notification);
                        
                        // Create Toast
                        const toastHtml = `
                            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <i class="${notification.icon} text-primary me-2"></i>
                                    <strong class="me-auto">${notification.title}</strong>
                                    <small class="text-muted">Just now</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    ${notification.message}
                                    ${notification.action_url ? `<div class="mt-2 pt-2 border-top"><a href="${notification.action_url}" class="btn btn-primary btn-sm">View Details</a></div>` : ''}
                                </div>
                            </div>
                        `;
                        const toastContainer = document.getElementById('liveToastContainer');
                        toastContainer.insertAdjacentHTML('beforeend', toastHtml);

                        // Increment Badge
                        const badge = document.getElementById('notification-badge');
                        let count = parseInt(badge.textContent) || 0;
                        count++;
                        badge.textContent = count > 99 ? '99+' : count;
                        badge.classList.remove('d-none');
                        
                        // Add to Dropdown List
                        const list = document.getElementById('notification-list');
                        const noNotifs = document.getElementById('no-notifications');
                        if (noNotifs) noNotifs.remove();
                        
                        const itemHtml = `
                            <a href="${notification.action_url || '#'}" class="dropdown-item p-3 border-bottom text-wrap notification-item" data-id="${notification.id}" onclick="markNotificationAsRead('${notification.id}')">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3 text-primary mt-1">
                                        <i class="${notification.icon || 'fas fa-bell'} fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold fs-6">${notification.title}</h6>
                                        <p class="mb-1 small text-muted">${notification.message}</p>
                                        <small class="text-secondary">Just now</small>
                                    </div>
                                </div>
                            </a>
                        `;
                        list.insertAdjacentHTML('afterbegin', itemHtml);
                    });
            }
        });
    </script>
    <script nonce="{{ $cspNonce ?? '' }}">
        // Inline Editing Logic
        document.addEventListener('click', function(e) {
            const inlineEditEl = e.target.closest('[data-inline-edit]');
            if (!inlineEditEl) return;
            if (inlineEditEl.classList.contains('editing')) return;

            const field = inlineEditEl.getAttribute('data-inline-edit');
            const url = inlineEditEl.getAttribute('data-inline-url');
            const type = inlineEditEl.getAttribute('data-inline-type') || 'text';
            const originalValue = inlineEditEl.textContent.trim();

            inlineEditEl.classList.add('editing');
            
            let inputHtml = '';
            if (type === 'select' && field === 'is_active') {
                const isActive = inlineEditEl.getAttribute('data-value') === '1';
                inputHtml = `
                    <select class="form-select form-select-sm d-inline-block w-auto inline-input">
                        <option value="1" ${isActive ? 'selected' : ''}>Published</option>
                        <option value="0" ${!isActive ? 'selected' : ''}>Draft</option>
                    </select>
                `;
            } else if (type === 'select' && field === 'status') {
                const currentStatus = inlineEditEl.getAttribute('data-value');
                inputHtml = `
                    <select class="form-select form-select-sm d-inline-block w-auto inline-input">
                        <option value="pending" ${currentStatus==='pending' ? 'selected' : ''}>Pending</option>
                        <option value="reviewed" ${currentStatus==='reviewed' ? 'selected' : ''}>Reviewed</option>
                        <option value="contacted" ${currentStatus==='contacted' ? 'selected' : ''}>Contacted</option>
                        <option value="completed" ${currentStatus==='completed' ? 'selected' : ''}>Completed</option>
                        <option value="spam" ${currentStatus==='spam' ? 'selected' : ''}>Spam</option>
                    </select>
                `;
            } else {
                inputHtml = `<input type="text" class="form-control form-control-sm d-inline-block inline-input" style="min-width:150px" value="${originalValue.replace(/"/g, '&quot;')}">`;
            }

            const originalContent = inlineEditEl.innerHTML;
            inlineEditEl.innerHTML = inputHtml;
            const input = inlineEditEl.querySelector('.inline-input');
            input.focus();

            function saveChanges() {
                const newValue = input.value;
                if (type !== 'select' && newValue === originalValue) {
                    restore();
                    return;
                }

                // Show loading
                inlineEditEl.innerHTML = '<i class="fas fa-spinner fa-spin text-muted"></i>';

                const data = {};
                data[field] = newValue;

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        inlineEditEl.classList.remove('editing');
                        if (type === 'select') {
                            inlineEditEl.setAttribute('data-value', newValue);
                            inlineEditEl.innerHTML = data.html || input.options[input.selectedIndex].text;
                        } else {
                            inlineEditEl.innerHTML = newValue + ' <i class="fas fa-pencil-alt text-muted ms-1" style="font-size:0.75rem; opacity:0; transition:0.2s"></i>';
                        }
                    } else {
                        alert(data.message || 'Error updating value');
                        restore();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Network error during update.');
                    restore();
                });
            }

            function restore() {
                inlineEditEl.innerHTML = originalContent;
                inlineEditEl.classList.remove('editing');
            }

            input.addEventListener('blur', saveChanges);
            input.addEventListener('keydown', function(evt) {
                if (evt.key === 'Enter') {
                    evt.preventDefault();
                    input.blur(); // triggers save
                }
                if (evt.key === 'Escape') {
                    restore();
                }
            });
        });

        // Add hover effect for inline edit pencils
        document.addEventListener('mouseover', function(e) {
            const inlineEditEl = e.target.closest('[data-inline-edit]:not(.editing)');
            if (inlineEditEl) {
                const icon = inlineEditEl.querySelector('.fa-pencil-alt');
                if (icon) icon.style.opacity = '1';
                inlineEditEl.style.cursor = 'pointer';
            }
        });
        document.addEventListener('mouseout', function(e) {
            const inlineEditEl = e.target.closest('[data-inline-edit]:not(.editing)');
            if (inlineEditEl) {
                const icon = inlineEditEl.querySelector('.fa-pencil-alt');
                if (icon) icon.style.opacity = '0';
            }
        });

        // Bulk Actions Logic
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all-rows');
            if (!selectAll) return;

            const rowCheckboxes = document.querySelectorAll('.row-selector');
            const bulkActionsBar = document.getElementById('bulk-actions-bar');
            const selectedCount = document.getElementById('selected-count');
            const bulkIdsInput = document.getElementById('bulk-ids');

            function updateBulkBar() {
                const checked = document.querySelectorAll('.row-selector:checked');
                if (checked.length > 0) {
                    bulkActionsBar.classList.remove('d-none');
                    selectedCount.textContent = checked.length;
                    
                    const ids = Array.from(checked).map(cb => cb.value);
                    bulkIdsInput.value = JSON.stringify(ids);
                } else {
                    bulkActionsBar.classList.add('d-none');
                }
                selectAll.checked = (checked.length === rowCheckboxes.length && rowCheckboxes.length > 0);
            }

            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBulkBar();
            });

            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateBulkBar);
            });
            
            // Save View Logic
            const saveViewBtn = document.getElementById('btn-save-view');
            if (saveViewBtn) {
                saveViewBtn.addEventListener('click', function() {
                    const viewName = prompt("Enter a name for this saved view:");
                    if (!viewName) return;
                    
                    const currentUrl = window.location.search;
                    const routeName = '{{ Route::currentRouteName() }}';
                    const key = routeName + '_' + Date.now();
                    
                    const prefData = {
                        name: viewName,
                        url: currentUrl
                    };

                    fetch('{{ route("admin.settings.preferences") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            key: key,
                            value: prefData
                        })
                    }).then(r => r.json()).then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
