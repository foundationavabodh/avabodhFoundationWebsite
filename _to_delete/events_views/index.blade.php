@php($headerVariant = 'inner')
@extends('layouts.app')

@section('content')

    {{-- Hero / Breadcrumb Section Start (reused pattern from pages/projects/index.blade.php) --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Events</h1>
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
                        Events
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Hero / Breadcrumb Section End --}}

    {{-- Events Section Start (adapted from pages/projects/index.blade.php's causes-card-item-3 pattern) --}}
    <section class="casuss-section-3 section-padding fix">
        <div class="container">
            @if ($events->isEmpty())
                <div class="text-center py-5">
                    <p>There are no events to show right now. Please check back soon.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($events as $index => $event)
                        @php($styleClass = ['', ' style-2', ' style-3'][$index % 3])
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".{{ 3 + ($index % 3) * 2 }}s">
                            <div class="causes-card-item-3 mt-0">
                                <div class="causes-image">
                                    @if ($event->image)
                                        <img src="{{ Storage::disk('public')->url($event->image) }}" alt="{{ $event->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/home-1/news/01.jpg') }}" alt="{{ $event->title }}">
                                    @endif
                                </div>
                                <div class="causes-content">
                                    @if ($event->event_date || $event->location)
                                        <ul class="cause-list">
                                            @if ($event->event_date)
                                                <li>
                                                    <i class="fa-regular fa-calendar"></i>
                                                    {{ $event->event_date->format('d M Y') }}
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

                                    <h4>
                                        <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                                    </h4>

                                    @if ($event->short_description)
                                        <p>
                                            {{ Str::limit($event->short_description, 120) }}
                                        </p>
                                    @endif

                                    <a href="{{ route('events.show', $event) }}" class="theme-btn{{ $styleClass }}">
                                        View Details <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $events->links('pagination.kindi') }}
            @endif
        </div>
    </section>
    {{-- Events Section End --}}

@endsection
