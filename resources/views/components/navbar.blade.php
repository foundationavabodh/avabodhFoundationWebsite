        @php
            $settings = \App\Models\WebsiteSetting::current();
            $logoUrl = $settings->logo
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings->logo)
                : asset('assets/img/logo/black-logo.svg');
            $logoAlt = $settings->site_name ?: 'logo-img';
        @endphp

        <!-- Offcanvas Area Start -->
        <div class="fix-area">
            <div class="offcanvas__info">
                <div class="offcanvas__wrapper">
                    <div class="offcanvas__content">
                        <div class="offcanvas__top mb-5 d-flex justify-content-between align-items-center">
                            <div class="offcanvas__logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
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
                        <div class="mobile-menu fix mb-3"></div>
                        <div class="offcanvas__contact d-xl-block">
                            <h4 class="d-xl-block">Contact Info</h4>
                            <ul class="d-xl-block">
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon">
                                        <i class="fal fa-map-marker-alt"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a target="_blank" href="#">Main Street, Melbourne, Australia</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon mr-15">
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a href="mailto:info@example.com"><span class="mailto:info@example.com">info@example.com</span></a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon mr-15">
                                        <i class="fal fa-clock"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a target="_blank" href="#">Mod-friday, 09am -05pm</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon mr-15">
                                        <i class="far fa-phone"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a href="tel:+11002345909">+11002345909</a>
                                    </div>
                                </li>
                            </ul>
                            <div class="social-icon d-flex align-items-center">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas__overlay"></div>
       
        <!-- Header Section Start -->
        <header id="header-sticky" class="header-1">
            <div class="container-fluid">
                <div class="mega-menu-wrapper">
                    <div class="header-main">
                        <div class="header-left">
                            <div class="logo">
                            <a href="{{ route('home') }}" class="header-logo">
                                <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
                            </a>
                        </div>
                        </div>
                        <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="active">
                                                <a href="{{ route('home') }}">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a href="about.html">About Us</a>
                                            </li>
                                            <li class="has-dropdown">
                                                <a href="news-details.html">
                                                    Pages
                                                </a>
                                                <ul class="submenu">
                                                    <li class="has-dropdown">
                                                        <a href="project-details.html">
                                                            Cause
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li><a href="project.html">Our Cause</a></li>
                                                            <li><a href="project-details.html">Cause Details</a></li>
                                                        </ul>
                                                    </li>
                                                     <li class="has-dropdown">
                                                        <a href="volounteer-details.html">
                                                            volounteer
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li><a href="become-volounteer.html">Become Volounteer</a></li>
                                                            <li><a href="volounteer.html">Volounteer</a></li>
                                                            <li><a href="volounteer-details.html">Volounteer Details</a></li>
                                                        </ul>
                                                    </li>
                                                     <li class="has-dropdown">
                                                        <a href="event-details.html">
                                                            Event
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li><a href="event.html"> Our Event</a></li>
                                                            <li><a href="event-list.html">Event List</a></li>
                                                            <li><a href="event-details.html">Event Details</a></li>
                                                        </ul>
                                                    </li>
                                                     <li class="has-dropdown">
                                                        <a href="donation-details.html">
                                                            Donation
                                                            <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li><a href="donation.html"> Our Donation</a></li>
                                                            <li><a href="donation-now.html">Donation Now</a></li>
                                                            <li><a href="donation-details.html">Donation Details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="pricing.html">Our Pricing</a></li>
                                                    <li><a href="faq.html">Our Faq</a></li>
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
                            <a href="#" class="main-header__search search-toggler">
                                <i class="fa-regular fa-magnifying-glass"></i>
                            </a>
                            <div class="header-button">
                                <a href="donation-details.html" class="theme-btn">
                                  Donte Now <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class="header__hamburger d-xl-none my-auto">
                                <div class="sidebar__toggle">
                                    <i class="fas fa-bars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Search Area Start -->
        <div class="search-popup">
            <div class="search-popup__overlay search-toggler"></div>
            <div class="search-popup__content">
                <form role="search" method="get" class="search-popup__form" action="#">
                    <input type="text" id="search" name="search" placeholder="Search Here...">
                    <button type="submit" aria-label="search submit" class="search-btn">
                        <span><i class="fa-regular fa-magnifying-glass"></i></span>
                    </button>
                </form>
            </div>
        </div>
