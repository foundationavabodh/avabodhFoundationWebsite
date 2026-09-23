        @php
            $settings = \App\Models\WebsiteSetting::current();
            $logoUrl = $settings->logo
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings->logo)
                : asset('assets/img/logo/black-logo.svg');
            $logoAlt = $settings->site_name ?: 'logo-img';

            // Database-driven main navigation (see Filament's Navigation manager at
            // /admin/navigation and App\Models\MenuItem::tree()). Only active top-level
            // items are included, each with its active submenu items (one level) eager
            // loaded; the same tree drives both the desktop dropdown menu below and the
            // mobile offcanvas menu, since meanmenu.js builds the mobile menu straight
            // from this same <nav id="mobile-menu"> markup at runtime.
            $menuTree = \App\Models\MenuItem::tree();

            // A menu item is highlighted as the current page only when it's a named
            // route we can reliably match against the current request (path/external
            // links -- mostly legacy placeholders migrated as-is -- are left unmarked
            // rather than guessed at).
            $isMenuItemActive = function (\App\Models\MenuItem $item): bool {
                return $item->link_type === \App\Enums\MenuLinkType::Route
                    && $item->route_name
                    && request()->routeIs($item->route_name);
            };
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
                                <i class="fas fa-xmark"></i>
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
                                        <i class="fas fa-location-dot"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a target="_blank" href="#">Main Street, Melbourne, Australia</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon mr-15">
                                        <i class="far fa-envelope"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a href="mailto:info@example.com"><span class="mailto:info@example.com">info@example.com</span></a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon mr-15">
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <div class="offcanvas__contact-text">
                                        <a target="_blank" href="#">Mod-friday, 09am -05pm</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="offcanvas__contact-icon mr-15">
                                        <i class="fas fa-phone"></i>
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
        <header id="header-sticky" class="header-1 header-two-tone">
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
                                            @foreach ($menuTree as $item)
                                                <li class="{{ $item->children->isNotEmpty() ? 'has-dropdown' : '' }}{{ $isMenuItemActive($item) ? ' active' : '' }}">
                                                    <a href="{{ $item->resolved_url }}"@if ($item->open_in_new_tab) target="_blank" rel="noopener"@endif>
                                                        {{ $item->label }}
                                                    </a>
                                                    @if ($item->children->isNotEmpty())
                                                        <ul class="submenu">
                                                            @foreach ($item->children as $child)
                                                                <li>
                                                                    <a href="{{ $child->resolved_url }}"@if ($child->open_in_new_tab) target="_blank" rel="noopener"@endif>{{ $child->label }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                          <div class="header-right d-flex justify-content-end align-items-center">
                            <a href="#" class="main-header__search search-toggler">
                                <i class="fa-solid fa-magnifying-glass"></i>
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
                        <span><i class="fa-solid fa-magnifying-glass"></i></span>
                    </button>
                </form>
            </div>
        </div>
