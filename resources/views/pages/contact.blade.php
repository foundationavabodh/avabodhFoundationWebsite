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
                                    {{-- str_replace('@', '@<wbr>', ...) lets long emails wrap right
                                         after the @ instead of breaking mid-word wherever they run out
                                         of space (which is what overflow-wrap: break-word alone does). --}}
                                    <a href="mailto:{{ $websiteSettings->header_email ?: 'info@donat.com' }}">{!! str_replace('@', '@<wbr>', e($websiteSettings->header_email ?: 'info@donat.com')) !!}</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="from-fill-up-box">
                            <h4>
                                Send Us A Message
                            </h4>

                            {{-- Submits to ContactController@store (see routes/web.php), which
                                 validates via StoreContactMessageRequest and emails a copy to
                                 the foundation's inbox (ContactFormSubmitted notification). --}}
                            @if (session('contactMessageSent'))
                                <div class="alert alert-success contact-form-alert" role="alert">
                                    <strong>Message sent!</strong> Thanks for reaching out -- we've received your message and will get back to you soon.
                                </div>
                            @endif

                            @if (session('contactError'))
                                <div class="alert alert-danger contact-form-alert" role="alert">
                                    {{ session('contactError') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger contact-form-alert" role="alert">
                                    <strong>Please fix the following:</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('contact.submit') }}" method="POST" id="contact-form">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="text" name="name" id="contact-name" placeholder="Your Name *"
                                                   value="{{ old('name') }}" required maxlength="255" autocomplete="name"
                                                   class="@error('name') is-invalid @enderror">
                                            @error('name')
                                                <div class="contact-form-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="email" name="email" id="contact-email" placeholder="Enter Your Email *"
                                                   value="{{ old('email') }}" required maxlength="255" autocomplete="email"
                                                   class="@error('email') is-invalid @enderror">
                                            @error('email')
                                                <div class="contact-form-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <input type="tel" name="number" id="contact-number" placeholder="Phone Number *"
                                                   value="{{ old('number') }}" required inputmode="numeric" autocomplete="tel"
                                                   minlength="10" maxlength="10" pattern="[0-9]{10}" title="Enter a valid 10-digit phone number"
                                                   class="@error('number') is-invalid @enderror">
                                            @error('number')
                                                <div class="contact-form-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="message" id="contact-message" placeholder="Type your message *"
                                                      required minlength="10" maxlength="5000"
                                                      class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="contact-form-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="theme-btn" id="contact-submit-btn">
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
            {{-- The three info boxes (Phone/Location/Email) share one .icon size (64x64)
                 from the vendor's own CSS, but the boxes themselves were different
                 heights because the Location address wraps onto two lines while
                 Phone/Email are one line -- giving them a shared min-height keeps all
                 three the same size regardless of how long the text inside is. --}}
            .contact-us-wrapper-2 .contact-us-box {
                min-height: 136px;
            }
            /* .contact-us-box is a flex row (icon + text), and flex items shrink
               by default. The long unbreakable email address ("...@Gmail.Com" has
               no spaces to wrap at) was squeezing the icon square down to make room
               for the text, so Phone/Location/Email ended up with different icon
               widths even though they all use the same 64x64 .icon rule. Locking
               flex-shrink/grow keeps the icon fixed at 64x64 no matter how long the
               text next to it is; the text wraps/truncates on its own instead. */
            .contact-us-wrapper-2 .contact-us-box .icon {
                flex-shrink: 0;
                flex-grow: 0;
            }
            .contact-us-wrapper-2 .contact-us-box .contact-us-content {
                min-width: 0;
                overflow-wrap: break-word;
                word-break: break-word;
            }
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

            /* "Send Us A Message" form validation styling. */
            .contact-form-alert {
                margin-bottom: 24px;
                border-radius: 10px;
            }
            .from-fill-up-box .form-clt input.is-invalid,
            .from-fill-up-box .form-clt textarea.is-invalid {
                border-color: #dc3545 !important;
            }
            .contact-form-error {
                color: #dc3545;
                font-size: 13px;
                margin-top: 6px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Prevents a double-submit (and a duplicate email) if someone double-clicks
            // "Send Message" or the request is slow -- native HTML5 required/type=email/
            // pattern/minlength validation on the fields themselves is what enforces the
            // actual validation rules client-side; StoreContactMessageRequest enforces
            // the same rules server-side regardless.
            (function () {
                var form = document.getElementById('contact-form');
                var submitBtn = document.getElementById('contact-submit-btn');

                if (form && submitBtn) {
                    form.addEventListener('submit', function () {
                        if (form.checkValidity()) {
                            submitBtn.setAttribute('disabled', 'disabled');
                            submitBtn.innerHTML = 'Sending...';
                        }
                    });
                }
            })();
        </script>
    @endpush

@endsection
