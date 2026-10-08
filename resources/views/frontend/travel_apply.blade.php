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
        #availableJobsList .available-job-card:hover .job-card-summary {
            color: var(--text-main) !important;
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <!-- Sub-Banner Header -->
        <div class="visa-hero-section" style="min-height: 350px; padding: 40px 5%; background-position: top center;">
            <div class="hero-overlay-content reveal reveal-left" style="max-width: 100%;">
                <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; Apply for Visa</p>
                <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">Apply for Visa</h2>
                <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Fill in your details and submit your application. It's fast, secure and easy.</p>
            </div>
        </div>

        <div class="section-wrapper-global" style="padding-top: 40px; padding-bottom: 60px;">

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

            <!-- Form & Sidebar Dual Layout Grid -->
            <div class="form-sidebar-grid">
                <!-- Left Side: Form Block -->
                <div class="premium-dark-box reveal reveal-up delay-1">
                    <h4 class="fw-bold mb-4" style="font-size: 1.25rem; color: var(--text-main); border-left: 3px solid var(--btn-primary); padding-left: 12px; line-height: 1.2;">Personal Details<br><small style="font-size: 0.8rem; font-weight: normal; color: var(--text-muted);">Please provide your personal information as per your passport.</small></h4>

                    <form action="{{ route('travel.apply.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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

                        <div class="form-group">
                            <label>VISA CATEGORY *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-briefcase"></i>
                                <select id="visa_category_select" name="visa_category" class="visa-type-selector form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Visa Category</option>
                                    @if(isset($categories) && count($categories) > 0)
                                        @php
                                            $defaultCategoryId = null;
                                            foreach ($categories as $cat) {
                                                $name = strtolower($cat->name ?? '');
                                                if (str_contains($name, 'hospital') || str_contains($name, 'medical')) {
                                                    $defaultCategoryId = $cat->id;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->name }}" data-id="{{ $cat->id }}" data-country-id="{{ $cat->country_id ?? '' }}" {{ (($defaultCategoryId && $cat->id == $defaultCategoryId) || old('visa_category') == $cat->name) ? 'selected' : '' }}>{{ strtoupper($cat->name) }}</option>
                                        @endforeach
                                    @else
                                        <option value="Work Visa" selected>WORK VISA</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>PROFESSION *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user-tie"></i>
                                <select id="visa_type_select" name="visa_type" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Profession</option>
                                    @foreach($professions as $profession)
                                        <option value="{{ $profession->name }}" {{ old('visa_type') === $profession->name ? 'selected' : '' }}>{{ $profession->name }}</option>
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
                            <div class="form-check p-3 px-5 rounded border d-flex align-items-center gap-2" style="background-color: var(--input-bg); border-color: var(--border-color) !important;">
                                <input class="form-check-input m-0" type="checkbox" value="1" id="agree" required style="accent-color: var(--btn-primary);">
                                <label class="form-check-label fw-bold text-uppercase text-white" for="agree" style="font-size: 0.8rem; cursor: pointer;">
                                    YES, I AGREE TO THE TERMS & CONDITIONS *
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit mt-4 py-3" style="border-radius: 50px;">
                            Submit Application <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Side: Sticky Info Widget Panels -->
                <div class="sidebar-sticky-panel reveal reveal-up delay-2">
                    <div class="sidebar-widget-card mt-4">
                        <h4>Need Help?</h4>
                        <p class="text-muted mb-4" style="font-size: 0.85rem; line-height: 1.5;">Our support team is available 24/7 to assist you with your visa application.</p>

                        <div class="help-contact-row">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <p>24/7 Support Helpline</p>
                                <h5>{{ $settings->phone ?? '+92 300 123 4567' }}</h5>
                            </div>
                        </div>
                        <div class="help-contact-row">
                            <i class="far fa-envelope"></i>
                            <div>
                                <p>Email Support</p>
                                <h5>{{ $settings->email ?? 'info@visabook.com' }}</h5>
                            </div>
                        </div>

                        <a href="#" class="btn-submit mt-3 py-2" style="background: transparent; border: 1px solid var(--btn-primary); color: var(--primary-color); font-size: 0.9rem;"><i class="far fa-comments"></i> Live Chat</a>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
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

            const catSelect = document.getElementById('visa_category_select');
            const typeSelect = document.getElementById('visa_type_select');
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
            const categoriesById = @json($categories->mapWithKeys(fn ($category) => [(string) $category->id => $category->name]));
            const selectedJobIds = new Set();

            function filterCategories(resetSelection) {
                const selectedCountryOption = destinationCountrySelect.options[destinationCountrySelect.selectedIndex];
                const selectedCountryId = selectedCountryOption ? selectedCountryOption.dataset.id : '';
                const currentCategoryOption = catSelect.options[catSelect.selectedIndex];

                Array.from(catSelect.options).forEach(option => {
                    if (!option.value) {
                        option.hidden = false;
                        return;
                    }
                    const categoryCountryId = option.dataset.countryId || '';
                    option.hidden = Boolean(categoryCountryId && categoryCountryId !== selectedCountryId);
                });

                if (resetSelection || (currentCategoryOption && currentCategoryOption.hidden)) {
                    catSelect.value = '';
                }
            }

            function renderAvailableJobs() {
                const selectedCountry = destinationCountrySelect.value.trim().toLowerCase();
                const selectedCategory = catSelect.value.trim();
                const selectedProfession = typeSelect.value.trim().toLowerCase();

                availableJobsList.replaceChildren();
                if (!selectedCountry || !selectedCategory || !selectedProfession) {
                    selectedJobIds.clear();
                    availableJobsSection.classList.add('d-none');
                    return;
                }

                availableJobsSection.classList.remove('d-none');
                const matchingJobs = availableJobs.filter(job => {
                    const jobCountry = (job.country_location || '').trim().toLowerCase();
                    const jobProfession = (job.profession || '').trim().toLowerCase();
                    const selectedCategoryOption = catSelect.options[catSelect.selectedIndex];
                    const selectedCategoryId = selectedCategoryOption ? Number.parseInt(selectedCategoryOption.dataset.id, 10) : null;
                    let jobCategoryIds = [];
                    try {
                        jobCategoryIds = Array.isArray(job.category_ids) ? job.category_ids : JSON.parse(job.category_ids || '[]');
                    } catch (error) {
                        console.error('Unable to read visa types assigned to a job.', error);
                        jobCategoryIds = [];
                    }
                    const belongsToSelectedCategory = selectedCategoryId !== null && jobCategoryIds.map(Number).includes(selectedCategoryId);

                    return (jobCountry === selectedCountry || jobCountry === 'all country (global multi-select)')
                        && belongsToSelectedCategory
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
                    title.className = 'mb-1 text-white';
                    title.textContent = job.job_title || 'Job Opening';

                    const details = document.createElement('p');
                    details.className = 'job-card-summary small text-muted mb-2';
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
                    const vacancies = job.number_of_vacancies ? `${job.number_of_vacancies} vacancies` : '';
                    details.textContent = [salary, vacancies].filter(Boolean).join(' | ');

                    let jobCategoryIds = [];
                    try {
                        jobCategoryIds = Array.isArray(job.category_ids) ? job.category_ids : JSON.parse(job.category_ids || '[]');
                    } catch (error) {
                        console.error('Unable to read visa types assigned to a job.', error);
                    }
                    const categoryNames = Array.isArray(jobCategoryIds)
                        ? jobCategoryIds.map(categoryId => categoriesById[String(categoryId)]).filter(Boolean)
                        : [];
                    if (categoryNames.length) {
                        const categoriesDetail = document.createElement('p');
                        categoriesDetail.className = 'small mb-2';
                        categoriesDetail.textContent = `Visa categories: ${categoryNames.join(', ')}`;
                        item.append(title, details, categoriesDetail);
                    } else {
                        item.append(title, details);
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
                            const cities = [];
                            Object.values(parsedCityMap).forEach(countryCities => {
                                if (Array.isArray(countryCities)) {
                                    countryCities.forEach(city => {
                                        if (city && !cities.includes(city)) cities.push(city);
                                    });
                                }
                            });
                            return cities.join(', ');
                        } catch (error) {
                            console.error('Unable to read city locations for a job.', error);
                            return '';
                        }
                    })();

                    addJobDetail('Country', job.country_location);
                    if (cityList) addJobDetail('City', cityList);
                    addJobDetail('Profession', job.profession);
                    addJobDetail('Working hours', job.working_hours);
                    addJobDetail('Working days', workingDays.join(', '));
                    addJobDetail('Contract duration', job.contract_duration);
                    addJobDetail('Paid leave after one year', job.paid_leave_days_after_one_year !== null && job.paid_leave_days_after_one_year !== ''
                        ? `${job.paid_leave_days_after_one_year} days`
                        : '');
                    addJobDetail('Overtime policy', job.overtime_policy);
                    addJobDetail('Benefits', benefits.join(' | '));
                    if (detailGrid.childElementCount) item.appendChild(detailGrid);

                    const appendJobText = (label, value) => {
                        if (!value) return;
                        const textBlock = document.createElement('div');
                        textBlock.className = 'small mb-2';
                        const textLabel = document.createElement('strong');
                        textLabel.textContent = `${label}: `;
                        const textContent = document.createElement('span');
                        textContent.textContent = value;
                        textBlock.append(textLabel, textContent);
                        item.appendChild(textBlock);
                    };
                    appendJobText('Job description', job.job_description);
                    appendJobText('Requirements / qualifications', job.requirements);

                    const applyLabel = document.createElement('div');
                    applyLabel.className = 'd-inline-flex mt-3 mb-0';
                    applyLabel.style.cursor = 'pointer';

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
                            applyButton.style.backgroundColor = '#16a34a';
                            applyButton.style.borderColor = '#16a34a';
                            applyButton.style.boxShadow = '0 0 0 3px rgba(22, 163, 74, 0.18)';
                            radioIndicator.style.backgroundColor = '#ffffff';
                            radioIndicator.style.borderColor = '#ffffff';
                            radioIndicator.innerHTML = '<span style="display:block;width:7px;height:7px;border-radius:50%;background:#16a34a;"></span>';
                        } else {
                            selectedJobIds.delete(String(job.id));
                            applyButton.style.backgroundColor = '#2563eb';
                            applyButton.style.borderColor = '#2563eb';
                            applyButton.style.boxShadow = '0 8px 18px rgba(37, 99, 235, 0.25)';
                            radioIndicator.style.backgroundColor = 'transparent';
                            radioIndicator.style.borderColor = '#ffffff';
                            radioIndicator.innerHTML = '';
                        }
                    });

                    const applyButton = document.createElement('span');
                    applyButton.className = 'btn btn-sm px-3 py-2';
                    applyButton.style.backgroundColor = applyCheckbox.checked ? '#16a34a' : '#2563eb';
                    applyButton.style.border = `1px solid ${applyCheckbox.checked ? '#16a34a' : '#2563eb'}`;
                    applyButton.style.color = '#ffffff';
                    applyButton.style.borderRadius = '8px';
                    applyButton.style.fontWeight = '600';
                    applyButton.style.boxShadow = applyCheckbox.checked ? '0 0 0 3px rgba(22, 163, 74, 0.18)' : '0 8px 18px rgba(37, 99, 235, 0.25)';
                    applyButton.style.transition = 'all 0.2s ease';
                    applyButton.style.display = 'inline-flex';
                    applyButton.style.alignItems = 'center';
                    applyButton.style.gap = '8px';
                    applyButton.addEventListener('click', function() {
                        applyCheckbox.checked = !applyCheckbox.checked;
                        applyCheckbox.dispatchEvent(new Event('change'));
                    });

                    const radioIndicator = document.createElement('span');
                    radioIndicator.style.width = '18px';
                    radioIndicator.style.height = '18px';
                    radioIndicator.style.borderRadius = '50%';
                    radioIndicator.style.border = '2px solid #ffffff';
                    radioIndicator.style.display = 'inline-flex';
                    radioIndicator.style.alignItems = 'center';
                    radioIndicator.style.justifyContent = 'center';
                    radioIndicator.style.background = applyCheckbox.checked ? '#ffffff' : 'transparent';
                    radioIndicator.style.boxShadow = '0 0 0 2px rgba(255,255,255,0.18)';
                    radioIndicator.style.marginRight = '8px';
                    radioIndicator.innerHTML = applyCheckbox.checked ? '<span style="display:block;width:7px;height:7px;border-radius:50%;background:#16a34a;"></span>' : '';
                    radioIndicator.style.position = 'relative';
                    radioIndicator.style.zIndex = '1';

                    const buttonText = document.createElement('span');
                    buttonText.textContent = 'Apply for this job';

                    applyButton.append(radioIndicator, buttonText);
                    applyLabel.append(applyCheckbox);
                    applyLabel.append(applyButton);

                    item.appendChild(applyLabel);
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

            typeSelect.addEventListener('change', toggleDrivingLicenseField);
            typeSelect.addEventListener('change', renderAvailableJobs);
            destinationCountrySelect.addEventListener('change', function() {
                filterCategories(true);
                renderAvailableJobs();
            });

            catSelect.addEventListener('change', function() {
                renderAvailableJobs();
            });

            filterCategories(false);
            updateProfessionSelection();
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
