@extends('admin.jobs.layout')

@php
    $isEditing = $job !== null;
    $countryValue = old('country_location', $job->country_location ?? '');
    $professionValue = old('profession', $job->profession ?? '');
    $jobTitleValue = old('job_title', $job->job_title ?? '');
    $workingDaysValue = old('working_days', $selectedWorkingDays);
    $selectedCategoryIds = collect(old('category_ids', json_decode($job->category_ids ?? '[]', true) ?: []))
        ->map(fn ($id) => (string) $id)
        ->all();
    $selectedCityLocations = old('city_locations', json_decode($job->city_locations ?? '[]', true) ?: []);
    $selectedGlobalCountryIds = collect(old('global_country_ids', json_decode($job->global_country_ids ?? '[]', true) ?: []))
        ->map(fn ($id) => (string) $id)
        ->all();
    if (!$selectedCategoryIds && $job) {
        $legacyCategory = $categories->firstWhere('name', $job->category_visa_type)
            ?? $categories->firstWhere('name', $job->category);
        if ($legacyCategory) {
            $selectedCategoryIds = [(string) $legacyCategory->id];
        }
    }
@endphp

@section('title', $isEditing ? 'Edit Job Posting' : 'Add Job Posting')

@section('content')
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Manage Jobs</a>
        <div>
            <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Job Posting' : 'Add Job Posting' }}</h1>
            <p class="text-muted mb-0">{{ $isEditing ? 'Update posting details.' : 'Create a new job posting.' }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ $isEditing ? route('admin.jobs.update', $job->id) : route('admin.jobs.add') }}" method="POST" class="admin-card">
        @csrf
        @if($isEditing) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-12"><h2 class="h5 mb-0">1. Job Basic Details</h2></div>
            <div class="col-md-6">
                <label for="job_title" class="form-label">Job Title</label>
                <input id="job_title" type="text" name="job_title" class="form-control" value="{{ $jobTitleValue }}" placeholder="Enter job title" maxlength="255" required>
            </div>
            <div class="col-md-6">
                <label for="profession" class="form-label">Profession</label>
                <select id="profession" name="profession" class="form-select" required>
                    <option value="">Select profession</option>
                    @if($professionValue && !$professions->contains('name', $professionValue))
                        <option value="{{ $professionValue }}" selected>{{ $professionValue }} (current)</option>
                    @endif
                    @foreach($professions as $profession)
                        <option value="{{ $profession->name }}" {{ $professionValue === $profession->name ? 'selected' : '' }}>{{ $profession->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="country_location" class="form-label">Country / Location</label>
                @if(isset($countries) && $countries->isNotEmpty())
                    <select id="country_location" name="country_location" class="form-select" required>
                        <option value="">Select country</option>
                        <option value="All Country (Global multi-select)" {{ $countryValue === 'All Country (Global multi-select)' ? 'selected' : '' }}>All Country (Global multi-select)</option>
                        @if($countryValue && !$countries->contains('name', $countryValue) && $countryValue !== 'All Country (Global multi-select)')
                            <option value="{{ $countryValue }}" selected>{{ $countryValue }}</option>
                        @endif
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" data-country-id="{{ $country->id }}" {{ $countryValue === $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                @else
                    <input id="country_location" type="text" name="country_location" class="form-control" value="{{ $countryValue }}" placeholder="e.g. Saudi Arabia" maxlength="255" required>
                @endif
            </div>
            <div class="col-md-6">
                <label for="number_of_vacancies" class="form-label">Number of Vacancies</label>
                <input id="number_of_vacancies" type="number" name="number_of_vacancies" class="form-control" value="{{ old('number_of_vacancies', $job->number_of_vacancies ?? 1) }}" min="1" required>
            </div>
            <div class="col-12">
                <section id="globalCountryMatrix" class="admin-card d-none p-3" aria-live="polite">
                    <div class="d-flex justify-content-between align-items-center gap-3 border-bottom border-secondary pb-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-globe text-primary"></i>
                            <div>
                                <h3 class="h6 mb-0">Global Country &amp; Visa Matrix</h3>
                                <small class="text-muted">Check countries and select valid visa types for each</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-light" id="selectAllCountriesBtn">Select All</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllCountriesBtn">Deselect All</button>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach($countries as $country)
                            @php
                                $countryCategories = $categories->where('country_id', $country->id);
                                $hasSelectedCountryCategory = $countryCategories->contains(fn ($category) => in_array((string) $category->id, $selectedCategoryIds, true));
                                $countryChecked = in_array((string) $country->id, $selectedGlobalCountryIds, true)
                                    || isset($selectedCityLocations[$country->id])
                                    || ($countryValue === 'All Country (Global multi-select)' && $hasSelectedCountryCategory);
                            @endphp
                            <div class="border border-secondary rounded p-3 country-matrix-row" data-country-id="{{ $country->id }}">
                                <label class="d-flex align-items-center gap-2 m-0">
                                    <input type="checkbox" class="form-check-input m-0 country-matrix-checkbox" name="global_country_ids[]" value="{{ $country->id }}" {{ $countryChecked ? 'checked' : '' }}>
                                    <span class="fw-semibold">{{ strtoupper(substr($country->name, 0, 2)) }}</span>
                                    <span class="fw-semibold">{{ $country->name }}</span>
                                </label>
                                <div class="country-matrix-categories d-flex flex-wrap gap-2 ms-4 pt-3 {{ $countryChecked ? '' : 'd-none' }}">
                                    @forelse($countryCategories as $category)
                                        <label class="d-inline-flex align-items-center gap-2 border border-secondary rounded px-3 py-2 m-0 bg-dark">
                                            <input class="form-check-input m-0 flex-shrink-0 category-id-input global-category-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ in_array((string) $category->id, $selectedCategoryIds, true) ? 'checked' : '' }}>
                                            <span>{{ $category->name }}</span>
                                        </label>
                                    @empty
                                        <span class="small text-muted">No visa types are configured for this country.</span>
                                    @endforelse
                                </div>
                                @if(count($country->cities))
                                    <fieldset class="country-matrix-cities ms-4 pt-3 {{ $countryChecked ? '' : 'd-none' }}">
                                        <legend class="small fw-semibold mb-2">Job cities</legend>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($country->cities as $city)
                                                <label class="d-inline-flex align-items-center gap-2 border border-secondary rounded px-3 py-2 m-0 bg-dark">
                                                    <input class="form-check-input m-0 flex-shrink-0 city-location-input global-city-input" type="checkbox" name="city_locations[{{ $country->id }}][]" value="{{ $city }}" {{ in_array($city, $selectedCityLocations[$country->id] ?? [], true) ? 'checked' : '' }}>
                                                    <span>{{ $city }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>

                <section id="countryCategoriesPanel" class="admin-card d-none p-3" aria-live="polite">
                    <div class="d-flex align-items-center gap-2 pb-3 border-bottom border-secondary">
                        <input type="checkbox" id="selectedCountryIndicator" class="form-check-input m-0" checked disabled style="opacity: 1;" aria-label="Selected country">
                        <h3 class="h6 mb-0" id="selectedCountryName"></h3>
                    </div>
                    <div id="countryCategoriesList" class="d-flex flex-wrap gap-2 ms-4 pt-3">
                        @foreach($categories as $category)
                            <label class="d-inline-flex align-items-center gap-2 border border-secondary rounded px-3 py-2 m-0 category-choice bg-dark" data-country-id="{{ $category->country_id ?? '' }}">
                                <input class="form-check-input m-0 flex-shrink-0 category-id-input country-category-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ in_array((string) $category->id, $selectedCategoryIds, true) ? 'checked' : '' }}>
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p id="noCountryCategories" class="small text-muted mb-0 d-none">No visa types are configured for this country.</p>
                    <fieldset id="countryCitiesList" class="ms-4 pt-3 d-none">
                        <legend class="small fw-semibold mb-2">Job cities</legend>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($countries as $country)
                                @foreach($country->cities as $city)
                                    <label class="d-inline-flex align-items-center gap-2 border border-secondary rounded px-3 py-2 m-0 city-choice bg-dark" data-country-id="{{ $country->id }}">
                                        <input class="form-check-input m-0 flex-shrink-0 city-location-input country-city-input" type="checkbox" name="city_locations[{{ $country->id }}][]" value="{{ $city }}" {{ in_array($city, $selectedCityLocations[$country->id] ?? [], true) ? 'checked' : '' }}>
                                        <span>{{ $city }}</span>
                                    </label>
                                @endforeach
                            @endforeach
                        </div>
                    </fieldset>
                    @error('category_ids')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                    @error('city_locations')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                </section>
            </div>

            <div class="col-12 mt-4"><h2 class="h5 mb-0">2. Working Hours &amp; Schedule</h2></div>
            <div class="col-md-6">
                <label for="working_hours" class="form-label">Job Timing / Working Hours</label>
                <input id="working_hours" type="text" name="working_hours" class="form-control" value="{{ old('working_hours', $job->working_hours ?? '') }}" placeholder="e.g. 9:00 AM - 6:00 PM" maxlength="100" required>
            </div>
            <fieldset class="col-md-6">
                <legend class="form-label fs-6">Working Days</legend>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <label class="form-check form-check-inline mb-0"><input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" {{ in_array($day, $workingDaysValue, true) ? 'checked' : '' }}> <span class="form-check-label">{{ substr($day, 0, 3) }}</span></label>
                    @endforeach
                </div>
            </fieldset>
            <div class="col-md-6">
                <label for="overtime_policy" class="form-label">Overtime Policy</label>
                <textarea id="overtime_policy" name="overtime_policy" class="form-control" rows="3" maxlength="1000" required>{{ old('overtime_policy', $job->overtime_policy ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label for="contract_duration" class="form-label">Contract Duration</label>
                <select id="contract_duration" name="contract_duration" class="form-select" required>
                    <option value="">Select contract duration</option>
                    @foreach(['6 months', '1 year', '2 years renewable', 'Permanent', 'Other'] as $duration)
                        <option value="{{ $duration }}" {{ old('contract_duration', $job->contract_duration ?? '') === $duration ? 'selected' : '' }}>{{ $duration }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 mt-4"><h2 class="h5 mb-0">3. Salary &amp; Benefits</h2></div>
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                    <label class="form-label mb-0">Salary by Country</label>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addSalaryCountryRow"><i class="fas fa-plus me-1"></i> Add Salary</button>
                </div>
                @php
                    $salaryCountryRows = old('salary_by_country', !empty($job->salary_by_country) ? json_decode($job->salary_by_country, true) : []);
                    if (!is_array($salaryCountryRows) || $salaryCountryRows === []) {
                        $salaryCountryRows = [[
                            'country' => old('country_location', $job->country_location ?? ''),
                            'amount' => old('salary', $job->salary ?? ''),
                            'currency' => old('salary_currency', $job->salary_currency ?? 'SAR'),
                            'period' => old('salary_period', $job->salary_period ?? 'month'),
                        ]];
                    }
                @endphp
                <div id="salaryCountryRows" class="d-flex flex-column gap-2">
                    @foreach($salaryCountryRows as $index => $salaryRow)
                        @php
                            $salaryCountryName = old('salary_by_country.' . $index . '.country', $salaryRow['country'] ?? '');
                            $selectedSalaryCurrency = old('salary_by_country.' . $index . '.currency', $salaryRow['currency'] ?? 'SAR');
                            $salaryCountry = $countries->firstWhere('name', $salaryCountryName);
                            $hasConfiguredSalaryCurrencies = $salaryCountry && !empty($salaryCountry->currencies);
                            $salaryCurrencies = $hasConfiguredSalaryCurrencies
                                ? $salaryCountry->currencies
                                : ['SAR', 'USD', 'AED', 'QAR', 'KWD', 'BHD', 'OMR', 'PKR'];
                            if ($hasConfiguredSalaryCurrencies && !in_array($selectedSalaryCurrency, $salaryCurrencies, true)) {
                                $selectedSalaryCurrency = $salaryCurrencies[0];
                            } elseif (!$hasConfiguredSalaryCurrencies && $selectedSalaryCurrency && !in_array($selectedSalaryCurrency, $salaryCurrencies, true)) {
                                $salaryCurrencies[] = $selectedSalaryCurrency;
                            }
                        @endphp
                        <div class="row salary-country-row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <select name="salary_by_country[{{ $index }}][country]" class="form-select">
                                    <option value="">Select country</option>
                                    <option value="All Country (Global multi-select)" {{ $salaryCountryName === 'All Country (Global multi-select)' ? 'selected' : '' }}>All Country (Global multi-select)</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" {{ $salaryCountryName === $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Amount</label>
                                <input type="number" step="0.01" min="0" name="salary_by_country[{{ $index }}][amount]" value="{{ old('salary_by_country.' . $index . '.amount', $salaryRow['amount'] ?? '') }}" class="form-control" placeholder="e.g. 1800">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Currency</label>
                                <select name="salary_by_country[{{ $index }}][currency]" class="form-select">
                                    @foreach($salaryCurrencies as $currency)
                                        <option value="{{ $currency }}" {{ $selectedSalaryCurrency === $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Per</label>
                                <select name="salary_by_country[{{ $index }}][period]" class="form-select">
                                    @foreach(['month' => 'Month', 'week' => 'Week', 'day' => 'Day'] as $period => $label)
                                        <option value="{{ $period }}" {{ (old('salary_by_country.' . $index . '.period', $salaryRow['period'] ?? 'month') ?? 'month') === $period ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger remove-salary-country-row" aria-label="Remove salary row"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <label for="salary" class="form-label">Primary Salary (fallback)</label>
                <div class="input-group">
                    <input id="salary" type="number" step="0.01" min="0" name="salary" class="form-control" value="{{ old('salary', $job->salary ?? '') }}" placeholder="e.g. 1800">
                    <select name="salary_currency" class="form-select" aria-label="Salary currency">
                        @foreach(['SAR', 'USD', 'AED', 'QAR', 'KWD', 'BHD', 'OMR', 'PKR'] as $currency)
                            <option value="{{ $currency }}" {{ old('salary_currency', $job->salary_currency ?? 'SAR') === $currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                    <select name="salary_period" class="form-select" aria-label="Salary period">
                        @foreach(['month' => 'month', 'week' => 'week', 'day' => 'day'] as $period => $label)
                            <option value="{{ $period }}" {{ old('salary_period', $job->salary_period ?? 'month') === $period ? 'selected' : '' }}>/ {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="paid_leave_days_after_one_year" class="form-label">Paid Leave After 1 Year (Days)</label>
                <input id="paid_leave_days_after_one_year" type="number" min="0" name="paid_leave_days_after_one_year" class="form-control" value="{{ old('paid_leave_days_after_one_year', $job->paid_leave_days_after_one_year ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="accommodation_provided" class="form-label">Accommodation</label>
                <select id="accommodation_provided" name="accommodation_provided" class="form-select" required>
                    <option value="1" {{ (string) old('accommodation_provided', $job->accommodation_provided ?? 1) === '1' ? 'selected' : '' }}>Provided</option>
                    <option value="0" {{ (string) old('accommodation_provided', $job->accommodation_provided ?? 1) === '0' ? 'selected' : '' }}>Not provided</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="food_allowance_provided" class="form-label">Food / Allowance</label>
                <select id="food_allowance_provided" name="food_allowance_provided" class="form-select" required>
                    <option value="1" {{ (string) old('food_allowance_provided', $job->food_allowance_provided ?? 1) === '1' ? 'selected' : '' }}>Provided</option>
                    <option value="0" {{ (string) old('food_allowance_provided', $job->food_allowance_provided ?? 1) === '0' ? 'selected' : '' }}>Not provided</option>
                </select>
            </div>
            <div class="col-md-6">
                <span class="form-label d-block">Other Benefits</span>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="medical_insurance" id="medical_insurance" value="1" @checked(old('medical_insurance', $job->medical_insurance ?? false))>
                    <label class="form-check-label" for="medical_insurance">Medical Insurance</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ticket_provided" id="ticket_provided" value="1" @checked(old('ticket_provided', $job->ticket_provided ?? false))>
                    <label class="form-check-label" for="ticket_provided">Air Ticket Provided</label>
                </div>
            </div>

            <div class="col-12 mt-4"><h2 class="h5 mb-0">4. Description &amp; Requirements</h2></div>
            <div class="col-md-6">
                <label for="job_description" class="form-label">Job Description</label>
                <textarea id="job_description" name="job_description" class="form-control" rows="5" required>{{ old('job_description', $job->job_description ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label for="requirements" class="form-label">Requirements / Qualifications</label>
                <textarea id="requirements" name="requirements" class="form-control" rows="5" required>{{ old('requirements', $job->requirements ?? '') }}</textarea>
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="Active" {{ old('status', $job->status ?? 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $job->status ?? 'Active') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary">
            <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ $isEditing ? 'Save Changes' : 'Save Posting' }}</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.getElementById('country_location');
            const panel = document.getElementById('countryCategoriesPanel');
            const globalCountryMatrix = document.getElementById('globalCountryMatrix');
            const selectedCountryName = document.getElementById('selectedCountryName');
            const emptyMessage = document.getElementById('noCountryCategories');
            const categoryChoices = Array.from(document.querySelectorAll('.category-choice'));
            const countryMatrixCheckboxes = Array.from(document.querySelectorAll('.country-matrix-checkbox'));
            const globalCategoryInputs = Array.from(document.querySelectorAll('.global-category-input'));
            const countryCategoryInputs = Array.from(document.querySelectorAll('.country-category-input'));
            const globalCityInputs = Array.from(document.querySelectorAll('.global-city-input'));
            const countryCityInputs = Array.from(document.querySelectorAll('.country-city-input'));
            const cityChoices = Array.from(document.querySelectorAll('.city-choice'));
            const countryCitiesList = document.getElementById('countryCitiesList');
            const globalCountry = 'All Country (Global multi-select)';
            const selectAllCountriesBtn = document.getElementById('selectAllCountriesBtn');
            const deselectAllCountriesBtn = document.getElementById('deselectAllCountriesBtn');

            function updateGlobalCountryRows(clearUnselectedCategories) {
                countryMatrixCheckboxes.forEach(function (checkbox) {
                    const row = checkbox.closest('.country-matrix-row');
                    const categories = row.querySelector('.country-matrix-categories');
                    categories.classList.toggle('d-none', !checkbox.checked);
                    const cities = row.querySelector('.country-matrix-cities');
                    if (cities) cities.classList.toggle('d-none', !checkbox.checked);

                    row.querySelectorAll('.global-category-input').forEach(function (categoryInput) {
                        categoryInput.disabled = !checkbox.checked;
                        if (!checkbox.checked && clearUnselectedCategories) {
                            categoryInput.checked = false;
                        }
                    });
                    row.querySelectorAll('.global-city-input').forEach(function (cityInput) {
                        cityInput.disabled = !checkbox.checked;
                    });
                });
            }

            if (selectAllCountriesBtn) {
                selectAllCountriesBtn.addEventListener('click', function () {
                    countryMatrixCheckboxes.forEach(function (checkbox) {
                        checkbox.checked = true;
                    });
                    updateGlobalCountryRows(false);
                });
            }

            if (deselectAllCountriesBtn) {
                deselectAllCountriesBtn.addEventListener('click', function () {
                    countryMatrixCheckboxes.forEach(function (checkbox) {
                        checkbox.checked = false;
                    });
                    updateGlobalCountryRows(true);
                });
            }

            countryMatrixCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    updateGlobalCountryRows(true);
                });
            });

            function updateCountryCategories() {
                const selectedCountry = countrySelect.value;
                const selectedOption = countrySelect instanceof HTMLSelectElement
                    ? countrySelect.options[countrySelect.selectedIndex]
                    : null;
                const selectedCountryId = selectedOption ? selectedOption.dataset.countryId : '';
                const showAll = selectedCountry === globalCountry;
                const showGlobalMatrix = showAll;
                let visibleCityChoices = 0;
                let visibleChoices = 0;

                categoryChoices.forEach(choice => {
                    const belongsToCountry = choice.dataset.countryId === selectedCountryId;
                    const visible = Boolean(selectedCountry) && !showAll && belongsToCountry;
                    choice.classList.toggle('d-none', !visible);
                    const checkbox = choice.querySelector('input');
                    checkbox.disabled = !visible;
                    if (!visible) checkbox.checked = false;
                    if (visible) visibleChoices++;
                });

                panel.classList.toggle('d-none', !selectedCountry || showAll);
                countryCitiesList.classList.toggle('d-none', !selectedCountry || showAll);
                globalCountryMatrix.classList.toggle('d-none', !showGlobalMatrix);
                countryCategoryInputs.forEach(function (checkbox) {
                    const visible = Boolean(selectedCountry) && !showAll && checkbox.closest('.category-choice').dataset.countryId === selectedCountryId;
                    checkbox.disabled = !visible;
                    if (!visible) checkbox.checked = false;
                });
                globalCategoryInputs.forEach(function (checkbox) {
                    checkbox.disabled = !showAll || !checkbox.closest('.country-matrix-row').querySelector('.country-matrix-checkbox').checked;
                });
                cityChoices.forEach(function (choice) {
                    const visible = Boolean(selectedCountry) && !showAll && choice.dataset.countryId === selectedCountryId;
                    choice.classList.toggle('d-none', !visible);
                    const checkbox = choice.querySelector('input');
                    checkbox.disabled = !visible;
                    if (visible) visibleCityChoices++;
                });
                countryCityInputs.forEach(function (checkbox) {
                    checkbox.disabled = !selectedCountry || showAll || checkbox.closest('.city-choice').dataset.countryId !== selectedCountryId;
                });
                globalCityInputs.forEach(function (checkbox) {
                    checkbox.disabled = !showAll || !checkbox.closest('.country-matrix-row').querySelector('.country-matrix-checkbox').checked;
                });
                selectedCountryName.textContent = showAll ? 'All Countries' : selectedCountry;
                emptyMessage.classList.toggle('d-none', !selectedCountry || visibleChoices > 0);
            }

            const salaryCountryRows = document.getElementById('salaryCountryRows');
            const addSalaryCountryRowButton = document.getElementById('addSalaryCountryRow');
            const currenciesByCountry = @json($countries->mapWithKeys(fn ($country) => [$country->name => $country->currencies]));
            const fallbackCurrencies = ['SAR', 'USD', 'AED', 'QAR', 'KWD', 'BHD', 'OMR', 'PKR'];

            function updateSalaryCurrencyOptions(row, chooseFirstCurrency) {
                const countrySelect = row.querySelector('select[name$="[country]"]');
                const currencySelect = row.querySelector('select[name$="[currency]"]');
                const availableCurrencies = currenciesByCountry[countrySelect.value] || fallbackCurrencies;
                const currentCurrency = currencySelect.value;
                const currencies = [...availableCurrencies];
                if (!chooseFirstCurrency && currentCurrency && !currencies.includes(currentCurrency)) {
                    currencies.push(currentCurrency);
                }
                currencySelect.replaceChildren();
                currencies.forEach(function (currency) {
                    const option = document.createElement('option');
                    option.value = currency;
                    option.textContent = currency;
                    currencySelect.appendChild(option);
                });
                if (chooseFirstCurrency) {
                    currencySelect.value = currencies[0] || '';
                } else if (currencies.includes(currentCurrency)) {
                    currencySelect.value = currentCurrency;
                }
            }

            salaryCountryRows?.querySelectorAll('.salary-country-row').forEach(function (row) {
                const countrySelect = row.querySelector('select[name$="[country]"]');
                countrySelect.addEventListener('change', function () {
                    updateSalaryCurrencyOptions(row, true);
                });
                updateSalaryCurrencyOptions(row, false);
            });

            function addSalaryCountryRow() {
                if (!salaryCountryRows) return;
                const rowCount = salaryCountryRows.querySelectorAll('.salary-country-row').length;
                const row = document.createElement('div');
                row.className = 'row salary-country-row g-2 align-items-end';
                row.innerHTML = `
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <select name="salary_by_country[${rowCount}][country]" class="form-select">
                            <option value="">Select country</option>
                            <option value="All Country (Global multi-select)">All Country (Global multi-select)</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0" name="salary_by_country[${rowCount}][amount]" class="form-control" placeholder="e.g. 1800">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Currency</label>
                        <select name="salary_by_country[${rowCount}][currency]" class="form-select">
                            @foreach(['SAR', 'USD', 'AED', 'QAR', 'KWD', 'BHD', 'OMR', 'PKR'] as $currency)
                                <option value="{{ $currency }}" {{ $currency === 'SAR' ? 'selected' : '' }}>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Per</label>
                        <select name="salary_by_country[${rowCount}][period]" class="form-select">
                            @foreach(['month' => 'Month', 'week' => 'Week', 'day' => 'Day'] as $period => $label)
                                <option value="{{ $period }}" {{ $period === 'month' ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger remove-salary-country-row" aria-label="Remove salary row"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                salaryCountryRows.appendChild(row);
                const countrySelect = row.querySelector('select[name$="[country]"]');
                countrySelect.addEventListener('change', function () {
                    updateSalaryCurrencyOptions(row, true);
                });
                updateSalaryCurrencyOptions(row, false);
            }

            if (addSalaryCountryRowButton) {
                addSalaryCountryRowButton.addEventListener('click', addSalaryCountryRow);
            }

            salaryCountryRows?.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-salary-country-row');
                if (!removeButton) return;
                const row = removeButton.closest('.salary-country-row');
                if (row && salaryCountryRows.querySelectorAll('.salary-country-row').length > 1) {
                    row.remove();
                }
            });

            updateGlobalCountryRows(false);
            countrySelect.addEventListener(countrySelect instanceof HTMLSelectElement ? 'change' : 'input', updateCountryCategories);
            updateCountryCategories();
        });
    </script>
@endsection
