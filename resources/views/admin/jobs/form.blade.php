@extends('admin.jobs.layout')

@php
    $isEditing = $job !== null;
    $categoryValue = old('category_visa_type', $job->category_visa_type ?? '');
    $countryValue = old('country_location', $job->country_location ?? '');
    $categoryOptions = $categories->flatMap(function ($category) {
        return $category->types->isNotEmpty() ? $category->types->pluck('name') : collect([$category->name]);
    })->all();
    $workingDaysValue = old('working_days', $selectedWorkingDays);
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
                <input id="job_title" type="text" name="job_title" class="form-control" value="{{ old('job_title', $job->job_title ?? '') }}" placeholder="e.g. Hospital Nurse" maxlength="255" required>
            </div>
            <div class="col-md-6">
                <label for="category_visa_type" class="form-label">Category / Visa Type</label>
                @if($categories->isNotEmpty())
                    <select id="category_visa_type" name="category_visa_type" class="form-select" required>
                        <option value="">Select category / visa type</option>
                        @if($categoryValue && !in_array($categoryValue, $categoryOptions, true))<option value="{{ $categoryValue }}" selected>{{ $categoryValue }}</option>@endif
                        @foreach($categories as $category)
                            @if($category->types->isNotEmpty())
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->types as $visaType)
                                        <option value="{{ $visaType->name }}" {{ $categoryValue === $visaType->name ? 'selected' : '' }}>{{ $visaType->name }}</option>
                                    @endforeach
                                </optgroup>
                            @else
                                <option value="{{ $category->name }}" {{ $categoryValue === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <input id="category_visa_type" type="text" name="category_visa_type" class="form-control" value="{{ $categoryValue }}" placeholder="e.g. Work Visa" required>
                @endif
            </div>
            <div class="col-md-6">
                <label for="country_location" class="form-label">Country / Location</label>
                @if(isset($countries) && $countries->isNotEmpty())
                    <select id="country_location" name="country_location" class="form-select" required>
                        <option value="">Select country</option>
                        @if($countryValue && !$countries->contains('name', $countryValue))
                            <option value="{{ $countryValue }}" selected>{{ $countryValue }}</option>
                        @endif
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" {{ $countryValue === $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
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
            <div class="col-md-6">
                <label for="salary" class="form-label">Basic Salary</label>
                <div class="input-group">
                    <input id="salary" type="number" step="0.01" min="0" name="salary" class="form-control" value="{{ old('salary', $job->salary ?? '') }}" placeholder="e.g. 1800" required>
                    <select name="salary_currency" class="form-select" aria-label="Salary currency" required>
                        @foreach(['SAR', 'USD', 'AED', 'QAR', 'KWD', 'BHD', 'OMR', 'PKR'] as $currency)
                            <option value="{{ $currency }}" {{ old('salary_currency', $job->salary_currency ?? 'SAR') === $currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                    <select name="salary_period" class="form-select" aria-label="Salary period" required>
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
@endsection
