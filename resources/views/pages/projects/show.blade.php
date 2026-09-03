@php($headerVariant = 'inner')
@extends('layouts.app')

@section('content')

    {{-- Hero / Breadcrumb Section Start (reused from public/project-details.html) --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url(https://ex-coders.com/html/kindi/assets/img/inner-page/breadcrumb.png);">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $project->title }}</h1>
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
                        <a href="{{ route('projects.index') }}">
                            Our Causes
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        {{ $project->title }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Hero / Breadcrumb Section End --}}

    {{-- Project-Details Section Start (reused from public/project-details.html) --}}
    <section class="causes-details-section section-padding fix">
        <div class="container">
            <div class="causes-details-wrapper">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="causes-details-post">
                            <div class="details-image">
                                @if ($project->image)
                                    <img src="{{ Storage::disk('public')->url($project->image) }}" alt="{{ $project->title }}">
                                @else
                                    <img src="{{ asset('assets/img/home-1/donation/01.jpg') }}" alt="{{ $project->title }}">
                                @endif
                            </div>
                            <div class="details-content">
                                @if ($project->start_date || $project->end_date)
                                    <ul class="cause-list">
                                        @if ($project->start_date)
                                            <li>
                                                <i class="fa-regular fa-calendar"></i>
                                                Starts {{ $project->start_date->format('d M Y') }}
                                            </li>
                                        @endif
                                        @if ($project->end_date)
                                            <li>
                                                <i class="fa-regular fa-calendar"></i>
                                                Ends {{ $project->end_date->format('d M Y') }}
                                            </li>
                                        @endif
                                    </ul>
                                @endif

                                <h2>
                                    {{ $project->title }}
                                </h2>

                                @if ($project->description)
                                    <div class="cause-description">
                                        {!! $project->description !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="causes-details-sideber">
                            <div class="causes-details-sideber-box">
                                <h4>Project Info</h4>
                                <ul class="donation-list">
                                    <li>
                                        Status <span>{{ $project->status->getLabel() }}</span>
                                    </li>
                                    @if ($project->start_date)
                                        <li>
                                            Start Date <span>{{ $project->start_date->format('d M Y') }}</span>
                                        </li>
                                    @endif
                                    @if ($project->end_date)
                                        <li>
                                            End Date <span>{{ $project->end_date->format('d M Y') }}</span>
                                        </li>
                                    @endif
                                    @if (! is_null($project->goal_amount))
                                        <li>
                                            Goal Amount <span>${{ number_format((float) $project->goal_amount, 2) }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="contact-bg bg-cover" style="background-image: url(https://ex-coders.com/html/kindi/assets/img/inner-page/project-details/bg.jpg);">
                                <div class="donation-contact-content">
                                    <div class="shape">
                                        <img src="https://ex-coders.com/html/kindi/assets/img/inner-page/project-details/shape.png" alt="">
                                    </div>
                                    <h6>Small Donations Bigger Impact</h6>
                                    <h2>
                                        Help Us Reach Our Goal
                                    </h2>
                                    <a href="{{ route('projects.index') }}" class="theme-btn border-btn">Back To Causes <i class="fa-solid fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Project-Details Section End --}}

@endsection
