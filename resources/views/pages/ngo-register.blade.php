@php($headerVariant = 'inner')
@extends('layouts.app')

@section('content')

    <div class="breadcrumb-wrapper fix bg-cover" style="background-image: url({{ asset('assets/img/inner-page/breadcrumb.png') }});">
        <div class="container">
            <div class="page-heading">
                <div class="breadcrumb-sub-title">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Register Your NGO</h1>
                </div>
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li><a href="{{ route('ngo') }}">NGO Network</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>Register</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="become-volounteer-section section-padding fix">
        <div class="container">
            <div class="become-volounteer-wrapper">
                @if (session('ngoRegistered'))
                    <div class="ngo-success text-center">
                        <i class="fa-solid fa-circle-check"></i>
                        <h3>Thank you for registering!</h3>
                        <p>
                            We have received the details of <strong>{{ session('ngoRegistered') }}</strong>.
                            Our team will review your registration, and once it is approved your NGO will
                            appear on the Avabodh NGO Network with its own profile page. We will contact you
                            on the email address you provided if we need anything else.
                        </p>
                        <a href="{{ route('ngo') }}" class="theme-btn">Back To NGO Network <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                @else
                    <div class="from-box ngo-register-box">
                        <h3>NGO Information Collection Form</h3>
                        <p>
                            Use this form to submit your organisation's details for inclusion on the Avabodh
                            NGO Network. Your registration is reviewed by our team and appears on the website
                            only after it is approved. Fields marked <span class="text-danger">*</span> are required.
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger" id="ngo-form-errors">
                                <strong>Please fix the following:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('ngo.register.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            {{-- Honeypot: hidden from people, often filled in by bots. --}}
                            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                                <label for="company_website">Leave this field empty</label>
                                <input type="text" name="company_website" id="company_website" tabindex="-1" autocomplete="off">
                            </div>

                            <span class="form-section-label">Section 1: Basic &amp; Legal Identity</span>
                            <div class="row g-4 mb-5">
                                <x-ngo-field name="legal_name" label="NGO full legal name" required />
                                <x-ngo-field name="display_name" label="Display / operating name (if different)" />
                                <x-ngo-field name="established_year" label="Year of establishment" type="number" required placeholder="e.g. 2015" inputmode="numeric" />
                                <x-ngo-field name="registration_details" label="Registration number & type" required placeholder="e.g. Trust - E-1234, Section 8 Company" />
                                <x-ngo-field name="tax_certifications" label="Tax exemption / certification status" placeholder="e.g. 80G, 12A, FCRA, CSR-1" />
                                <x-ngo-field name="focus_sectors" label="Primary focus sectors / domains" required placeholder="Separate with commas" hint="e.g. Education, Healthcare, Environment, Rural Development, Women Empowerment" />
                                <x-ngo-field name="tag_line" label="Tagline / catchphrase" required col="col-12" />
                            </div>

                            <span class="form-section-label">Section 2: Contact &amp; Key Personnel</span>
                            <div class="row g-4 mb-5">
                                <x-ngo-field name="founder_name" label="Founder / president / director (name & designation)" required />
                                <x-ngo-field name="contact_person" label="Primary contact person (name & title)" required />
                                <x-ngo-field name="contact_phone" label="Official contact number / WhatsApp" type="tel" required inputmode="tel" />
                                <x-ngo-field name="contact_email" label="Official email address" type="email" required />
                                <x-ngo-field name="website_url" label="Official website URL" type="url" placeholder="https://" col="col-12" />
                                <x-ngo-field name="social_links.facebook" label="Facebook" type="url" placeholder="https://facebook.com/..." />
                                <x-ngo-field name="social_links.instagram" label="Instagram" type="url" placeholder="https://instagram.com/..." />
                                <x-ngo-field name="social_links.linkedin" label="LinkedIn" type="url" placeholder="https://linkedin.com/..." />
                                <x-ngo-field name="social_links.youtube" label="YouTube" type="url" placeholder="https://youtube.com/..." />
                                <x-ngo-field name="social_links.x" label="X (Twitter)" type="url" placeholder="https://x.com/..." />
                                <x-ngo-field name="location" label="City & state" required placeholder="e.g. Nagpur, Maharashtra" />
                                <x-ngo-field name="address" label="Registered address" type="textarea" rows="2" required />
                                <x-ngo-field name="operating_address" label="Operating / branch office address" type="textarea" rows="2" />
                            </div>

                            <span class="form-section-label">Section 3: About the Organisation</span>
                            <div class="row g-4 mb-5">
                                <x-ngo-field name="description" label="Short summary (1-2 sentences for the listing card)" type="textarea" rows="2" required maxlength="500" col="col-12" />
                                <x-ngo-field name="mission" label="Mission statement" type="textarea" rows="3" required />
                                <x-ngo-field name="vision" label="Vision statement" type="textarea" rows="3" />
                                <x-ngo-field name="details" label="About us / detailed overview" type="textarea" rows="6" required col="col-12" hint="Leave a blank line between paragraphs." />
                                <x-ngo-field name="ongoing_projects" label="Key ongoing projects & initiatives" type="textarea" rows="5" col="col-12" />
                                <x-ngo-field name="achievements" label="Key achievements & impact metrics" type="textarea" rows="4" col="col-12" hint="e.g. beneficiaries reached, projects completed." />
                            </div>

                            <span class="form-section-label">Section 4: Media &amp; Visual Assets</span>
                            <div class="row g-4 mb-5">
                                <x-ngo-field name="logo" label="NGO logo" type="file" hint="JPG, PNG or WebP, up to 2 MB." />
                                <x-ngo-field name="cover_image" label="Header / cover banner image" type="file" hint="Wide image, up to 4 MB." />

                                <div class="col-12">
                                    <span class="ngo-label">Project / activity photos (up to 5, with brief captions)</span>
                                    @foreach (range(0, 4) as $i)
                                        <div class="row g-3 mb-2 ngo-photo-row {{ $i > 2 && ! old('gallery_captions.'.$i) ? 'd-none' : '' }}" data-extra="{{ $i > 2 ? '1' : '0' }}">
                                            <div class="col-md-6">
                                                <input type="file" name="gallery[{{ $i }}]" accept="image/png,image/jpeg,image/webp"
                                                       class="ngo-file @error('gallery.'.$i) is-invalid @enderror">
                                                @error('gallery.'.$i)
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-clt">
                                                    <input type="text" name="gallery_captions[{{ $i }}]" placeholder="Caption (optional)"
                                                           value="{{ old('gallery_captions.'.$i) }}" maxlength="255">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" class="ngo-add-photo" id="ngo-add-photo">+ Add another photo</button>
                                    <div class="ngo-hint">JPG, PNG or WebP, up to 4 MB each.</div>
                                </div>

                                <x-ngo-field name="video_url" label="Documentary / promotional video URL" type="url" placeholder="YouTube, Vimeo or Drive link" />
                                <x-ngo-field name="brochure_url" label="Brochure or annual report PDF link" type="url" placeholder="https://" />
                            </div>

                            <span class="form-section-label">Section 5: Donation &amp; Bank Details (optional)</span>
                            <p class="ngo-hint mb-3">
                                Anything you fill in here will be shown publicly on your NGO's profile page so that
                                visitors can donate. Leave this section empty if you do not want a donation box.
                            </p>
                            <div class="row g-4 mb-5">
                                <x-ngo-field name="bank_account_holder" label="Account holder name (legal registered name)" />
                                <x-ngo-field name="bank_name" label="Bank name" />
                                <x-ngo-field name="bank_branch" label="Branch name & address" />
                                <x-ngo-field name="bank_account_number" label="Account number" inputmode="numeric" maxlength="20" />
                                <x-ngo-field name="bank_ifsc" label="IFSC code / SWIFT code" maxlength="11" />
                                <x-ngo-field name="upi_id" label="UPI ID" placeholder="name@bank" />
                                <x-ngo-field name="upi_qr_image" label="UPI QR code image" type="file" hint="JPG, PNG or WebP, up to 2 MB." />
                                <x-ngo-field name="donor_tax_benefit" label="Tax exemption benefit details for donors" type="textarea" rows="2" placeholder="e.g. 80G tax receipt available" />
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input @error('consent') is-invalid @enderror" type="checkbox" name="consent" id="consent" value="1" @checked(old('consent'))>
                                <label class="form-check-label" for="consent">
                                    I confirm that the information above is correct and that Avabodh Foundation may
                                    publish it on the NGO Network page once approved. <span class="text-danger">*</span>
                                </label>
                                @error('consent')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="theme-btn">
                                Submit For Approval <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .ngo-register-box {
                max-width: 960px;
                margin: 0 auto;
            }
            .ngo-label {
                display: block;
                font-weight: 600;
                color: var(--heading);
                margin-bottom: 8px;
                font-size: 14px;
            }
            .ngo-hint {
                font-size: 12px;
                color: var(--text-2);
                margin-top: 6px;
            }
            .ngo-register-box .form-clt input.is-invalid,
            .ngo-register-box .form-clt textarea.is-invalid,
            .ngo-register-box .ngo-file.is-invalid {
                border-color: #dc3545 !important;
            }
            .ngo-file {
                width: 100%;
                padding: 12px 14px;
                border: 1px dashed var(--border);
                border-radius: 12px;
                background-color: var(--white);
                font-size: 14px;
            }
            .ngo-add-photo {
                background: none;
                border: none;
                color: var(--theme);
                font-weight: 700;
                padding: 4px 0;
                cursor: pointer;
            }
            .ngo-success {
                max-width: 720px;
                margin: 0 auto;
                padding: 50px 24px;
                background-color: var(--bg);
                border-radius: 20px;
            }
            .ngo-success i {
                font-size: 48px;
                color: var(--theme);
                margin-bottom: 16px;
            }
            .ngo-success p {
                margin: 12px 0 24px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                // "Add another photo" reveals the next hidden gallery row (max 5 in total).
                var addBtn = document.getElementById('ngo-add-photo');
                if (addBtn) {
                    addBtn.addEventListener('click', function () {
                        var next = document.querySelector('.ngo-photo-row.d-none');
                        if (next) { next.classList.remove('d-none'); }
                        if (!document.querySelector('.ngo-photo-row.d-none')) { addBtn.style.display = 'none'; }
                    });
                }

                // After a failed submit, scroll the error summary into view.
                var errors = document.getElementById('ngo-form-errors');
                if (errors) { errors.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
            })();
        </script>
    @endpush

@endsection
