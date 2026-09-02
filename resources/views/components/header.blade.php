@props(['variant' => 'home'])

{{-- The Kindi template uses two different top-bar layouts: a "home"
     variant (icon + label items, used on index-2.html) and a visually
     different "inner" variant (plain icon list, used on about.html and
     the other inner pages). Only the home variant is migrated in
     Phase 1 -- the inner variant will be added here (not redesigned)
     when the inner pages are converted, so both share this one
     component. --}}
@if ($variant === 'home')
        <!-- Header-Top Start -->
        <div class="header-top-section">
            <div class="container-fluid">
                <div class="header-top-wrapper">
                    <div class="icon-items">
                        <div class="icon">
                            <i class="fa-regular fa-location-dot"></i>
                        </div>
                        <div class="content">
                            <span>Locate Address</span>
                            <h5>
                                Network City, USA
                            </h5>
                        </div>
                    </div>
                    <div class="icon-items">
                        <div class="icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="content">
                            <span>Call Us any time</span>
                            <h5>
                                <a href="tel:+16336547896">+163 3654 7896</a>
                            </h5>
                        </div>
                    </div>
                    <div class="icon-items">
                        <div class="icon">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="content">
                            <span>Email</span>
                            <h4>
                                <a href="mailto:info@donat.com">info@donat.com</a>
                            </h4>
                        </div>
                    </div>
                    <div class="social-icon">
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
@endif
