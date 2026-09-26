@extends('layouts.app')

@section('content')

    {{-- Hero / Breadcrumb Section (converted from public/about.html, following
         the same breadcrumb-wrapper pattern already used on the Internships
         and Projects pages). --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">About Us</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>About Us</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- About Section: same about-wrapper-2 layout already used on the
         homepage (home-3.blade.php), rewritten here with foundation-specific
         copy instead of the vendor's unconverted lorem/restaurant-review text
         so this page doesn't repeat that placeholder. --}}
    <section class="about-section section-padding fix">
        <div class="container">
            <div class="about-wrapper-2">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="about-left-item">
                            <div class="section-title style-2 mb-0">
                                <span class="sub-title wow fadeInUp">About Us</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>B</span>uilding futures one step at a time, one community at a time.
                                </h2>
                            </div>
                            <p class="text wow fadeInUp" data-wow-delay=".5s">
                                Avabodh Foundation started with a simple idea: that access to
                                education, healthcare and a supportive community shouldn't depend
                                on circumstance. Today we work alongside students, volunteers and
                                local partners to make that access a little more within reach.
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
                                            <h5>Quality Education</h5>
                                            <p>
                                                Tutoring and learning support for students who need
                                                a head start.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="icon-item wow fadeInUp" data-wow-delay=".5s">
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/home-2/icon/01.svg') }}" alt="img">
                                        </div>
                                        <div class="content">
                                            <h5>Community Healthcare</h5>
                                            <p>
                                                Basic health outreach for families who can't
                                                easily reach it otherwise.
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
                                            <h5>Skill Development</h5>
                                            <p>
                                                Practical training that helps people build a
                                                livelihood, not just get by.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="icon-item wow fadeInUp" data-wow-delay=".5s">
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/home-2/icon/04.svg') }}" alt="img">
                                        </div>
                                        <div class="content">
                                            <h5>Community First</h5>
                                            <p>
                                                Every program is shaped by listening to the
                                                community it serves.
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

    {{-- Team Section: role-only labels rather than invented personal bios,
         since there's no real staff-directory data behind this yet. --}}
    <section class="team-section fix">
        <div class="container">
            <div class="section-title text-center">
                <span class="sub-title wow fadeInUp">Our People</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>T</span>he People Behind The Work
                </h2>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="team-card-items">
                        <div class="team-image">
                            <img src="{{ asset('assets/img/home-1/team/01.jpg') }}" alt="img">
                        </div>
                        <div class="team-content">
                            <h5>Program Director</h5>
                            <p>Avabodh Foundation</p>
                            <div class="social-icon">
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#"><i class="fas fa-paper-plane"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="team-card-items">
                        <div class="team-image">
                            <img src="{{ asset('assets/img/home-1/team/02.jpg') }}" alt="img">
                        </div>
                        <div class="team-content">
                            <h5>Volunteer Coordinator</h5>
                            <p>Avabodh Foundation</p>
                            <div class="social-icon">
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#"><i class="fas fa-paper-plane"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".6s">
                    <div class="team-card-items">
                        <div class="team-image">
                            <img src="{{ asset('assets/img/home-1/team/03.jpg') }}" alt="img">
                        </div>
                        <div class="team-content">
                            <h5>Outreach Lead</h5>
                            <p>Avabodh Foundation</p>
                            <div class="social-icon">
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#"><i class="fas fa-paper-plane"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".8s">
                    <div class="team-card-items">
                        <div class="team-image">
                            <img src="{{ asset('assets/img/home-1/team/04.jpg') }}" alt="img">
                        </div>
                        <div class="team-content">
                            <h5>Education Lead</h5>
                            <p>Avabodh Foundation</p>
                            <div class="social-icon">
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#"><i class="fas fa-paper-plane"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section: each question given its own distinct answer instead of
         the vendor's single repeated line across all five. --}}
    <section class="faq-section section-padding fix">
        <div class="container">
            <div class="faq-wrapper">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="faq-items">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            What does Avabodh Foundation actually do?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                We run education support, skill-building and
                                                community outreach programs, working directly with
                                                local volunteers and partners rather than at a
                                                distance.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            How can I get involved?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                You can volunteer, apply through our internship
                                                program, or support an active project directly --
                                                see the Internship Portal and Projects pages for
                                                current openings.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                                    <h2 class="accordion-header" id="headingthree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsethree" aria-expanded="false"
                                            aria-controls="collapsethree">
                                            Are donations tax-deductible?
                                        </button>
                                    </h2>
                                    <div id="collapsethree" class="accordion-collapse collapse"
                                        aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                This depends on your country's tax rules and our
                                                registration status -- get in touch with us
                                                directly for the specifics before you donate.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                    <h2 class="accordion-header" id="headingfour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsefour" aria-expanded="false"
                                            aria-controls="collapsefour">
                                            Where does my donation go?
                                        </button>
                                    </h2>
                                    <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                Straight to the project you choose -- each one on
                                                our Projects page lists what it's raising for and
                                                how far it's gotten.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-0 wow fadeInUp" data-wow-delay=".3s">
                                    <h2 class="accordion-header" id="headingfive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsefive" aria-expanded="false"
                                            aria-controls="collapsefive">
                                            Do you take one-time volunteers, or only regular ones?
                                        </button>
                                    </h2>
                                    <div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                Both -- some of our volunteers help with a single
                                                event, others stay on for an ongoing program. There's
                                                a place for whatever time you can give.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="faq-content">
                            <div class="section-title mb-0">
                                <span class="sub-title wow fadeInUp">Our Faq</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>C</span>ommon questions, answered plainly
                                </h2>
                            </div>
                            <p class="text wow fadeInUp" data-wow-delay=".5s">
                                We'd rather you understood exactly how we work before you
                                get involved, whether that's as a volunteer, an intern or a
                                donor. If your question isn't here, reach out through the
                                Contact page.
                            </p>
                            <div class="faq-image wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms">
                                <img src="{{ asset('assets/img/home-1/faq.jpg') }}" alt="img">
                                <a href="https://www.youtube.com/watch?v=Cn4G2lZ_g2I" class="video-btn ripple video-popup">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonial Section: rewritten copy in a volunteer's voice rather
         than the vendor's restaurant review; the brand-logo strip from the
         source page was dropped since it doesn't correspond to any real
         Avabodh partner and would read as an unearned "as seen in" claim. --}}
    <section class="testimonial-section section-padding pt-0 fix">
        <div class="container">
            <div class="section-title">
                <span class="sub-title wow fadeInUp">Testimonials</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>W</span>hat Our Volunteers Say
                </h2>
            </div>
            <div class="testimonial-wrapper">
                <div class="row g-4">
                    <div class="col-lg-5 wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                        <div class="testimonial-image">
                            <img src="{{ asset('assets/img/home-1/testimonial/01.jpg') }}" alt="img">
                            <div class="shape">
                                <img src="{{ asset('assets/img/home-1/testimonial/shape.png') }}" alt="img">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="testimonial-content">
                            <div class="swiper testimonial-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="content">
                                            <div class="star">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>
                                                What stood out to me volunteering here is how
                                                directly the work reaches people -- there's no
                                                sense that anything gets lost between a donation
                                                and the family it's meant to help.
                                            </p>
                                            <h3>Program Volunteer</h3>
                                            <span>Avabodh Foundation</span>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="content">
                                            <div class="star">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>
                                                I started with a single weekend event and ended
                                                up staying on for a full program. The team makes
                                                it easy to contribute whatever time you actually
                                                have.
                                            </p>
                                            <h3>Community Outreach Volunteer</h3>
                                            <span>Avabodh Foundation</span>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="content">
                                            <div class="star">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>
                                                Every project page tells you exactly what it's
                                                raising for and how it's going -- that kind of
                                                transparency is rare and it's why I keep coming
                                                back.
                                            </p>
                                            <h3>Program Donor</h3>
                                            <span>Avabodh Foundation</span>
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

@endsection
