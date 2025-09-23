{{-- <!-- Header Section Start -->
<div class="header-top-3">
    <div class="container">
        <p>
            All with One CRM Platform <a href="{{ route('contact') }}">download app</a>
        </p>
    </div>
</div>
<header id="header-sticky" class="header-3">
    <div class="container">
        <div class="mega-menu-wrapper">
            <div class="header-main">
                <div class="logo">
                    <a href="{{ route('home') }}" class="header-logo">
                        <img src="{{ asset('assets/img/logo/theme-logo-2.svg') }}" alt="logo-img">
                    </a>
                </div>
                <div class="mean__menu-wrapper">
                    <div class="main-menu">
                        <nav id="mobile-menu">
                            <ul>
                                <li class="has-dropdown {{ request()->routeIs('home') ? 'active' : '' }} menu-thumb">
                                    <a href="{{ route('home') }}">
                                        Home 
                                    </a>
                                    <ul class="submenu has-homemenu">
                                        <li>
                                            <div class="homemenu-items">
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb">
                                                        <img src="{{ asset('assets/img/header/home-1.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="{{ route('home') }}" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                             CRM SupremeIT
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-2.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                            App landing
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-3.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                           AI Content Writer
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-4.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                            Payment gateway
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-5.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                          SEO Agency
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-dropdown {{ request()->routeIs('home') ? 'active' : '' }} d-xl-none">
                                    <a href="{{ route('home') }}" class="border-none">
                                    Home
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('home') }}">CRM SupremeIT</a></li>
                                        <li><a href="#">App landing </a></li>
                                        <li><a href="#">AI Content Writer</a></li>
                                        <li><a href="#">Payment gateway</a></li>
                                        <li><a href="#">SEO Agency</a></li>
                                    </ul>
                                </li>
                               <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">about us</a>
                                </li>
                                <li>
                                    <a href="#">
                                        services
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="#">Our service</a></li>
                                        <li><a href="#">service Details</a></li>
                                    </ul>
                                </li>
                                <li class="has-dropdown">
                                    <a href="#">
                                        Pages
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown">
                                            <a href="#">
                                                Our Team
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="#">Our Team</a></li>
                                                <li><a href="#">Team Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="#">
                                               Case studies
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="#">Case studies</a></li>
                                                <li><a href="#">Case studies Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Pricing Plan</a></li>
                                        <li><a href="#">Our Faq</a></li>
                                        <li><a href="#">sign in</a></li>
                                        <li><a href="#">Register</a></li>
                                        <li><a href="#">404 Page</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        Blog
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="#">Blog Grid</a></li>
                                        <li><a href="#">Blog Standard</a></li>
                                        <li><a href="#">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="header-right d-flex justify-content-end align-items-center">
                    <div class="header-button">
                        <a href="#" class="gt-theme-btn gt-theme-btn style-3 bg-border">sign in</a>
                        <a href="{{ route('contact') }}" class="gt-theme-btn gt-theme-btn style-3 bg-theme">get A demo</a>
                    </div>
                    <div class="header__hamburger d-xl-none my-auto">
                        <div class="sidebar__toggle">
                            <div class="header-bar">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> --}}



   <head>
        <!-- ========== Meta Tags ========== -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Gramentheme">
        <meta name="description" content="Boostly - SaaS & Tech Startup HTML Template">
        <!-- ======== Page title ============ -->
        <title>Shared on THEMELOCK.COM - Boostly - SaaS & Tech Startup HTML Template</title>
        <!--<< Favcion >>-->
        <link rel="shortcut icon" href="assets/img/favicon.svg">
        <!--<< Bootstrap min.css >>-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!--<< All Min Css >>-->
        <link rel="stylesheet" href="assets/css/all.min.css">
        <!--<< Animate.css >>-->
        <link rel="stylesheet" href="assets/css/animate.css">
        <!--<< Magnific Popup.css >>-->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <!--<< MeanMenu.css >>-->
        <link rel="stylesheet" href="assets/css/meanmenu.css">
        <!--<< Swiper Bundle.css >>-->
        <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
        <!--<< Nice Select.css >>-->
        <link rel="stylesheet" href="assets/css/nice-select.css">
        <!--<< Main.css >>-->
        <link rel="stylesheet" href="assets/css/flaticon.css">
         <!--<< Main.css >>-->
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="body-bg-2">

         <!-- Preloader -->
        <div class="preloader"></div>

        <!-- GT Back To Top Start -->
        <button id="gt-back-top" class="gt-back-to-top color-3">
           <i class="fa-solid fa-arrow-up"></i>
        </button>

        <!-- GT MouseCursor Start -->
        <div class="mouseCursor cursor-outer color-3"></div>
        <div class="mouseCursor cursor-inner color-3"></div>

        <!-- Offcanvas Area Start -->
        <div class="fix-area">
            <div class="offcanvas__info style-3">
                <div class="offcanvas__wrapper">
                    <div class="offcanvas__content">
                        <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                            <div class="offcanvas__logo">
                                <a href="index.html">
                                    <img src="assets/img/logo/theme-logo-2.svg" alt="logo-img">
                                </a>
                            </div>
                            <div class="offcanvas__close">
                                <button>
                                <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text d-none d-xl-block">
                            Nullam dignissim, ante scelerisque the  is euismod fermentum odio sem semper the is erat, a feugiat leo urna eget eros. Duis Aenean a imperdiet risus.
                        </p>
                        <div class="mobile-menu style-2 fix mb-3"></div>
                        <div class="offcanvas__contact pt-5">
                            <a href="contact.html" class="gt-theme-btn">
                               get free trial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas__overlay"></div>

        <!-- Header Section Start -->
          <div class="header-top-3">
            <div class="container">
                <p>
                    All with One CRM Platform <a href="contact.html">download app</a>
                </p>
            </div>
         </div>
        {{-- <header id="header-sticky" class="header-3">
            <div class="container">
                <div class="mega-menu-wrapper">
                    <div class="header-main">
                        <div class="logo">
                                <a href="index.html" class="header-logo">
                                    <img src="assets/img/logo/theme-logo-2.svg" alt="logo-img">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="has-dropdown active menu-thumb">
                                                <a href="index.html">
                                                    Home 
                                                </a>
                                                <ul class="submenu has-homemenu">
                                                    <li>
                                                        <div class="homemenu-items">
                                                            <div class="homemenu">
                                                                <div class="homemenu-thumb">
                                                                    <img src="assets/img/header/home-1.jpg" alt="img">
                                                                    <div class="demo-button">
                                                                        <a href="index.html" class="theme-btn">
                                                                            Demo Page
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="homemenu-content text-center">
                                                                    <h4 class="homemenu-title">
                                                                         CRM Boostly
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="homemenu">
                                                                <div class="homemenu-thumb mb-15">
                                                                    <img src="assets/img/header/home-2.jpg" alt="img">
                                                                    <div class="demo-button">
                                                                        <a href="index-2.html" class="theme-btn">
                                                                            Demo Page
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="homemenu-content text-center">
                                                                    <h4 class="homemenu-title">
                                                                        App landing
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="homemenu">
                                                                <div class="homemenu-thumb mb-15">
                                                                    <img src="assets/img/header/home-3.jpg" alt="img">
                                                                    <div class="demo-button">
                                                                        <a href="index-3.html" class="theme-btn">
                                                                            Demo Page
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="homemenu-content text-center">
                                                                    <h4 class="homemenu-title">
                                                                       AI Content Writer
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="homemenu">
                                                                <div class="homemenu-thumb mb-15">
                                                                    <img src="assets/img/header/home-4.jpg" alt="img">
                                                                    <div class="demo-button">
                                                                        <a href="index-4.html" class="theme-btn">
                                                                            Demo Page
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="homemenu-content text-center">
                                                                    <h4 class="homemenu-title">
                                                                        Payment getway
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="homemenu">
                                                                <div class="homemenu-thumb mb-15">
                                                                    <img src="assets/img/header/home-5.jpg" alt="img">
                                                                    <div class="demo-button">
                                                                        <a href="index-5.html" class="theme-btn">
                                                                            Demo Page
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="homemenu-content text-center">
                                                                    <h4 class="homemenu-title">
                                                                      SEO Agency
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="has-dropdown active d-xl-none">
                                                <a href="index.html" class="border-none">
                                                Home
                                                </a>
                                                <ul class="submenu">
                                                    <li><a href="index.html">CRM Boostly</a></li>
                                                    <li><a href="index-2.html">App landing </a></li>
                                                    <li><a href="index-3.html">AI Content Writer</a></li>
                                                    <li><a href="index-4.html">Payment getway</a></li>
                                                    <li><a href="index-5.html">SEO Agency</a></li>
                                                </ul>
                                            </li>
                                           <li>
                                                <a href="about.html">about us</a>
                                            </li>
                                            <li>
                                                <a href={{route('services')}}>
                                                    services
                                                </a>
                                                <ul class="submenu">
                                                    <li><a href="service.html">Our service</a></li>
                                                    <li><a href="service-details.html">service Details</a></li>
                                                </ul>
                                            </li>
                                            <li class="has-dropdown">
                                                <a href="news-details.html">
                                                    Pages
                                                </a>
                                                <ul class="submenu">
                                                    <li class="has-dropdown">
                                                        <a href="team-details.html">
                                                            Our Team
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li><a href="team.html">Our Team</a></li>
                                                            <li><a href="team-details.html">Team Details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-dropdown">
                                                        <a href="project-details.html">
                                                           Case studies
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li><a href="project.html">Case studies</a></li>
                                                            <li><a href="project-details.html">Case studies Details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="pricing.html">Pricing Plan</a></li>
                                                    <li><a href="faq.html">Our Faq</a></li>
                                                    <li><a href="sign-in.html">sign in</a></li>
                                                    <li><a href="register.html">Register</a></li>
                                                    <li><a href="404.html">404 Page</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="news-details.html">
                                                    Blog
                                                </a>
                                                <ul class="submenu">
                                                    <li><a href="news-grid.html">Blog Grid</a></li>
                                                    <li><a href="news.html">Blog Standard</a></li>
                                                    <li><a href="news-details.html">Blog Details</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="contact.html">Contact Us</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="header-right d-flex justify-content-end align-items-center">
                                <div class="header-button">
                                    <a href="sign-in.html" class="gt-theme-btn gt-theme-btn style-3 bg-border">sign in</a>
                                    <a href="contact.html" class="gt-theme-btn gt-theme-btn style-3 bg-theme">get A demo</a>
                                </div>
                                <div class="header__hamburger d-xl-none my-auto">
                                    <div class="sidebar__toggle">
                                        <div class="header-bar">
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </header> --}}

