@extends('layouts.app')

@section('content')
        @push('styles')
            <style>
                /* Per-slide background + overlay for the homepage hero slider (added
                   alongside the Slider CMS feature). The section itself no longer
                   carries its own background-image -- each .swiper-slide does, so
                   multiple slides can each show a different photo. The existing
                   .hero-2::before gradient still renders but sits behind the swiper
                   (which paints as its own stacking context), so each slide carries
                   its own .hero-slide-overlay reproducing that same gradient on top
                   of its own photo and below its own text. */
                .hero-2 .swiper-slide {
                    position: relative;
                    overflow: hidden;
                    /* Without a floor, each slide's box is only as tall as its own text
                       (subtitle/description are optional per slide), so slide height
                       varies slide to slide. Swiper's fade transition doesn't smoothly
                       animate a height change, so switching between a short and a tall
                       slide produced a visible jump/overlap of both slides' photos
                       during the crossfade. A shared minimum height keeps every slide
                       the same size so there's nothing to jump between. */
                    min-height: 320px;
                }
                /* .hero-2 itself carries top/bottom padding (180px, down to 100px and
                   80px at narrower widths) which used to be fine because the photo was
                   the SECTION's own background-image, covering the full section box
                   including that padding. Now the photo lives on .hero-slide-bg inside
                   each slide instead, sized to the slide's own box -- so the section's
                   padding shows through as a plain grey band above/below the photo
                   instead of being covered by it. (A negative-margin trick to pull the
                   slide out over that padding was tried first, but .swiper has its own
                   overflow:hidden -- needed for the carousel mechanics -- which clips
                   anything a child paints outside its own measured box, so the photo
                   just got cut off instead.) Moving the padding from the section onto
                   the text content itself sidesteps that: the section has no padding
                   left to show through, the slide (and its full-bleed photo) naturally
                   fills the whole section, and the text still sits inset by the same
                   amount as before, just from its own box instead of the section's. */
                .hero-2 {
                    padding: 0 !important;
                }
                .hero-2 .swiper-slide .hero-content,
                .hero-2 .hero-content {
                    min-height: 320px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    padding: 180px 0;
                }
                @media (max-width: 1399px) {
                    .hero-2 .swiper-slide .hero-content,
                    .hero-2 .hero-content {
                        padding: 100px 0;
                    }
                }
                @media (max-width: 991px) {
                    .hero-2 .swiper-slide .hero-content,
                    .hero-2 .hero-content {
                        padding: 80px 0;
                    }
                }
                .hero-2 .hero-slide-bg {
                    position: absolute;
                    inset: 0;
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center center;
                }
                .hero-2 .hero-slide-overlay {
                    position: absolute;
                    inset: 0;
                    background: linear-gradient(90deg, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.51) 30.29%, rgba(0, 0, 0, 0.37) 39.42%, rgba(0, 0, 0, 0) 55.77%);
                }
                .hero-2 .swiper-slide > .container { position: relative; z-index: 1; }
                /* Swiper's own bundled CSS gives .swiper itself "position: relative;
                   z-index: 1" (needed for its internal layering). That gives the whole
                   slider its own elevated stacking context, which paints above any
                   sibling with the default z-index:auto -- including the decorative
                   corner shapes below -- REGARDLESS of which one is later in the DOM.
                   (Moving the shapes after the slide content in the markup, done
                   earlier for the single-slide/no-slide static hero which has no
                   .swiper wrapper, only controls stacking among equal z-index:auto
                   elements -- it doesn't help once a real .swiper is in the mix.)
                   Explicitly raising the shapes above the swiper's z-index:1 fixes
                   that regardless of DOM order or which hero variant is rendering. */
                .hero-2 .left-shape,
                .hero-2 .right-shape {
                    z-index: 2;
                }
                /* The bundled Swiper build's fade effect only recalculates opacity for
                   the slide it is actively transitioning into -- the slide being
                   transitioned AWAY from keeps whatever opacity it last had (1) and
                   never fades back out, so for several seconds both a "prev" slide and
                   the incoming slide render fully visible at once ("images overlapped").
                   Driving opacity purely from the swiper-slide-active class instead
                   (with !important, since Swiper sets opacity inline) sidesteps that
                   per-slide progress bug entirely and gives a clean two-slide crossfade. */
                .hero-2 .swiper-slide {
                    opacity: 0 !important;
                    transition: opacity 0.6s ease !important;
                }
                .hero-2 .swiper-slide-active {
                    opacity: 1 !important;
                }
            </style>
        @endpush

        <!-- Hero Section Start -->
         <section class="hero-section hero-2 fix">
            {{-- The decorative corner shapes are placed AFTER the slide content below
                 (not before) even though they read first visually -- they're
                 position:absolute with no z-index, same stacking level as the slide
                 background/overlay, so whichever comes later in the DOM paints on top.
                 Putting them last keeps them visible over the photo, matching the
                 original design, instead of being silently covered by it. --}}

            @if ($slides->count() > 1)
                {{-- Homepage Slider (managed in the admin panel under "Homepage Slider").
                     Autoplays via the .hero-slider Swiper already initialized in
                     public/assets/js/main.js -- no new JS needed. Each slide's text
                     plays its own chosen entrance effect via the existing
                     animated_swiper()/[data-animation] mechanism in that same file.
                     Requires 2+ slides: main.js configures this swiper with loop:true,
                     and Swiper's loop mode needs at least 2 real slides to loop cleanly
                     -- with only 1 it clones the single slide into broken duplicates and
                     collapses the height. A single slide is rendered statically below
                     instead, which looks identical but sidesteps that entirely. --}}
                <div class="swiper hero-slider" data-slide-count="{{ $slides->count() }}">
                    <div class="swiper-wrapper">
                        @foreach ($slides as $slide)
                            <div class="swiper-slide">
                                <div class="hero-slide-bg" style="background-image: url({{ $slide->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($slide->image) : asset('assets/img/home-2/hero/bg.jpg') }});"></div>
                                <div class="hero-slide-overlay"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xl-9">
                                            <div class="hero-content">
                                                @if ($slide->subtitle)
                                                    <h4 data-animation="{{ $slide->text_animation->value }}" data-delay=".1s">{{ $slide->subtitle }}</h4>
                                                @endif
                                                <h1 data-animation="{{ $slide->text_animation->value }}" data-delay=".3s">
                                                    {{ $slide->title }}
                                                </h1>
                                                @if ($slide->description)
                                                    <p data-animation="{{ $slide->text_animation->value }}" data-delay=".4s">
                                                        {{ $slide->description }}
                                                    </p>
                                                @endif
                                                <div class="hero-button-item" data-animation="{{ $slide->text_animation->value }}" data-delay=".5s">
                                                    @if ($slide->button_text)
                                                        <a href="{{ $slide->button_url ?: '#' }}" class="theme-btn border-btn">{{ $slide->button_text }} <i class="fa-solid fa-arrow-right-long"></i></a>
                                                    @endif
                                                    <span class="button-text">
                                                        <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn ripple video-popup">
                                                            <i class="fa-solid fa-play"></i></a>
                                                        <span class="ms-3">Video Playing Theme</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif ($slides->count() === 1)
                {{-- Exactly one active slide: render it statically (no swiper) using its
                     own content, for the reason noted above. --}}
                @php($slide = $slides->first())
                <div class="hero-slide-bg" style="background-image: url({{ $slide->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($slide->image) : asset('assets/img/home-2/hero/bg.jpg') }});"></div>
                <div class="hero-slide-overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="hero-content">
                                @if ($slide->subtitle)
                                    <h4 class="wow fadeInUp">{{ $slide->subtitle }}</h4>
                                @endif
                                <h1 class="wow fadeInUp" data-wow-delay=".3s">
                                    {{ $slide->title }}
                                </h1>
                                @if ($slide->description)
                                    <p class="wow fadeInUp" data-wow-delay=".4s">
                                        {{ $slide->description }}
                                    </p>
                                @endif
                                <div class="hero-button-item wow fadeInUp" data-wow-delay=".5s">
                                    @if ($slide->button_text)
                                        <a href="{{ $slide->button_url ?: '#' }}" class="theme-btn border-btn">{{ $slide->button_text }} <i class="fa-solid fa-arrow-right-long"></i></a>
                                    @endif
                                    <span class="button-text">
                                        <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn ripple video-popup">
                                            <i class="fa-solid fa-play"></i></a>
                                        <span class="ms-3">Video Playing Theme</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Fallback: no active slides configured (e.g. all deleted or
                     deactivated) -- render the original static hero exactly as it
                     looked before the slider existed, so the page never breaks. --}}
                <div class="hero-slide-bg" style="background-image: url({{ asset('assets/img/home-2/hero/bg.jpg') }});"></div>
                <div class="hero-slide-overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="hero-content">
                                <h4 class="wow fadeInUp">Non - Profit Charity</h4>
                                <h1 class="wow fadeInUp" data-wow-delay=".3s">
                                    Make Someone’s Life By Giving Of Yours's.
                                </h1>
                                <div class="hero-button-item wow fadeInUp" data-wow-delay=".5s">
                                    <a href="contact.html" class="theme-btn border-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                    <span class="button-text">
                                        <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn ripple video-popup">
                                            <i class="fa-solid fa-play"></i></a>
                                        <span class="ms-3">Video Playing Theme</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="left-shape">
                <img src="{{ asset('assets/img/home-2/hero/shape-2.png') }}" alt="img">
            </div>
            <div class="right-shape">
                <img src="{{ asset('assets/img/home-2/hero/shape-3.png') }}" alt="img">
            </div>
            <div class="left-shape-2">
                <img src="{{ asset('assets/img/home-2/hero/shape.png') }}" alt="img">
            </div>
         </section>

         <!-- About Section Start -->
         <section class="about-section section-padding fix">
            <div class="container">
                <div class="about-wrapper-2">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="about-left-item">
                                <div class="section-title style-2 mb-0">
                                    <span class="sub-title wow fadeInUp">About Us</span>
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        <span>B</span>uilding futures one step at a time celebrating the wonder <br> of childhood.
                                    </h2>
                                </div>
                                <p class="text wow fadeInUp" data-wow-delay=".5s">
                                    “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further. 
                                </p>
                                <div class="about-image wow img-custom-anim-left" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                    <img src="{{ asset('assets/img/home-2/about/01.jpg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="about-right-item">
                                <div class="about-image wow img-custom-anim-right" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                    <img src="{{ asset('assets/img/home-2/about/02.jpg') }}" alt="img">
                                </div>
                                <div class="about-icon-main-item">
                                    <div class="about-icon-item">
                                        <div class="icon-item wow fadeInUp" data-wow-delay=".3s">
                                            <div class="icon">
                                                <img src="{{ asset('assets/img/home-2/icon/01.svg') }}" alt="img">
                                            </div>
                                            <div class="content">
                                                <h5>Healthy Food</h5>
                                                <p>
                                                    Impeccable service, look no further. 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="icon-item wow fadeInUp" data-wow-delay=".5s">
                                            <div class="icon">
                                                <img src="{{ asset('assets/img/home-2/icon/01.svg') }}" alt="img">
                                            </div>
                                            <div class="content">
                                                <h5>Medial Help</h5>
                                                <p>
                                                    Impeccable service, look no further. 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="about-icon-item mb-0">
                                        <div class="icon-item wow fadeInUp" data-wow-delay=".3s">
                                            <div class="icon">
                                                <img src="{{ asset('assets/img/home-2/icon/03.svg') }}" alt="img">
                                            </div>
                                            <div class="content">
                                                <h5>Responsibilities</h5>
                                                <p>
                                                    Impeccable service, look no further. 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="icon-item wow fadeInUp" data-wow-delay=".5s">
                                            <div class="icon">
                                                <img src="{{ asset('assets/img/home-2/icon/04.svg') }}" alt="img">
                                            </div>
                                            <div class="content">
                                                <h5>Community</h5>
                                                <p>
                                                    Impeccable service, look no further. 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Service Section Start -->
         <section class="causes-section-2 fix section-bg-1 section-padding">
            <div class="left-shape">
                <img src="{{ asset('assets/img/home-2/service/shape.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="section-title style-2 text-center">
                    <span class="sub-title wow fadeInUp">Our Causes</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>E</span>xploring possibilities <br> leniting passions
                    </h2>
                </div>
            </div>
            <div class="container-fluid">
                <div class="arrow-button">
                    <button class="array-prev">
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </button>
                    <button class="array-next">
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                </div>
                <div class="swiper causes-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="causes-card-items-2">
                                <div class="causes-image">
                                    <img src="{{ asset('assets/img/home-2/service/01.png') }}" alt="img">
                                    <div class="causes-content">
                                        <h3>
                                            <a href="project-details.html">Medical Lab</a>
                                        </h3>
                                        <div class="content">
                                            <p>
                                                “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious.
                                            </p>
                                            <a href="project-details.html" class="link-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="causes-card-items-2">
                                <div class="causes-image">
                                    <img src="{{ asset('assets/img/home-2/service/02.png') }}" alt="img">
                                    <div class="causes-content">
                                        <h3>
                                            <a href="project-details.html">Education</a>
                                        </h3>
                                        <div class="content">
                                            <p>
                                                “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious.
                                            </p>
                                            <a href="project-details.html" class="link-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="causes-card-items-2">
                                <div class="causes-image">
                                    <img src="{{ asset('assets/img/home-2/service/03.png') }}" alt="img">
                                    <div class="causes-content">
                                        <h3>
                                            <a href="project-details.html">Homeless</a>
                                        </h3>
                                        <div class="content">
                                            <p>
                                                “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious.
                                            </p>
                                            <a href="project-details.html" class="link-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="causes-card-items-2">
                                <div class="causes-image">
                                    <img src="{{ asset('assets/img/home-2/service/04.png') }}" alt="img">
                                    <div class="causes-content">
                                        <h3>
                                            <a href="project-details.html">Food & Nutrition</a>
                                        </h3>
                                        <div class="content">
                                            <p>
                                                “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious.
                                            </p>
                                            <a href="project-details.html" class="link-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="causes-button">
                    <a href="project-details.html" class="theme-btn">Discover More <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>
         </section>

         <!-- counter Section-2 Start -->
         <section class="counter-section-2 section-padding pb-0 fix">
            <div class="right-shape">
                <img src="{{ asset('assets/img/home-2/counter/blur.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="section-title style-2 text-center mb-0">
                    <span class="sub-title wow fadeInUp">Help Organotin</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>W</span>here smiles are the building <br> blocks of learning
                    </h2>
                </div>
                <div class="row">
                    <div class="counter-main-wrapper">
                        <p class="wow fadeInUp" data-wow-delay=".3s">
                            Charity is a powerful act of kindness and compassion that aims to support those in need and improve the well-being of society. It involves giving time, money, resources, or services to help the less fortunate, promote education, provide healthcare, and respond to emergencies. Charitable efforts not only uplift individuals and communities but also foster a sense of unity, empathy, and social responsibility. Whether through small acts or large-scale initiatives, charity plays a crucial role in building a more just and compassionate world.
                        </p>
                        <div class="map-shape">
                            <img src="{{ asset('assets/img/home-2/counter/map.png') }}" alt="img">
                        </div>
                        <div class="counter-wrapper-2">
                            <div class="counter-image">
                                <img src="{{ asset('assets/img/home-2/counter/01.jpg') }}" alt="img">
                            </div>
                            <div class="counter-item">
                                 <div class="counter-content wow fadeInUp" data-wow-delay=".3s">
                                    <h2><span class="count">3,865,567</span></h2>
                                    <h5>Volunteers In 2025</h5>
                                 </div>
                                 <div class="counter-content style-2 wow fadeInUp" data-wow-delay=".5s">
                                    <h2><span class="count">120</span>k+</h2>
                                    <h5>Customer Satisfaction</h5>
                                 </div>
                                 <div class="counter-content style-2 wow fadeInUp" data-wow-delay=".7s">
                                    <h2><span class="count">25</span>+</h2>
                                    <h5>Funds We Collected</h5>
                                 </div>
                            </div>
                            <div class="counter-image">
                                <img src="{{ asset('assets/img/home-2/counter/02.jpg') }}" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Donation Section Start -->
         <section class="donation-section-2 section-padding fix">
            <div class="container">
                <div class="section-title style-2">
                    <span class="sub-title wow fadeInUp">Funds Collection</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>E</span>xplore Our Campaigns
                    </h2>
                </div>
                <div class="donation-wrapper-2">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="donation-card-item-2">
                                <div class="left-shape">
                                    <img src="{{ asset('assets/img/home-2/donation/shape-1.png') }}" alt="img">
                                </div>
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-2/donation/01.jpg') }}" alt="img">
                                    <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/01.jpg') }});"></div>
                                </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Help Children Poor Insurance & Medical</a>
                                    </h4>
                                    <div class="pro-items">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        Raised - $ 16,020.00
                                        </li>
                                        <li>
                                        <span>Goal - $60,000.00</span>
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn style-2">Donte Now  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                            <div class="donation-card-item-2">
                                <div class="left-shape">
                                    <img src="{{ asset('assets/img/home-2/donation/shape-2.png') }}" alt="img">
                                </div>
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-2/donation/02.jpg') }}" alt="img">
                                    <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/02.jpg') }});"></div>
                                </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Help us touch their lives of these youths</a>
                                    </h4>
                                    <div class="pro-items style-2">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        Raised - $ 16,020.00
                                        </li>
                                        <li>
                                        <span>Goal - $60,000.00</span>
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn">Donte Now  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                            <div class="donation-card-item-2">
                                <div class="left-shape">
                                    <img src="{{ asset('assets/img/home-2/donation/shape-3.png') }}" alt="img">
                                </div>
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-2/donation/03.jpg') }}" alt="img">
                                    <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/03.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/03.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/03.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/donation/03.jpg') }});"></div>
                                </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Raise found for clean & Healthy Water</a>
                                    </h4>
                                    <div class="pro-items style-3">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        Raised - $ 16,020.00
                                        </li>
                                        <li>
                                        <span>Goal - $60,000.00</span>
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn style-3">Donte Now  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Cta Section Start -->
         <section class="cta-section section-padding pb-0 fix bg-cover" style="background-image: url({{ asset('assets/img/home-2/cta/bg.png') }});">
            <div class="left-shape float-bob-y">
                <img src="{{ asset('assets/img/home-2/cta/hand.png') }}" alt="img">
            </div>
            <div class="love-shape float-bob-x">
                <img src="{{ asset('assets/img/home-2/cta/love.png') }}" alt="img">
            </div>
            <div class="top-shape float-bob-x">
                <img src="{{ asset('assets/img/home-2/cta/love-2.png') }}" alt="img">
            </div>
            <div class="right-shape float-bob-y">
                <img src="{{ asset('assets/img/home-2/cta/hand-2.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="cta-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="cta-content">
                                <div class="circle-image">
                                <img src="{{ asset('assets/img/home-2/cta/circle.png') }}" alt="img">
                                <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn video-popup">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                                <div class="section-title style-2 mb-0">
                                    <h2 class="text-white wow fadeInUp" data-wow-delay=".3s">
                                        <span>O</span>ur door are always open to more to more people who what to <br> support each other
                                    </h2>
                                </div>
                                <a href="contact.html" class="theme-btn wow fadeInUp" data-wow-delay=".3s">Get Involved <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Pricing Section Start -->
         <section class="pricing-section section-padding fix">
            <div class="container">
                <div class="section-title style-2">
                    <span class="sub-title wow fadeInUp">Pricing Plan</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>T</span>he terms and conditions <br> sect your plan
                    </h2>
                </div>
               <div class="pricing-wrapper">
                     <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="pricing-card-item-2 wow fadeInLeft" data-wow-delay=".3s">
                                <div class="content">
                                    <h3>Free this plan</h3>
                                    <p>
                                        Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference life.
                                    </p>
                                </div>
                                <h3 class="number">$00</h3>
                            </div>
                             <div class="pricing-card-item-2 wow fadeInLeft" data-wow-delay=".5s">
                                <div class="content">
                                    <h3>Standard this plan this plan</h3>
                                    <p>
                                        Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference life.
                                    </p>
                                </div>
                                <h3 class="number">$60</h3>
                            </div>
                             <div class="pricing-card-item-2 mb-0 wow fadeInLeft" data-wow-delay=".7s">
                                <div class="content">
                                    <h3>Premium this plan</h3>
                                    <p>
                                        Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference life.
                                    </p>
                                </div>
                                <h3 class="number">$90</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="pricing-right-card wow fadeInRight" data-wow-delay=".3s">
                                <ul class="pricing-list">
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        We are privileged to work.
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        24/7 system monitoring
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        Encourage team member
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                       remote best support
                                    </li>
                                </ul>
                                <div class="pricing-button">
                                    <a href="pricing.html" class="theme-btn">Choose Your Plan  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                            <div class="pricing-right-card wow fadeInRight" data-wow-delay=".5s">
                                <ul class="pricing-list">
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        We are privileged to work.
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        24/7 system monitoring
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        Encourage team member
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                       remote best support
                                    </li>
                                </ul>
                                <div class="pricing-button">
                                    <a href="pricing.html" class="theme-btn">Choose Your Plan  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                            <div class="pricing-right-card mb-0 wow fadeInRight" data-wow-delay=".7s">
                                <ul class="pricing-list">
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        We are privileged to work.
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        24/7 system monitoring
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                        Encourage team member
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-check-double"></i>
                                       remote best support
                                    </li>
                                </ul>
                                <div class="pricing-button">
                                    <a href="pricing.html" class="theme-btn">Choose Your Plan  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
         </section>

         <!-- Upcoming-Event Section Start -->
         <section class="upcoming-event-section section-padding section-bg-1 fix">
            <div class="container">
                <div class="section-title style-2 text-center">
                    <span class="sub-title wow fadeInUp">Upcoming Event</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>E</span>xciting events & upcoming <br> announcements.
                    </h2>
                </div>
                <div class="upcoming-event-wrapper">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="upcoming-event-image wow img-custom-anim-left" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                <img src="{{ asset('assets/img/home-2/event/01.jpg') }}" alt="img">
                            </div>
                            <p>
                                Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <div class="upcoming-event-item">
                                <div class="upcoming-event-box wow fadeInUp" data-wow-delay=".2s">
                                    <div class="left-content">
                                        <span>Jan</span>
                                        <h4>06</h4>
                                    </div>
                                    <div class="right-content">
                                        <h5>
                                            <a href="event-details.html">Trustee leadership programmer</a>
                                        </h5>
                                        <ul class="event-list">
                                            <li>
                                                <i class="fa-regular fa-clock"></i>
                                                3.00pm - 4.00pm
                                            </li>
                                            <li>
                                                <i class="fa-regular fa-location-dot"></i>
                                                London park
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="upcoming-event-box event-acive-box wow fadeInUp" data-wow-delay=".4s">
                                    <div class="left-content">
                                        <span>Jan</span>
                                        <h4>07</h4>
                                    </div>
                                    <div class="right-content">
                                        <h5>
                                            <a href="event-details.html">Apprenticeship taster event</a>
                                        </h5>
                                        <ul class="event-list">
                                            <li>
                                                <i class="fa-regular fa-clock"></i>
                                                3.00pm - 4.00pm
                                            </li>
                                            <li>
                                                <i class="fa-regular fa-location-dot"></i>
                                                London park
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="upcoming-event-box wow fadeInUp" data-wow-delay=".6s">
                                    <div class="left-content">
                                        <span>Jan</span>
                                        <h4>08</h4>
                                    </div>
                                    <div class="right-content">
                                        <h5>
                                            <a href="event-details.html">Event health food for growing</a>
                                        </h5>
                                        <ul class="event-list">
                                            <li>
                                                <i class="fa-regular fa-clock"></i>
                                                3.00pm - 4.00pm
                                            </li>
                                            <li>
                                                <i class="fa-regular fa-location-dot"></i>
                                                London park
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="upcoming-event-box mb-0 wow fadeInUp" data-wow-delay=".8s">
                                    <div class="left-content">
                                        <span>Jan</span>
                                        <h4>09</h4>
                                    </div>
                                    <div class="right-content">
                                        <h5>
                                            <a href="event-details.html">Education for poor children</a>
                                        </h5>
                                        <ul class="event-list">
                                            <li>
                                                <i class="fa-regular fa-clock"></i>
                                                3.00pm - 4.00pm
                                            </li>
                                            <li>
                                                <i class="fa-regular fa-location-dot"></i>
                                                London park
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Testimonial Section Start -->
         <section class="testimonial-section-2 section-padding pb-0">
            <div class="container">
                <div class="testimonial-wrapper-2">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="testimonial-content">
                                <div class="section-title style-2 mb-0">
                                    <span class="sub-title wow fadeInUp">Testimonials</span>
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        <span>H</span>appy Clients <br> Reflect On Their Journey With Us.
                                    </h2>
                                </div>
                                <p class="text wow fadeInUp" data-wow-delay=".5s">
                                    Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                                </p>
                                <a href="contact.html" class="theme-btn">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="testimonial-items">
                                <section id="slider">
                                <input type="radio" name="slider" id="s1" checked>
                                <input type="radio" name="slider" id="s2">
                                <input type="radio" name="slider" id="s3">
                                <label for="s1" id="slide1">
                                    <div class="testimonial-box">
                                    <div class="top-item">
                                        <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="35" viewBox="0 0 40 35" fill="none">
                                        <g opacity="0.2">
                                            <path d="M0 0V35L15 17.5V0H0Z" fill="#FFC107"/>
                                            <path d="M25 0V35L40 17.5V0H25Z" fill="#FFC107"/>
                                        </g>
                                        </svg>
                                    </div>
                                    <p>
                                        It reflects compassion and empathy, aiming to reduce suffering and improve lives. True charity is selfless—it comes from a genuine desire to make a difference.
                                    </p>
                                    <div class="client-info">
                                        <div class="client-image">
                                        <img src="{{ asset('assets/img/home-2/client-1.png') }}" alt="img">
                                        </div>
                                        <div class="content">
                                        <h5>Jenny Wilson</h5>
                                        <span>Project Manager</span>
                                        </div>
                                    </div>
                                    </div>
                                </label>
                                <label for="s2" id="slide2">
                                    <div class="testimonial-box">
                                    <div class="top-item">
                                        <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="35" viewBox="0 0 40 35" fill="none">
                                        <g opacity="0.2">
                                            <path d="M0 0V35L15 17.5V0H0Z" fill="#FFC107"/>
                                            <path d="M25 0V35L40 17.5V0H25Z" fill="#FFC107"/>
                                        </g>
                                        </svg>
                                    </div>
                                    <p>
                                        Charity involves giving without expecting anything in return. It builds a better world by helping those who need it the most, especially during crises.
                                    </p>
                                    <div class="client-info">
                                        <div class="client-image">
                                        <img src="{{ asset('assets/img/home-2/client-2.png') }}" alt="img">
                                        </div>
                                        <div class="content">
                                        <h5>John Doe</h5>
                                        <span>Team Lead</span>
                                        </div>
                                    </div>
                                    </div>
                                </label>
                                <label for="s3" id="slide3">
                                    <div class="testimonial-box">
                                    <div class="top-item">
                                        <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="35" viewBox="0 0 40 35" fill="none">
                                        <g opacity="0.2">
                                            <path d="M0 0V35L15 17.5V0H0Z" fill="#FFC107"/>
                                            <path d="M25 0V35L40 17.5V0H25Z" fill="#FFC107"/>
                                        </g>
                                        </svg>
                                    </div>
                                    <p>
                                        Giving back to society strengthens communities. Even the smallest act of kindness can bring hope and change lives in extraordinary ways.
                                    </p>
                                    <div class="client-info">
                                        <div class="client-image">
                                        <img src="{{ asset('assets/img/home-2/client-3.png') }}" alt="img">
                                        </div>
                                        <div class="content">
                                        <h5>Sarah Lee</h5>
                                        <span>Volunteer</span>
                                        </div>
                                    </div>
                                    </div>
                                </label>
                            </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

          <!-- News Section Start -->
         <section class="news-section section-padding pt-0 fix">
            <div class="container">
                <div class="section-title style-2 text-center">
                    <span class="sub-title wow fadeInUp">bLOG & nEWS</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>O</span>ur Latest News & Article's
                    </h2>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="news-card-items-2">
                            <div class="news-image">
                                <img src="{{ asset('assets/img/home-2/news/01.jpg') }}" alt="img">
                                <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/01.jpg') }});"></div>
                                </div>
                            </div>
                            <div class="news-content">
                                <ul class="news-meta">
                                    <li>
                                        <i class="fa-regular fa-user"></i>
                                        By : Admin
                                    </li>
                                    <li>
                                        <i class="fa-regular fa-comment"></i>
                                        By : Comment
                                    </li>
                                </ul>
                                <h3>
                                    <a href="news-details.html">
                                        Discover unparalleled expertise in market
                                    </a>
                                </h3>
                                <p>
                                    “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes.
                                </p>
                               <a href="news-details.html" class="theme-btn border-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="news-card-items-2">
                            <div class="news-image">
                                <img src="{{ asset('assets/img/home-2/news/02.jpg') }}" alt="img">
                                <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-2/news/02.jpg') }});"></div>
                                </div>
                            </div>
                            <div class="news-content">
                                <ul class="news-meta">
                                    <li>
                                        <i class="fa-regular fa-user"></i>
                                        By : Admin
                                    </li>
                                    <li>
                                        <i class="fa-regular fa-comment"></i>
                                        By : Comment
                                    </li>
                                </ul>
                                <h3>
                                    <a href="news-details.html">
                                        See you impact transparent donation tracking
                                    </a>
                                </h3>
                                <p>
                                    “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes.
                                </p>
                               <a href="news-details.html" class="theme-btn border-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>
         
         <!-- Cta-Contact Section-2 Start -->
         <section class="cta-contact-section-2">
            <div class="top-shape">
                <img src="{{ asset('assets/img/home-2/shape.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="cta-contact-wrapper wow fadeInUp" data-wow-delay=".3s">
                    <div class="contact-item">
                        <div class="icon">
                            <i class="fa-regular fa-location-dot"></i>
                        </div>
                         <div class="content">
                            <h4>Network City, USA</h4>
                         </div>
                    </div>
                    <div class="contact-item">
                        <div class="icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="content">
                            <h6>Call us any time</h6>
                            <h4>
                                <a href="tel:+16336547896">+163 3654 7896</a>
                            </h4>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="icon">
                             <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="content">
                            <h6>Send us a message</h6>
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
         </section>

    @push('scripts')
        <script>
            // Each slide's height is driven purely by its own text (a 2-line title vs
            // a 1-line one, an optional description) via .hero-content's padding +
            // content -- so slides with different amounts of text render at different
            // heights. The flex layout Swiper puts slides in (.swiper-wrapper) would
            // normally equalize that automatically via align-items:stretch, but that
            // isn't happening here (confirmed directly: forcing align-items:stretch
            // with !important made no difference), so the section's own height ends
            // up matching whichever slide is tallest while a shorter slide's photo
            // stops short of the bottom, leaving a plain grey/blank gap below it.
            // Measuring every slide's natural height and applying the tallest as an
            // explicit height on all of them sidesteps that flex quirk entirely and
            // keeps the section (and every slide's full-bleed photo) a single
            // consistent size no matter which slide is showing.
            (function () {
                function equalizeHeroHeights() {
                    var contents = document.querySelectorAll('.hero-2 .swiper-slide .hero-content, .hero-2 > .container .hero-content');
                    if (!contents.length) {
                        return;
                    }
                    var maxHeight = 0;
                    contents.forEach(function (el) {
                        el.style.height = '';
                        maxHeight = Math.max(maxHeight, el.scrollHeight);
                    });
                    contents.forEach(function (el) {
                        el.style.height = maxHeight + 'px';
                    });
                }
                equalizeHeroHeights();
                // Padding (and so the natural content height) changes at the same
                // 1399px/991px breakpoints .hero-2 itself used to use -- recompute
                // after a resize settles so the heights stay matched at any width.
                var resizeTimer;
                window.addEventListener('resize', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(equalizeHeroHeights, 150);
                });
            })();
        </script>
        <script>
            // The homepage hero slider (.hero-slider) is initialized in main.js with
            // loop: true, which requires several real slides to loop/fade cleanly --
            // with only 2 slides, Swiper's loop mode creates just one duplicate pair
            // per side, and the fade effect's opacity bookkeeping breaks down: the
            // outgoing slide can get stuck at full opacity instead of fading to 0,
            // so two slides render fully visible at once ("images overlapped").
            // Swiper's own docs recommend loop mode only once there are enough real
            // slides; below that we re-init with rewind (repeat from the start on
            // autoplay, no slide duplication) which fades correctly with few slides.
            // main.js's own init runs inside jQuery's document-ready callback. jQuery
            // can resolve that callback on a deferred tick rather than synchronously,
            // so neither DOMContentLoaded nor window 'load' reliably guarantee it has
            // already run by the time this script checks -- both were observed to
            // race and intermittently skip the fix. Polling for heroEl.swiper to
            // exist (instead of trusting any single event) sidesteps that race
            // entirely: this runs immediately (the element itself is already in the
            // DOM, since this script is lower in the page), and simply waits, however
            // long it takes, for main.js's init to finish before replacing it.
            (function () {
                var heroEl = document.querySelector('.hero-slider');
                if (!heroEl) {
                    return;
                }
                var slideCount = parseInt(heroEl.getAttribute('data-slide-count') || '0', 10);
                if (!(slideCount > 0 && slideCount < 3)) {
                    return;
                }
                var attemptsLeft = 50; // ~5s of polling; main.js's init normally finishes within milliseconds
                (function waitForSwiperThenReinit() {
                    if (heroEl.swiper) {
                        heroEl.swiper.destroy(true, true);
                        new Swiper('.hero-slider', {
                            loop: false,
                            rewind: true,
                            slidesPerView: 1,
                            effect: 'fade',
                            speed: 600,
                            autoplay: {
                                delay: 3000,
                                disableOnInteraction: false,
                            },
                            navigation: {
                                nextEl: '.array-prev',
                                prevEl: '.array-next',
                            },
                            pagination: {
                                el: '.dot',
                                clickable: true,
                            },
                        });
                        return;
                    }
                    attemptsLeft -= 1;
                    if (attemptsLeft > 0) {
                        setTimeout(waitForSwiperThenReinit, 100);
                    }
                })();
            })();
        </script>
    @endpush
@endsection
