<!DOCTYPE html>
<html lang="en">
<head>
       <!-- ========== Meta Tags ========== -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Pixel-plus">
        <meta name="description" content="Kindi - Non Profit Charity HTML Template">
        <!-- ======== Page title ============ -->
        <title>Kindi - Non Profit Charity HTML Template</title>
        <!--<< Favcion >>-->
        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.svg') }}">
        <!--<< Bootstrap min.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!--<< All Min Css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
        <!--<< Animate.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <!--<< Magnific Popup.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <!--<< MeanMenu.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
        <!--<< Swiper Bundle.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <!--<< Nice Select.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
        <!--<< Main.css >>-->
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>

        <!-- Preloader Start -->
        <div id="preloader" class="preloader">
            <div class="animation-preloader">
                <div class="spinner">                
                </div>
                <div class="txt-loading">
                    <span data-text-preloader="K" class="letters-loading">
                        K
                    </span>
                     <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
                     <span data-text-preloader="N" class="letters-loading">
                        N
                    </span>
                    <span data-text-preloader="D" class="letters-loading">
                        D
                    </span>
                    <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
                </div>
                <p class="text-center">Loading</p>
            </div>
            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>  

        <!-- Back To Top Start -->
        <button id="back-top" class="back-to-top show">
            <i class="fa-regular fa-arrow-up"></i>
        </button>

        <!-- MouseCursor Start -->
        <div class="mouseCursor cursor-outer"></div>
        <div class="mouseCursor cursor-inner"></div>

        <x-header/>

        <x-navbar/>

        @yield('content')

         <!-- Footer Section Start -->
         <footer class="footer-section header-bg fix">
            <div class="container">
                <div class="footer-widget-wrapper">
                    <div class="row g-4 justify-content-between">
                        <div class="col-xl-2 col-md-6 col-lg-2 wow fadeInUp" data-wow-delay=".2s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Quick Links</h3>
                                </div>
                                <ul class="list-area">
                                    <li>
                                        <a href="about.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            About US
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                           Contact
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Gallery
                                        </a>
                                    </li>
                                    <li>
                                        <a href="faq.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            FAQ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news-details.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Blog
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 ps-lg-5 wow fadeInUp" data-wow-delay=".4s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Explore Now</h3>
                                </div>
                                <ul class="list-area">
                                    <li>
                                        <a href="volounteer-details.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Volunteers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="project-details.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                           Project
                                        </a>
                                    </li>
                                    <li>
                                        <a href="event-details.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Event
                                        </a>
                                    </li>
                                    <li>
                                        <a href="project-details.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Causes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                         <div class="col-xl-2 col-md-6 col-lg-2 wow fadeInUp" data-wow-delay=".6s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Supports</h3>
                                </div>
                                <ul class="list-area">
                                    <li>
                                        <a href="donation-details.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Domination
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                           Forums
                                        </a>
                                    </li>
                                    <li>
                                        <a href="faq.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Faq
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Support Policy
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-5 col-md-6 col-lg-5 ps-lg-5 wow fadeInUp" data-wow-delay=".8s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Newsletter</h3>
                                </div>
                                <div class="footer-newsletter">
                                    <p>
                                        Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society.
                                    </p>
                                    <form action="#">
                                        <div class="form-clt">
                                            <input type="text" name="email" id="email" placeholder="Enter Your Email">
                                            <button type="submit" class="theme-btn">
                                               Subscribe Now
                                            </button>
                                        </div>
                                    </form>
                                    <div class="social-icon">
                                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="footer-wrapper">
                        <p>Copyright & Design By <span>@Kindi</span></p>
                        <ul class="footer-bottom-list">
                            <li>
                                <a href="faq.html">Faq</a>
                            </li>
                            <li>
                                <a href="contact.html">Careers</a>
                            </li>
                            <li>
                                <a href="contact.html">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
         </footer>

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
        <!--<< Magnific Popup Js >>-->
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <!--<< Wow Animation Js >>-->
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <!--<< Main.js >>-->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        @stack('scripts')
</body>
</html>
