<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Visa - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <!-- Modern Plus Jakarta Sans Font & UI Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        .visa-hero-section {
            @php
                $banner = !empty($settings->inner_banner) ? $settings->inner_banner : "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80";
                $bannerUrl = (str_starts_with($banner, 'http') || str_starts_with($banner, '//')) ? $banner : asset($banner);
            @endphp
            background-image: url('{{ $bannerUrl }}') !important;
        }
        #availableJobsList .available-job-card {
            background: #fff;
            border: 2px solid #000 !important;
            border-radius: 8px !important;
            color: #111827;
            padding: 12px !important;
        }
        #availableJobsList .available-job-card h6 {
            color: #111827 !important;
            font-size: 0.95rem;
            font-weight: 700;
        }
        #availableJobsList .job-card-summary {
            color: #111827 !important;
            line-height: 1.5;
        }
        #availableJobsList .job-card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        #availableJobsList .job-card-actions .btn {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 5px 8px;
        }
        #availableJobsList .job-card-actions .select-job-button,
        #availableJobsList .job-card-actions .description-job-button {
            background-color: #fff !important;
            box-shadow: none !important;
        }
        #availableJobsList .job-card-actions .select-job-button {
            border-color: #198754 !important;
            color: #198754 !important;
        }
        #availableJobsList .job-card-actions .select-job-button.is-selected {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #fff !important;
        }
        #availableJobsList .job-card-actions .description-job-button {
            border-color: #2563eb !important;
            color: #2563eb !important;
        }
        #availableJobsList .job-card-actions .select-job-button:hover,
        #availableJobsList .job-card-actions .description-job-button:hover {
            filter: brightness(0.96);
        }
        #availableJobsList .job-card-details {
            border-top: 1px solid #e5e7eb;
            color: #374151;
            margin-top: 10px;
            padding-top: 10px;
        }
        .apply-wizard-page {
            background: #f4f7fc;
            flex: 1;
        }
        .apply-wizard-header {
            background: #0865ed;
            color: #fff;
            padding: 15px 14px 11px;
            position: relative;
        }
        .apply-wizard-header-back {
            align-items: center;
            background: transparent;
            border: 0;
            color: #fff;
            display: inline-flex;
            font-size: .8rem;
            height: 32px;
            justify-content: center;
            left: 8px;
            padding: 0;
            position: absolute;
            top: 7px;
            width: 32px;
        }
        .apply-wizard-header-back i {
            color: #fff !important;
        }
        .apply-wizard-header h1 {
            color: #fff !important;
            font-size: 1rem;
            font-weight: 700;
            margin: 0 0 12px;
            text-align: center;
        }
        .apply-stepper {
            align-items: flex-start;
            display: flex;
            list-style: none;
            margin: 0 auto;
            max-width: 400px;
            padding: 0;
        }
        .apply-stepper li {
            color: rgba(255, 255, 255, .65);
            flex: 1;
            font-size: .66rem;
            line-height: 1.2;
            position: relative;
            text-align: center;
        }
        .apply-stepper li:not(:last-child)::after {
            background: rgba(255, 255, 255, .38);
            content: "";
            height: 1px;
            left: calc(50% + 11px);
            position: absolute;
            right: calc(-50% + 11px);
            top: 9px;
        }
        .apply-stepper li.is-complete,
        .apply-stepper li.is-active {
            color: #fff;
        }
        .apply-stepper-icon {
            align-items: center;
            background: rgba(255, 255, 255, .25);
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 50%;
            color: #fff;
            display: flex;
            font-size: .65rem;
            height: 19px;
            justify-content: center;
            margin: 0 auto 4px;
            position: relative;
            width: 19px;
            z-index: 1;
        }
        .is-complete .apply-stepper-icon,
        .is-active .apply-stepper-icon {
            background: #fff;
            border-color: #fff;
            color: #0865ed;
        }
        .apply-wizard-content {
            margin: 0 auto;
            max-width: 500px;
            padding: 13px 12px 24px;
        }
        .apply-wizard-card {
            background: #fff;
            border: 1px solid #e6edf7;
            border-radius: 14px;
            box-shadow: 0 5px 18px rgba(22, 47, 89, .06);
            padding: 15px 12px;
        }
        .apply-step-heading {
            align-items: flex-start;
            display: flex;
            gap: 9px;
            margin-bottom: 12px;
        }
        .apply-step-heading-icon {
            align-items: center;
            background: #eef5ff;
            border-radius: 50%;
            color: #0871f9;
            display: flex;
            flex: 0 0 32px;
            height: 32px;
            justify-content: center;
        }
        .apply-step-heading h2 {
            color: #102b51 !important;
            font-size: 1rem;
            font-weight: 800;
            margin: 1px 0 2px;
        }
        .apply-step-heading p {
            color: #6f7f96 !important;
            font-size: .75rem;
            line-height: 1.4;
            margin: 0;
        }
        .apply-wizard-card .form-group {
            margin-bottom: 10px;
        }
        .apply-wizard-card .form-group label {
            color: #0d2d59 !important;
            font-size: .72rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .apply-wizard-card .input-with-icon i {
            color: #6a7c96;
            font-size: 12px;
            left: 10px;
        }
        .apply-wizard-card .input-with-icon input,
        .apply-wizard-card .input-with-icon select {
            background-color: #fff;
            border: 1px solid #dce6f3;
            border-radius: 7px;
            color: #425675 !important;
            font-size: .8rem;
            min-height: 38px;
            padding: 8px 10px 8px 32px;
        }
        .apply-wizard-card .form-row {
            gap: 8px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .apply-wizard-card .form-check-label,
        .apply-wizard-card .text-white {
            color: #344864 !important;
        }
        .apply-wizard-card .terms-box {
            color: #667891;
            font-size: .75rem;
            line-height: 1.5;
        }
        .apply-wizard-card .apply-terms-check {
            background: #f7faff !important;
            border-color: #dce6f3 !important;
            border-radius: 7px !important;
            padding: 8px 10px !important;
        }
        .apply-wizard-card .apply-terms-check label {
            color: #193b6b !important;
            font-size: .66rem !important;
        }
        .apply-wizard-navigation {
            display: flex;
            gap: 8px;
            margin-top: 14px;
        }
        .apply-wizard-navigation button {
            border-radius: 8px !important;
            font-size: .85rem !important;
            margin: 0 !important;
            min-height: 34px;
            padding: 8px 12px !important;
        }
        #wizardBack {
            background: #fff;
            border: 1px solid #d7e2f1;
            color: #25456f !important;
            flex: 0 0 34%;
        }
        #wizardNext {
            background: #0865ed;
            border: 1px solid #0865ed;
            color: #fff !important;
            flex: 1;
            font-weight: 700;
            width: 100%;
        }
        #wizardSubmit {
            flex: 1;
        }
        .apply-wizard-card .upload-box {
            padding: 14px;
        }
        .apply-wizard-card .upload-icon {
            font-size: 22px;
            margin-bottom: 7px;
        }
        @media (max-width: 420px) {
            .apply-wizard-card .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
        @media (max-width: 360px) {
            .apply-wizard-header { padding-left: 9px; padding-right: 9px; }
            .apply-wizard-content { padding-left: 8px; padding-right: 8px; }
            .apply-stepper li { font-size: .58rem; }
            .apply-wizard-card { padding: 12px 9px; }
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        <header class="apply-wizard-header">
            <button type="button" id="wizardHeaderBack" class="apply-wizard-header-back" aria-label="Go back">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h1>Apply Visa</h1>
            <ol class="apply-stepper" aria-label="Application progress">
                <li class="is-active" data-step-indicator="0"><span class="apply-stepper-icon"><i class="far fa-user"></i></span>Personal<br>Details</li>
                <li data-step-indicator="1"><span class="apply-stepper-icon"><i class="far fa-id-card"></i></span>Additional<br>Details</li>
                <li data-step-indicator="2"><span class="apply-stepper-icon">3</span>Destination &amp;<br>Profession</li>
            </ol>
        </header>

        <main class="apply-wizard-page">
        <div class="apply-wizard-content">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="apply-wizard-card">
                    <div class="apply-step-heading">
                        <span class="apply-step-heading-icon" id="applyStepIcon"><i class="far fa-user"></i></span>
                        <div>
                            <h2 id="applyStepTitle">Personal Details</h2>
                            <p id="applyStepDescription">Please provide your personal information as per your passport.</p>
                        </div>
                    </div>
                    <form id="visaApplicationForm" action="{{ route('travel.apply.post') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <section class="apply-wizard-step" data-wizard-step="0">
                        <div class="form-group">
                            <label>NATIONALITY *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-flag"></i>
                                <select id="nationality_select" name="nationality" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Nationality</option>
                                    @foreach($nationalities as $nationality)
                                        <option value="{{ $nationality->name }}" data-phone-code="{{ $nationality->phone_code ?? '' }}" data-phone-length="{{ $nationality->phone_number_length ?? '' }}" data-id-length="{{ $nationality->id_number_length ?? '' }}" data-currency="{{ $nationality->currency ?? '' }}" {{ old('nationality') == $nationality->name ? 'selected' : '' }}>{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>National Identity/Aadhaar Card *</label>
                            <div class="input-with-icon">
                                <i class="far fa-id-card"></i>
                                <input id="national_identity_input" type="text" name="national_identity" value="{{ old('national_identity') }}" placeholder="National Identity/Aadhaar Card" maxlength="100" inputmode="numeric" pattern="[0-9]*" required>
                            </div>
                            <small id="national_identity_hint" class="form-text text-muted d-none mt-1"></small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>FIRST NAME *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-user"></i>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>LAST NAME *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-user"></i>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>E-MAIL *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-envelope"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ACTIVE WHATSAPP NUMBER *</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone-alt"></i>
                                    <input id="mobile_number_input" type="tel" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Active WhatsApp Number" inputmode="numeric" pattern="[0-9+\-\s]*" required>
                                </div>
                                <small id="mobile_number_hint" class="form-text text-muted d-none mt-1"></small>
                            </div>
                        </div>

                        </section>
                        <section class="apply-wizard-step d-none" data-wizard-step="1">
                        <div class="form-row">
                            <div class="form-group">
                                <label>DATE OF BIRTH *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <input type="date" name="dob" value="{{ old('dob') ? \Illuminate\Support\Carbon::parse(old('dob'))->format('Y-m-d') : '' }}" placeholder="DD/MM/YYYY" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>GENDER *</label>
                                <div class="d-flex gap-3 mt-2" style="font-size: 0.95rem; padding-left: 4px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender', 'male') == 'male' ? 'checked' : '' }} style="accent-color: var(--btn-primary);">
                                        <label class="form-check-label text-white" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} style="accent-color: var(--btn-primary);">
                                        <label class="form-check-label text-white" for="female">Female</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} style="accent-color: var(--btn-primary);">
                                        <label class="form-check-label text-white" for="other">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>PASSPORT NUMBER *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-id-card"></i>
                                    <input type="text" name="passport_number" value="{{ old('passport_number') }}" placeholder="ENTER PASSPORT" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>PASSPORT EXPIRY *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <input type="date" name="passport_expiry" value="{{ old('passport_expiry') ? \Illuminate\Support\Carbon::parse(old('passport_expiry'))->format('Y-m-d') : '' }}" placeholder="DD-MM-YYYY" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>UPLOAD PASSPORT SIZE PHOTO *</label>
                            <div class="upload-box">
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p id="file-name" style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 14px;">White background passport size photo.</p>
                                <label class="btn btn-sm btn-primary px-4 py-2" style="font-size: 0.85rem; font-weight: 600; border-radius: 6px; background-color: var(--btn-primary);">
                                    <i class="far fa-image me-1"></i> Choose File
                                    <input type="file" name="passport_photo_file" hidden onchange="document.getElementById('file-name').textContent = this.files[0].name">
                                </label>
                            </div>
                        </div>

                        </section>
                        <section class="apply-wizard-step d-none" data-wizard-step="2">
                        <div class="form-group">
                            <label>SELECT DESTINATION COUNTRY *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-globe"></i>
                                <select id="destination_country_select" name="destination_country" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" data-id="{{ $country->id }}" {{ old('destination_country') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                    @if(count($countries) == 0)
                                        <option>United Arab Emirates</option>
                                        <option>Saudi Arabia</option>
                                        <option>Qatar</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <input id="visa_category_input" type="hidden" name="visa_category" value="{{ old('visa_category') }}">

                        <div class="form-group">
                            <label>PROFESSION *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user-tie"></i>
                                <select id="visa_type_select" name="visa_type" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Profession</option>
                                    @foreach($professions as $profession)
                                        @php
                                            $professionCategory = $categories->firstWhere('id', $profession->category_id);
                                        @endphp
                                        <option value="{{ $profession->name }}" data-category-name="{{ $professionCategory->name ?? '' }}" {{ old('visa_type') === $profession->name ? 'selected' : '' }}>{{ $profession->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="availableJobsSection" class="form-group d-none" aria-live="polite">
                            <label>AVAILABLE JOBS</label>
                            <div id="availableJobsList"></div>
                        </div>

                        <div id="drivingLicenseField" class="form-group d-none">
                            <label>Driving License Available ?</label>
                            <div class="d-flex gap-3 mt-2" style="font-size: 0.95rem; padding-left: 4px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="driving_license_available" id="license_yes" value="yes" {{ old('driving_license_available') == 'yes' ? 'checked' : '' }} style="accent-color: var(--btn-primary);">
                                    <label class="form-check-label text-white" for="license_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="driving_license_available" id="license_no" value="no" {{ old('driving_license_available') == 'no' ? 'checked' : '' }} style="accent-color: var(--btn-primary);">
                                    <label class="form-check-label text-white" for="license_no">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="fas fa-shield-alt text-primary" style="font-size: 14px;"></i>
                                <h6 class="mb-0 fw-bold text-white" style="font-size: 0.9rem;">TERMS & CONDITIONS</h6>
                            </div>
                            <div class="terms-box">
                                I agree that the above information is correct and complete to the best of my knowledge and belief. I understand that in the event of any information being found false/incorrect, my application is liable to be rejected.
                            </div>
                            <div class="form-check apply-terms-check p-3 px-5 rounded border d-flex align-items-center gap-2" style="background-color: var(--input-bg); border-color: var(--border-color) !important;">
                                <input class="form-check-input m-0" type="checkbox" value="1" id="agree" required style="accent-color: var(--btn-primary);">
                                <label class="form-check-label fw-bold text-uppercase text-white" for="agree" style="font-size: 0.8rem; cursor: pointer;">
                                    YES, I AGREE TO THE TERMS & CONDITIONS *
                                </label>
                            </div>
                        </div>

                        </section>
                        <div class="apply-wizard-navigation">
                            <button type="button" id="wizardBack" class="d-none"><i class="fas fa-arrow-left me-1"></i> Back</button>
                            <button type="button" id="wizardNext">Next <i class="fas fa-arrow-right ms-1"></i></button>
                            <button type="submit" id="wizardSubmit" class="btn-submit d-none">Submit Application <i class="fas fa-paper-plane ms-1"></i></button>
                        </div>
                    </form>
            </div>
        </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="date"]').forEach(function(dateInput) {
                dateInput.addEventListener('focus', function() {
                    if (typeof this.showPicker === 'function') {
                        this.showPicker();
                    }
                });
            });

            const typeSelect = document.getElementById('visa_type_select');
            const visaCategoryInput = document.getElementById('visa_category_input');
            const drivingLicenseField = document.getElementById('drivingLicenseField');
            const nationalitySelect = document.getElementById('nationality_select');
            const mobileNumberInput = document.getElementById('mobile_number_input');
            const mobileNumberHint = document.getElementById('mobile_number_hint');
            const nationalIdentityInput = document.getElementById('national_identity_input');
            const nationalIdentityHint = document.getElementById('national_identity_hint');
            const destinationCountrySelect = document.getElementById('destination_country_select');
            const availableJobsSection = document.getElementById('availableJobsSection');
            const availableJobsList = document.getElementById('availableJobsList');
            const availableJobs = @json($jobs);
            const visaCategories = @json($categories);
            const selectedJobIds = new Set();
            const applicationForm = document.getElementById('visaApplicationForm');
            const wizardSteps = Array.from(applicationForm.querySelectorAll('[data-wizard-step]'));
            const wizardIndicators = Array.from(document.querySelectorAll('[data-step-indicator]'));
            const wizardTitle = document.getElementById('applyStepTitle');
            const wizardDescription = document.getElementById('applyStepDescription');
            const wizardIcon = document.getElementById('applyStepIcon');
            const wizardBack = document.getElementById('wizardBack');
            const wizardHeaderBack = document.getElementById('wizardHeaderBack');
            const wizardNext = document.getElementById('wizardNext');
            const wizardSubmit = document.getElementById('wizardSubmit');
            const wizardCopy = [
                {
                    title: 'Personal Details',
                    description: 'Please provide your personal information as per your passport.',
                    icon: '<i class="far fa-user"></i>',
                },
                {
                    title: 'Additional Details',
                    description: 'Add your passport details and upload your passport-size photo.',
                    icon: '<i class="far fa-id-card"></i>',
                },
                {
                    title: 'Destination & Profession',
                    description: 'Please select your destination country and profession details.',
                    icon: '<i class="fas fa-globe"></i>',
                },
            ];
            let activeWizardStep = @json(
                $errors->has('destination_country') || $errors->has('visa_type') || $errors->has('selected_job_ids') || $errors->has('driving_license_available')
                    ? 2
                    : ($errors->has('passport_number') || $errors->has('passport_expiry') ? 1 : 0)
            );

            function showWizardStep(stepIndex) {
                activeWizardStep = stepIndex;
                wizardSteps.forEach((step, index) => step.classList.toggle('d-none', index !== stepIndex));
                wizardIndicators.forEach((indicator, index) => {
                    indicator.classList.toggle('is-active', index === stepIndex);
                    indicator.classList.toggle('is-complete', index < stepIndex);
                    const icon = indicator.querySelector('.apply-stepper-icon');
                    if (index < stepIndex) {
                        icon.innerHTML = '<i class="fas fa-check"></i>';
                    } else if (index === stepIndex) {
                        icon.innerHTML = wizardCopy[index].icon;
                    } else {
                        icon.textContent = String(index + 1);
                    }
                });

                wizardTitle.textContent = wizardCopy[stepIndex].title;
                wizardDescription.textContent = wizardCopy[stepIndex].description;
                wizardIcon.innerHTML = wizardCopy[stepIndex].icon;
                wizardBack.classList.toggle('d-none', stepIndex === 0);
                wizardNext.classList.toggle('d-none', stepIndex === wizardSteps.length - 1);
                wizardSubmit.classList.toggle('d-none', stepIndex !== wizardSteps.length - 1);
            }

            function validateWizardStep(stepIndex) {
                const invalidField = wizardSteps[stepIndex].querySelector(':invalid');
                if (!invalidField) return true;
                invalidField.reportValidity();
                invalidField.focus();
                return false;
            }

            wizardNext.addEventListener('click', function() {
                if (validateWizardStep(activeWizardStep)) {
                    showWizardStep(Math.min(activeWizardStep + 1, wizardSteps.length - 1));
                }
            });
            wizardBack.addEventListener('click', function() {
                showWizardStep(Math.max(activeWizardStep - 1, 0));
            });
            wizardHeaderBack.addEventListener('click', function() {
                if (activeWizardStep > 0) {
                    showWizardStep(activeWizardStep - 1);
                    return;
                }
                window.location.href = @json(url('/'));
            });
            applicationForm.addEventListener('submit', function(event) {
                for (let stepIndex = 0; stepIndex < wizardSteps.length; stepIndex += 1) {
                    const invalidField = wizardSteps[stepIndex].querySelector(':invalid');
                    if (invalidField) {
                        event.preventDefault();
                        showWizardStep(stepIndex);
                        invalidField.reportValidity();
                        invalidField.focus();
                        return;
                    }
                }
            });
            showWizardStep(activeWizardStep);

            function updateVisaCategory() {
                const selectedProfession = typeSelect.options[typeSelect.selectedIndex];
                visaCategoryInput.value = selectedProfession ? selectedProfession.dataset.categoryName || '' : '';
            }

            function renderAvailableJobs() {
                const selectedCountry = destinationCountrySelect.value.trim().toLowerCase();
                const selectedCountryOption = destinationCountrySelect.options[destinationCountrySelect.selectedIndex];
                const selectedCountryId = selectedCountryOption ? String(selectedCountryOption.dataset.id || '') : '';
                const selectedProfession = typeSelect.value.trim().toLowerCase();

                availableJobsList.replaceChildren();
                if (!selectedCountry || !selectedProfession) {
                    selectedJobIds.clear();
                    availableJobsSection.classList.add('d-none');
                    return;
                }

                availableJobsSection.classList.remove('d-none');
                const matchingJobs = availableJobs.filter(job => {
                    const jobCountry = (job.country_location || '').trim().toLowerCase();
                    const jobProfession = (job.profession || '').trim().toLowerCase();
                    return (jobCountry === selectedCountry || jobCountry === 'all country (global multi-select)')
                        && jobProfession === selectedProfession;
                });
                const visibleJobIds = new Set(matchingJobs.map(job => String(job.id)));
                selectedJobIds.forEach(jobId => {
                    if (!visibleJobIds.has(jobId)) selectedJobIds.delete(jobId);
                });

                if (matchingJobs.length === 0) {
                    const emptyMessage = document.createElement('p');
                    emptyMessage.className = 'small text-muted mb-0';
                    emptyMessage.textContent = 'No job available right now';
                    availableJobsList.appendChild(emptyMessage);
                    return;
                }

                matchingJobs.forEach(job => {
                    const item = document.createElement('article');
                    item.className = 'available-job-card border rounded p-3 mb-2';

                    const title = document.createElement('h6');
                    title.className = 'mb-1';
                    title.textContent = job.job_title || 'Job Opening';

                    const details = document.createElement('p');
                    details.className = 'job-card-summary small mb-2';
                    const fallbackSalary = job.salary !== null && job.salary !== ''
                        ? `${Number(job.salary).toLocaleString()} ${job.salary_currency || ''}${job.salary_period ? ` / ${job.salary_period}` : ''}`
                        : '';
                    let salary = fallbackSalary;
                    if (job.salary_by_country) {
                        try {
                            const salaryRows = Array.isArray(job.salary_by_country)
                                ? job.salary_by_country
                                : JSON.parse(job.salary_by_country);
                            if (Array.isArray(salaryRows) && salaryRows.length) {
                                const normalizedCountry = country => (country || '').trim().toLowerCase();
                                const selectedCountrySalary = salaryRows.find(row =>
                                    row
                                    && normalizedCountry(row.country) === selectedCountry
                                    && row.amount !== null
                                    && row.amount !== ''
                                ) || salaryRows.find(row =>
                                    row
                                    && normalizedCountry(row.country) === 'all country (global multi-select)'
                                    && row.amount !== null
                                    && row.amount !== ''
                                );
                                salary = selectedCountrySalary
                                    ? `${Number(selectedCountrySalary.amount).toLocaleString()} ${selectedCountrySalary.currency || job.salary_currency || ''}${selectedCountrySalary.period ? ` / ${selectedCountrySalary.period}` : ''}`
                                    : '';
                            }
                        } catch (error) {
                            console.error('Unable to read country-specific salary details for a job.', error);
                        }
                    }
                    const summaryLines = [];
                    if (job.profession) summaryLines.push(`Profession: ${job.profession}`);
                    if (salary) summaryLines.push(`Salary: ${salary}`);
                    if (job.number_of_vacancies) summaryLines.push(`Vacancies: ${job.number_of_vacancies}`);
                    details.textContent = '';
                    summaryLines.forEach((line, index) => {
                        if (index) details.appendChild(document.createElement('br'));
                        details.appendChild(document.createTextNode(line));
                    });
                    item.append(title, details);

                    const detailContent = document.createElement('div');
                    detailContent.className = 'job-card-details small d-none';

                    let jobCategoryIds = [];
                    try {
                        jobCategoryIds = Array.isArray(job.category_ids) ? job.category_ids : JSON.parse(job.category_ids || '[]');
                    } catch (error) {
                        console.error('Unable to read visa types assigned to a job.', error);
                    }
                    const categoryNames = Array.isArray(jobCategoryIds)
                        ? jobCategoryIds
                            .map(categoryId => visaCategories.find(category =>
                                String(category.id) === String(categoryId)
                                && (!category.country_id || String(category.country_id) === selectedCountryId)
                            ))
                            .filter(Boolean)
                            .map(category => category.name)
                        : [];
                    if (categoryNames.length) {
                        const categoriesDetail = document.createElement('p');
                        categoriesDetail.className = 'small mb-2';
                        categoriesDetail.textContent = `Visa categories: ${categoryNames.join(', ')}`;
                        detailContent.appendChild(categoriesDetail);
                    }

                    const detailGrid = document.createElement('div');
                    detailGrid.className = 'row g-2 small mb-3';
                    const addJobDetail = (label, value) => {
                        if (value === null || value === undefined || value === '') return;
                        const detail = document.createElement('div');
                        detail.className = 'col-sm-6';
                        const detailLabel = document.createElement('strong');
                        detailLabel.textContent = `${label}: `;
                        const detailValue = document.createElement('span');
                        detailValue.textContent = value;
                        detail.append(detailLabel, detailValue);
                        detailGrid.appendChild(detail);
                    };
                    const workingDays = (() => {
                        if (Array.isArray(job.working_days)) return job.working_days;
                        try {
                            const parsedDays = JSON.parse(job.working_days || '[]');
                            return Array.isArray(parsedDays) ? parsedDays : [];
                        } catch (error) {
                            console.error('Unable to read working days for a job.', error);
                            return [];
                        }
                    })();
                    const benefits = [
                        ['Accommodation', job.accommodation_provided],
                        ['Food allowance', job.food_allowance_provided],
                        ['Medical insurance', job.medical_insurance],
                        ['Air ticket', job.ticket_provided],
                    ].map(([benefit, provided]) => `${benefit}: ${Number(provided) === 1 ? 'Provided' : 'Not provided'}`);

                    const cityList = (() => {
                        if (!job.city_locations) return '';
                        try {
                            const parsedCityMap = JSON.parse(job.city_locations || '{}');
                            if (!parsedCityMap || typeof parsedCityMap !== 'object') return '';
                            const countryCities = parsedCityMap[selectedCountryId] || parsedCityMap[selectedCountry] || [];
                            const cities = Array.isArray(countryCities)
                                ? countryCities.filter(city => typeof city === 'string' && city.trim() !== '')
                                : [];
                            return cities.join(', ');
                        } catch (error) {
                            console.error('Unable to read city locations for a job.', error);
                            return '';
                        }
                    })();

                    addJobDetail('Country / City', cityList
                        ? `${destinationCountrySelect.value}: ${cityList}`
                        : job.country_location);
                    addJobDetail('Profession', job.profession);
                    addJobDetail('Working hours', job.working_hours);
                    addJobDetail('Working days', workingDays.join(', '));
                    addJobDetail('Contract duration', job.contract_duration);
                    addJobDetail('Paid leave after one year', job.paid_leave_days_after_one_year !== null && job.paid_leave_days_after_one_year !== ''
                        ? `${job.paid_leave_days_after_one_year} days`
                        : '');
                    addJobDetail('Overtime policy', job.overtime_policy);
                    addJobDetail('Benefits', benefits.join(' | '));
                    if (detailGrid.childElementCount) detailContent.appendChild(detailGrid);

                    const appendJobText = (label, value) => {
                        if (!value) return;
                        const textBlock = document.createElement('div');
                        textBlock.className = 'small mb-2';
                        const textLabel = document.createElement('strong');
                        textLabel.textContent = `${label}: `;
                        const textContent = document.createElement('span');
                        textContent.textContent = value;
                        textBlock.append(textLabel, textContent);
                        detailContent.appendChild(textBlock);
                    };
                    appendJobText('Job description', job.job_description);
                    appendJobText('Requirements / qualifications', job.requirements);

                    const applyCheckbox = document.createElement('input');
                    applyCheckbox.type = 'checkbox';
                    applyCheckbox.name = 'selected_job_ids[]';
                    applyCheckbox.value = job.id;
                    applyCheckbox.checked = selectedJobIds.has(String(job.id));
                    applyCheckbox.style.display = 'none';
                    applyCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            selectedJobIds.clear();
                            availableJobsList.querySelectorAll('input[name="selected_job_ids[]"]').forEach(selectedCheckbox => {
                                if (selectedCheckbox !== this && selectedCheckbox.checked) {
                                    selectedCheckbox.checked = false;
                                    selectedCheckbox.dispatchEvent(new Event('change'));
                                }
                            });
                            selectedJobIds.add(String(job.id));
                        }
                        if (!this.checked) selectedJobIds.delete(String(job.id));
                        selectButton.innerHTML = this.checked
                            ? '<i class="fas fa-check-circle"></i> Selected'
                            : '<i class="fas fa-check-circle"></i> Select Job';
                        selectButton.classList.toggle('is-selected', this.checked);
                        selectButton.setAttribute('aria-pressed', String(this.checked));
                    });

                    const selectButton = document.createElement('button');
                    selectButton.type = 'button';
                    selectButton.className = `btn select-job-button${applyCheckbox.checked ? ' is-selected' : ''}`;
                    selectButton.setAttribute('aria-pressed', String(applyCheckbox.checked));
                    selectButton.innerHTML = applyCheckbox.checked
                        ? '<i class="fas fa-check-circle"></i> Selected'
                        : '<i class="fas fa-check-circle"></i> Select Job';
                    selectButton.addEventListener('click', function() {
                        applyCheckbox.checked = !applyCheckbox.checked;
                        applyCheckbox.dispatchEvent(new Event('change'));
                    });

                    const descriptionButton = document.createElement('button');
                    descriptionButton.type = 'button';
                    descriptionButton.className = 'btn description-job-button';
                    descriptionButton.innerHTML = '<i class="fas fa-file-alt"></i> View Full Description';
                    descriptionButton.addEventListener('click', function() {
                        const showingDetails = !detailContent.classList.contains('d-none');
                        detailContent.classList.toggle('d-none', showingDetails);
                        descriptionButton.innerHTML = showingDetails
                            ? '<i class="fas fa-file-alt"></i> View Full Description'
                            : '<i class="fas fa-chevron-up"></i> Hide Full Description';
                    });

                    const actions = document.createElement('div');
                    actions.className = 'job-card-actions';
                    actions.append(applyCheckbox, selectButton, descriptionButton);
                    item.append(actions, detailContent);
                    availableJobsList.appendChild(item);
                });
            }

            function updateNationalityPhoneCode() {
                const selectedOption = nationalitySelect.options[nationalitySelect.selectedIndex];
                const phoneCode = selectedOption ? (selectedOption.dataset.phoneCode || '').trim() : '';
                const phoneDigitLength = Number.parseInt(selectedOption ? selectedOption.dataset.phoneLength : '', 10);
                const previousCode = mobileNumberInput.dataset.nationalityPhoneCode || '';
                const currentNumber = mobileNumberInput.value.trim();

                if (previousCode && currentNumber.startsWith(previousCode)) {
                    mobileNumberInput.value = phoneCode
                        ? `${phoneCode}${currentNumber.slice(previousCode.length)}`
                        : currentNumber.slice(previousCode.length).trimStart();
                } else if (!currentNumber && phoneCode) {
                    mobileNumberInput.value = `${phoneCode} `;
                }

                mobileNumberInput.dataset.nationalityPhoneCode = phoneCode;
                mobileNumberInput.dataset.phoneNumberLength = Number.isInteger(phoneDigitLength) && phoneDigitLength > 0
                    ? String(phoneDigitLength)
                    : '';
                if (mobileNumberInput.dataset.phoneNumberLength) {
                    mobileNumberHint.textContent = `Enter no more than ${phoneDigitLength} phone number digits, excluding the country code.`;
                    mobileNumberHint.classList.remove('d-none');
                } else {
                    mobileNumberHint.textContent = '';
                    mobileNumberHint.classList.add('d-none');
                }
                enforcePhoneNumberLength();
            }

            nationalitySelect.addEventListener('change', updateNationalityPhoneCode);
            updateNationalityPhoneCode();

            function enforcePhoneNumberLength() {
                const digitLength = Number.parseInt(mobileNumberInput.dataset.phoneNumberLength || '', 10);
                if (!Number.isInteger(digitLength) || digitLength < 1) {
                    return;
                }

                const phoneCode = mobileNumberInput.dataset.nationalityPhoneCode || '';
                const value = mobileNumberInput.value;
                const prefix = phoneCode && value.startsWith(phoneCode) ? value.slice(0, phoneCode.length) : '';
                const subscriberNumber = value.slice(prefix.length);
                let remainingDigits = digitLength;
                const limitedSubscriberNumber = subscriberNumber.replace(/\d/g, digit => {
                    if (remainingDigits === 0) {
                        return '';
                    }
                    remainingDigits -= 1;
                    return digit;
                });
                const limitedValue = `${prefix}${limitedSubscriberNumber}`;
                if (limitedValue !== value) {
                    mobileNumberInput.value = limitedValue;
                }
            }

            mobileNumberInput.addEventListener('input', enforcePhoneNumberLength);

            function updateNationalIdentityLength() {
                const selectedOption = nationalitySelect.options[nationalitySelect.selectedIndex];
                const digitLength = Number.parseInt(selectedOption ? selectedOption.dataset.idLength : '', 10);
                const hasConfiguredLength = Number.isInteger(digitLength) && digitLength > 0;

                if (hasConfiguredLength) {
                    nationalIdentityInput.maxLength = digitLength;
                    nationalIdentityInput.minLength = digitLength;
                    nationalIdentityInput.pattern = `[0-9]{${digitLength}}`;
                    nationalIdentityInput.inputMode = 'numeric';
                    nationalIdentityInput.placeholder = `Enter exactly ${digitLength} digits`;
                    nationalIdentityInput.title = `Enter exactly ${digitLength} digits`;
                    nationalIdentityHint.textContent = `Enter exactly ${digitLength} digits.`;
                    nationalIdentityHint.classList.remove('d-none');
                    nationalIdentityInput.value = nationalIdentityInput.value.replace(/\D/g, '').slice(0, digitLength);
                } else {
                    nationalIdentityInput.maxLength = 100;
                    nationalIdentityInput.removeAttribute('minlength');
                    nationalIdentityInput.removeAttribute('pattern');
                    nationalIdentityInput.removeAttribute('inputmode');
                    nationalIdentityInput.placeholder = 'National Identity/Aadhaar Card';
                    nationalIdentityInput.removeAttribute('title');
                    nationalIdentityHint.textContent = '';
                    nationalIdentityHint.classList.add('d-none');
                }
            }

            nationalitySelect.addEventListener('change', updateNationalIdentityLength);
            updateNationalIdentityLength();
            nationalIdentityInput.addEventListener('input', function() {
                const selectedOption = nationalitySelect.options[nationalitySelect.selectedIndex];
                const digitLength = Number.parseInt(selectedOption ? selectedOption.dataset.idLength : '', 10);

                if (Number.isInteger(digitLength) && digitLength > 0) {
                    this.value = this.value.replace(/\D/g, '').slice(0, digitLength);
                }
            });

            function toggleDrivingLicenseField() {
                const selectedValue = typeSelect.value || '';
                const shouldShow = /driver|chauffeur/i.test(selectedValue);

                drivingLicenseField.classList.toggle('d-none', !shouldShow);
                if (!shouldShow) {
                    document.querySelectorAll('input[name="driving_license_available"]').forEach(input => input.checked = false);
                }
            }

            function updateProfessionSelection() {
                toggleDrivingLicenseField();
                renderAvailableJobs();
            }

            typeSelect.addEventListener('change', function() {
                updateVisaCategory();
                toggleDrivingLicenseField();
                renderAvailableJobs();
            });
            destinationCountrySelect.addEventListener('change', function() {
                renderAvailableJobs();
            });

            updateVisaCategory();
            updateProfessionSelection();
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
