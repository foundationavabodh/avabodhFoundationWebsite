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
                                Fields marked <span class="text-danger">*</span> are required.
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

                                <span class="form-section-label">Your Details</span>
                                <div class="row g-4 mb-4">
                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="text" name="full_name" id="full_name" placeholder="Full Name *"
                                                   value="{{ old('full_name') }}" required minlength="2" maxlength="255"
                                                   pattern="[A-Za-z\s.'\-]{2,255}" title="Please enter a valid name (letters, spaces, apostrophes, periods and hyphens only)"
                                                   autocomplete="name" class="@error('full_name') is-invalid @enderror">
                                            @error('full_name')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="email" name="email" id="email" placeholder="Email Address *"
                                                   value="{{ old('email') }}" required maxlength="255"
                                                   autocomplete="email" class="@error('email') is-invalid @enderror">
                                            @error('email')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <span class="form-section-label">Contact &amp; Background</span>
                                <div class="row g-4 mb-4">
                                    <div class="col-lg-6">
                                        <div class="form-clt">
                                            <input type="tel" name="phone" id="phone" placeholder="Contact Number *"
                                                   value="{{ old('phone') }}" required inputmode="numeric" autocomplete="tel"
                                                   minlength="10" maxlength="10" pattern="[0-9]{10}" title="Enter a valid 10-digit contact number"
                                                   class="@error('phone') is-invalid @enderror">
                                            @error('phone')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        {{-- A fixed list of local colleges (matching what avabodhfoundation.org's own
                                             form offers) plus "Other", which reveals the free-text field below --}}
                                        <select name="college_name" id="college_name" class="single-select @error('college_name') is-invalid @enderror">
                                            <option value="">Select your College *</option>
                                            @foreach ($collegeOptions as $college)
                                                <option value="{{ $college }}" @selected(old('college_name') == $college)>{{ $college }}</option>
                                            @endforeach
                                            <option value="Other" @selected(old('college_name') == 'Other')>Other</option>
                                        </select>
                                        {{-- Same niceSelect caveat as #internship_id below: the underlying <select>
                                             is hidden, so native "required" can't be trusted -- validated in JS instead. --}}
                                        <div id="college-select-error" class="text-danger small mt-2 d-none">
                                            Please select your college.
                                        </div>
                                        @error('college_name')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 {{ old('college_name') === 'Other' ? '' : 'd-none' }}" id="college-other-wrapper">
                                        <div class="form-clt">
                                            <input type="text" name="college_name_other" id="college_name_other" placeholder="Enter your college name *"
                                                   value="{{ old('college_name_other') }}" maxlength="255"
                                                   class="@error('college_name_other') is-invalid @enderror">
                                            @error('college_name_other')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
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
                                        <select name="internship_id" id="internship_id" class="single-select @error('internship_id') is-invalid @enderror">
                                            <option value="">Select Internship *</option>
                                            @foreach ($internships as $internship)
                                                <option value="{{ $internship->id }}" @selected(old('internship_id') == $internship->id)>
                                                    {{ $internship->title }}@if ($internship->domain) ({{ $internship->domain->name }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- niceSelect (public/assets/js/main.js) hides this <select> and renders its
                                             own widget in its place. A hidden field's native "required" validation is
                                             unreliable across browsers (notably silent in Safari), so validation for
                                             this field is done in JS on submit instead -- see the script below. --}}
                                        <div id="internship-select-error" class="text-danger small mt-2 d-none">
                                            Please select an internship.
                                        </div>
                                        @error('internship_id')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="address" id="address" placeholder="Address *" required minlength="10" maxlength="2000"
                                                      class="@error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-clt">
                                            <textarea name="skills" id="skills" placeholder="Relevant Skills (optional)" maxlength="2000">{{ old('skills') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="submit-application-btn" class="theme-btn apply-submit-btn">
                                    Submit Application <i class="fa-solid fa-arrow-right-long"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Apply For Internship Section End --}}

@endsection

@push('styles')
    <style>
        .from-box .form-clt input.is-invalid,
        .from-box .form-clt textarea.is-invalid {
            border-color: #dc3545 !important;
        }

        /* niceSelect (jquery.nice-select.min.js) copies the underlying
           select element's class onto its own wrapper div at init time, so
           an is-invalid class added server-side lands here too. The JS
           below also toggles this class live for client-side checks. */
        .from-box .nice-select.is-invalid {
            border-color: #dc3545 !important;
        }

    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const internshipSelect = document.getElementById('internship_id');
            const applicationForm = document.getElementById('internship-application-form');
            const internshipSelectError = document.getElementById('internship-select-error');
            const collegeSelect = document.getElementById('college_name');
            const collegeSelectError = document.getElementById('college-select-error');
            const collegeOtherWrapper = document.getElementById('college-other-wrapper');
            const collegeOtherInput = document.getElementById('college_name_other');

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

            // niceSelect replaces #internship_id with its own widget and hides the
            // original <select>, so the browser's native "required" validation on
            // it can't be trusted (it fails silently in Safari in particular).
            // Validate explicitly here instead, so a missing selection always shows
            // a clear, visible message rather than the form just doing nothing.
            // Same "Other" pattern as a typical college/occupation picker: showing the
            // free-text field only once it's actually needed, instead of always
            // showing an "Other" box nobody uses.
            function updateCollegeOtherVisibility() {
                if (collegeSelect.value === 'Other') {
                    collegeOtherWrapper.classList.remove('d-none');
                    collegeOtherInput.setAttribute('required', 'required');
                } else {
                    collegeOtherWrapper.classList.add('d-none');
                    collegeOtherInput.removeAttribute('required');
                    collegeOtherInput.value = '';
                }
            }

            updateCollegeOtherVisibility();

            function handleCollegeChange() {
                updateCollegeOtherVisibility();
                if (collegeSelect.value) {
                    collegeSelectError.classList.add('d-none');
                }
            }

            // niceSelect (jquery.nice-select.min.js) only ever calls jQuery's
            // .trigger("change") on the real <select> when an option is clicked --
            // never a native DOM "change" event -- so a plain addEventListener here
            // would silently never fire for an actual user click on the dropdown
            // (only for changes made programmatically via plain JS elsewhere, like
            // the "Apply Now" card buttons below). Binding through jQuery catches
            // both; a native listener is added too as a harmless fallback.
            if (window.jQuery) {
                jQuery(collegeSelect).on('change', handleCollegeChange);
            }
            collegeSelect.addEventListener('change', handleCollegeChange);

            applicationForm.addEventListener('submit', function (e) {
                const internshipWidget = internshipSelect.nextElementSibling;
                const collegeWidget = collegeSelect.nextElementSibling;

                if (!internshipSelect.value) {
                    e.preventDefault();
                    internshipSelectError.classList.remove('d-none');
                    if (internshipWidget && internshipWidget.classList.contains('nice-select')) {
                        internshipWidget.classList.add('is-invalid');
                        internshipWidget.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }

                internshipSelectError.classList.add('d-none');
                if (internshipWidget) {
                    internshipWidget.classList.remove('is-invalid');
                }

                // college_name's <select> is also niceSelect-hidden, so it gets the
                // same explicit-JS-validation treatment as #internship_id above.
                if (!collegeSelect.value) {
                    e.preventDefault();
                    collegeSelectError.classList.remove('d-none');
                    if (collegeWidget && collegeWidget.classList.contains('nice-select')) {
                        collegeWidget.classList.add('is-invalid');
                        collegeWidget.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }

                collegeSelectError.classList.add('d-none');
                if (collegeWidget) {
                    collegeWidget.classList.remove('is-invalid');
                }

                if (collegeSelect.value === 'Other' && !collegeOtherInput.value.trim()) {
                    e.preventDefault();
                    collegeOtherInput.classList.add('is-invalid');
                    collegeOtherInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    collegeOtherInput.focus();
                    return false;
                }

                collegeOtherInput.classList.remove('is-invalid');
            });

            function handleInternshipChange() {
                if (internshipSelect.value) {
                    internshipSelectError.classList.add('d-none');
                    const widget = internshipSelect.nextElementSibling;
                    if (widget && widget.classList.contains('nice-select')) {
                        widget.classList.remove('is-invalid');
                    }
                }
            }

            // Same niceSelect caveat as college_name above: a real click on the
            // dropdown only ever fires jQuery's own trigger("change"), never a
            // native DOM event, so bind through jQuery too (not just a plain
            // addEventListener) or this silently never runs for a real user click.
            if (window.jQuery) {
                jQuery(internshipSelect).on('change', handleInternshipChange);
            }
            internshipSelect.addEventListener('change', handleInternshipChange);
        })();
    </script>
@endpush
