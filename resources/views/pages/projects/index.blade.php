@php($headerVariant = 'inner')
@extends('layouts.app')

@section('content')

    {{-- Hero / Breadcrumb Section Start (reused from public/project.html) --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url(https://ex-coders.com/html/kindi/assets/img/inner-page/breadcrumb.png);">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Our Causes</h1>
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
                        Our Causes
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Hero / Breadcrumb Section End --}}

    {{-- Causes Section Start (reused from public/project.html) --}}
    <section class="casuss-section-3 section-padding fix">
        <div class="container">
            @if ($projects->isEmpty())
                <div class="text-center py-5">
                    <p>There are no causes to show right now. Please check back soon.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($projects as $index => $project)
                        @php($styleClass = ['', ' style-2', ' style-3'][$index % 3])
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".{{ 3 + ($index % 3) * 2 }}s">
                            <div class="causes-card-item-3 mt-0">
                                <div class="causes-image">
                                    @if ($project->image)
                                        <img src="{{ Storage::disk('public')->url($project->image) }}" alt="{{ $project->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/home-1/donation/01.jpg') }}" alt="{{ $project->title }}">
                                    @endif
                                </div>
                                <div class="causes-content">
                                    <h4>
                                        <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                                    </h4>

                                    @if ($project->short_description)
                                        <p>
                                            {{ Str::limit($project->short_description, 120) }}
                                        </p>
                                    @endif

                                    @if (! is_null($project->goal_amount))
                                        <ul class="donate-list">
                                            <li>
                                                Goal - ${{ number_format((float) $project->goal_amount, 2) }}
                                            </li>
                                        </ul>
                                    @endif

                                    <a href="{{ route('projects.show', $project) }}" class="theme-btn{{ $styleClass }}">
                                        View Details <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $projects->links('pagination.kindi') }}
            @endif
        </div>
    </section>
    {{-- Causes Section End --}}

@endsection
