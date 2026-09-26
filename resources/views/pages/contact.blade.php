@extends('layouts.app')

@section('content')

    {{-- layouts/app.blade.php only defines $websiteSettings for its own top-level
         markup; a child page's @section('content') doesn't inherit it, so it's
         fetched again here -- same pattern used on the NGO network page. --}}
    @php
        $websiteSettings = \App\Models\WebsiteSetting::current();
    @endphp

    {{-- Hero / Breadcrumb Section (converted from public/contact.html, following
         the same breadcrumb-wrapper pattern already used on About/Internships/NGO). --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Contact Us</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Contact Section: same contact-us-wrapper-2 layout as the vendor page,
         with the info boxes pulling from the site's real Website Settings
         (the same header_phone/header_email/header_address fields the top
         contact bar and footer's Contact Office column already use) instead of
         the vendor's placeholder US phone numbers and example@email.com. --}}
    <div class="contact-us-section-2 section-padding fix">
        <div class="container">
            <div class="contact-us-wrapper-2">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="contact-us-box">
                            <div class="icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="contact-us-content">
                                <span>Phone No</span>
                                <h5>
                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $websiteSettings->header_phone ?: '+16336547896') }}">{{ $websiteSettings->header_phone ?: '+163 3654 7896' }}</a>
                                </h5>
                            </div>
                        </div>
                        <div class="contact-us-box">
                            <div class="icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="contact-us-content">
                                <span>Location</span>
                                <h5>
                                    Plot No. 81, Mahakali Nagar, Besa, Nagpur, Maharashtra, 440034
                                </h5>
                            </div>
                        </div>
                        <div class="contact-us-box mb-0">
                            <div class="icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="contact-us-content">
                                <span>Email Address</span>
                                <h5>
                                    <a href="mailto:{{ $websiteSettings->header_email ?: 'info@donat.com' }}">{{ $websiteSettings->header_email ?: 'info@donat.com' }}</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="from-fill-up-box">
                            <h4>
                                Send Us A Message
                            </h4>
                            {{-- Static for now, same as the footer's newsletter form
                                 (action="#") -- no backend wiring requested yet. Ask
                                 if you'd like this to actually email/save submissions. --}}
                            <form action="#" id="contact-form" method="POST">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="text" name="name" id="contact-name" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="email" name="email" id="contact-email" placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="text" name="number" id="contact-number" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="message" id="contact-message" placeholder="Type your message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="theme-btn">
                                            Send Message <i class="fa-solid fa-arrow-right-long"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Google Map: embeds the office address shown above using Google's
         free "output=embed" search embed -- no API key/billing required.
         Styled to match the theme (rounded card, shadow, overlay info
         card with a "Get Directions" link) instead of a bare iframe. --}}
    @php
        $officeAddress = 'Plot No. 81, Mahakali Nagar, Besa, Nagpur, Maharashtra, 440034';
    @endphp
    <div class="contact-map-section section-padding pt-0 fix">
        <div class="container">
            <div class="section-title text-center">
                <span class="sub-title wow fadeInUp">Visit Us</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s"><span>F</span>ind Our Office</h2>
            </div>
            <div class="contact-map-wrapper wow fadeInUp" data-wow-delay=".2s">
                <iframe
                    class="contact-map-iframe"
                    src="https://www.google.com/maps?q={{ urlencode($officeAddress) }}&output=embed"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Avabodh Foundation office location">
                </iframe>
                <div class="contact-map-card">
                    <div class="contact-map-card-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="contact-map-card-content">
                        <h6>Avabodh Foundation</h6>
                        <p>{{ $officeAddress }}</p>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($officeAddress) }}"
                           target="_blank" rel="noopener" class="contact-map-card-link">
                            Get Directions <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .contact-map-wrapper {
                position: relative;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: var(--box-shadow);
                border: 1px solid var(--border);
            }
            .contact-map-iframe {
                width: 100%;
                height: 480px;
                border: 0;
                display: block;
            }
            .contact-map-card {
                position: absolute;
                top: 28px;
                left: 28px;
                max-width: 300px;
                background-color: var(--white);
                border-radius: 16px;
                box-shadow: var(--box-shadow);
                padding: 24px;
                display: flex;
                flex-direction: column;
                gap: 14px;
            }
            .contact-map-card-icon {
                width: 64px;
                height: 64px;
                min-width: 64px;
                border-radius: 6px;
                background-color: var(--theme-2);
                color: var(--white);
                font-size: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .contact-map-card-content h6 {
                color: var(--heading);
                margin-bottom: 8px;
            }
            .contact-map-card-content p {
                color: var(--text);
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 16px;
            }
            .contact-map-card-link {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: var(--theme);
                font-weight: 600;
                font-size: 14px;
                transition: all 0.3s ease-in-out;
            }
            .contact-map-card-link:hover {
                color: var(--theme-2);
                gap: 12px;
            }
            @media (max-width: 767px) {
                .contact-map-wrapper {
                    display: flex;
                    flex-direction: column-reverse;
                }
                .contact-map-card {
                    position: static;
                    max-width: initial;
                    box-shadow: none;
                    border-bottom: 1px solid var(--border);
                    border-radius: 0;
                }
                .contact-map-iframe {
                    height: 350px;
                }
            }
        </style>
    @endpush

@endsection
