@extends('layouts.app')

@section('content')

    @php
        // A child page's content section doesn't inherit layout variables (see ngo.blade.php).
        $websiteSettings = \App\Models\WebsiteSetting::current();
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        $url = fn ($path) => $path ? $disk->url($path) : null;

        $logoUrl = $url($partner->logo);
        $coverUrl = $url($partner->cover_image);
        $focusAreas = array_values(array_filter((array) $partner->focus_areas));
        $social = array_filter((array) $partner->social_links);
        $gallery = collect((array) $partner->gallery)->filter(fn ($g) => ! empty($g['image']))->values();
        $websiteHost = $partner->website_url ? preg_replace('#^https?://(www\.)?#i', '', rtrim($partner->website_url, '/')) : null;

        // YouTube / Vimeo links are embedded; anything else becomes a plain "Watch video" link.
        $videoEmbed = null;
        if ($partner->video_url) {
            if (preg_match('#(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})#i', $partner->video_url, $m)) {
                $videoEmbed = 'https://www.youtube.com/embed/'.$m[1];
            } elseif (preg_match('#vimeo\.com/(?:video/)?(\d+)#i', $partner->video_url, $m)) {
                $videoEmbed = 'https://player.vimeo.com/video/'.$m[1];
            }
        }

        $hasBank = filled($partner->bank_account_holder) || filled($partner->bank_name) || filled($partner->bank_branch)
            || filled($partner->bank_account_number) || filled($partner->bank_ifsc) || filled($partner->upi_id)
            || filled($partner->upi_qr_image) || filled($partner->donor_tax_benefit);

        $socialIcons = ['facebook' => 'fa-brands fa-facebook-f', 'instagram' => 'fa-brands fa-instagram', 'linkedin' => 'fa-brands fa-linkedin-in', 'youtube' => 'fa-brands fa-youtube', 'x' => 'fa-brands fa-x-twitter'];
    @endphp

    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ $coverUrl ?: asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $partner->name }}</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li><a href="{{ route('ngo') }}">NGO Network</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>{{ $partner->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="partner-details-section section-padding fix">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="partner-details-card">
                        <div class="partner-details-head">
                            @if ($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $partner->name }} logo" class="partner-details-logo">
                            @else
                                <div class="partner-details-logo partner-details-logo-placeholder">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                            @endif
                            <div>
                                <span class="partner-badge partner-badge-{{ $partner->category->value }}">{{ $partner->badge_label }}</span>
                                <h2>{{ $partner->name }}</h2>
                                <span class="partner-tagline partner-tagline-{{ $partner->category->value }}">{{ strtoupper($partner->tag_line) }}</span>
                            </div>
                        </div>

                        <h4 class="partner-details-heading">About {{ $partner->name }}</h4>
                        <div class="partner-details-body">
                            @if (filled($partner->details))
                                {!! $partner->details !!}
                            @else
                                <p>{{ $partner->description }}</p>
                            @endif
                        </div>

                        @if (filled($partner->mission) || filled($partner->vision))
                            <div class="partner-mv">
                                @if (filled($partner->mission))
                                    <div class="partner-mv-box">
                                        <i class="fa-solid fa-bullseye"></i>
                                        <h5>Our Mission</h5>
                                        <p>{!! nl2br(e($partner->mission)) !!}</p>
                                    </div>
                                @endif
                                @if (filled($partner->vision))
                                    <div class="partner-mv-box">
                                        <i class="fa-solid fa-eye"></i>
                                        <h5>Our Vision</h5>
                                        <p>{!! nl2br(e($partner->vision)) !!}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if (filled($partner->details))
                            <h4 class="partner-details-heading">How we collaborate with Avabodh</h4>
                            <div class="partner-details-body"><p>{{ $partner->description }}</p></div>
                        @endif

                        @if (count($focusAreas))
                            <h4 class="partner-details-heading">Focus sectors</h4>
                            <ul class="partner-chip-list">
                                @foreach ($focusAreas as $area)
                                    <li>{{ $area }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (filled($partner->ongoing_projects))
                            <h4 class="partner-details-heading">Key ongoing projects &amp; initiatives</h4>
                            <div class="partner-details-body">{!! $partner->ongoing_projects !!}</div>
                        @endif

                        @if (filled($partner->achievements))
                            <h4 class="partner-details-heading">Key achievements &amp; impact</h4>
                            <div class="partner-details-body">{!! $partner->achievements !!}</div>
                        @endif

                        @if ($gallery->isNotEmpty())
                            <h4 class="partner-details-heading">Project &amp; activity photos</h4>
                            <div class="partner-gallery">
                                @foreach ($gallery as $item)
                                    <figure>
                                        <a href="{{ $url($item['image']) }}" target="_blank" rel="noopener">
                                            <img src="{{ $url($item['image']) }}" alt="{{ $item['caption'] ?? $partner->name }}" loading="lazy">
                                        </a>
                                        @if (! empty($item['caption']))
                                            <figcaption>{{ $item['caption'] }}</figcaption>
                                        @endif
                                    </figure>
                                @endforeach
                            </div>
                        @endif

                        @if ($partner->video_url)
                            <h4 class="partner-details-heading">Watch</h4>
                            @if ($videoEmbed)
                                <div class="partner-video">
                                    <iframe src="{{ $videoEmbed }}" title="{{ $partner->name }} video" loading="lazy" allowfullscreen
                                            allow="accelerometer; encrypted-media; picture-in-picture"></iframe>
                                </div>
                            @else
                                <a href="{{ $partner->video_url }}" target="_blank" rel="noopener nofollow" class="theme-btn">
                                    <i class="fa-solid fa-circle-play"></i> Watch video
                                </a>
                            @endif
                        @endif

                        @if ($partner->brochure_url)
                            <div class="mt-4">
                                <a href="{{ $partner->brochure_url }}" target="_blank" rel="noopener nofollow" class="theme-btn border-btn">
                                    <i class="fa-solid fa-file-pdf"></i> Brochure / Annual Report
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="partner-details-card partner-info-card">
                        <h4>Organisation Info</h4>
                        <ul class="partner-info-list">
                            @if (filled($partner->legal_name) && $partner->legal_name !== $partner->name)
                                <li><i class="fa-solid fa-landmark"></i><div><span>Legal name</span>{{ $partner->legal_name }}</div></li>
                            @endif
                            <li><i class="fa-solid fa-tag"></i><div><span>Category</span>{{ $partner->category->getLabel() }}</div></li>
                            <li><i class="fa-solid fa-location-dot"></i><div><span>Location</span>{{ $partner->location }}</div></li>
                            @if ($partner->established_year)
                                <li><i class="fa-solid fa-calendar-days"></i><div><span>Established</span>{{ $partner->established_year }}</div></li>
                            @endif
                            @if (filled($partner->registration_details))
                                <li><i class="fa-solid fa-file-contract"></i><div><span>Registration</span>{{ $partner->registration_details }}</div></li>
                            @endif
                            @if (filled($partner->tax_certifications))
                                <li><i class="fa-solid fa-certificate"></i><div><span>Certifications</span>{{ $partner->tax_certifications }}</div></li>
                            @endif
                            @if (filled($partner->founder_name))
                                <li><i class="fa-solid fa-user-tie"></i><div><span>Founder / Director</span>{{ $partner->founder_name }}</div></li>
                            @endif
                            @if (filled($partner->contact_person))
                                <li><i class="fa-solid fa-address-card"></i><div><span>Contact person</span>{{ $partner->contact_person }}</div></li>
                            @endif
                            @if ($partner->contact_phone)
                                <li><i class="fa-solid fa-phone-volume"></i><div><span>Phone / WhatsApp</span><a href="tel:{{ preg_replace('/[^\d+]/', '', $partner->contact_phone) }}">{{ $partner->contact_phone }}</a></div></li>
                            @endif
                            @if ($partner->contact_email)
                                <li><i class="fa-solid fa-envelope"></i><div><span>Email</span><a href="mailto:{{ $partner->contact_email }}">{{ $partner->contact_email }}</a></div></li>
                            @endif
                            @if ($partner->website_url)
                                <li><i class="fa-solid fa-globe"></i><div><span>Website</span><a href="{{ $partner->website_url }}" target="_blank" rel="noopener nofollow">{{ $websiteHost }}</a></div></li>
                            @endif
                            @if ($partner->address)
                                <li><i class="fa-solid fa-map-location-dot"></i><div><span>Registered address</span>{!! nl2br(e($partner->address)) !!}</div></li>
                            @endif
                            @if ($partner->operating_address)
                                <li><i class="fa-solid fa-building"></i><div><span>Operating / branch office</span>{!! nl2br(e($partner->operating_address)) !!}</div></li>
                            @endif
                        </ul>

                        @if (count($social))
                            <div class="partner-social">
                                @foreach ($socialIcons as $key => $icon)
                                    @if (! empty($social[$key]))
                                        <a href="{{ $social[$key] }}" target="_blank" rel="noopener nofollow" aria-label="{{ ucfirst($key) }}"><i class="{{ $icon }}"></i></a>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('ngo') }}" class="theme-btn">
                            <i class="fa-solid fa-arrow-left"></i> Back To NGO Network
                        </a>
                    </div>

                    @if ($hasBank)
                        <div class="partner-details-card partner-donate-card mt-4">
                            <h4><i class="fa-solid fa-hand-holding-heart"></i> Support {{ $partner->name }}</h4>
                            <ul class="partner-bank-list">
                                @foreach ([
                                    'Account holder' => $partner->bank_account_holder,
                                    'Bank' => $partner->bank_name,
                                    'Branch' => $partner->bank_branch,
                                    'Account number' => $partner->bank_account_number,
                                    'IFSC / SWIFT' => $partner->bank_ifsc,
                                    'UPI ID' => $partner->upi_id,
                                ] as $label => $value)
                                    @if (filled($value))
                                        <li>
                                            <span>{{ $label }}</span>
                                            <strong>{{ $value }}</strong>
                                            @if (in_array($label, ['Account number', 'IFSC / SWIFT', 'UPI ID'], true))
                                                <button type="button" class="partner-copy" data-copy="{{ $value }}" aria-label="Copy {{ $label }}"><i class="fa-regular fa-copy"></i></button>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            @if ($partner->upi_qr_image)
                                <div class="partner-qr">
                                    <img src="{{ $url($partner->upi_qr_image) }}" alt="UPI QR code for {{ $partner->name }}">
                                    <small>Scan to pay via UPI</small>
                                </div>
                            @endif
                            @if (filled($partner->donor_tax_benefit))
                                <p class="partner-tax-note"><i class="fa-solid fa-receipt"></i> {{ $partner->donor_tax_benefit }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            @if ($related->isNotEmpty())
                <div class="partner-related">
                    <h3>More {{ $partner->category->tabLabel() }}</h3>
                    <div class="row g-4">
                        @foreach ($related as $other)
                            <div class="col-lg-4 col-md-6">
                                <div class="partner-card">
                                    <span class="partner-badge partner-badge-{{ $other->category->value }}">{{ $other->badge_label }}</span>
                                    <h5 class="partner-name mt-3"><a href="{{ route('ngo.show', $other) }}">{{ $other->name }}</a></h5>
                                    <p class="partner-description">{{ \Illuminate\Support\Str::limit($other->description, 110) }}</p>
                                    <div class="partner-meta">
                                        <span><i class="fa-solid fa-location-dot"></i> {{ $other->location }}</span>
                                        <a href="{{ route('ngo.show', $other) }}" class="partner-readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('styles')
        <style>
            .partner-details-card {
                background-color: var(--white);
                border: 1px solid var(--border);
                border-radius: 16px;
                box-shadow: var(--box-shadow);
                padding: 36px;
                height: 100%;
            }
            .partner-details-head {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 28px;
                padding-bottom: 24px;
                border-bottom: 1px solid var(--border);
            }
            .partner-details-head h2 {
                margin: 10px 0 6px;
                font-size: 30px;
            }
            .partner-details-logo {
                width: 88px;
                height: 88px;
                flex: 0 0 88px;
                border-radius: 16px;
                object-fit: cover;
                border: 1px solid var(--border);
                background-color: var(--bg);
            }
            .partner-details-logo-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 30px;
                color: var(--text-2);
            }
            .partner-details-heading {
                margin: 28px 0 12px;
                color: var(--heading);
            }
            .partner-details-body p {
                margin-bottom: 14px;
            }
            .partner-details-body ul,
            .partner-details-body ol {
                padding-left: 20px;
                margin-bottom: 14px;
            }
            .partner-details-body ul { list-style: disc; }
            .partner-details-body ol { list-style: decimal; }
            .partner-focus-list {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px 24px;
            }
            .partner-focus-list li {
                display: flex;
                gap: 10px;
                align-items: flex-start;
                color: var(--text);
            }
            .partner-focus-list i {
                color: var(--theme);
                margin-top: 5px;
            }
            .partner-info-card h4 {
                margin-bottom: 20px;
            }
            .partner-info-list {
                margin-bottom: 28px;
            }
            .partner-info-list li {
                display: flex;
                gap: 14px;
                padding: 12px 0;
                border-bottom: 1px solid var(--border);
                color: var(--heading);
                word-break: break-word;
            }
            .partner-info-list li:last-child {
                border-bottom: none;
            }
            .partner-info-list i {
                color: var(--theme);
                width: 18px;
                margin-top: 4px;
                text-align: center;
            }
            .partner-info-list span {
                display: block;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: var(--text-2);
            }
            .partner-info-list a:hover {
                color: var(--theme);
            }
            .partner-related {
                margin-top: 64px;
            }
            .partner-related h3 {
                margin-bottom: 24px;
            }
            /* Card styles shared with the NGO listing page, for the "related" cards. */
            .partner-related .partner-card {
                position: relative;
                height: 100%;
                background-color: var(--white);
                border: 1px solid var(--border);
                border-radius: 16px;
                box-shadow: var(--box-shadow);
                padding: 28px;
            }
            .partner-badge {
                display: inline-block;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.03em;
                border-radius: 50px;
                padding: 6px 14px;
            }
            .partner-badge-educational { color: var(--secondary); background-color: rgba(0, 174, 241, 0.12); }
            .partner-badge-ngo { color: var(--theme); background-color: rgba(32, 149, 70, 0.12); }
            .partner-badge-csr { color: var(--earth-brown); background-color: rgba(198, 134, 66, 0.14); }
            .partner-tagline {
                display: block;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.03em;
            }
            .partner-tagline-educational { color: var(--secondary); }
            .partner-tagline-ngo { color: var(--theme); }
            .partner-tagline-csr { color: var(--earth-brown); }
            .partner-name a { color: inherit; }
            .partner-name a:hover { color: var(--theme); }
            .partner-description { margin-bottom: 20px; }
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
            .partner-meta i { color: var(--theme); margin-right: 4px; }
            .partner-readmore {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 14px;
                font-weight: 700;
                color: var(--theme);
            }
            .partner-readmore i { margin-right: 0; }
            .partner-mv {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
                margin-top: 28px;
            }
            .partner-mv-box {
                background-color: var(--bg);
                border-radius: 14px;
                padding: 24px;
            }
            .partner-mv-box i { color: var(--theme); font-size: 22px; margin-bottom: 10px; }
            .partner-mv-box h5 { margin-bottom: 8px; }
            .partner-chip-list { display: flex; flex-wrap: wrap; gap: 10px; }
            .partner-chip-list li {
                background-color: rgba(32, 149, 70, 0.1);
                color: var(--theme);
                border-radius: 50px;
                padding: 7px 16px;
                font-size: 14px;
                font-weight: 600;
            }
            .partner-gallery {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
            }
            .partner-gallery figure { margin: 0; }
            .partner-gallery img {
                width: 100%;
                aspect-ratio: 4 / 3;
                object-fit: cover;
                border-radius: 12px;
            }
            .partner-gallery figcaption { font-size: 13px; color: var(--text-2); margin-top: 6px; }
            .partner-video { position: relative; aspect-ratio: 16 / 9; border-radius: 14px; overflow: hidden; }
            .partner-video iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
            .partner-social { display: flex; gap: 10px; margin-bottom: 24px; }
            .partner-social a {
                width: 38px; height: 38px; border-radius: 50%;
                display: inline-flex; align-items: center; justify-content: center;
                background-color: var(--bg); color: var(--heading);
                transition: all 0.3s ease-in-out;
            }
            .partner-social a:hover { background-color: var(--theme); color: #fff; }
            .partner-donate-card h4 { margin-bottom: 18px; }
            .partner-donate-card h4 i { color: var(--theme); margin-right: 6px; }
            .partner-bank-list li {
                position: relative;
                padding: 10px 40px 10px 0;
                border-bottom: 1px solid var(--border);
                word-break: break-word;
            }
            .partner-bank-list li:last-child { border-bottom: none; }
            .partner-bank-list span {
                display: block;
                font-size: 12px; font-weight: 700; text-transform: uppercase;
                letter-spacing: 0.04em; color: var(--text-2);
            }
            .partner-bank-list strong { color: var(--heading); }
            .partner-copy {
                position: absolute; right: 0; top: 50%; transform: translateY(-50%);
                background: none; border: 0; color: var(--text-2); cursor: pointer; font-size: 16px;
            }
            .partner-copy:hover, .partner-copy.copied { color: var(--theme); }
            .partner-qr { text-align: center; margin-top: 18px; }
            .partner-qr img { max-width: 180px; width: 100%; border-radius: 12px; border: 1px solid var(--border); }
            .partner-qr small { display: block; margin-top: 6px; color: var(--text-2); }
            .partner-tax-note {
                margin-top: 18px; padding: 12px 14px; border-radius: 12px;
                background-color: rgba(32, 149, 70, 0.1); color: var(--heading); font-size: 14px;
            }
            .partner-tax-note i { color: var(--theme); margin-right: 6px; }
            @media (max-width: 767px) {
                .partner-mv, .partner-gallery { grid-template-columns: 1fr; }
                .partner-details-card { padding: 24px; }
                .partner-details-head { flex-direction: column; align-items: flex-start; }
                .partner-focus-list { grid-template-columns: 1fr; }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.querySelectorAll('.partner-copy').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var text = btn.dataset.copy;
                    var done = function () {
                        btn.classList.add('copied');
                        setTimeout(function () { btn.classList.remove('copied'); }, 1500);
                    };
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(done);
                    }
                });
            });
        </script>
    @endpush

@endsection
