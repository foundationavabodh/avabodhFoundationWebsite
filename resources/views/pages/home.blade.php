@extends('layouts.app')

@section('content')
        <!-- Hero Section Start -->
         <section class="hero-section-1">
            <div class="arrow-button">
                <button class="array-prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="array-next">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <div class="swiper hero-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="hero-1">
                            <div class="shape">
                                <img src="{{ asset('assets/img/home-1/hero/shape.png') }}" alt="img">
                            </div>
                            <div class="hero-bg bg-cover" style="background-image: url({{ asset('assets/img/home-1/hero/hero-bg.jpg') }});">
                            </div>
                                <div class="container">
                                    <div class="row g-4 justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="hero-content">
                                                <h6 data-animation="fadeInUp" data-delay="1.3s">Start Donating Poor People</h6>
                                                <h1 data-animation="fadeInUp" data-delay="1.5s">
                                                    We Are Non Profit Charity Organization
                                                </h1>
                                               <p data-animation="fadeInUp" data-delay="1.3s">
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference in someone's life.
                                               </p>
                                                <div class="hero-button" data-animation="fadeInUp" data-delay="1.5s">
                                                    <a href="contact.html" class="theme-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                                    <a href="about.html" class="theme-btn border-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="hero-1">
                            <div class="shape">
                                <img src="{{ asset('assets/img/home-1/hero/shape.png') }}" alt="img">
                            </div>
                            <div class="hero-bg bg-cover" style="background-image: url({{ asset('assets/img/home-1/hero/hero-bg-2.jpg') }});">
                            </div>
                                <div class="container">
                                    <div class="row g-4 justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="hero-content">
                                                <h6 data-animation="fadeInUp" data-delay="1.3s">Start Donating Poor People</h6>
                                                <h1 data-animation="fadeInUp" data-delay="1.5s">
                                                    We Are Non Profit Charity Organization
                                                </h1>
                                               <p data-animation="fadeInUp" data-delay="1.3s">
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference in someone's life.
                                               </p>
                                                <div class="hero-button" data-animation="fadeInUp" data-delay="1.5s">
                                                    <a href="contact.html" class="theme-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                                    <a href="about.html" class="theme-btn border-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="hero-1">
                             <div class="shape">
                                <img src="{{ asset('assets/img/home-1/hero/shape.png') }}" alt="img">
                            </div>
                            <div class="hero-bg bg-cover" style="background-image: url({{ asset('assets/img/home-1/hero/hero-bg-3.jpg') }});">
                            </div>
                                <div class="container">
                                    <div class="row g-4 justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="hero-content">
                                                <h6 data-animation="fadeInUp" data-delay="1.3s">Start Donating Poor People</h6>
                                                <h1 data-animation="fadeInUp" data-delay="1.5s">
                                                    We Are Non Profit Charity Organization
                                                </h1>
                                               <p data-animation="fadeInUp" data-delay="1.3s">
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference in someone's life.
                                               </p>
                                                <div class="hero-button" data-animation="fadeInUp" data-delay="1.5s">
                                                    <a href="contact.html" class="theme-btn">Join With Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                                    <a href="about.html" class="theme-btn border-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
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

         <!-- About Section Start -->
         <section class="about-section section-padding fix">
            <div class="container">
                <div class="about-wrapper">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="about-content">
                                <div class="section-title mb-0">
                                    <span class="sub-title wow fadeInUp">About Us</span>
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        <span>O</span>ur goal is to save more lives with your help.
                                    </h2>
                                </div>
                                <p class="text wow fadeInUp" data-wow-delay=".5s">
                                    “Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further. I will definitely be returning .
                                </p>
                                <div class="about-icon-item wow fadeInUp" data-wow-delay=".3s">
                                    <div class="icon">
                                        <img src="{{ asset('assets/img/home-1/icon/01.svg') }}" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>Fundraising</h4>
                                        <p>
                                            Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                                        </p>
                                    </div>
                                </div>
                                 <div class="about-icon-item mb-0 wow fadeInUp" data-wow-delay=".5s">
                                    <div class="icon">
                                        <img src="{{ asset('assets/img/home-1/icon/02.svg') }}" alt="img">
                                    </div>
                                    <div class="content">
                                        <h4>Donation Marketing</h4>
                                        <p>
                                            Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                                        </p>
                                    </div>
                                </div>
                                <div class="about-bottom wow fadeInUp" data-wow-delay=".3s">
                                     <a href="about.html" class="theme-btn">More About Us <i class="fa-solid fa-arrow-right-long"></i></a>
                                     <div class="info-item">
                                        <div class="client-image">
                                            <img src="{{ asset('assets/img/home-1/about/client.png') }}" alt="img">
                                        </div>
                                        <div class="info-content">
                                            <h5>James Anderson</h5>
                                            <span>Software Engineer</span>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-item">
                                <div class="about-image">
                                    <img src="{{ asset('assets/img/home-1/about/about-3.jpg') }}" alt="img" class="wow img-custom-anim-right" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                    <div class="shape">
                                        <img src="{{ asset('assets/img/home-1/about/shape.png') }}" alt="img">
                                    </div>
                                    <div class="about-image-2">
                                        <img src="{{ asset('assets/img/home-1/about/about-1.jpg') }}" alt="img" class="wow img-custom-anim-left" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                    </div>
                                    <div class="about-image-3">
                                        <img src="{{ asset('assets/img/home-1/about/about-2.png') }}" alt="img" class="wow img-custom-anim-left" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Service Section Start -->
         <section class="causes-section section-padding fix bg-cover" style="background-image: url({{ asset('assets/img/home-1/service/bg.jpg') }});">
            <div class="shape">
                <img src="{{ asset('assets/img/home-1/service/shape.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="section-title text-center">
                    <span class="sub-title wow fadeInUp">Charity Services</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>P</span>roviding Humanist services to all <br> people is what we do
                    </h2>
                </div>
                <div class="swiper service-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="causes-box-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-1/icon/03.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h3>
                                        <a href="project-details.html">Healthy Foods</a>
                                    </h3>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                                    </p>
                                    <a href="project-details.html" class="theme-btn">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="causes-box-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-1/icon/04.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h3>
                                        <a href="project-details.html">Education</a>
                                    </h3>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                                    </p>
                                    <a href="project-details.html" class="theme-btn">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="causes-box-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/img/home-1/icon/05.svg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h3>
                                        <a href="project-details.html">Medical Help</a>
                                    </h3>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further.
                                    </p>
                                    <a href="project-details.html" class="theme-btn">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-dot">
                    <div class="dot"></div>
                </div>
            </div>
         </section>

         <!-- Donation Section Start -->
         <section class="donation-section section-padding fix">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <span class="sub-title wow fadeInUp">Lets Start Donating</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            <span>S</span>ee You Impact Transparent <br> Donation Causes
                        </h2>
                    </div>
                    <a href="donation.html" class="theme-btn">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
                <div class="donation-wrapper">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".2s">
                            <div class="donation-card-item">
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-1/donation/01.jpg') }}" alt="img">
                                    <div class="right-shape">
                                        <img src="{{ asset('assets/img/home-1/donation/shape.png') }}" alt="img">
                                    </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Give African Children a Good Education</a>
                                    </h4>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service.
                                    </p>
                                    <div class="pro-items">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        <span>Goal :</span> $250,000
                                        </li>
                                        <li>
                                        <span>Raised:</span> $500,000
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn">Donte Now <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".4s">
                            <div class="donation-card-item">
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-1/donation/02.jpg') }}" alt="img">
                                    <div class="right-shape">
                                        <img src="{{ asset('assets/img/home-1/donation/shape.png') }}" alt="img">
                                    </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Support Learning, Inspire Hope in Africa</a>
                                    </h4>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service.
                                    </p>
                                    <div class="pro-items style-2">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        <span>Goal :</span> $250,000
                                        </li>
                                        <li>
                                        <span>Raised:</span> $500,000
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn style-2">Donte Now  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".6s">
                            <div class="donation-card-item">
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-1/donation/03.jpg') }}" alt="img">
                                    <div class="right-shape">
                                        <img src="{{ asset('assets/img/home-1/donation/shape.png') }}" alt="img">
                                    </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Building Bright Futures With Every Lesson</a>
                                    </h4>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service.
                                    </p>
                                    <div class="pro-items style-3">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        <span>Goal :</span> $250,000
                                        </li>
                                        <li>
                                        <span>Raised:</span> $500,000
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn style-3">Donte Now  <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".8s">
                            <div class="donation-card-item">
                                <div class="donation-image">
                                    <img src="{{ asset('assets/img/home-1/donation/04.jpg') }}" alt="img">
                                    <div class="right-shape">
                                        <img src="{{ asset('assets/img/home-1/donation/shape.png') }}" alt="img">
                                    </div>
                                </div>
                                <div class="donation-content">
                                    <h4>
                                        <a href="donation-details.html">Help Children Dream Bigger With Education</a>
                                    </h4>
                                    <p>
                                        Looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service.
                                    </p>
                                    <div class="pro-items style-4">
                                        <div class="progress">
                                            <div class="progress-value style-two"></div>
                                        </div>
                                    </div>
                                    <ul class="donate-list">
                                        <li>
                                        <span>Goal :</span> $250,000
                                        </li>
                                        <li>
                                        <span>Raised:</span> $500,000
                                        </li>
                                    </ul>
                                    <a href="donation-details.html" class="theme-btn style-4">Donte Now <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Project Section Start -->
         <section class="project-section fix">
            <div class="container">
                <div class="section-title text-center">
                    <span class="sub-title wow fadeInUp">Complete Project</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>O</span>ur Recent Compiled  Project
                    </h2>
                </div>
            </div>
            <div class="swiper project-slider">
                <div class="swiper-wrapper slide-transtion">
                    <div class="swiper-slide brand-slide-element">
                        <div class="project-card-item">
                        <div class="project-image">
                            <img src="{{ asset('assets/img/home-1/project/01.jpg') }}" alt="img">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/home-1/project/shape.png') }}" alt="img">
                                </div>
                                <div class="project-content">
                                    <div class="content">
                                        <h3>
                                            <a href="project-details.html">Child Educations</a>
                                        </h3>
                                        <h5>Charity & Funding</h5>
                                    </div>
                                    <a href="project-details.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide brand-slide-element">
                        <div class="project-card-item">
                        <div class="project-image">
                            <img src="{{ asset('assets/img/home-1/project/02.jpg') }}" alt="img">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/home-1/project/shape.png') }}" alt="img">
                                </div>
                                <div class="project-content">
                                    <div class="content">
                                        <h3>
                                            <a href="project-details.html">Child Educations</a>
                                        </h3>
                                        <h5>Charity & Funding</h5>
                                    </div>
                                    <a href="project-details.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide brand-slide-element">
                        <div class="project-card-item">
                        <div class="project-image">
                            <img src="{{ asset('assets/img/home-1/project/03.jpg') }}" alt="img">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/home-1/project/shape.png') }}" alt="img">
                                </div>
                                <div class="project-content">
                                    <div class="content">
                                        <h3>
                                            <a href="project-details.html">Child Educations</a>
                                        </h3>
                                        <h5>Charity & Funding</h5>
                                    </div>
                                    <a href="project-details.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div dir="rtl" class="swiper project-slider-2">
                <div class="swiper-wrapper slide-transtion">
                    <div class="swiper-slide brand-slide-element">
                        <div class="project-card-item">
                        <div class="project-image">
                            <img src="{{ asset('assets/img/home-1/project/01.jpg') }}" alt="img">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/home-1/project/shape.png') }}" alt="img">
                                </div>
                                <div class="project-content style-2">
                                    <div class="content">
                                        <h3>
                                            <a href="project-details.html">Child Educations</a>
                                        </h3>
                                        <h5>Charity & Funding</h5>
                                    </div>
                                    <a href="project-details.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide brand-slide-element">
                        <div class="project-card-item">
                        <div class="project-image">
                            <img src="{{ asset('assets/img/home-1/project/02.jpg') }}" alt="img">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/home-1/project/shape.png') }}" alt="img">
                                </div>
                                <div class="project-content style-2">
                                    <div class="content">
                                        <h3>
                                            <a href="project-details.html">Child Educations</a>
                                        </h3>
                                        <h5>Charity & Funding</h5>
                                    </div>
                                    <a href="project-details.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide brand-slide-element">
                        <div class="project-card-item">
                        <div class="project-image">
                            <img src="{{ asset('assets/img/home-1/project/03.jpg') }}" alt="img">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/home-1/project/shape.png') }}" alt="img">
                                </div>
                                <div class="project-content style-2">
                                    <div class="content">
                                        <h3>
                                            <a href="project-details.html">Child Educations</a>
                                        </h3>
                                        <h5>Charity & Funding</h5>
                                    </div>
                                    <a href="project-details.html" class="arrow-icon"><i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Team Section Start -->
         <section class="team-section section-padding fix pb-0">
            <div class="container">
                <div class="section-title text-center">
                    <span class="sub-title wow fadeInUp">Team Members</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>M</span>eet The Optimistic Volunteer
                    </h2>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="team-card-items">
                            <div class="team-image">
                                <img src="{{ asset('assets/img/home-1/team/01.jpg') }}" alt="img">
                            </div>
                            <div class="team-content">
                                <h5>
                                    <a href="volounteer-details.html">Darrell Steward</a>
                                </h5>
                                <p>Software Developer</p>
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
                                <h5>
                                    <a href="volounteer-details.html">Courtney Henry</a>
                                </h5>
                                <p>Software Developer</p>
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
                                <h5>
                                    <a href="volounteer-details.html">Annette Black</a>
                                </h5>
                                <p>Software Developer</p>
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
                                <h5>
                                    <a href="volounteer-details.html">Kristin Watson</a>
                                </h5>
                                <p>Software Developer</p>
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

          <!-- Testimonial Section Start -->
         <section class="testimonial-section section-padding fix">
            <div class="container">
                 <div class="section-title">
                    <span class="sub-title wow fadeInUp">Testimonials</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>W</span>hat People Say About Charity.
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
                                                    Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further. I will definitely be returning soon to try more of their culinary delights”
                                                </p>
                                                <h3>Jonny Ananta</h3>
                                                <span>Regular Customer’s</span>
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
                                                    Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further. I will definitely be returning soon to try more of their culinary delights”
                                                </p>
                                                <h3>Jonny Ananta</h3>
                                                <span>Regular Customer’s</span>
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
                                                    Overall, I cannot recommend The Gourmet Bistro highly enough. If you're looking for a restaurant that serves delicious, beautifully presented dishes with impeccable service, look no further. I will definitely be returning soon to try more of their culinary delights”
                                                </p>
                                                <h3>Jonny Ananta</h3>
                                                <span>Regular Customer’s</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6>Total raising money in this year > <span>$4,50,000</span></h6>
                                <div class="swiper brand-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="brand-image text-center">
                                                <img src="{{ asset('assets/img/home-1/brand/01.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="brand-image text-center">
                                                <img src="{{ asset('assets/img/home-1/brand/02.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="brand-image text-center">
                                                <img src="{{ asset('assets/img/home-1/brand/03.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="brand-image text-center">
                                                <img src="{{ asset('assets/img/home-1/brand/04.png') }}" alt="img">
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

         <!-- Counter Section Start -->
         <div class="counter-section fix section-bg-1">
             <div class="right-shape">
                <img src="{{ asset('assets/img/home-1/feature/shape-2.png') }}" alt="img">
            </div>
            <div class="container">
                <div class="counter-wrapper">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="counter-image">
                                <img src="{{ asset('assets/img/home-1/feature/01.jpg') }}" alt="img">
                                <div class="shape">
                                    <img src="{{ asset('assets/img/home-1/feature/shape-1.png') }}" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="counter-content">
                                <div class="section-title mb-0">
                                    <span class="sub-title wow fadeInUp">Numbers</span>
                                    <h2 class="sec-title">
                                        <span>W</span>e Always Help The <br> Needy Peoply
                                    </h2>
                                </div>
                                <p class="text wow fadeInUp" data-wow-delay=".3s">
                                    Charity helps to reduce suffering but also fosters a sense of unity and shared responsibility in difference in someone's life.
                                </p>
                                <div class="counter-main-item">
                                    <div class="counter-item wow fadeInUp" data-wow-delay=".5s">
                                        <div class="content style-2">
                                            <h2><span class="count">35</span>k</h2>
                                            <p>Team Suppor</p>
                                        </div>
                                         <div class="content">
                                            <h2><span class="count">1</span>k+</h2>
                                            <p>Successful Camaigns</p>
                                        </div>
                                    </div>
                                    <div class="counter-item style-border wow fadeInUp" data-wow-delay=".3s">
                                        <div class="content">
                                            <h2><span class="count">15</span>k+</h2>
                                            <p>Incredible Volunteers</p>
                                        </div>
                                         <div class="content style-2">
                                            <h2><span class="count">400</span>+</h2>
                                            <p>Monthly Donor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>

         <!-- Faq Section Start -->
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
                                            What Is Charity, And Why Is It Important ?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                               Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            How Can I Get Involved In Charity Work ?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                                    <h2 class="accordion-header" id="headingthree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsethree" aria-expanded="false"
                                            aria-controls="collapsethree">
                                            Dedication for charitable Donations ?
                                        </button>
                                    </h2>
                                    <div id="collapsethree" class="accordion-collapse collapse"
                                        aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                                    <h2 class="accordion-header" id="headingfour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsefour" aria-expanded="false"
                                            aria-controls="collapsefour">
                                           My Donations Are Going To a Charity ?
                                        </button>
                                    </h2>
                                    <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society. 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item mb-0 wow fadeInUp" data-wow-delay=".3s">
                                    <h2 class="accordion-header" id="headingfive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsefive" aria-expanded="false"
                                            aria-controls="collapsefive">
                                          Is my donation actually being put to use?
                                        </button>
                                    </h2>
                                    <div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society. 
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
                                        <span>E</span>Explore our FAQs for quick and helpful guidance
                                    </h2>
                                </div>
                                <p class="text wow fadeInUp" data-wow-delay=".5s">
                                    Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society. It reminds us of the can make it your significant difference in someone's life.
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

          <!-- News Section Start -->
         <section class="news-section section-padding pt-0 fix">
            <div class="container">
                <div class="section-title text-center">
                    <span class="sub-title wow fadeInUp">bLOG & nEWS</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                        <span>I</span>nsights from latest blog
                    </h2>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="news-card-items">
                            <div class="news-image">
                                <img src="{{ asset('assets/img/home-1/news/01.jpg') }}" alt="img">
                                <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/01.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/01.jpg') }});"></div>
                                </div>
                                <div class="bottom-shape">
                                    <img src="{{ asset('assets/img/home-1/news/shape.png') }}" alt="img">
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
                                <h4>
                                    <a href="news-details.html">
                                        How Education Can Transform a Child’s Future.
                                    </a>
                                </h4>
                                <a href="news-details.html" class="link-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="news-card-items">
                            <div class="news-image">
                                <img src="{{ asset('assets/img/home-1/news/02.jpg') }}" alt="img">
                                 <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/02.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/02.jpg') }});"></div>
                                </div>
                                <div class="bottom-shape">
                                    <img src="{{ asset('assets/img/home-1/news/shape.png') }}" alt="img">
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
                                <h4>
                                    <a href="news-details.html">
                                        How Education Can Transform a Child’s Future.
                                    </a>
                                </h4>
                                <a href="news-details.html" class="link-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".7s">
                        <div class="news-card-items">
                            <div class="news-image">
                                <img src="{{ asset('assets/img/home-1/news/03.jpg') }}" alt="img">
                                 <div class="news-layer-wrapper">
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/03.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/03.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/03.jpg') }});"></div>
                                    <div class="news-layer-image" style="background-image: url({{ asset('assets/img/home-1/news/03.jpg') }});"></div>
                                </div>
                                <div class="bottom-shape">
                                    <img src="{{ asset('assets/img/home-1/news/shape.png') }}" alt="img">
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
                                <h4>
                                    <a href="news-details.html">
                                        How Education Can Transform a Child’s Future.
                                    </a>
                                </h4>
                                <a href="news-details.html" class="link-btn">Read More <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <!-- Contact Section Start -->
         <section class="contact-section section-padding pb-0">
            <div class="container-fluid">
                <div class="contact-wrapper">
                    <div class="row g-4 align-items-end">
                        <div class="col-lg-6">
                            <div class="contact-image wow img-custom-anim-left" data-wow-duration="1.3s" data-wow-delay="0.3s">
                                <img src="{{ asset('assets/img/home-1/contact.jpg') }}" alt="img">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-content">
                                <div class="logo-image">
                                    <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/white-logo.svg') }}" alt="img"></a>
                                </div>
                            <div class="section-title mb-0">
                                    <h2 class="sec-title text-white">
                                        <span>A</span>lways open to more people <br> who what to support easts other
                                    </h2>
                                </div>
                                <p class="text wow fadeInUp" data-wow-delay=".3s">
                                    Charity not only helps to reduce suffering but also fosters a sense of unity and shared responsibility in society It reminds us of the can make it.
                                </p>
                                <div class="contact-item wow fadeInUp" data-wow-delay=".5s">
                                    <a href="contact.html" class="theme-btn">Explore More <i class="fa-solid fa-arrow-right-long"></i></a>
                                    <h6>
                                        <span>Call :</span>
                                        <a href="tel: +123 876 234">+123 876 234</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>
@endsection
