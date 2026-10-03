<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #0b0e14;
            --sidebar-bg: #0f131a;
            --card-bg: #161b22;
            --text-main: #ffffff;
            --text-secondary: #8b949e;
            --accent-blue: #007bff;
            --border-color: #30363d;
            --accent-success: #238636;
            --accent-warning: #d29922;
            --accent-purple: #a371f7;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            padding: 20px;
            display: flex;
            flex-direction: column;
            z-index: 1200;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overscroll-behavior-y: contain;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-logo-img {
            width: 80px;
            height: 80px;
            border-radius: 0;
            object-fit: contain;
            background: transparent;
            border: 0;
        }

        .brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-badge {
            background: rgba(0, 123, 255, 0.1);
            color: var(--accent-blue);
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid var(--accent-blue);
            margin-left: auto;
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            background: rgba(0, 123, 255, 0.1);
            border: 1px solid rgba(0, 123, 255, 0.2);
            color: var(--accent-blue);
        }

        .logout-btn {
            margin-top: auto;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            background: transparent;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            text-align: left;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #ff4d4d;
            border-color: #ff4d4d;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            transition: margin-left 0.3s ease;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .header-app-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
        }

        .stat-info p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Content Card */
        .admin-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 30px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        /* Forms & Inputs */
        .form-label { color: var(--text-secondary); margin-bottom: 8px; font-size: 0.9rem; }
        .form-control, .form-select {
            background: #0d1117;
            border: 1px solid var(--border-color);
            color: white;
            padding: 12px;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            background: #0d1117;
            border-color: var(--accent-blue);
            color: white;
            box-shadow: none;
        }

        .icon-preview-box {
            width: 60px;
            height: 60px;
            background: #161b22;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .icon-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-preview-box {
            width: 100%;
            height: 120px;
            background: #161b22;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-bottom: 10px;
        }

        .banner-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--accent-blue);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: fit-content;
        }

        .btn-save-main {
            width: 100%;
            margin-top: 10px;
        }

        /* Table */
        .reviews-table {
            width: 100%;
            border-collapse: collapse;
        }
        .reviews-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 500;
        }
        .reviews-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .country-flag-sm {
            width: 30px;
            height: 20px;
            object-fit: cover;
            border-radius: 2px;
            border: 1px solid var(--border-color);
        }
        .cat-icon-preview {
            width: 40px;
            height: 40px;
            background: #0d1117;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--accent-purple);
            border: 1px solid var(--border-color);
        }
        .cat-image-sm {
            width: 50px;
            height: 35px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--border-color);
        }

        .visa-type-tag {
            background: rgba(163, 113, 247, 0.1);
            color: var(--accent-purple);
            border: 1px solid rgba(163, 113, 247, 0.2);
            padding: 2px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .visa-type-tag i {
            cursor: pointer;
            font-size: 0.7rem;
        }
        .visa-type-tag i:hover { color: #ff4d4d; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="page-header d-flex align-items-center gap-3 mb-4">
            <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="App Icon" class="header-app-icon">
            <div>
                <h1 class="mb-0">Website Configuration</h1>
                <p class="mb-0">Update your portal identity, contact information, and banners.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Section: Dashboard -->
        <section id="dashboardSection" class="dashboard-section d-none">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1); color: var(--accent-blue);">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Countries</p>
                        <h3>{{ $stats['total_countries'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(163, 113, 247, 0.1); color: var(--accent-purple);">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Categories</p>
                        <h3>{{ $stats['total_categories'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(210, 153, 34, 0.1); color: var(--accent-warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <p>Pending Requests</p>
                        <h3>{{ $stats['pending_requests'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(35, 134, 54, 0.1); color: var(--accent-success);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <p>Approved Requests</p>
                        <h3>{{ $stats['approved_requests'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h5 class="section-title">Quick Actions</h5>
                <div class="d-flex gap-3 mt-3">
                    <button class="btn btn-outline-primary" onclick="showSection('requests')">Manage Requests</button>
                    <button class="btn btn-outline-purple" style="color:#a371f7; border-color:#a371f7;" onclick="showSection('categories')">Manage Categories</button>
                    <a class="btn btn-outline-info" href="{{ route('admin.jobs.index') }}">Manage Jobs</a>
                    <button class="btn btn-outline-info" onclick="showSection('playstore')">Edit Settings</button>
                </div>
            </div>
        </section>

        <!-- Section: Jobs -->
        <!-- Section: Bank Accounts -->
        <section id="bank-accountsSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add Bank Account</h5>
                <form id="addBankAccountForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Account Holder Name</label>
                            <input type="text" name="account_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="account_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">IBAN</label>
                            <input type="text" name="iban" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Branch</label>
                            <input type="text" name="branch" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SWIFT / BIC Code</label>
                            <input type="text" name="swift_code" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Currency</label>
                            <input type="text" name="currency" class="form-control" value="PKR" maxlength="10" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn-primary-custom w-100">Add Account</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <h5 class="section-title">Manage Bank Accounts</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead>
                            <tr><th>Bank</th><th>Account Holder</th><th>Account Number</th><th>IBAN</th><th>Branch</th><th>SWIFT / BIC</th><th>Currency</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @forelse($bankAccounts as $bankAccount)
                            <tr>
                                <td>{{ $bankAccount->bank_name }}</td>
                                <td>{{ $bankAccount->account_name }}</td>
                                <td>{{ $bankAccount->account_number }}</td>
                                <td>{{ $bankAccount->iban ?: 'N/A' }}</td>
                                <td>{{ $bankAccount->branch ?: 'N/A' }}</td>
                                <td>{{ $bankAccount->swift_code ?: 'N/A' }}</td>
                                <td>{{ $bankAccount->currency }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.bank_accounts.edit', $bankAccount->id) }}" class="btn btn-sm btn-outline-primary" title="Edit bank account"><i class="fas fa-pen"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteBankAccount({{ $bankAccount->id }})" title="Delete bank account"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center">No bank accounts added.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Visa Requests -->
        <section id="requestsSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Visa Application Requests</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Applicant</th>
                                <th>Contact</th>
                                <th>Destination / Visa</th>
                                <th>Passport</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visa_requests as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>
                                    <strong>{{ $req->first_name }} {{ $req->last_name }}</strong><br>
                                    <small class="text-muted">DOB: {{ $req->dob }}</small><br>
                                    <small class="text-muted">Nationality: {{ $req->nationality ?: 'Not provided' }}</small>
                                </td>
                                <td>
                                    {{ $req->email }}<br>
                                    {{ $req->mobile_number }}
                                </td>
                                <td>
                                    {{ $req->destination_country }}<br>
                                    <small class="">{{ $req->visa_category }} - {{ $req->visa_type }}</small>
                                </td>
                                <td>
                                    {{ $req->passport_number }}<br>
                                    @if($req->passport_photo)
                                        <a href="{{ $req->passport_photo }}" target="_blank" class="btn btn-sm btn-outline-info py-0">View Photo</a>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ in_array($req->status, ['Visa Approved', 'Payment Verified', 'Visa Issued', 'Flight Ticket Booked'], true) ? 'success' : ($req->status === 'Fee Payment' ? 'warning text-dark' : 'secondary') }}">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.requests.edit', $req->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit request">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteRequest({{ $req->id }})" title="Delete request">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Countries -->
        <section id="countriesSection" class="dashboard-section d-none">
            @php
                $nationalityCurrencies = $nationalities->pluck('currency')
                    ->filter(fn ($currency) => !empty(trim($currency ?? '')))
                    ->map(fn ($currency) => strtoupper(trim($currency)))
                    ->unique()
                    ->sort()
                    ->values();
            @endphp
            <div class="admin-card">
                <h5 class="section-title">Add New Country</h5>
                <form id="addCountryForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Country Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. United Arab Emirates" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Country Flag</label>
                            <input type="file" name="flag_file" class="form-control" accept="image/*" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="form-label">Visa Fee by Currency</label>
                        <div id="countryCurrencyFeeRows">
                            <div class="row g-2 currency-fee-row">
                                <div class="col-md-3">
                                    <select name="currency[]" class="form-select">
                                        <option value="">Select</option>
                                        @forelse($nationalityCurrencies as $currency)
                                            <option value="{{ $currency }}">{{ $currency }}</option>
                                        @empty
                                            <option value="" disabled>No nationality currencies added</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <input type="number" name="fee[]" class="form-control" step="0.01" min="0" placeholder="1200">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-fee-row w-100">Remove</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addCurrencyFeeRow" class="btn btn-sm btn-outline-primary mt-2">+ Add another currency</button>
                    </div>
                    <div id="countryFormError" class="alert alert-danger mt-3 d-none" role="alert"></div>
                    <button type="submit" id="addCountrySubmit" class="btn-primary-custom mt-3">Add Country</button>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Manage Countries</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Flag</th><th>Country Name</th><th>Visa Fees</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($countries as $country)
                            @php
                                $feeDetails = json_decode($country->visa_fee_details ?? '[]', true);
                                $displayFees = [];
                                if (!empty($feeDetails) && is_array($feeDetails)) {
                                    foreach ($feeDetails as $entry) {
                                        if (!empty($entry['currency']) && isset($entry['fee'])) {
                                            $displayFees[] = strtoupper($entry['currency']) . ': ' . number_format((float) $entry['fee'], 2);
                                        }
                                    }
                                }
                                if (empty($displayFees) && $country->visa_fee !== null) {
                                    $currencyLabel = !empty($country->currency) ? strtoupper($country->currency) : 'PKR';
                                    $displayFees[] = $currencyLabel . ': ' . number_format((float) $country->visa_fee, 2);
                                }
                            @endphp
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>
                                    @if(!empty($country->flag))
                                        <img src="{{ $country->flag }}" class="country-flag-sm">
                                    @else
                                        <span class="text-muted">No Flag</span>
                                    @endif
                                </td>
                                <td>{{ $country->name }}</td>
                                <td>{{ !empty($displayFees) ? implode('<br>', $displayFees) : 'N/A' }}</td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteCountry({{ $country->id }})"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Nationalities -->
        <section id="nationalitiesSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add New Nationality</h5>
                <form id="addNationalityForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nationality Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Pakistani" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Currency</label>
                            <input type="text" name="currency" class="form-control" placeholder="e.g. PKR" maxlength="20">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Phone Code</label>
                            <input type="text" name="phone_code" class="form-control" placeholder="+92" maxlength="20">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">ID Digits</label>
                            <input type="number" name="id_number_length" class="form-control" placeholder="13" min="1" max="30">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn-primary-custom w-100">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Manage Nationalities</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Nationality</th><th>Currency</th><th>Phone Code</th><th>ID Digits</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($nationalities as $nationality)
                            <tr>
                                <td>{{ $nationality->id }}</td>
                                <td>{{ $nationality->name }}</td>
                                <td>{{ $nationality->currency ?? '—' }}</td>
                                <td>{{ $nationality->phone_code ?? '—' }}</td>
                                <td>{{ $nationality->id_number_length ?? '—' }}</td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteNationality({{ $nationality->id }})"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Airports -->
        <section id="airportsSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add New Airport</h5>
                <form id="addAirportForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label" for="airportCode">Airport Code</label>
                            <input id="airportCode" type="text" name="code" class="form-control" maxlength="10" placeholder="e.g. DAC" required>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label" for="airportName">Airport Name</label>
                            <input id="airportName" type="text" name="name" class="form-control" maxlength="255" placeholder="e.g. Hazrat Shahjalal International Airport, Dhaka" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn-primary-custom w-100">Add Airport</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Manage Airports</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>Code</th><th>Airport Name</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($airports as $airport)
                            <tr>
                                <td>{{ $airport->code }}</td>
                                <td>{{ $airport->name }}</td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteAirport({{ $airport->id }})" title="Delete airport"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">No airports added.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Categories -->
        <section id="categoriesSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add New Category</h5>
                <form id="addCategoryForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Tourist Visa" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-suitcase-rolling" value="fas fa-suitcase-rolling">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Display Image</label>
                            <input type="file" name="image_file" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Short Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief info about this visa type..."></textarea>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn-primary-custom w-100">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Dedicated Visa Type Addition Form -->
            <div class="admin-card">
                <h5 class="section-title">Add Visa Type (Occupation)</h5>
                <form id="addVisaTypeForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Select Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" selected disabled>Choose Category...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Visa Type Name(s)</label>
                            <input type="text" name="names" class="form-control" placeholder="e.g. Driver, Electrician (comma separated)" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn-primary-custom w-100">Add Type</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <h5 class="section-title">Manage Categories & Visa Types</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Icon/Image</th><th>Category Name & Types</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(!empty($cat->icon))
                                            <div class="cat-icon-preview"><i class="{{ $cat->icon }}"></i></div>
                                        @endif
                                        @if(!empty($cat->image))
                                            <img src="{{ $cat->image }}" class="cat-image-sm">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $cat->name }}</strong><br>
                                    <div class="mt-2 mb-2" id="types-list-{{ $cat->id }}">
                                        @foreach($cat->types ?? [] as $type)
                                            <span class="visa-type-tag">
                                                {{ $type->name }}
                                                <i class="fas fa-times" onclick="deleteVisaType({{ $type->id }})"></i>
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="input-group input-group-sm mt-2" style="max-width: 300px;">
                                        <input type="text" id="type-input-{{ $cat->id }}" class="form-control bg-dark text-white border-secondary" placeholder="Quick Add Type">
                                        <button class="btn btn-outline-purple" type="button" onclick="addVisaTypeQuick({{ $cat->id }})"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteCategory({{ $cat->id }})"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Security -->
        <section id="securitySection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Update Admin Password</h5>
                <form id="passwordUpdateForm">
                    @csrf
                    <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Confirm New Password</label><input type="password" name="new_password_confirmation" class="form-control" required></div>
                    <button type="submit" class="btn-primary-custom">Update Password</button>
                </form>
            </div>
        </section>

        <!-- Section: Settings -->
        <section id="playstoreSection" class="dashboard-section d-none">
            <form id="playstoreSettingsForm" enctype="multipart/form-data">
                @csrf
                <div class="admin-card">
                    <h5 class="section-title">Core Identity & Contact Info</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Business Name</label>
                            <input type="text" name="app_name" class="form-control" value="{{ $settings->app_name ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slogan / Tagline</label>
                            <input type="text" name="tags" class="form-control" value="{{ $settings->tags ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $settings->phone ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Support Email</label>
                            <input type="text" name="email" class="form-control" value="{{ $settings->email ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Office Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $settings->address ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Footer Copyright Text</label>
                            <input type="text" name="footer_text" class="form-control" value="{{ $settings->footer_text ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo Icon</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-preview-box">
                                    <img src="{{ $settings->app_icon ?? '' }}" id="iconPreview" alt="App Icon">
                                </div>
                                <input type="text" name="app_icon" class="form-control" placeholder="Icon URL" value="{{ $settings->app_icon ?? '' }}">
                                <div class="position-relative">
                                    <input type="file" name="app_icon_file" id="app_icon_file" class="d-none" accept="image/*" onchange="previewIcon(this)">
                                    <button type="button" class="btn btn-primary-custom py-2" onclick="document.getElementById('app_icon_file').click()">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h5 class="section-title">Background Banners</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Home Page Banner</label>
                            <div class="banner-preview-box">
                                <img src="{{ !empty($settings->home_banner) ? $settings->home_banner : 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" id="homeBannerPreview" alt="Homepage Banner">
                            </div>
                            <div class="d-flex gap-2">
                                <input type="text" name="home_banner" class="form-control" placeholder="Image URL" value="{{ $settings->home_banner ?? '' }}">
                                <input type="file" name="home_banner_file" id="home_banner_file" class="d-none" accept="image/*" onchange="document.getElementById('homeBannerPreview').src = URL.createObjectURL(this.files[0])">
                                <button type="button" class="btn btn-outline-info" onclick="document.getElementById('home_banner_file').click()"><i class="fas fa-camera"></i></button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Inner Pages Banner</label>
                            <div class="banner-preview-box">
                                <img src="{{ !empty($settings->inner_banner) ? $settings->inner_banner : 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" id="innerBannerPreview" alt="Inner Pages Banner">
                            </div>
                            <div class="d-flex gap-2">
                                <input type="text" name="inner_banner" class="form-control" placeholder="Image URL" value="{{ $settings->inner_banner ?? '' }}">
                                <input type="file" name="inner_banner_file" id="inner_banner_file" class="d-none" accept="image/*" onchange="document.getElementById('innerBannerPreview').src = URL.createObjectURL(this.files[0])">
                                <button type="button" class="btn btn-outline-info" onclick="document.getElementById('inner_banner_file').click()"><i class="fas fa-camera"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h5 class="section-title">About & Description</h5>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Portal Description / About Text</label>
                            <textarea name="description" class="form-control" rows="6">{{ $settings->description ?? '' }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary-custom btn-save-main py-3 mt-4">
                        <i class="fas fa-save"></i> Save All Settings
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        function showSection(sectionId) {
            localStorage.setItem('activeAdminTab', sectionId);
            document.querySelectorAll('.dashboard-section').forEach(s => s.classList.add('d-none'));
            const targetSection = document.getElementById(sectionId + 'Section');
            if (targetSection) targetSection.classList.remove('d-none');
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            const targetNav = document.getElementById('nav-' + sectionId);
            if (targetNav) targetNav.classList.add('active');
        }

        window.onload = function() {
            const activeTab = localStorage.getItem('activeAdminTab') || 'dashboard';
            showSection(activeTab === 'jobs' ? 'dashboard' : activeTab);
        };

        async function updateRequestStatus(id, status) {
            const res = await fetch("{{ route('admin.requests.update_status') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id, status })
            });
            if (res.ok) alert("Status updated!");
        }

        async function deleteRequest(id) {
            if (!confirm('Delete this visa request? This action cannot be undone.')) return;

            const res = await fetch("{{ route('admin.requests.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });

            if (res.ok) {
                location.reload();
            } else {
                alert('Unable to delete the visa request.');
            }
        }

        function previewIcon(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('iconPreview').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('playstoreSettingsForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.settings.update') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new FormData(this)
            });
            if (res.ok) alert("Settings saved!");
        };

        const currencyFeeRows = document.getElementById('countryCurrencyFeeRows');
        const addCurrencyFeeRow = document.getElementById('addCurrencyFeeRow');
        const nationalityCurrencies = @json($nationalityCurrencies);

        function createCurrencyFeeRow() {
            const row = document.createElement('div');
            row.className = 'row g-2 currency-fee-row mt-1';
            row.innerHTML = `
                <div class="col-md-3">
                    <select name="currency[]" class="form-select">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <input type="number" name="fee[]" class="form-control" step="0.01" min="0" placeholder="150">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-fee-row w-100">Remove</button>
                </div>
            `;
            const currencySelect = row.querySelector('select[name="currency[]"]');
            if (nationalityCurrencies.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No nationality currencies added';
                option.disabled = true;
                currencySelect.appendChild(option);
            } else {
                nationalityCurrencies.forEach(currency => {
                    const option = document.createElement('option');
                    option.value = currency;
                    option.textContent = currency;
                    currencySelect.appendChild(option);
                });
            }
            row.querySelector('.remove-fee-row').addEventListener('click', function() {
                row.remove();
            });
            return row;
        }

        if (addCurrencyFeeRow) {
            addCurrencyFeeRow.addEventListener('click', function() {
                currencyFeeRows.appendChild(createCurrencyFeeRow());
            });
        }

        if (currencyFeeRows) {
            currencyFeeRows.querySelectorAll('.remove-fee-row').forEach(function(button) {
                button.addEventListener('click', function() {
                    const row = button.closest('.currency-fee-row');
                    if (row) row.remove();
                });
            });
        }

        document.getElementById('addCountryForm').onsubmit = async function(e) {
            e.preventDefault();
            const form = this;
            const errorBox = document.getElementById('countryFormError');
            const submitButton = document.getElementById('addCountrySubmit');
            errorBox.classList.add('d-none');
            errorBox.textContent = '';
            submitButton.disabled = true;
            submitButton.textContent = 'Adding...';

            try {
                const res = await fetch("{{ route('admin.countries.add') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });
                const result = await res.json();

                if (!res.ok) {
                    const validationMessages = result.errors
                        ? Object.values(result.errors).flat().join(' ')
                        : '';
                    throw new Error(validationMessages || result.message || 'Unable to add country.');
                }

                location.reload();
            } catch (error) {
                errorBox.textContent = error.message || 'Unable to submit the form. Please try again.';
                errorBox.classList.remove('d-none');
                submitButton.disabled = false;
                submitButton.textContent = 'Add Country';
            }
        };

        document.getElementById('addNationalityForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.nationalities.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
        };

        document.getElementById('addAirportForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.airports.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
            else alert((await res.json()).message || 'Unable to add airport.');
        };

        async function deleteAirport(id) {
            if (!confirm('Delete this airport?')) return;
            const res = await fetch("{{ route('admin.airports.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });
            if (res.ok) location.reload();
            else alert((await res.json()).message || 'Unable to delete airport.');
        }

        async function deleteNationality(id) {
            if (!confirm("Delete this nationality?")) return;
            const res = await fetch("{{ route('admin.nationalities.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });
            if (res.ok) location.reload();
        }

        async function deleteCountry(id) {
            if (!confirm("Delete this country?")) return;
            const res = await fetch("{{ route('admin.countries.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });
            if (res.ok) location.reload();
        }

        document.getElementById('addCategoryForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.categories.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
        };

        async function deleteCategory(id) {
            if (!confirm("Delete this category?")) return;
            const res = await fetch("{{ route('admin.categories.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });
            if (res.ok) location.reload();
        }

        document.getElementById('addVisaTypeForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.visa_types.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
        };

        async function addVisaTypeQuick(catId) {
            const name = document.getElementById('type-input-' + catId).value;
            if (!name) return;
            const res = await fetch("{{ route('admin.visa_types.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ category_id: catId, names: name })
            });
            if (res.ok) location.reload();
        }

        async function deleteVisaType(id) {
            if (!confirm("Delete this visa type?")) return;
            const res = await fetch("{{ route('admin.visa_types.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });
            if (res.ok) location.reload();
        }

        document.getElementById('addBankAccountForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.bank_accounts.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
            else {
                const data = await res.json();
                alert(data.message || 'Unable to add bank account.');
            }
        };

        async function deleteBankAccount(id) {
            if (!confirm('Delete this bank account?')) return;
            const res = await fetch("{{ route('admin.bank_accounts.delete') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ id })
            });
            if (res.ok) location.reload();
            else {
                const data = await res.json();
                alert(data.message || 'Unable to delete bank account.');
            }
        }

        document.getElementById('passwordUpdateForm').onsubmit = async function(e) {
            e.preventDefault();
            const res = await fetch("{{ route('admin.password.update') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(this)
            });
            if (res.ok) alert("Password updated!");
        };
    </script>
</body>
</html>
