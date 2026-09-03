@props(['variant' => 'home'])

@php
    $settings = \App\Models\WebsiteSetting::current();
@endphp

{{-- The Kindi template uses two different top-bar layouts: a "home"
     variant (icon + label items, used on index-2.html) and a visually
     different "inner" variant (plain icon list, used on about.html and
     the other inner pages). Only the home variant is migrated in
     Phase 1 -- the inner variant will be added here (not redesigned)
     when the inner pages are converted, so both share this one
     component. --}}
@if ($variant === 'home' && $settings->show_header_top_bar)
        <!-- Header-Top Start -->
        <div class="header-top-section">
            <div class="container-fluid">
                <div class="header-top-wrapper">
                    <div class="icon-items">
                        <div class="icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="content">
                            <span>Locate Address</span>
                            <h5>
                                {{ $settings->header_address ?: 'Network City, USA' }}
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
                                <a href="tel:{{ preg_replace('/[^\d+]/', '', $settings->header_phone ?: '+16336547896') }}">{{ $settings->header_phone ?: '+163 3654 7896' }}</a>
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
                                <a href="mailto:{{ $settings->header_email ?: 'info@donat.com' }}">{{ $settings->header_email ?: 'info@donat.com' }}</a>
                            </h4>
                        </div>
                    </div>
                    <div class="social-icon">
                        <a href="{{ $settings->social_twitter_url ?: '#' }}"><i class="fa-brands fa-twitter"></i></a>
                        <a href="{{ $settings->social_whatsapp_url ?: '#' }}"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="{{ $settings->social_instagram_url ?: '#' }}"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ $settings->social_youtube_url ?: '#' }}"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
@endif
