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
                                        <option value="{{ $nationality->name }}" data-phone-code="{{ $nationality->phone_code ?? '' }}" data-id-length="{{ $nationality->id_number_length ?? '' }}" data-currency="{{ $nationality->currency ?? '' }}" {{ old('nationality') == $nationality->name ? 'selected' : '' }}>{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>National Identity/Aadhaar Card *</label>
                            <div class="input-with-icon">
                                <i class="far fa-id-card"></i>
                                <input id="national_identity_input" type="text" name="national_identity" value="{{ old('national_identity') }}" placeholder="National Identity/Aadhaar Card" maxlength="100" required>
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
                                    <input id="mobile_number_input" type="text" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Active WhatsApp Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>DATE OF BIRTH *</label>
                                <div class="input-with-icon">
                                    <i class="far fa-calendar-alt"></i>
                                    <input type="text" name="dob" value="{{ old('dob') }}" placeholder="DD/MM/YYYY" required>
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
                                    <input type="text" name="passport_expiry" value="{{ old('passport_expiry') }}" placeholder="DD-MM-YYYY" required>
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
                            <input type="text" class="form-control mb-2 searchable-select-input" data-target="destination_country_select" placeholder="Search country..." aria-label="Search country">
                            <div class="input-with-icon">
                                <i class="fas fa-globe"></i>
                                <select id="destination_country_select" name="destination_country" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Country</option>
                                    @foreach($countries as $country)
                                        @php
                                            $countryFees = json_decode($country->visa_fee_details ?? '[]', true);
                                            $countryFees = is_array($countryFees) ? $countryFees : [];
                                            if (empty($countryFees) && $country->visa_fee !== null) {
                                                $countryFees[] = [
                                                    'currency' => $country->currency ?: 'PKR',
                                                    'fee' => $country->visa_fee,
                                                ];
                                            }
                                        @endphp
                                        <option value="{{ $country->name }}" data-fees="{{ json_encode($countryFees) }}" {{ old('destination_country') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                    @if(count($countries) == 0)
                                        <option>United Arab Emirates</option>
                                        <option>Saudi Arabia</option>
                                        <option>Qatar</option>
                                    @endif
                                </select>
                            </div>
                            <div id="destination_country_fee" class="mt-2 small text-white" aria-live="polite"></div>
                        </div>

                        <div class="form-group">
                            <label>VISA CATEGORY *</label>
                            <input type="text" class="form-control mb-2 searchable-select-input" data-target="visa_category_select" placeholder="Search category..." aria-label="Search visa category">
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
                                            <option value="{{ $cat->name }}" data-id="{{ $cat->id }}" {{ (($defaultCategoryId && $cat->id == $defaultCategoryId) || old('visa_category') == $cat->name) ? 'selected' : '' }}>{{ strtoupper($cat->name) }}</option>
                                        @endforeach
                                    @else
                                        <option value="Work Visa" selected>WORK VISA</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>WORK TYPE / SUBCATEGORY OF VISA TYPE *</label>
                            <div class="input-with-icon">
                                <i class="far fa-list-alt"></i>
                                <select id="visa_type_select" name="visa_type" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Work Type / Subcategory</option>
                                </select>
                            </div>
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
            const catSelect = document.getElementById('visa_category_select');
            const typeSelect = document.getElementById('visa_type_select');
            const drivingLicenseField = document.getElementById('drivingLicenseField');
            const nationalitySelect = document.getElementById('nationality_select');
            const mobileNumberInput = document.getElementById('mobile_number_input');
            const nationalIdentityInput = document.getElementById('national_identity_input');
            const nationalIdentityHint = document.getElementById('national_identity_hint');
            const destinationCountrySelect = document.getElementById('destination_country_select');
            const destinationCountryFee = document.getElementById('destination_country_fee');

            function updateDestinationVisaFee() {
                const selectedOption = destinationCountrySelect.options[destinationCountrySelect.selectedIndex];
                const nationalityOption = nationalitySelect.options[nationalitySelect.selectedIndex];
                const currency = nationalityOption ? (nationalityOption.dataset.currency || '').trim().toUpperCase() : '';
                let fees = [];

                try {
                    fees = selectedOption ? JSON.parse(selectedOption.dataset.fees || '[]') : [];
                } catch (error) {
                    fees = [];
                }

                destinationCountryFee.replaceChildren();
                if (!selectedOption || !selectedOption.value) return;

                if (!currency) {
                    destinationCountryFee.textContent = 'Currency is not configured for this nationality.';
                    return;
                }

                const matchingFee = fees.find(entry => (entry.currency || '').trim().toUpperCase() === currency
                    && Number.isFinite(Number(entry.fee)));

                if (!matchingFee) {
                    destinationCountryFee.textContent = `Visa fee is not available in ${currency} for this country.`;
                    return;
                }

                destinationCountryFee.textContent = `Visa fee: ${currency} ${Number(matchingFee.fee).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            }

            destinationCountrySelect.addEventListener('change', updateDestinationVisaFee);
            nationalitySelect.addEventListener('change', updateDestinationVisaFee);
            updateDestinationVisaFee();

            function updateNationalityPhoneCode() {
                const selectedOption = nationalitySelect.options[nationalitySelect.selectedIndex];
                const phoneCode = selectedOption ? (selectedOption.dataset.phoneCode || '').trim() : '';
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
            }

            nationalitySelect.addEventListener('change', updateNationalityPhoneCode);
            updateNationalityPhoneCode();

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

            document.querySelectorAll('.searchable-select-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    const targetId = input.dataset.target;
                    const select = document.getElementById(targetId);
                    if (!select) return;

                    const searchValue = this.value.trim().toLowerCase();
                    Array.from(select.options).forEach(function(option) {
                        if (!option.value) {
                            option.hidden = false;
                            return;
                        }

                        const optionText = option.textContent.toLowerCase();
                        option.hidden = searchValue !== '' && !optionText.includes(searchValue);
                    });
                });
            });

            function isDriverType(value) {
                const text = (value || '').toLowerCase();
                return text.includes('driver') || text.includes('chauffeur');
            }

            function toggleDrivingLicenseField() {
                const selectedValue = typeSelect.value || '';
                const shouldShow = isDriverType(selectedValue);

                drivingLicenseField.classList.toggle('d-none', !shouldShow);
                if (!shouldShow) {
                    document.querySelectorAll('input[name="driving_license_available"]').forEach(input => input.checked = false);
                }
            }

            async function updateVisaTypes(catId) {
                if (!catId) {
                    typeSelect.innerHTML = '<option value="" selected disabled>Select Visa Type</option>';
                    toggleDrivingLicenseField();
                    return;
                }

                typeSelect.innerHTML = '<option value="" selected disabled>Loading...</option>';
                try {
                    const response = await fetch(`/api/visa-types/${catId}`);
                    const types = await response.json();

                    typeSelect.innerHTML = '<option value="" selected disabled>Select Visa Type</option>';
                    if (types.length > 0) {
                        types.forEach(type => {
                            const option = document.createElement('option');
                            option.value = type.name;
                            option.textContent = type.name;
                            typeSelect.appendChild(option);
                        });

                        const firstDriverType = Array.from(typeSelect.options).find(option => isDriverType(option.value));
                        if (firstDriverType) {
                            typeSelect.value = firstDriverType.value;
                        }
                    } else {
                        const option = document.createElement('option');
                        option.value = "";
                        option.textContent = "No types available for this category";
                        typeSelect.appendChild(option);
                    }
                } catch (error) {
                    console.error('Error fetching visa types:', error);
                    typeSelect.innerHTML = '<option value="" selected disabled>Error loading types</option>';
                }

                toggleDrivingLicenseField();
            }

            typeSelect.addEventListener('change', toggleDrivingLicenseField);

            catSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                updateVisaTypes(selectedOption ? selectedOption.getAttribute('data-id') : null);
            });

            const selectedOption = catSelect.options[catSelect.selectedIndex];
            if (selectedOption) {
                updateVisaTypes(selectedOption.getAttribute('data-id'));
            }
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
