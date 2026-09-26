<!DOCTYPE html>
<html lang="en">
<head>
       @php
           // Fetched once per request (see App\Models\WebsiteSetting::current()'s own
           // in-request memoization) and reused wherever this layout needs branding --
           // the header/navbar components each also call current() independently below,
           // at no extra query/cache cost.
           $websiteSettings = \App\Models\WebsiteSetting::current();
       @endphp
       <!-- ========== Meta Tags ========== -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Avabodh Foundation">
        <meta name="description" content="Avbodh Foundation">
        {{-- Used by the internship application form's email-verification AJAX calls
             (resources/views/pages/internships/index.blade.php) to send Laravel's
             CSRF token with fetch() requests. --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- ======== Page title ============ -->
        <title>{{ $websiteSettings->site_name ?: 'Avbodh Foundation' }}</title>
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
        @stack('styles')
</head>
<body>

        <!-- Preloader Start -->
        <div id="preloader" class="preloader">
            <div class="animation-preloader">
                <div class="spinner">
                </div>
                <div class="txt-loading">
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                     <span data-text-preloader="V" class="letters-loading">
                        V
                    </span>
                     <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                    <span data-text-preloader="B" class="letters-loading">
                        B
                    </span>
                    <span data-text-preloader="O" class="letters-loading">
                        O
                    </span>
                    <span data-text-preloader="D" class="letters-loading">
                        D
                    </span>
                    <span data-text-preloader="H" class="letters-loading">
                        H
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
            <i class="fa-solid fa-arrow-up"></i>
        </button>

        <!-- MouseCursor Start -->
        <div class="mouseCursor cursor-outer"></div>
        <div class="mouseCursor cursor-inner"></div>

        <x-header :variant="$headerVariant ?? 'home'"/>

        <x-navbar/>

        @yield('content')

         <!-- Footer Section Start -->
         <footer class="footer-section header-bg fix">
            <div class="container">
                <div class="footer-widget-wrapper">
                    @php
                        $footerLogoUrl = $websiteSettings->logo
                            ? \Illuminate\Support\Facades\Storage::disk('public')->url($websiteSettings->logo)
                            : asset('assets/img/logo/black-logo.svg');
                    @endphp
                    <div class="row g-4 justify-content-between">
                        {{-- Newsletter widget moved to the first position and given the
                             logo + mission statement above its existing subscribe form,
                             so this column now doubles as the footer's brand/about block. --}}
                        <div class="col-xl-3 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".2s">
                            <div class="single-footer-widget">
                                <div class="footer-logo mb-3">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ $footerLogoUrl }}" alt="{{ $websiteSettings->site_name ?: 'Avbodh Foundation' }}" style="max-height: 48px;">
                                    </a>
                                </div>
                                <p class="mb-4" style="color: #ffffff; text-align: justify;">
                                    Avabodh Foundation is a youth-driven, non-profit organization
                                    dedicated to paving 'Steps Towards A Better World'. We connect
                                    resources, students, and corporates for sustainable community
                                    impact.
                                </p>
                                <div class="footer-newsletter">
                                    {{-- Each icon only renders once a real link is set for it,
                                         instead of falling back to a dead "#" link. --}}
                                    <div class="social-icon">
                                        @if ($websiteSettings->social_twitter_url)
                                            <a href="{{ $websiteSettings->social_twitter_url }}"><i class="fa-brands fa-twitter"></i></a>
                                        @endif
                                        @if ($websiteSettings->social_whatsapp_url)
                                            <a href="{{ $websiteSettings->social_whatsapp_url }}"><i class="fa-brands fa-whatsapp"></i></a>
                                        @endif
                                        @if ($websiteSettings->social_instagram_url)
                                            <a href="{{ $websiteSettings->social_instagram_url }}"><i class="fa-brands fa-instagram"></i></a>
                                        @endif
                                        @if ($websiteSettings->social_youtube_url)
                                            <a href="{{ $websiteSettings->social_youtube_url }}"><i class="fa-brands fa-youtube"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".4s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Quick Links</h3>
                                </div>
                                <ul class="list-area">
                                    <li>
                                        <a href="about.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            About US
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                           Contact
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Gallery
                                        </a>
                                    </li>
                                    <li>
                                        <a href="faq.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            FAQ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news-details.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Blog
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".6s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Explore Now</h3>
                                </div>
                                <ul class="list-area">
                                    <li>
                                        <a href="volounteer-details.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Volunteers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="project-details.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                           Project
                                        </a>
                                    </li>
                                    <li>
                                        <a href="event-details.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Event
                                        </a>
                                    </li>
                                    <li>
                                        <a href="project-details.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Causes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                         <div class="col-xl-3 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".8s">
                            <div class="single-footer-widget">
                                <div class="wid-title">
                                    <h3>Supports</h3>
                                </div>
                                <ul class="list-area">
                                    <li>
                                        <a href="donation-details.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Domination
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                           Forums
                                        </a>
                                    </li>
                                    <li>
                                        <a href="faq.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Faq
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <i class="fa-solid fa-angles-right"></i>
                                            Support Policy
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="footer-wrapper">
                        <p>
                            @if ($websiteSettings->copyright_text)
                                {{ $websiteSettings->copyright_text }}
                            @else
                                Copyright © 2026 <span>Avbodh Foundation</span>. All rights reserved.
                            @endif
                        </p>
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

        {{-- Donate Now popup, triggered from the header button in the navbar
             component via data-bs-toggle="modal" data-bs-target="#donateModal".
             Content mirrors the live avabodhfoundation.org/donate page: the
             PhonePe/UPI QR code, the UPI ID, and the 80G tax-exemption note.

             The sticky header (main.css `.sticky`) uses z-index: 99999, higher
             than Bootstrap's default modal stack (1055/1050), so without this
             override the header renders on top of the modal. This is the only
             Bootstrap modal on the site, so bumping .modal/.modal-backdrop here
             is safe. --}}
        <style>
            #donateModal.modal { z-index: 100000; }
            .modal-backdrop { z-index: 99998; }
        </style>
        <div class="modal fade" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
                    <div class="modal-header" style="background-color: var(--theme); border: none;">
                        <h5 class="modal-title" id="donateModalLabel" style="color: var(--white); font-weight: 600;">
                            Support Avabodh Foundation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" style="padding: 30px;">
                        <p style="color: var(--text); margin-bottom: 20px;">
                            Avabodh Foundation is a youth-driven, non-profit organization dedicated to
                            paving 'Steps Towards A Better World'. Your contribution helps us connect
                            resources, students, and corporates for sustainable community impact.
                        </p>
                        <img src="{{ asset('assets/img/donate/phonepe-qr.png') }}" alt="Scan to donate via UPI"
                             style="width: 220px; height: 220px; margin: 0 auto 16px; display: block; border: 1px solid var(--border); border-radius: 8px; padding: 8px; background: var(--white);">
                        <p style="font-weight: 600; color: var(--heading); margin-bottom: 12px;">
                            Scan via any UPI app (GPay, PhonePe, Paytm)
                        </p>
                        <div style="background-color: var(--bg); border-radius: 8px; padding: 10px 16px; display: inline-flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                            <span id="donateUpiId" style="font-weight: 600; color: var(--text); text-transform: none;">9096617654boi@ybl</span>
                            <button type="button" class="theme-btn" style="padding: 4px 14px; font-size: 13px;"
                                    onclick="donateCopyUpiId(this)">
                                Copy
                            </button>
                        </div>
                        <p style="font-size: 14px; color: var(--theme-2); font-weight: 600; margin-bottom: 0;">
                            All donations exempt under Section 80G
                        </p>
                    </div>
                </div>
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
        <!--<< Magnific Popup Js >>-->
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <!--<< Wow Animation Js >>-->
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <!--<< Main.js >>-->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script>
            function donateCopyUpiId(btn) {
                var text = '9096617654boi@ybl';
                function done() {
                    btn.innerText = 'Copied';
                    setTimeout(function () { btn.innerText = 'Copy'; }, 1500);
                }
                function fallbackCopy() {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.left = '-9999px';
                    document.body.appendChild(ta);
                    ta.focus();
                    ta.select();
                    try { document.execCommand('copy'); } catch (e) { /* no-op */ }
                    document.body.removeChild(ta);
                }
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(done).catch(function () {
                        fallbackCopy();
                        done();
                    });
                } else {
                    fallbackCopy();
                    done();
                }
            }
        </script>

        @stack('scripts')
</body>
</html>
