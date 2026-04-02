<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard') - Nova Agency</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>Nova Agency Admin</h4>
        </div>
        
        <nav class="nav flex-column">
            <div class="sidebar-heading">Main</div>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-heading">Inbox & Requests</div>
            <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-envelope"></i>
                <span>Contacts</span>
                @if(\App\Models\Contact::where('is_read', false)->count() > 0)
                <span class="badge bg-danger ms-2">{{ \App\Models\Contact::where('is_read', false)->count() }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.tc-requests.*') ? 'active' : '' }}" href="{{ route('admin.tc-requests.index') }}">
                <i class="fas fa-file-alt"></i>
                <span>Service Requests</span>
                @if(\App\Models\TcRequest::where('is_read', false)->count() > 0)
                <span class="badge bg-danger ms-2">{{ \App\Models\TcRequest::where('is_read', false)->count() }}</span>
                @endif
            </a>

            <div class="sidebar-heading">Website Content</div>
            <a class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}" href="{{ route('admin.content.index') }}">
                <i class="fas fa-edit"></i>
                <span>CMS Manager</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                <i class="fas fa-cogs"></i>
                <span>Services</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                <i class="fas fa-project-diagram"></i>
                <span>Projects</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                <i class="fas fa-blog"></i>
                <span>Blog Posts</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                <i class="fas fa-star"></i>
                <span>Reviews</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                <i class="fas fa-images"></i>
                <span>Sliders</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}">
                <i class="fas fa-handshake"></i>
                <span>Partners</span>
            </a>

            @if(Auth::user()->isAdmin())
            <div class="sidebar-heading">Administration</div>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
            @endif
            <hr style="border-color: rgba(255, 255, 255, 0.1); margin: 20px 15px;">
            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>View Website</span>
            </a>
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
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
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            
            @yield('content')
        </div>
    </div>
    
    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Admin JS -->
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('hidden-forms')
    @stack('scripts')

    <script>
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
    </script>
</body>
</html>
