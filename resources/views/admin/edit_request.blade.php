<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Visa Request #{{ $visaRequest->id }} - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color: #0b0e14; --sidebar-bg: #0f131a; --card-bg: #161b22; --text-main: #ffffff; --text-secondary: #8b949e; --accent-blue: #007bff; --border-color: #30363d; }
        body { background: var(--bg-color); color: var(--text-main); font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 260px; height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); position: fixed; padding: 20px; display: flex; flex-direction: column; z-index: 1200; }
        .brand-section { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }
        .brand-logo-img { width: 80px; height: 80px; border-radius: 0; object-fit: contain; background: transparent; border: 0; }
        .brand-name { font-size: 1.15rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-badge { background: rgba(0, 123, 255, .1); color: #58a6ff; font-size: .7rem; padding: 2px 8px; border-radius: 4px; border: 1px solid var(--accent-blue); margin-left: auto; }
        .nav-link { color: var(--text-secondary); padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; display: flex; align-items: center; text-decoration: none; }
        .nav-link i { width: 20px; margin-right: 12px; }
        .nav-link:hover { color: var(--text-main); background: rgba(255, 255, 255, .05); }
        .logout-btn { margin-top: auto; color: var(--text-secondary); border: 1px solid var(--border-color); background: transparent; padding: 10px; border-radius: 8px; width: 100%; text-align: left; }
        .main-content { margin-left: 260px; padding: 32px; min-height: 100vh; }
        .page-shell { max-width: 1100px; }
        .editor-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 0, 0, .2); }
        .section-title { border-bottom: 1px solid var(--border-color); color: var(--text-main); font-size: 1rem; font-weight: 700; margin: 1.5rem 0 1rem; padding-bottom: .65rem; }
        .section-title:first-child { margin-top: 0; }
        .form-label { color: #c9d1d9; }
        .form-control, .form-select { background: #0d1117; border-color: var(--border-color); color: var(--text-main); }
        .form-control:focus, .form-select:focus { background: #0d1117; border-color: var(--accent-blue); color: var(--text-main); box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .2); }
        .form-control::placeholder { color: #6e7681; }
        .form-text, .text-muted { color: var(--text-secondary) !important; }
        .current-photo { max-height: 120px; max-width: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color); }
        .btn-light { background: transparent; border-color: var(--border-color); color: var(--text-secondary); }
        .btn-light:hover { background: rgba(255, 255, 255, .05); color: var(--text-main); }
        @media (max-width: 768px) { .sidebar { width: 220px; padding: 15px; } .main-content { margin-left: 220px; padding: 20px 15px; } .admin-badge { display: none; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand-section">
            <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="Logo" class="brand-logo-img">
            <span class="brand-name">{{ $settings->app_name ?? 'VisaBook' }}</span>
            <div class="admin-badge">Admin</div>
        </div>
        <nav class="nav flex-column">
            <a href="/" class="nav-link" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link" onclick="localStorage.setItem('activeAdminTab', 'requests')"><i class="fas fa-file-signature"></i> Visa Requests</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-globe"></i> Countries</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-th-large"></i> Categories</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-shield-alt"></i> Security</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-cog"></i> Settings</a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="container page-shell py-1 py-md-3">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" onclick="localStorage.setItem('activeAdminTab', 'requests')">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <div>
                <h1 class="h3 mb-1">Edit Visa Request</h1>
                <p class="text-muted mb-0">Request #{{ $visaRequest->id }}</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please correct the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.requests.update', $visaRequest->id) }}" method="POST" enctype="multipart/form-data" class="card editor-card p-3 p-md-4">
            @csrf

            <h2 class="section-title">Personal Details</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Apply Date</label>
                    <input type="date" name="apply_date" class="form-control" value="{{ old('apply_date', $visaRequest->apply_date) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $visaRequest->first_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $visaRequest->last_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $visaRequest->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number', $visaRequest->mobile_number) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="text" name="dob" class="form-control" value="{{ old('dob', $visaRequest->dob) }}" placeholder="DD/MM/YYYY">
                </div>
                <div class="col-md-6">
                    <label class="form-label d-block">Gender <span class="text-danger">*</span></label>
                    @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_{{ $value }}" value="{{ $value }}" {{ old('gender', $visaRequest->gender) === $value ? 'checked' : '' }} required>
                            <label class="form-check-label" for="gender_{{ $value }}">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nationality</label>
                    <select name="nationality" class="form-select">
                        <option value="">Select nationality</option>
                        @foreach($nationalities as $nationality)
                            <option value="{{ $nationality->name }}" {{ old('nationality', $visaRequest->nationality) === $nationality->name ? 'selected' : '' }}>{{ $nationality->name }}</option>
                        @endforeach
                        @if($visaRequest->nationality && (!$nationalities->count() || !$nationalities->contains('name', $visaRequest->nationality)))
                            <option value="{{ $visaRequest->nationality }}" selected>{{ $visaRequest->nationality }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <h2 class="section-title">Passport Details</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Passport Number <span class="text-danger">*</span></label>
                    <input type="text" name="passport_number" class="form-control" value="{{ old('passport_number', $visaRequest->passport_number) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Passport Expiry</label>
                    <input type="text" name="passport_expiry" class="form-control" value="{{ old('passport_expiry', $visaRequest->passport_expiry) }}" placeholder="DD-MM-YYYY">
                </div>
                <div class="col-12">
                    <label class="form-label">Passport Photo</label>
                    @if($visaRequest->passport_photo)
                        <div class="mb-2"><img src="{{ $visaRequest->passport_photo }}" alt="Current passport photo" class="current-photo"></div>
                    @endif
                    <input type="file" name="passport_photo_file" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <div class="form-text">Leave empty to keep the current photo.</div>
                </div>
            </div>

            <h2 class="section-title">Visa Details</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Destination Country <span class="text-danger">*</span></label>
                    <select name="destination_country" class="form-select" required>
                        <option value="">Select country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" {{ old('destination_country', $visaRequest->destination_country) === $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                        @if(!$countries->count() || !$countries->contains('name', $visaRequest->destination_country))
                            <option value="{{ $visaRequest->destination_country }}" selected>{{ $visaRequest->destination_country }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Visa Category <span class="text-danger">*</span></label>
                    <select name="visa_category" class="form-select" required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ old('visa_category', $visaRequest->visa_category) === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                        @if(!$categories->count() || !$categories->contains('name', $visaRequest->visa_category))
                            <option value="{{ $visaRequest->visa_category }}" selected>{{ $visaRequest->visa_category }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Visa Type</label>
                    <input type="text" name="visa_type" class="form-control" value="{{ old('visa_type', $visaRequest->visa_type) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $visaRequest->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
            </div>
        </form>
        </div>
    </main>
</body>
</html>
