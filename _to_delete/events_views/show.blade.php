@php($headerVariant = 'inner')
@extends('layouts.app')

@section('content')

    {{-- Hero / Breadcrumb Section Start (reused pattern from pages/projects/show.blade.php) --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $event->title }}</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li>
                        <a href="{{ route('home') }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}">
                            Events
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        {{ $event->title }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Hero / Breadcrumb Section End --}}

    {{-- Event-Details Section Start (adapted from pages/projects/show.blade.php) --}}
    <section class="causes-details-section section-padding fix">
        <div class="container">
            <div class="causes-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="causes-details-post">
                            <div class="details-image">
                                @if ($event->image)
                                    <img src="{{ Storage::disk('public')->url($event->image) }}" alt="{{ $event->title }}">
                                @else
                                    <img src="{{ asset('assets/img/home-1/news/01.jpg') }}" alt="{{ $event->title }}">
                                @endif
                            </div>
                            <div class="details-content">
                                @if ($event->event_date || $event->start_time || $event->location)
                                    <ul class="cause-list">
                                        @if ($event->event_date)
                                            <li>
                                                <i class="fa-regular fa-calendar"></i>
                                                {{ $event->event_date->format('d M Y') }}
                                            </li>
                                        @endif
                                        @if ($event->start_time)
                                            <li>
                                                <i class="fa-regular fa-clock"></i>
                                                {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('g:i A') }}
                                                @if ($event->end_time)
                                                    &ndash; {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('g:i A') }}
                                                @endif
                                            </li>
                                        @endif
                                        @if ($event->location)
                                            <li>
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $event->location }}
                                            </li>
                                        @endif
                                    </ul>
                                @endif

                                <h2>
                                    {{ $event->title }}
                                </h2>

                                @if ($event->description)
                                    <div class="cause-description">
                                        {!! $event->description !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="causes-details-sideber">
                            <div class="causes-details-sideber-box">
                                <h4>Event Info</h4>
                                <ul class="donation-list">
                                    @if ($event->event_date)
                                        <li>
                                            Date <span>{{ $event->event_date->format('d M Y') }}</span>
                                        </li>
                                    @endif
                                    @if ($event->start_time)
                                        <li>
                                            Time
                                            <span>
                                                {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('g:i A') }}
                                                @if ($event->end_time)
                                                    &ndash; {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </li>
                                    @endif
                                    @if ($event->location)
                                        <li>
                                            Location <span>{{ $event->location }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="contact-bg bg-cover" style="background-image: url({{ asset('assets/img/inner-page/project-details/bg.jpg') }});">
                                <div class="donation-contact-content">
                                    <div class="shape">
                                        <img src="{{ asset('assets/img/inner-page/project-details/shape.png') }}" alt="">
                                    </div>
                                    <h6>Be Part Of The Change</h6>
                                    <h2>
                                        Join Us At This Event
                                    </h2>
                                    <a href="{{ route('events.index') }}" class="theme-btn border-btn">Back To Events <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Event-Details Section End --}}

@endsection
