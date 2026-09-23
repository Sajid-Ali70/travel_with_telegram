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
            background-image: linear-gradient(180deg, rgba(3, 7, 18, 0.4) 0%, #030712 100%),
                              url('{{ $bannerUrl }}') !important;
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
                    <h4 class="fw-bold mb-4" style="font-size: 1.25rem; color: #fff; border-left: 3px solid var(--btn-primary); padding-left: 12px; line-height: 1.2;">Personal Details<br><small style="font-size: 0.8rem; font-weight: normal; color: var(--text-muted);">Please provide your personal information as per your passport.</small></h4>

                    <form action="{{ route('travel.apply.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>NATIONALITY *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-flag"></i>
                                <select name="nationality" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Nationality</option>
                                    @foreach($nationalities as $nationality)
                                        <option value="{{ $nationality->name }}" {{ old('nationality') == $nationality->name ? 'selected' : '' }}>{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Apply Date *</label>
                            <div class="input-with-icon">
                                <i class="far fa-calendar-alt"></i>
                                <input type="date" name="apply_date" value="{{ old('apply_date', date('Y-m-d')) }}" required>
                            </div>
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
                                <label>MOBILE NUMBER *</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone-alt"></i>
                                    <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="98XXXXXXXX" required>
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
                            <div class="input-with-icon">
                                <i class="fas fa-globe"></i>
                                <select name="destination_country" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" {{ old('destination_country') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                    @if(count($countries) == 0)
                                        <option>United Arab Emirates</option>
                                        <option>Saudi Arabia</option>
                                        <option>Qatar</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="visa-type-selector">
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $index => $cat)
                                    <div class="visa-type-option">
                                        <input type="radio" name="visa_category" class="visa-cat-radio" id="v_{{ $cat->id }}" value="{{ $cat->name }}" {{ ($index == 0 && !old('visa_category')) || old('visa_category') == $cat->name ? 'checked' : '' }} data-id="{{ $cat->id }}">
                                        <label for="v_{{ $cat->id }}" class="w-100 cursor-pointer m-0">
                                            <div class="mt-1"><i class="{{ $cat->icon ?? 'fas fa-briefcase' }} text-primary fs-5"></i></div>
                                            <div class="fw-bold mt-2 text-white" style="font-size: 0.9rem;">{{ strtoupper($cat->name) }}</div>
                                            <div class="text-muted" style="font-size: 0.8rem; margin-top: 2px;">{{ Str::limit($cat->description, 30) }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <div class="visa-type-option">
                                    <input type="radio" name="visa_category" id="v_work" value="Work Visa" checked>
                                    <label for="v_work" class="w-100 cursor-pointer m-0">
                                        <div class="mt-1"><i class="fas fa-briefcase text-primary fs-5"></i></div>
                                        <div class="fw-bold mt-2 text-white" style="font-size: 0.9rem;">WORK VISA</div>
                                        <div class="text-muted" style="font-size: 0.8rem; margin-top: 2px;">Category Employment</div>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>VISA TYPE / OCCUPATION *</label>
                            <div class="input-with-icon">
                                <i class="far fa-list-alt"></i>
                                <select id="visa_type_select" name="visa_type" class="form-select" required style="padding-left: 48px;">
                                    <option value="" selected disabled>Select Visa Type</option>
                                </select>
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
                    <div class="sidebar-widget-card">
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

                        <a href="#" class="btn-submit mt-3 py-2" style="background: transparent; border: 1px solid var(--btn-primary); color: #fff; font-size: 0.9rem;"><i class="far fa-comments"></i> Live Chat</a>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const catRadios = document.querySelectorAll('.visa-cat-radio');
            const typeSelect = document.getElementById('visa_type_select');

            async function updateVisaTypes(catId) {
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
            }

            catRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        updateVisaTypes(this.getAttribute('data-id'));
                    }
                });
            });

            // Initial load for checked radio
            const checkedRadio = document.querySelector('.visa-cat-radio:checked');
            if (checkedRadio) {
                updateVisaTypes(checkedRadio.getAttribute('data-id'));
            }
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
