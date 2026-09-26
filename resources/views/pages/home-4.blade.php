@extends('layouts.app')

@section('content')

    @push('styles')
        <style>
            /* index-4's About section overlays a second photo on top of the
               main one, pre-cut into a pointed "arrow"/banner shape with a
               thin white border around it -- that shape lives inside the
               original vendor PNG's own transparency mask (main.css has no
               clip-path rule for .about-image-2 at all: position only,
               border-radius: 0). We don't have that source file, so this
               approximates the same pointed silhouette with a CSS clip-path
               polygon on our own substitute photo instead, framed in white
               to match the look, and grayscaled to match the monochrome
               treatment used across the rest of the page. */
            .about-wrapper-3 .about-image .about-image-2 {
                background-color: #fff;
                padding: 8px;
                clip-path: polygon(0 0, 78% 0, 100% 50%, 78% 100%, 0 100%);
                -webkit-clip-path: polygon(0 0, 78% 0, 100% 50%, 78% 100%, 0 100%);
            }
            .about-wrapper-3 .about-image .about-image-2 img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: cover;
                filter: grayscale(100%);
                clip-path: polygon(0 0, 78% 0, 100% 50%, 78% 100%, 0 100%);
                -webkit-clip-path: polygon(0 0, 78% 0, 100% 50%, 78% 100%, 0 100%);
            }

            /* Color-legend follow-up: give each repeating icon/card group on
               this page its own accent instead of every icon sharing one
               color, matching the reference's per-category color pattern.
               Scoped to this page only -- the shared component/other pages
               are untouched. (The hero's own emphasis-word color now lives
               in the hero-2 style block below, next to the rest of the hero
               styling.) */
            .service-card-items-3.accent-secondary .service-content .icon {
                background-color: var(--secondary);
            }
            .service-card-items-3.accent-highlight .service-content .icon {
                background-color: var(--highlight);
            }
            .about-wrapper-3 .about-content .about-box:nth-of-type(2) .icon {
                background-color: var(--earth-brown);
            }
        </style>
    @endpush

    {{-- Hero Section: swapped from the index-4 "hero-3" split layout (static
         text + side image carousel, amber diagonal panel) to the simpler,
         already-proven full-width "hero-2" slider used on the existing
         home-3 page -- a single full-bleed photo per slide with the text
         overlaid on top, the whole slide crossfading as one. Ported
         near-verbatim from home-3.blade.php (styles, markup, and the
         supporting scripts below) since that implementation already
         handles the multi-slide / single-slide / no-slides cases and a
         couple of real Swiper quirks (see the comments in each piece). --}}
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
               instead of being covered by it. Moving the padding from the section
               onto the text content itself sidesteps that: the section has no
               padding left to show through, the slide (and its full-bleed photo)
               naturally fills the whole section, and the text still sits inset by
               the same amount as before, just from its own box instead of the
               section's. */
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
               z-index: 1" (needed for its internal layering), which paints above
               any sibling with the default z-index:auto -- including the
               decorative corner shapes below -- regardless of DOM order.
               Explicitly raising the shapes above the swiper's z-index:1 fixes
               that. */
            .hero-2 .left-shape,
            .hero-2 .right-shape {
                z-index: 2;
            }
            /* The bundled Swiper build's fade effect only recalculates opacity for
               the slide it is actively transitioning into -- the slide being
               transitioned AWAY from keeps whatever opacity it last had (1) and
               never fades back out, so for several seconds both a "prev" slide and
               the incoming slide render fully visible at once. Driving opacity
               purely from the swiper-slide-active class instead (with !important,
               since Swiper sets opacity inline) sidesteps that and gives a clean
               two-slide crossfade. */
            .hero-2 .swiper-slide {
                opacity: 0 !important;
                transition: opacity 0.6s ease !important;
            }
            .hero-2 .swiper-slide-active {
                opacity: 1 !important;
            }
            /* Color-legend follow-up: keep the hero's emphasised word on the new
               deep-blue token (previously rode on --theme, which the site-wide
               palette swap turned green) so it still reads as a distinct accent
               against the surrounding white heading text. */
            .hero-2 .hero-content h1 span {
                color: var(--deep-blue);
            }
        </style>
    @endpush

    <section class="hero-section hero-2 fix">
        @if ($slides->count() > 1)
            {{-- Homepage Slider (managed in the admin panel under "Homepage Slider").
                 Autoplays via the .hero-slider Swiper already initialized in
                 public/assets/js/main.js -- no new JS needed. Requires 2+ slides:
                 main.js configures this swiper with loop:true, and Swiper's loop
                 mode needs at least 2 real slides to loop cleanly -- with only 1 it
                 clones the single slide into broken duplicates and collapses the
                 height. A single slide is rendered statically below instead, which
                 looks identical but sidesteps that entirely. --}}
            <div class="swiper hero-slider" data-slide-count="{{ $slides->count() }}">
                <div class="swiper-wrapper">
                    @foreach ($slides as $slide)
                        <div class="swiper-slide">
                            <div class="hero-slide-bg" style="background-image: url({{ $slide->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($slide->image) : asset('assets/img/home-1/hero/hero-bg-3.jpg') }});"></div>
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
                                                @else
                                                    <a href="{{ route('internships.index') }}" class="theme-btn border-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                                @endif
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
            {{-- Exactly one active slide: render it statically (no swiper). --}}
            @php($slide = $slides->first())
            <div class="hero-slide-bg" style="background-image: url({{ $slide->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($slide->image) : asset('assets/img/home-1/hero/hero-bg-3.jpg') }});"></div>
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
                                @else
                                    <a href="{{ route('internships.index') }}" class="theme-btn border-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Fallback: no active slides configured -- static defaults so the
                 page never breaks. --}}
            <div class="hero-slide-bg" style="background-image: url({{ asset('assets/img/home-1/hero/hero-bg-3.jpg') }});"></div>
            <div class="hero-slide-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="hero-content">
                            <h4 class="wow fadeInUp">Non - Profit Charity</h4>
                            <h1 class="wow fadeInUp" data-wow-delay=".3s">
                                Make Someone's Life By Giving Of Yours's.
                            </h1>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                Avabodh Foundation brings communities together to support
                                education, skill-building and local outreach -- every
                                contribution, big or small, helps someone move forward.
                            </p>
                            <div class="hero-button-item wow fadeInUp" data-wow-delay=".5s">
                                <a href="{{ route('internships.index') }}" class="theme-btn border-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
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

    {{-- About Section --}}
    <section class="about-section section-padding fix">
        <div class="container">
            <div class="about-wrapper-3">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="section-title style-2 mb-0">
                                <span class="sub-title wow fadeInUp">About Us</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>U</span>nited for a cause <br> inspired by humanity.
                                </h2>
                            </div>
                            <p class="text wow fadeInUp" data-wow-delay=".3s">
                                Avabodh Foundation works with students, volunteers and local
                                partners to make education and opportunity a little more
                                within reach for the people who need it most.
                            </p>
                            <div class="about-box wow fadeInUp" data-wow-delay=".5s">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-2/icon/01.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h5>
                                        Helping people rebuild and prepare
                                    </h5>
                                    <p>
                                        From learning support to hands-on training, we walk
                                        alongside every participant, not just fund them.
                                    </p>
                                </div>
                            </div>
                            <div class="about-box mb-0 wow fadeInUp" data-wow-delay=".3s">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-2/icon/03.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h5>
                                        Putting people first in everything we do
                                    </h5>
                                    <p>
                                        Every program starts with listening to the community
                                        it's meant to serve.
                                    </p>
                                </div>
                            </div>
                            <div class="about-button-item wow fadeInUp" data-wow-delay=".5s">
                                <a href="about.html" class="theme-btn">More About Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                <div class="info-item">
                                    <div class="client-image">
                                        <img src="{{ asset('assets/img/home-2/client-1.png') }}" alt="img">
                                    </div>
                                    <div class="info-content">
                                        <h5>Program Volunteer</h5>
                                        <span>Avabodh Foundation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-image">
                            <img src="{{ asset('assets/img/home-2/about/02.jpg') }}" alt="img" class="wow img-custom-anim-right" data-wow-duration="1.3s" data-wow-delay="0.3s">
                            <div class="circle-image">
                                <img src="{{ asset('assets/img/home-2/cta/circle.png') }}" alt="img">
                                <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn video-popup">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                            <div class="shape">
                                <img src="{{ asset('assets/img/home-1/about/shape.png') }}" alt="img">
                            </div>
                            <div class="about-image-2">
                                <img src="{{ asset('assets/img/home-2/about/01.jpg') }}" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Service Section --}}
    <section class="service-section-3 section-padding fix bg-cover" style="background-image: url({{ asset('assets/img/home-1/service/bg.jpg') }});">
        <div class="container">
            <div class="section-title-area">
                <div class="section-title style-2">
                    <span class="sub-title wow fadeInUp">What We Do</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>P</span>rograms built around <br> real community <br> needs
                    </h2>
                </div>
                <div class="arrow-button">
                    <button class="array-prev">
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </button>
                    <button class="array-next">
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                </div>
            </div>
            <div class="swiper service-slider-3">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="service-card-items-3">
                            <div class="service-content">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-1/icon/01.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h4>01</h4>
                                    <h5>
                                        <a href="{{ route('internships.index') }}">Education &amp; learning support</a>
                                    </h5>
                                    <p>
                                        Tutoring, mentorship and internship placements for
                                        students who need a head start.
                                    </p>
                                </div>
                            </div>
                            <div class="service-image">
                                <img src="{{ asset('assets/img/home-1/project/01.jpg') }}" alt="img">
                                <a href="{{ route('internships.index') }}" class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.0156 3.66935C4.35751 11.2608 3.60376 27.2925 3.60376 27.2925C3.5822 27.7294 3.91876 28.102 4.35611 28.124C4.79298 28.1461 5.16564 27.809 5.18767 27.3717C5.18767 27.3717 6.02158 11.8373 24.4603 4.80419C23.9995 5.93435 23.4099 6.97451 22.8881 8.07654C22.7011 8.47216 22.8699 8.94513 23.2655 9.13263C23.6611 9.31966 24.1341 9.15044 24.3216 8.75529C24.9024 7.52763 25.5614 6.37216 26.0503 5.09622C26.0995 4.96779 26.4994 3.90044 26.512 3.64544C26.5341 3.2006 26.281 2.98216 26.1244 2.88607C25.5877 2.55654 24.908 2.35638 24.1866 2.23076C23.2669 2.07044 22.2755 2.03154 21.5274 1.88904C21.0975 1.80747 20.6822 2.08966 20.6002 2.51951C20.5186 2.94935 20.8013 3.36513 21.2311 3.44669C21.7458 3.54466 22.3734 3.59622 23.0156 3.66935Z" fill="#0B4E3D"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="service-card-items-3 accent-secondary">
                            <div class="service-content">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-1/icon/02.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h4>02</h4>
                                    <h5>
                                        <a href="{{ route('internships.index') }}">Skill development programs</a>
                                    </h5>
                                    <p>
                                        Hands-on training so young people leave with a real,
                                        usable skill.
                                    </p>
                                </div>
                            </div>
                            <div class="service-image">
                                <img src="{{ asset('assets/img/home-1/project/02.jpg') }}" alt="img">
                                <a href="{{ route('internships.index') }}" class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.0156 3.66935C4.35751 11.2608 3.60376 27.2925 3.60376 27.2925C3.5822 27.7294 3.91876 28.102 4.35611 28.124C4.79298 28.1461 5.16564 27.809 5.18767 27.3717C5.18767 27.3717 6.02158 11.8373 24.4603 4.80419C23.9995 5.93435 23.4099 6.97451 22.8881 8.07654C22.7011 8.47216 22.8699 8.94513 23.2655 9.13263C23.6611 9.31966 24.1341 9.15044 24.3216 8.75529C24.9024 7.52763 25.5614 6.37216 26.0503 5.09622C26.0995 4.96779 26.4994 3.90044 26.512 3.64544C26.5341 3.2006 26.281 2.98216 26.1244 2.88607C25.5877 2.55654 24.908 2.35638 24.1866 2.23076C23.2669 2.07044 22.2755 2.03154 21.5274 1.88904C21.0975 1.80747 20.6822 2.08966 20.6002 2.51951C20.5186 2.94935 20.8013 3.36513 21.2311 3.44669C21.7458 3.54466 22.3734 3.59622 23.0156 3.66935Z" fill="#0B4E3D"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="service-card-items-3 accent-highlight">
                            <div class="service-content">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-1/icon/03.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h4>03</h4>
                                    <h5>
                                        <a href="about.html">Community outreach initiatives</a>
                                    </h5>
                                    <p>
                                        Local events and drives that bring resources directly
                                        to the people who need them.
                                    </p>
                                </div>
                            </div>
                            <div class="service-image">
                                <img src="{{ asset('assets/img/home-1/project/03.jpg') }}" alt="img">
                                <a href="about.html" class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.0156 3.66935C4.35751 11.2608 3.60376 27.2925 3.60376 27.2925C3.5822 27.7294 3.91876 28.102 4.35611 28.124C4.79298 28.1461 5.16564 27.809 5.18767 27.3717C5.18767 27.3717 6.02158 11.8373 24.4603 4.80419C23.9995 5.93435 23.4099 6.97451 22.8881 8.07654C22.7011 8.47216 22.8699 8.94513 23.2655 9.13263C23.6611 9.31966 24.1341 9.15044 24.3216 8.75529C24.9024 7.52763 25.5614 6.37216 26.0503 5.09622C26.0995 4.96779 26.4994 3.90044 26.512 3.64544C26.5341 3.2006 26.281 2.98216 26.1244 2.88607C25.5877 2.55654 24.908 2.35638 24.1866 2.23076C23.2669 2.07044 22.2755 2.03154 21.5274 1.88904C21.0975 1.80747 20.6822 2.08966 20.6002 2.51951C20.5186 2.94935 20.8013 3.36513 21.2311 3.44669C21.7458 3.54466 22.3734 3.59622 23.0156 3.66935Z" fill="#0B4E3D"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Causes Section (kept the demo's own "casuss-*" class spelling since
         that exact class is what main.css ships styling for) --}}
    <section class="casuss-section-3 section-padding fix">
        <div class="container">
            <div class="section-title style-2 text-center">
                <span class="sub-title wow fadeInUp">Our Causes</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>C</span>hanging lives through action
                </h2>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="causes-card-item-3">
                        <div class="causes-image">
                            <img src="{{ asset('assets/img/home-2/donation/01.jpg') }}" alt="img">
                            <div class="causes-layer-wrapper">
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/01.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/01.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/01.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/01.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="causes-content">
                            <h4>
                                <a href="{{ route('projects.index') }}">Support Child Education</a>
                            </h4>
                            <p>
                                Books, supplies and tutoring for children whose families
                                can't cover the basics on their own.
                            </p>
                            <div class="pro-items">
                                <div class="progress">
                                    <div class="progress-value style-two"></div>
                                </div>
                            </div>
                            <ul class="donate-list">
                                <li>Raised - $ 16,020.00</li>
                                <li>57%</li>
                            </ul>
                            <a href="{{ route('projects.index') }}" class="theme-btn">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                    <div class="causes-card-item-3">
                        <div class="causes-image">
                            <img src="{{ asset('assets/img/home-2/donation/02.jpg') }}" alt="img">
                            <div class="causes-layer-wrapper">
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/02.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/02.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/02.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/02.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="causes-content">
                            <h4>
                                <a href="{{ route('projects.index') }}">Skill Training For Youth</a>
                            </h4>
                            <p>
                                Practical, job-ready training so young people can build a
                                path toward stable work.
                            </p>
                            <div class="pro-items style-2">
                                <div class="progress">
                                    <div class="progress-value style-two"></div>
                                </div>
                            </div>
                            <ul class="donate-list">
                                <li>Raised : $8,000 / 15,000</li>
                                <li>53%</li>
                            </ul>
                            <a href="{{ route('projects.index') }}" class="theme-btn style-2">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                    <div class="causes-card-item-3">
                        <div class="causes-image">
                            <img src="{{ asset('assets/img/home-2/donation/03.jpg') }}" alt="img">
                            <div class="causes-layer-wrapper">
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/03.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/03.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/03.jpg') }}');"></div>
                                <div class="causes-layer-image" style="background-image: url('{{ asset('assets/img/home-2/donation/03.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="causes-content">
                            <h4>
                                <a href="{{ route('projects.index') }}">Community Health &amp; Wellness</a>
                            </h4>
                            <p>
                                Basic health awareness and support drives for
                                underserved neighborhoods.
                            </p>
                            <div class="pro-items style-3">
                                <div class="progress">
                                    <div class="progress-value style-two"></div>
                                </div>
                            </div>
                            <ul class="donate-list">
                                <li>Raised : $8,000 / 15,000</li>
                                <li>53%</li>
                            </ul>
                            <a href="{{ route('projects.index') }}" class="theme-btn style-3">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Feature Section (Success Story) --}}
    <section class="feature-section-3 section-padding fix pt-0">
        <div class="container">
            <div class="feature-wrapper-3">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="feature-content">
                            <div class="section-title style-2 mb-0">
                                <span class="sub-title wow fadeInUp">Success Story</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>W</span>e help fellow <br> nonprofits access the funding tools training
                                </h2>
                            </div>
                            <p class="text wow fadeInUp" data-wow-delay=".5s">
                                Every program we run exists because of the people who
                                show up for it -- volunteers, donors and the communities
                                who trust us to get it right.
                            </p>
                            <a href="about.html" class="theme-btn wow fadeInUp" data-wow-delay=".5s">Our Success Story <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-right-items">
                            <div class="feature-image">
                                <img src="{{ asset('assets/img/home-1/feature/01.jpg') }}" alt="img" class="wow img-custom-anim-right" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                <div class="content-item">
                                    <div class="content">
                                        <h3>Impact</h3>
                                    </div>
                                    <h2>♥</h2>
                                </div>
                                <div class="feature-box float-bob-y">
                                    <h5>Program Volunteer</h5>
                                    <p>
                                        Working with Avabodh has meant getting to see the
                                        actual, direct impact of every donation.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Choose Us Section --}}
    <section class="choose-us-section-3 section-padding section-bg-2 fix">
        <div class="top-shape">
            <img src="{{ asset('assets/img/home-1/feature/shape-2.png') }}" alt="img">
        </div>
        <div class="left-shape float-bob-y">
            <img src="{{ asset('assets/img/home-2/cta/love.png') }}" alt="img">
        </div>
        <div class="right-shape float-bob-y">
            <img src="{{ asset('assets/img/home-2/cta/love-2.png') }}" alt="img">
        </div>
        <div class="container">
            <div class="section-title style-2 text-center">
                <span class="sub-title wow fadeInUp">Why Choose Us</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>W</span>hy trust Avabodh Foundation ?
                </h2>
            </div>
            <div class="choose-us-wrapper-3">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="choose-us-image">
                            <img src="{{ asset('assets/img/home-2/counter/01.jpg') }}" alt="img" class="wow img-custom-anim-left" data-wow-duration="1.3s" data-wow-delay="0.3s">
                            <div class="shape">
                                <img src="{{ asset('assets/img/home-1/feature/shape-1.png') }}" alt="img">
                            </div>
                            <div class="circle-image">
                                <img src="{{ asset('assets/img/home-2/cta/circle.png') }}" alt="img">
                                <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn video-popup">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                            <div class="content-box float-bob-y">
                                <a href="about.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                <h6>
                                    Join Our Community <br> Of Supporters
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="choose-us-box wow fadeInUp" data-wow-delay=".3s">
                            <div class="icon">
                                <img src="{{ asset('assets/img/home-1/icon/04.svg') }}" alt="img">
                            </div>
                            <div class="content">
                                <h5>Impact driven initiatives</h5>
                                <p>
                                    Every program is measured by the difference it makes,
                                    not just the money it raises.
                                </p>
                            </div>
                        </div>
                        <div class="choose-us-box active-box wow fadeInUp" data-wow-delay=".5s">
                            <div class="icon">
                                <img src="{{ asset('assets/img/home-1/icon/05.svg') }}" alt="img">
                            </div>
                            <div class="content">
                                <h5>Global reach, local impact</h5>
                                <p>
                                    We work directly with local communities so support
                                    lands where it's actually needed.
                                </p>
                            </div>
                        </div>
                        <div class="choose-us-box wow fadeInUp" data-wow-delay=".3s">
                            <div class="icon">
                                <img src="{{ asset('assets/img/home-2/icon/04.svg') }}" alt="img">
                            </div>
                            <div class="content">
                                <h5>Dedicated volunteers &amp; partners</h5>
                                <p>
                                    Our volunteers and partner organisations are the
                                    backbone of everything we run.
                                </p>
                            </div>
                        </div>
                        <div class="choose-us-box mb-0 wow fadeInUp" data-wow-delay=".5s">
                            <div class="icon">
                                <img src="{{ asset('assets/img/home-2/icon/01.svg') }}" alt="img">
                            </div>
                            <div class="content">
                                <h5>Transparent, accountable giving</h5>
                                <p>
                                    We're clear about where support goes and what it's
                                    used for.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Donation Section (How It Works) --}}
    <section class="donation-section-3 section-padding fix pb-0">
        <div class="container">
            <div class="section-title style-2">
                <span class="sub-title wow fadeInUp">How It Works</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>M</span>aking an impact step by step
                </h2>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="donation-card-items-3">
                        <div class="donation-image">
                            <img src="{{ asset('assets/img/home-1/donation/01.jpg') }}" alt="img">
                            <div class="donation-layer-wrapper">
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/01.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/01.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/01.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/01.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="donation-content">
                            <h5>
                                <a href="donation-details.html">Choose Your Cause</a>
                            </h5>
                            <p>
                                Pick the program that means the most to you -- education,
                                skills training, or community outreach.
                            </p>
                            <a href="donation-details.html" class="link-btn">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                    <div class="donation-card-items-3">
                        <div class="donation-content style-2">
                            <h5>
                                <a href="donation-details.html">Make A Donation</a>
                            </h5>
                            <p>
                                Every contribution, whatever the size, goes directly
                                toward running that program.
                            </p>
                            <a href="donation-details.html" class="link-btn">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                        <div class="donation-image">
                            <img src="{{ asset('assets/img/home-1/donation/02.jpg') }}" alt="img">
                            <div class="donation-layer-wrapper">
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/02.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/02.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/02.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/02.jpg') }}');"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                    <div class="donation-card-items-3">
                        <div class="donation-image">
                            <img src="{{ asset('assets/img/home-1/donation/03.jpg') }}" alt="img">
                            <div class="donation-layer-wrapper">
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/03.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/03.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/03.jpg') }}');"></div>
                                <div class="donation-layer-image" style="background-image: url('{{ asset('assets/img/home-1/donation/03.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="donation-content">
                            <h5>
                                <a href="donation-details.html">See The Impact</a>
                            </h5>
                            <p>
                                We follow up with real updates on where your support
                                went and what it made possible.
                            </p>
                            <a href="donation-details.html" class="link-btn">More Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonial Section --}}
    <section class="testimonial-section-3 section-padding fix">
        <div class="container">
            <div class="testimonial-wrapper-3">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="testimonial-item-3">
                            <div class="testimonial-image">
                                <img src="{{ asset('assets/img/home-1/testimonial/01.jpg') }}" alt="img">
                            </div>
                            <div class="testimonial-box">
                                <div class="array-button">
                                    <button class="array-prev">
                                        <i class="fa-solid fa-arrow-left-long"></i>
                                    </button>
                                    <button class="array-next">
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </button>
                                </div>
                                <div class="swiper testimonial-slider-2">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="testimonial-content">
                                                <div class="star">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                                <p>
                                                    Charity work doesn't just help the people
                                                    receiving it -- it builds a real sense of
                                                    unity and shared responsibility across the
                                                    whole community.
                                                </p>
                                                <h4>Program Participant</h4>
                                                <span>Avabodh Foundation</span>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial-content">
                                                <div class="star">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                                <p>
                                                    The internship program gave me real,
                                                    hands-on experience I couldn't have gotten
                                                    anywhere else nearby.
                                                </p>
                                                <h4>Internship Participant</h4>
                                                <span>Avabodh Foundation</span>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial-content">
                                                <div class="star">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                                <p>
                                                    Volunteering here made it easy to see
                                                    exactly where the time and support were
                                                    going -- and the difference it made.
                                                </p>
                                                <h4>Volunteer</h4>
                                                <span>Avabodh Foundation</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial-content">
                            <div class="section-title style-2 mb-0">
                                <span class="sub-title wow fadeInUp">testimonials</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>S</span>tories from the people we work with
                                </h2>
                            </div>
                            <p class="text wow fadeInUp" data-wow-delay=".5s">
                                From students to volunteers, these are the people whose
                                stories remind us why this work matters.
                            </p>
                            <a href="{{ route('internships.index') }}" class="theme-btn wow fadeInUp" data-wow-delay=".5s">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                            <div class="testimonial-count-box">
                                <div class="box">
                                    <div class="icon">
                                        <img src="{{ asset('assets/img/home-1/icon/02.svg') }}" alt="img">
                                    </div>
                                    <h2><span class="count">569</span>+</h2>
                                    <h6>Beneficiaries Reached</h6>
                                </div>
                                <div class="box">
                                    <div class="icon">
                                        <img src="{{ asset('assets/img/home-1/icon/02.svg') }}" alt="img">
                                    </div>
                                    <h2><span class="count">12</span>+</h2>
                                    <h6>Active Programs</h6>
                                </div>
                                <div class="box">
                                    <div class="icon">
                                        <img src="{{ asset('assets/img/home-1/icon/02.svg') }}" alt="img">
                                    </div>
                                    <h2><span class="count">25</span>+</h2>
                                    <h6>Volunteer Partners</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- News Section --}}
    <section class="news-section-3 section-padding fix">
        <div class="left-shape">
            <img src="{{ asset('assets/img/home-1/news/shape.png') }}" alt="img">
        </div>
        <div class="right-shape">
            <img src="{{ asset('assets/img/home-1/donation/shape.png') }}" alt="img">
        </div>
        <div class="container">
            <div class="section-title style-2">
                <span class="sub-title wow fadeInUp">Blog &amp; News</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>O</span>ur Latest News &amp; Articles
                </h2>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="news-card-items-3">
                        <div class="news-image">
                            <img src="{{ asset('assets/img/home-1/news/01.jpg') }}" alt="img">
                            <div class="news-layer-wrapper">
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/01.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/01.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/01.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/01.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="news-content">
                            <ul class="news-meta">
                                <li>
                                    <i class="fa-regular fa-user"></i>
                                    By: Admin
                                </li>
                                <li>
                                    <i class="fa-regular fa-comment"></i>
                                    Comments
                                </li>
                            </ul>
                            <h4>
                                <a href="news-details.html">
                                    How Your Support Changes Lives
                                </a>
                            </h4>
                            <a href="news-details.html" class="theme-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                    <div class="news-card-items-3">
                        <div class="news-image">
                            <img src="{{ asset('assets/img/home-1/news/02.jpg') }}" alt="img">
                            <div class="news-layer-wrapper">
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/02.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/02.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/02.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/02.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="news-content">
                            <ul class="news-meta">
                                <li>
                                    <i class="fa-regular fa-user"></i>
                                    By: Admin
                                </li>
                                <li>
                                    <i class="fa-regular fa-comment"></i>
                                    Comments
                                </li>
                            </ul>
                            <h4>
                                <a href="news-details.html">
                                    Behind Our Latest Community Outreach
                                </a>
                            </h4>
                            <a href="news-details.html" class="theme-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                    <div class="news-card-items-3">
                        <div class="news-image">
                            <img src="{{ asset('assets/img/home-1/news/03.jpg') }}" alt="img">
                            <div class="news-layer-wrapper">
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/03.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/03.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/03.jpg') }}');"></div>
                                <div class="news-layer-image" style="background-image: url('{{ asset('assets/img/home-1/news/03.jpg') }}');"></div>
                            </div>
                        </div>
                        <div class="news-content">
                            <ul class="news-meta">
                                <li>
                                    <i class="fa-regular fa-user"></i>
                                    By: Admin
                                </li>
                                <li>
                                    <i class="fa-regular fa-comment"></i>
                                    Comments
                                </li>
                            </ul>
                            <h4>
                                <a href="news-details.html">
                                    5 Ways To Get Involved This Month
                                </a>
                            </h4>
                            <a href="news-details.html" class="theme-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Volunteer / Donate CTA Section --}}
    <section class="volounteer-section section-padding fix">
        <div class="container">
            <div class="volounteer-wrapper-3">
                <div class="circle-image">
                    <img src="{{ asset('assets/img/home-2/cta/circle.png') }}" alt="img">
                    <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn video-popup">
                        <i class="fa-solid fa-play"></i>
                    </a>
                </div>
                <div class="right-shape">
                    <img src="{{ asset('assets/img/home-2/shape.png') }}" alt="img">
                </div>
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="volounteer-content">
                            <div class="section-title mb-0 style-2">
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>V</span>olunteer with us <br> and be part of the <br> solution
                                </h2>
                            </div>
                            <div class="volounteer-button wow fadeInUp" data-wow-delay=".5s">
                                <a href="{{ route('internships.index') }}" class="theme-btn">Get Involved <i class="fa-solid fa-arrow-right-long"></i></a>
                                <a href="donation-details.html" class="theme-btn style-2">Donate Now <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="volunteer-image img-custom-anim-right" data-wow-duration="1.3s" data-wow-delay="0.3s">
                            <img src="{{ asset('assets/img/home-1/donation/04.jpg') }}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Each slide's height is driven purely by its own text (a 2-line title vs
            // a 1-line one, an optional description) via .hero-content's padding +
            // content -- so slides with different amounts of text render at different
            // heights. Measuring every slide's natural height and applying the
            // tallest as an explicit height on all of them keeps the section (and
            // every slide's full-bleed photo) a single consistent size no matter
            // which slide is showing. Ported from home-3.blade.php's identical hero.
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
                var resizeTimer;
                window.addEventListener('resize', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(equalizeHeroHeights, 150);
                });
            })();
        </script>
        <script>
            // The homepage hero slider (.hero-slider) is initialized in main.js with
            // loop: true, which needs several real slides to loop/fade cleanly -- with
            // only 2, Swiper's loop mode breaks its fade-opacity bookkeeping and two
            // slides can render fully visible at once. Below 3 slides, re-init with
            // rewind (repeat from the start, no slide duplication) instead, which
            // fades correctly with few slides. Polls for main.js's own init to finish
            // (it runs inside a jQuery document-ready callback that isn't guaranteed
            // to have resolved by any single DOMContentLoaded/load event) rather than
            // trusting one event to have already fired. Ported from home-3.blade.php's
            // identical hero.
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