<header id="header-sticky" class="header-3">
    <div class="container">
        <div class="mega-menu-wrapper">
            <div class="header-main">
                <div class="logo">
                    <a href="{{ route('home') }}" class="header-logo">
                        <img src="{{ asset('assets/img/logo/theme-logo-2.svg') }}" alt="logo-img">
                    </a>
                </div>
                <div class="mean__menu-wrapper">
                    <div class="main-menu">
                        <nav id="mobile-menu">
                            <ul>
                                <li class="has-dropdown {{ request()->routeIs('home') ? 'active' : '' }} menu-thumb">
                                    <a href="{{ route('home') }}">
                                        Home 
                                    </a>
                                    <ul class="submenu has-homemenu">
                                        <li>
                                            <div class="homemenu-items">
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb">
                                                        <img src="{{ asset('assets/img/header/home-1.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="{{ route('home') }}" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                             CRM SupremeIT
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-2.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                            App landing
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-3.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                           AI Content Writer
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-4.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                            Payment gateway
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="homemenu">
                                                    <div class="homemenu-thumb mb-15">
                                                        <img src="{{ asset('assets/img/header/home-5.jpg') }}" alt="img">
                                                        <div class="demo-button">
                                                            <a href="#" class="theme-btn">
                                                                Demo Page
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="homemenu-content text-center">
                                                        <h4 class="homemenu-title">
                                                          SEO Agency
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-dropdown {{ request()->routeIs('home') ? 'active' : '' }} d-xl-none">
                                    <a href="{{ route('home') }}" class="border-none">
                                    Home
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('home') }}">CRM SupremeIT</a></li>
                                        <li><a href="#">App landing </a></li>
                                        <li><a href="#">AI Content Writer</a></li>
                                        <li><a href="#">Payment gateway</a></li>
                                        <li><a href="#">SEO Agency</a></li>
                                    </ul>
                                </li>
                               <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">about us</a>
                                </li>
                                <li>
                                    <a href="{{ route('services') }}">
                                        services
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="#">Our service</a></li>
                                        <li><a href="#">service Details</a></li>
                                    </ul>
                                </li>
                                <li class="has-dropdown">
                                    <a href="#">
                                        Pages
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown">
                                            <a href="#">
                                                Our Team
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="#">Our Team</a></li>
                                                <li><a href="#">Team Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="#">
                                               Case studies
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="#">Case studies</a></li>
                                                <li><a href="#">Case studies Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Pricing Plan</a></li>
                                        <li><a href="#">Our Faq</a></li>
                                        <li><a href="#">sign in</a></li>
                                        <li><a href="#">Register</a></li>
                                        <li><a href="#">404 Page</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('blog') }}">
                                        Blog
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="#">Blog Grid</a></li>
                                        <li><a href="#">Blog Standard</a></li>
                                        <li><a href="#">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="header-right d-flex justify-content-end align-items-center">
                    <div class="header-button">
                        <a href="#" class="gt-theme-btn gt-theme-btn style-3 bg-border">sign in</a>
                        <a href="{{ route('contact') }}" class="gt-theme-btn gt-theme-btn style-3 bg-theme">get A demo</a>
                    </div>
                    <div class="header__hamburger d-xl-none my-auto">
                        <div class="sidebar__toggle">
                            <div class="header-bar">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>