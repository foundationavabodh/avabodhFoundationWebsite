@props(['variant' => 'home'])

@php
    $settings = \App\Models\WebsiteSetting::current();
@endphp

{{-- Every page in the live template -- the index-3 homepage and every inner page
     (about.html, project.html, etc.) -- uses the same "-2" top-bar design
     (header-top-section-2 / list-icon). Inner pages just add the header-inner
     class for a flatter look (no diagonal shape divider). Both variants share
     this one component, driven by the site's Website Settings. --}}
@if (in_array($variant, ['home', 'inner']) && $settings->show_header_top_bar)
        <!-- Header-Top Start (matches this theme's "-2" top-bar design, which is
             what index-3.html -- and every inner page such as about.html/project.html --
             actually use; the "inner" variant just adds the header-inner class those inner
             pages add for a slightly flatter treatment, no shape divider) -->
        <div class="header-top-section-2{{ $variant === 'inner' ? ' header-inner' : '' }}">
            <div class="container-fluid">
                <div class="header-top-wrapper-2">
                    <div class="header-left">
                        <ul class="list-icon">
                            <li>
                                <i class="fa-regular fa-location-dot"></i>
                                {{ $settings->header_address ?: 'Network City, USA' }}
                            </li>
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <a href="mailto:{{ $settings->header_email ?: 'info@donat.com' }}">{{ $settings->header_email ?: 'info@donat.com' }}</a>
                            </li>
                            <li>
                                <i class="fa-solid fa-phone-volume"></i>
                                <a href="tel:{{ preg_replace('/[^\d+]/', '', $settings->header_phone ?: '+16336547896') }}">{{ $settings->header_phone ?: '+163 3654 7896' }}</a>
                            </li>
                        </ul>
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
