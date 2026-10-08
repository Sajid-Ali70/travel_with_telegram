<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->app_name ?? 'Jobs' }} - Job Openings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        body {
            background: #f5f7fb;
        }
        .page-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 16px 80px;
        }
        .job-filter-box {
            background: #fff;
            border: 1px solid #e7edf5;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.04);
            padding: 22px;
            margin-bottom: 24px;
        }
        .job-card {
            background: #fff;
            border: 1px solid #e7edf5;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
            padding: 24px;
            margin-bottom: 18px;
            transition: background-color .2s ease, border-color .2s ease;
        }
        .job-card:hover {
            background: #161b22;
            border-color: #30363d;
        }
        .job-card:hover h2,
        .job-card:hover .job-meta,
        .job-card:hover .job-meta span,
        .job-card:hover p.text-secondary {
            color: #fff !important;
        }
        .job-tag {
            display: inline-flex;
            align-items: center;
            background: #eef7ff;
            border-radius: 999px;
            color: #0d6efd;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .03em;
            padding: 6px 12px;
            text-transform: uppercase;
        }
        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            color: #475569;
            font-size: 0.92rem;
            margin-top: 10px;
        }
        .job-meta span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .salary-badge {
            background: #e8faf0;
            color: #198754;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .empty-state {
            background: #fff;
            border: 1px dashed #d8e2f0;
            border-radius: 18px;
            padding: 48px 20px;
            text-align: center;
            color: #475569;
        }
        @media (max-width: 767px) {
            .page-shell {
                padding-top: 18px;
            }
            .job-card {
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <div class="page-shell">
            <div class="d-flex flex-column gap-2 mb-4">
                <div class="job-tag">Jobs</div>
                <h1 class="mb-0" style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: #0f172a;">Find the right role for you</h1>
                <p class="text-muted mb-0">Browse active opportunities filtered by country and visa category.</p>
            </div>

            <form method="GET" action="{{ route('jobs.index') }}" class="job-filter-box row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="country" class="form-label fw-semibold">Country</label>
                    <select id="country" name="country" class="form-select">
                        <option value="">All countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" {{ $selectedCountry === $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label fw-semibold">Category</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ $selectedCategory === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">Apply Filters</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            @if($jobs->isEmpty())
                <div class="empty-state">
                    <h3 class="mb-2">No jobs found</h3>
                    <p class="mb-0">There are no active job openings matching the selected filters. Try a different country or category.</p>
                </div>
            @else
                @foreach($jobs as $job)
                    @php
                        $jobCityList = [];
                        $jobCityMap = json_decode($job->city_locations ?? '[]', true);
                        if (is_array($jobCityMap)) {
                            foreach ($jobCityMap as $countryCities) {
                                if (is_array($countryCities)) {
                                    foreach ($countryCities as $cityName) {
                                        $trimmedCity = trim((string) $cityName);
                                        if ($trimmedCity !== '' && !in_array($trimmedCity, $jobCityList, true)) {
                                            $jobCityList[] = $trimmedCity;
                                        }
                                    }
                                }
                            }
                        }
                        $jobSalaryRows = json_decode($job->salary_by_country ?? '[]', true);
                        $jobSalaryRows = array_values(array_filter(
                            is_array($jobSalaryRows) ? $jobSalaryRows : [],
                            fn ($salaryRow) => is_array($salaryRow) && isset($salaryRow['amount'])
                        ));
                    @endphp
                    <article class="job-card">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <div>
                                <div class="job-tag">{{ $job->category_visa_type ?? 'Job Opening' }}</div>
                                <h2 class="mt-3 mb-2" style="font-size: clamp(1.3rem, 2vw, 2rem); font-weight: 800; color: #0f172a;">{{ $job->job_title }}</h2>
                            </div>
                            <div class="salary-badge">
                                @forelse($jobSalaryRows as $salaryRow)
                                    <div>{{ $salaryRow['country'] ?? '—' }}: {{ number_format((float) $salaryRow['amount'], 2) }} {{ $salaryRow['currency'] ?? ($job->salary_currency ?? 'SAR') }} / {{ $salaryRow['period'] ?? ($job->salary_period ?? 'month') }}</div>
                                @empty
                                    {{ number_format((float) ($job->salary ?? 0), 2) }} {{ $job->salary_currency ?? 'SAR' }} / {{ $job->salary_period ?? 'month' }}
                                @endforelse
                            </div>
                        </div>

                        <div class="job-meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $job->country_location ?? 'International' }}</span>
                            @if(!empty($jobCityList))
                                <span><i class="fas fa-city"></i> {{ implode(', ', $jobCityList) }}</span>
                            @endif
                            <span><i class="fas fa-briefcase"></i> {{ $job->contract_duration ?? 'Contract' }}</span>
                            <span><i class="fas fa-clock"></i> {{ $job->working_hours ?? 'Flexible timing' }}</span>
                            <span><i class="fas fa-users"></i> {{ $job->number_of_vacancies ?? 1 }} vacancies</span>
                        </div>

                        <p class="mt-3 mb-3 text-secondary">{{ Str::limit(strip_tags($job->job_description ?? ''), 220) ?: 'No description provided yet.' }}</p>

                        <div class="d-flex flex-wrap gap-2">
                            @if(!empty($job->working_days))
                                @php $days = json_decode($job->working_days, true) ?: []; @endphp
                                @foreach(array_slice($days, 0, 5) as $day)
                                    <span class="badge text-bg-light border">{{ $day }}</span>
                                @endforeach
                            @endif
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
