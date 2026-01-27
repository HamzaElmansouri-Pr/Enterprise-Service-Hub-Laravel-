     <!-- Gt Footer Section Start -->
        <section class="gt-footer-section-3 footer-3">
            <div class="footer-dot">
                <img src="{{ asset('assets/img/new-add/footer-dot.png') }}" alt="img">
            </div>
            <div class="gt-cta-section-3">
                <div class="container">
                    <div class="gt-cta-wrapper-3 bg-cover" style="background-image: url('{{ asset('assets/img/home-3/cta-bg.jpg') }}');">
                        <div class="gt-section-title style-3 mb-0">
                            <h6 class="wow fadeInUp tt-capitalize">connect with us</h6>
                            <h2 class="char-animation">
                                Ready to Get Started?
                            </h2>
                        </div>
                        <p class="wow fadeInUp" data-wow-delay=".3s">Contact us today for a free consultation.</p>
                        <div class="gt-cta-btn wow fadeInUp" data-wow-delay=".5s">
                            <a href="{{ route('services') }}" class="gt-theme-btn style-3 bg-header">our services</a>
                            <a href="{{ route('contact') }}" class="gt-theme-btn style-3">contact us now</a>
                        </div>
                        <ul class="wow fadeInUp" data-wow-delay=".7s">
                            <li>
                                <i class="fa-regular fa-circle-check"></i>
                                Professional Support
                            </li>
                            <li>
                                <i class="fa-regular fa-circle-check"></i>
                                Expert Team
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="gt-footer-widget-wrapper style-2 style-3">
                    <div class="row justify-content-between">
                        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-8 col-sm-12 wow fadeInUp" data-wow-delay=".2s">
                            <div class="gt-footer-widget-items">
                                <div class="gt-widget-head">
                                    <h3>about SupremeIT</h3>
                                </div>
                                <div class="gt-footer-content">
                                    <p>
                                        We provide best IT solutions for your business. Our team of experts is dedicated to delivering high-quality services to help you achieve your goals.
                                    </p>
                                    <div class="gt-social-icon d-flex align-items-center">
                                        <a href="#">
                                            <img src="{{ asset('assets/img/home-3/play-store.png') }}" alt="img">
                                        </a>
                                        <a href="#">
                                            <img src="{{ asset('assets/img/home-3/app-store.png') }}" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".4s">
                            <div class="gt-footer-widget-items">
                                <div class="gt-widget-head">
                                    <h3>our Company</h3>
                                </div>
                               <ul class="gt-list-area">
                                    <li>
                                        <a href="{{ route('about') }}">
                                            About
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                            Careers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blog') }}">
                                            News & Blog
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                        Contact Us
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('services') }}">
                                            Services
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".6s">
                            <div class="gt-footer-widget-items">
                                <div class="gt-widget-head">
                                    <h3>Quick Links</h3>
                                </div>
                                <ul class="gt-list-area">
                                    <li>
                                        <a href="{{ route('projects') }}">
                                           Projects
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('services') }}">
                                           Services
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('about') }}">
                                           Why SupremeIT
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                      Contact Support
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                          Get a Quote
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                         <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-8 ps-xxl-5 wow fadeInUp" data-wow-delay=".8s">
                            <div class="gt-footer-widget-items">
                                <div class="gt-widget-head">
                                    <h3>Legal & Help</h3>
                                </div>
                                 <ul class="gt-list-area">
                                    <li>
                                        <a href="#">
                                            Privacy Policy
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                           Terms of Service
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                           Help Center
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                      FAQ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">
                                         Support
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gt-footer-bottom-3">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ asset('assets/img/logo/black-logo-3.svg') }}" alt="img">
                    </a>
                    <p>&copy; {{ date('Y') }} SupremeIT. All Rights Reserved.</p>
                    <div class="gt-social-icon d-flex align-items-center style-home-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-vimeo-v"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
            </div>
        </section>
            </div>
        </div>

       

       <!--<< All JS Plugins >>-->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <!--<< Viewport Js >>-->
        <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
        <!--<< Bootstrap Js >>-->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!--<< nice-selec Js >>-->
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <!--<< Waypoints Js >>-->
        <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
        <!--<< Counterup Js >>-->
        <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
        <!--<< Swiper Slider Js >>-->
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <!--<< MeanMenu Js >>-->
        <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
        <!--<< Parallaxie Js >>-->
        <script src="{{ asset('assets/js/parallaxie.js') }}"></script>
        <!--<< Magnific Popup Js >>-->
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <!--<< Wow Animation Js >>-->
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <!--<< Main.js >>-->
        <script src="{{ asset('assets/js/main.js') }}"></script>