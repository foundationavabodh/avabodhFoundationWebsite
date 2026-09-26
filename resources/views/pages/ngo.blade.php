@extends('layouts.app')

@section('content')

    {{-- layouts/app.blade.php only defines $websiteSettings for its own top-level
         markup (navbar/footer/donate modal); a child page's @section('content')
         is rendered in its own scope and doesn't inherit it, so it's fetched again
         here -- same "call current() independently, it's request-memoized" pattern
         the header/navbar components already use. --}}
    @php
        $websiteSettings = \App\Models\WebsiteSetting::current();
    @endphp

    {{-- Hero / Breadcrumb Section, matching the same breadcrumb-wrapper pattern
         used on About/Internships/Projects. --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Our Collaborative Ecosystem</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>NGO Network</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Partner/NGO network directory -- mirrors the live avabodhfoundation.org/ngo
         page's "Our Collaborative Ecosystem" section: a category filter bar + live
         search over a grid of partner cards, all client-side (no page reloads),
         backed by the Partner model / Filament "NGO Network Partners" resource so
         the admin can add, edit and reorder partners without any code changes. --}}
    <section class="partner-network-section section-padding fix">
        <div class="container">
            <div class="section-title text-center">
                <span class="sub-title wow fadeInUp">Avabodh Network</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>O</span>ur Collaborative Ecosystem
                </h2>
                <p class="wow fadeInUp" data-wow-delay=".5s">
                    Avabodh Foundation is proudly connected with premier educational institutions,
                    leading non-profits, and corporate CSR entities in Nagpur and beyond to drive
                    sustainable community growth.
                </p>
            </div>

            <div class="partner-filter-bar wow fadeInUp" data-wow-delay=".2s">
                <div class="partner-filter-tabs">
                    <button type="button" class="partner-filter-tab active" data-filter="all">
                        <i class="fa-solid fa-diagram-project"></i>
                        All Connections
                    </button>
                    @foreach (\App\Enums\PartnerCategory::cases() as $category)
                        <button type="button" class="partner-filter-tab" data-filter="{{ $category->value }}">
                            <i class="fa-solid fa-{{ $category === \App\Enums\PartnerCategory::Educational ? 'graduation-cap' : ($category === \App\Enums\PartnerCategory::Ngo ? 'hand-holding-heart' : 'building') }}"></i>
                            {{ $category->tabLabel() }}
                        </button>
                    @endforeach
                </div>
                <div class="partner-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="partnerSearch" placeholder="Search partners...">
                </div>
            </div>

            <div class="row g-4 partner-grid">
                @forelse ($partners as $partner)
                    <div class="col-xl-4 col-lg-6 col-md-6 partner-col wow fadeInUp"
                         data-wow-delay=".2s"
                         data-category="{{ $partner->category->value }}"
                         data-search="{{ strtolower($partner->name.' '.$partner->tag_line.' '.$partner->description.' '.$partner->location) }}">
                        <div class="partner-card">
                            <div class="partner-card-top">
                                <span class="partner-badge partner-badge-{{ $partner->category->value }}">
                                    {{ $partner->badge_label }}
                                </span>
                                <button type="button" class="partner-bookmark" aria-label="Bookmark this partner">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                            <div class="partner-identity">
                                @if ($partner->logo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo) }}"
                                         alt="{{ $partner->name }} logo" class="partner-logo">
                                @else
                                    <div class="partner-logo partner-logo-placeholder">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                @endif
                                <div class="partner-identity-text">
                                    <h5 class="partner-name">{{ $partner->name }}</h5>
                                    <span class="partner-tagline partner-tagline-{{ $partner->category->value }}">
                                        {{ strtoupper($partner->tag_line) }}
                                    </span>
                                </div>
                            </div>
                            <p class="partner-description">{{ $partner->description }}</p>
                            <div class="partner-meta">
                                <span><i class="fa-solid fa-location-dot"></i> {{ $partner->location }}</span>
                                <span class="partner-active"><i class="fa-solid fa-signal"></i> Active Network <i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <p id="partnerEmptyState" class="partner-empty-state" style="{{ $partners->isEmpty() ? '' : 'display: none;' }}">
                No Partners Found
            </p>
        </div>
    </section>

    {{-- CTA: mirrors the live site's "Let's Expand the Network" panel. Uses the
         same header_email settings field the top contact bar already reads,
         rather than hardcoding a personal address. --}}
    <section class="partner-cta-section fix">
        <div class="container">
            <div class="partner-cta-card wow fadeInUp" data-wow-delay=".2s">
                <i class="fa-solid fa-circle-nodes partner-cta-icon"></i>
                <h3>Let's Expand the Network</h3>
                <p>
                    Are you a registered educational institution, corporate CSR administrator, or
                    non-profit manager? Collaborate with us to run primary education modules and
                    skill training.
                </p>
                <a href="mailto:{{ $websiteSettings->header_email ?: 'info@donat.com' }}" class="theme-btn">
                    Partner with Avabodh <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .partner-filter-bar {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                background-color: var(--bg);
                border-radius: 16px;
                padding: 16px;
                margin-bottom: 40px;
            }
            .partner-filter-tabs {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }
            .partner-filter-tab {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border: 1px solid var(--border);
                background-color: var(--white);
                color: var(--text);
                border-radius: 50px;
                padding: 10px 18px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }
            .partner-filter-tab:hover {
                border-color: var(--heading);
            }
            .partner-filter-tab.active {
                background-color: var(--heading);
                border-color: var(--heading);
                color: var(--white);
            }
            .partner-search {
                position: relative;
                flex: 1 1 260px;
                max-width: 320px;
            }
            .partner-search i {
                position: absolute;
                top: 50%;
                left: 16px;
                transform: translateY(-50%);
                color: var(--text-2);
            }
            .partner-search input {
                width: 100%;
                border: 1px solid var(--border);
                border-radius: 50px;
                padding: 12px 16px 12px 42px;
                background-color: var(--white);
                color: var(--text);
            }
            .partner-search input:focus {
                outline: none;
                border-color: var(--heading);
            }
            .partner-card {
                position: relative;
                height: 100%;
                background-color: var(--white);
                border: 1px solid var(--border);
                border-radius: 16px;
                box-shadow: var(--box-shadow);
                padding: 28px;
            }
            .partner-card-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                margin-bottom: 16px;
            }
            .partner-badge {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.03em;
                border-radius: 50px;
                padding: 6px 14px;
            }
            .partner-badge-educational {
                color: var(--secondary);
                background-color: rgba(0, 174, 241, 0.12);
            }
            .partner-badge-ngo {
                color: var(--theme);
                background-color: rgba(32, 149, 70, 0.12);
            }
            .partner-badge-csr {
                color: var(--earth-brown);
                background-color: rgba(198, 134, 66, 0.14);
            }
            .partner-tagline-educational {
                color: var(--secondary);
            }
            .partner-tagline-ngo {
                color: var(--theme);
            }
            .partner-tagline-csr {
                color: var(--earth-brown);
            }
            .partner-bookmark {
                background: none;
                border: none;
                color: var(--text-2);
                font-size: 16px;
                cursor: pointer;
                transition: color 0.3s ease-in-out;
            }
            .partner-bookmark.is-bookmarked,
            .partner-bookmark.is-bookmarked i {
                color: var(--theme);
            }
            .partner-bookmark.is-bookmarked i {
                font-weight: 900;
            }
            .partner-identity {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 14px;
            }
            .partner-logo {
                width: 48px;
                height: 48px;
                flex: 0 0 48px;
                border-radius: 12px;
                object-fit: cover;
                border: 1px solid var(--border);
                background-color: var(--bg);
            }
            .partner-logo-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-2);
                font-size: 18px;
            }
            .partner-identity-text {
                min-width: 0;
            }
            .partner-name {
                margin-bottom: 4px;
                color: var(--heading);
            }
            .partner-tagline {
                display: block;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.03em;
            }
            .partner-description {
                color: var(--text);
                margin-bottom: 24px;
            }
            .partner-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                font-size: 13px;
                color: var(--text-2);
                border-top: 1px solid var(--border);
                padding-top: 16px;
            }
            .partner-meta i {
                color: var(--theme);
                margin-right: 4px;
            }
            .partner-empty-state {
                text-align: center;
                font-size: 18px;
                font-weight: 600;
                color: var(--text-2);
                padding: 40px 0;
            }
            .partner-cta-section {
                padding-bottom: 100px;
            }
            .partner-cta-card {
                text-align: center;
                background-color: var(--heading);
                border-radius: 24px;
                padding: 60px 24px;
            }
            .partner-cta-icon {
                font-size: 32px;
                color: var(--accent);
                margin-bottom: 16px;
            }
            .partner-cta-card h3 {
                color: var(--white);
                margin-bottom: 16px;
            }
            .partner-cta-card p {
                color: var(--white);
                max-width: 640px;
                margin: 0 auto 28px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                var filterButtons = document.querySelectorAll('.partner-filter-tab');
                var searchInput = document.getElementById('partnerSearch');
                var cards = document.querySelectorAll('.partner-col');
                var emptyState = document.getElementById('partnerEmptyState');
                var activeCategory = 'all';

                function applyFilters() {
                    var query = (searchInput ? searchInput.value : '').trim().toLowerCase();
                    var visibleCount = 0;

                    cards.forEach(function (card) {
                        var matchesCategory = activeCategory === 'all' || card.dataset.category === activeCategory;
                        var haystack = card.dataset.search || '';
                        var matchesSearch = query === '' || haystack.indexOf(query) !== -1;
                        var visible = matchesCategory && matchesSearch;
                        card.style.display = visible ? '' : 'none';
                        if (visible) {
                            visibleCount++;
                        }
                    });

                    if (emptyState) {
                        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                    }
                }

                filterButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        filterButtons.forEach(function (b) { b.classList.remove('active'); });
                        button.classList.add('active');
                        activeCategory = button.dataset.filter;
                        applyFilters();
                    });
                });

                if (searchInput) {
                    searchInput.addEventListener('input', applyFilters);
                }

                // Bookmark heart -- purely cosmetic (no persistence), matching the
                // live reference site's bookmark icon which has no visible effect either.
                document.querySelectorAll('.partner-bookmark').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        btn.classList.toggle('is-bookmarked');
                        var icon = btn.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('fa-regular');
                            icon.classList.toggle('fa-solid');
                        }
                    });
                });
            })();
        </script>
    @endpush

@endsection
