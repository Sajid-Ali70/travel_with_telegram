@extends('admin.jobs.layout')

@section('title', 'Manage Jobs')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Job Postings</h1>
            <p class="text-muted mb-0">Create, edit, and manage available positions.</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Job Posting</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <section class="admin-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h5 mb-0">Manage Jobs</h2>
            <span class="text-muted">{{ $jobs->count() }} postings</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Job</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Vacancies</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Posting Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        @php($jobWorkingDays = json_decode($job->working_days ?? '[]', true) ?: [])
                        <tr>
                            <td>
                                <strong>{{ $job->job_title }}</strong>
                                @if(!empty($job->profession))<div class="small text-muted">{{ $job->profession }}</div>@endif
                                <div class="small text-muted">#{{ $job->id }}</div>
                            </td>
                            <td>
                                {{ $job->category ?? '—' }}
                                @if(!empty($job->category_visa_type))<div class="small text-muted">Subcategory: {{ $job->category_visa_type }}</div>@endif
                            </td>
                            <td>{{ $job->country_location ?? '—' }}</td>
                            <td>{{ $job->number_of_vacancies ?? 1 }}</td>
                            <td>{{ number_format((float) ($job->salary ?? 0), 2) }} {{ $job->salary_currency ?? 'SAR' }} / {{ $job->salary_period ?? 'month' }}</td>
                            <td><span class="badge {{ ($job->status ?? 'Active') === 'Active' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $job->status ?? 'Active' }}</span></td>
                            <td>
                                <details>
                                    <summary>View details</summary>
                                    <div class="small mt-2">
                                        <div><strong>Hours:</strong> {{ $job->working_hours ?? '—' }}</div>
                                        <div><strong>Days:</strong> {{ implode(', ', $jobWorkingDays) ?: '—' }}</div>
                                        <div><strong>Overtime:</strong> {{ $job->overtime_policy ?? '—' }}</div>
                                        <div><strong>Contract:</strong> {{ $job->contract_duration ?? '—' }}</div>
                                        <div><strong>Accommodation:</strong> {{ $job->accommodation_provided ? 'Provided' : 'Not provided' }}</div>
                                        <div><strong>Food / allowance:</strong> {{ $job->food_allowance_provided ? 'Provided' : 'Not provided' }}</div>
                                        <div><strong>Medical insurance:</strong> {{ $job->medical_insurance ? 'Yes' : 'No' }}</div>
                                        <div><strong>Air ticket:</strong> {{ $job->ticket_provided ? 'Provided' : 'Not provided' }}</div>
                                        <div><strong>Paid leave:</strong> {{ $job->paid_leave_days_after_one_year ?? 0 }} days after one year</div>
                                        <div class="mt-2"><strong>Description:</strong><br>{{ $job->job_description }}</div>
                                        <div class="mt-2"><strong>Requirements:</strong><br>{{ $job->requirements ?? '—' }}</div>
                                    </div>
                                </details>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit {{ $job->job_title }}"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.jobs.delete') }}" method="POST" onsubmit="return confirm('Delete this job posting?')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $job->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Delete {{ $job->job_title }}"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No job postings yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
