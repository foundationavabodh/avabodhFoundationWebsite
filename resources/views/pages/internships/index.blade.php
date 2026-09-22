@php($headerVariant = 'inner')
@extends('layouts.app')

@section('content')

    {{-- Hero / Breadcrumb Section Start (structure reused from public/project.html, same
         as the Causes/Events pages -- content is ours) --}}
    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Internships</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>Internships</li>
                </ul>
            </div>
        </div>
    </div>
    {{-- Hero / Breadcrumb Section End --}}

    {{-- Application submitted confirmation --}}
    @if (session('applicationSubmitted'))
        <div class="container mt-5">
            <div class="alert alert-success" role="alert">
                <strong>Application submitted!</strong>
                Thank you for applying to <em>{{ session('applicationSubmitted.internship_title') }}</em>.
                Your application ID is <strong>{{ session('applicationSubmitted.application_id') }}</strong> --
                please save it, you'll need it to check your application status.
            </div>
        </div>
    @endif

    {{-- Intro Section Start --}}
    <section class="section-padding fix pb-0">
        <div class="container">
            <div class="section-title text-center mx-auto" style="max-width: 720px;">
                <span class="sub-title wow fadeInUp">Join Our Team</span>
                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                    <span>I</span>nternship Opportunities
                </h2>
                <p class="mt-3">
                    Gain real-world experience while helping us create lasting change. Explore our current
                    internship openings below, or scroll down to submit your application.
                </p>
            </div>
            <div class="text-center mt-4 mb-5">
                <a href="#open-positions" class="theme-btn">
                    View Open Positions <i class="fa-solid fa-arrow-right-long"></i>
                </a>
                <a href="#apply" class="theme-btn style-2">
                    Apply Now <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
        </div>
    </section>
    {{-- Intro Section End --}}

    {{-- Open Positions Section Start (card structure reused from public/project.html's
         causes grid) --}}
    <section id="open-positions" class="casuss-section-3 section-padding fix pt-0">
        <div class="container">
            @if ($internships->isEmpty())
                <div class="text-center py-5">
                    <p>There are no open internship positions right now. Please check back soon.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($internships as $index => $internship)
                        @php($styleClass = ['', ' style-2', ' style-3'][$index % 3])
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".{{ 3 + ($index % 3) * 2 }}s">
                            <div class="causes-card-item-3 mt-0">
                                <div class="causes-image">
                                    @if ($internship->image)
                                        <img src="{{ Storage::disk('public')->url($internship->image) }}" alt="{{ $internship->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/home-1/donation/01.jpg') }}" alt="{{ $internship->title }}">
                                    @endif
                                </div>
                                <div class="causes-content">
                                    @if ($internship->domain)
                                        <span class="sub-title d-block mb-2">{{ $internship->domain->name }}</span>
                                    @endif

                                    <h4>{{ $internship->title }}</h4>

                                    @if ($internship->short_description)
                                        <p>{{ Str::limit($internship->short_description, 120) }}</p>
                                    @endif

                                    <ul class="donate-list">
                                        @if ($internship->duration)
                                            <li>Duration - {{ $internship->duration }}</li>
                                        @endif
                                        @if ($internship->commitment)
                                            <li>Commitment - {{ $internship->commitment }}</li>
                                        @endif
                                    </ul>

                                    @if ($internship->skills_list->isNotEmpty())
                                        <p class="small mb-3">
                                            <strong>Skills:</strong> {{ $internship->skills_list->implode(', ') }}
                                        </p>
                                    @endif

                                    <button
                                        type="button"
                                        class="theme-btn{{ $styleClass }} internship-apply-trigger"
                                        data-internship-id="{{ $internship->id }}"
                                    >
                                        Apply Now <i class="fa-solid fa-arrow-right-long"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    {{-- Open Positions Section End --}}

    {{-- Apply For Internship Section Start (wrapper/form structure reused from public/
         become-volounteer.html's "Fill Up The Form" section -- content is ours) --}}
    <section id="apply" class="become-volounteer-section section-padding fix">
        <div class="container">
            <div class="become-volounteer-wrapper">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="become-volounteer-content">
                            <div class="section-title mb-0">
                                <span class="sub-title wow fadeInUp">Apply Now</span>
                                <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                    <span>W</span>hy Intern With Us
                                </h2>
                            </div>
                            <p class="text">
                                Whatever your background, there's a place for you here. Our internships are
                                hands-on, mentored, and focused on real impact -- not busywork.
                            </p>
                            <div class="become-volounteer-list">
                                <ul class="list-item">
                                    <li><i class="fa-solid fa-circle-check"></i> Real, mentored responsibility</li>
                                    <li><i class="fa-solid fa-circle-check"></i> Flexible commitment</li>
                                </ul>
                                <ul class="list-item">
                                    <li><i class="fa-solid fa-circle-check"></i> Certificate on completion</li>
                                    <li><i class="fa-solid fa-circle-check"></i> Remote-friendly</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="from-box">
                            <h3>Application Form</h3>
                            <p>
                                Fields marked <span class="text-danger">*</span> are required. Your email must be
                                verified before the application can be submitted.
                            </p>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('internships.apply') }}" method="POST" id="internship-application-form">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="text" name="full_name" id="full_name" placeholder="Full Name *" required value="{{ old('full_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="email" name="email" id="email" placeholder="Email Address *" required value="{{ old('email') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <button type="button" id="send-code-btn" class="theme-btn style-3">
                                                Verify Email
                                            </button>
                                            <span id="verify-status" class="small"></span>
                                        </div>

                                        <div id="code-entry" class="d-none mt-3">
                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                <input type="text" id="verification_code" placeholder="Enter 6-digit code" inputmode="numeric" maxlength="6" style="max-width: 220px;" class="form-control">
                                                <button type="button" id="confirm-code-btn" class="theme-btn style-3">
                                                    Confirm Code
                                                </button>
                                            </div>
                                        </div>

                                        <input type="hidden" name="email_verified" id="email_verified" value="0">
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-clt">
                                            <input type="text" name="country_code" id="country_code" placeholder="Country Code (e.g. +91)" value="{{ old('country_code') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-clt">
                                            <input type="text" name="phone" id="phone" placeholder="Contact Number" value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <select name="preferred_domain_id" id="preferred_domain_id" class="single-select">
                                            <option value="">Preferred Domain (optional)</option>
                                            @foreach ($domains as $domain)
                                                <option value="{{ $domain->id }}" @selected(old('preferred_domain_id') == $domain->id)>{{ $domain->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <select name="internship_id" id="internship_id" class="single-select" required>
                                            <option value="">Select Internship *</option>
                                            @foreach ($internships as $internship)
                                                <option value="{{ $internship->id }}" @selected(old('internship_id') == $internship->id)>
                                                    {{ $internship->title }}@if ($internship->domain) ({{ $internship->domain->name }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="text" name="college_name" id="college_name" placeholder="College / Institution Name" value="{{ old('college_name') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="address" id="address" placeholder="Address">{{ old('address') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="skills" id="skills" placeholder="Relevant Skills">{{ old('skills') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <button type="submit" id="submit-application-btn" class="theme-btn" disabled>
                                            Submit Application <i class="fa-solid fa-arrow-right-long"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Apply For Internship Section End --}}

@endsection

@push('scripts')
    <script>
        (function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const emailInput = document.getElementById('email');
            const sendCodeBtn = document.getElementById('send-code-btn');
            const codeEntry = document.getElementById('code-entry');
            const codeInput = document.getElementById('verification_code');
            const confirmCodeBtn = document.getElementById('confirm-code-btn');
            const verifyStatus = document.getElementById('verify-status');
            const emailVerifiedField = document.getElementById('email_verified');
            const submitBtn = document.getElementById('submit-application-btn');
            const internshipSelect = document.getElementById('internship_id');

            function setStatus(message, className) {
                verifyStatus.textContent = message;
                verifyStatus.className = 'small ' + (className || '');
            }

            function resetVerification() {
                emailVerifiedField.value = '0';
                submitBtn.disabled = true;
                codeEntry.classList.add('d-none');
                setStatus('', '');
            }

            // Changing the email after verifying invalidates that verification --
            // the server re-checks against whatever email is actually submitted, so
            // the UI must not let a stale "verified" state linger on a new address.
            emailInput.addEventListener('input', resetVerification);

            sendCodeBtn.addEventListener('click', function () {
                const email = emailInput.value.trim();
                if (!email) {
                    setStatus('Please enter your email first.', 'text-danger');
                    return;
                }

                sendCodeBtn.disabled = true;
                setStatus('Sending code...', 'text-muted');

                fetch('{{ route('internships.verify-email.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email: email }),
                })
                    .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
                    .then(function (result) {
                        if (result.ok) {
                            codeEntry.classList.remove('d-none');
                            setStatus(result.data.message, 'text-success');
                        } else {
                            setStatus(result.data.message || 'Could not send code.', 'text-danger');
                        }
                    })
                    .catch(function () {
                        setStatus('Something went wrong. Please try again.', 'text-danger');
                    })
                    .finally(function () {
                        sendCodeBtn.disabled = false;
                    });
            });

            confirmCodeBtn.addEventListener('click', function () {
                const email = emailInput.value.trim();
                const code = codeInput.value.trim();
                if (!code) {
                    setStatus('Please enter the code.', 'text-danger');
                    return;
                }

                confirmCodeBtn.disabled = true;

                fetch('{{ route('internships.verify-email.confirm') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email: email, code: code }),
                })
                    .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
                    .then(function (result) {
                        if (result.ok && result.data.verified) {
                            emailVerifiedField.value = '1';
                            submitBtn.disabled = false;
                            setStatus('Email verified.', 'text-success');
                        } else {
                            emailVerifiedField.value = '0';
                            submitBtn.disabled = true;
                            setStatus(result.data.message || 'Incorrect code.', 'text-danger');
                        }
                    })
                    .catch(function () {
                        setStatus('Something went wrong. Please try again.', 'text-danger');
                    })
                    .finally(function () {
                        confirmCodeBtn.disabled = false;
                    });
            });

            // "Apply Now" on an Open Positions card pre-selects that internship and
            // jumps to the form, instead of the applicant having to find it again
            // in the dropdown themselves.
            document.querySelectorAll('.internship-apply-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    internshipSelect.value = button.getAttribute('data-internship-id');
                    if (window.jQuery && jQuery.fn.niceSelect) {
                        jQuery(internshipSelect).niceSelect('update');
                    }
                    document.getElementById('apply').scrollIntoView({ behavior: 'smooth' });
                });
            });
        })();
    </script>
@endpush
