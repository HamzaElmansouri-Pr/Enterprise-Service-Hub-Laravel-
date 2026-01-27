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
                                    <img src="{{ asset('assets/img/logo/theme-logo-2.svg') }}" alt="logo-img">
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

        {{-- <!-- Header Section Start -->
          <div class="header-top-3">
            <div class="container">
                <p>
                    All with One CRM Platform <a href="contact.html">download app</a>
                </p>
            </div>
         </div> --}}

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
                                 
                                </li>
                                <li class="has-dropdown {{ request()->routeIs('home') ? 'active' : '' }} d-xl-none">
                                    <a href="{{ route('home') }}" class="border-none">
                                    Home
                                    </a>
                                   
                                </li>
                               <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">about us</a>
                                </li>
                                <li>
                                    <a href="{{ route('services') }}">
                                        services
                                    </a>
                                   
                                </li>
                                <li class="has-dropdown">
                                    <a href="{{ route('projects') }}">
                                        Projects
                                    </a>
                                   
                                        </li>
                                        
                                      
                                </li>
                                <li>
                                    <a href="{{ route('blog') }}">
                                        Blog
                                    </a>
                                   
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