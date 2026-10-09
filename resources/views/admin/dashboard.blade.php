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

        .text-muted, .form-text {
            color: #ffffff !important;
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

        .request-status-modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(0, 0, 0, .7);
        }
        .request-status-modal.d-none { display: none !important; }
        .request-status-dialog {
            width: min(560px, 100%);
            max-height: 90vh;
            overflow-y: auto;
            padding: 24px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
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

        .main-content.dashboard-home {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            align-items: start;
            gap: 10px;
            padding: 16px;
        }
        .dashboard-home > .page-header,
        .dashboard-home > .alert {
            display: none !important;
        }
        .dashboard-home > #dashboardSection {
            grid-column: 1 / -1;
            width: 100%;
            margin: 0 !important;
        }
        .dashboard-home .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin: 0;
        }
        .dashboard-home .stat-card {
            min-height: 125px;
        }
        .dashboard-home .stat-info h3 {
            font-variant-numeric: tabular-nums;
        }
        .dashboard-home #countriesSection,
        .dashboard-home #nationalitiesSection {
            display: block !important;
            grid-column: span 6;
            min-width: 0;
        }
        .dashboard-home #categoriesSection {
            display: grid !important;
            grid-column: 1 / -1;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
            gap: 10px;
            min-width: 0;
        }
        .dashboard-home #categoriesSection .admin-card:nth-child(3) {
            grid-column: 1 / -1;
        }
        .dashboard-home #airportsSection {
            display: grid !important;
            grid-column: 1 / -1;
            grid-template-columns: minmax(0, 1fr);
            align-items: start;
            gap: 10px;
            min-width: 0;
        }
        .dashboard-home #countriesSection .admin-card,
        .dashboard-home #nationalitiesSection .admin-card,
        .dashboard-home #categoriesSection .admin-card {
            min-width: 0;
            padding: 12px;
            margin-bottom: 0;
        }
        .dashboard-home .section-title { font-size: 0.9rem; }
        .dashboard-home .form-label { font-size: 0.72rem; margin-bottom: 4px; }
        .dashboard-home .form-control,
        .dashboard-home .form-select {
            min-width: 0;
            padding: 6px 8px;
            font-size: 0.76rem;
        }
        .dashboard-home .row {
            --bs-gutter-x: 0.5rem;
            --bs-gutter-y: 0.5rem;
        }
        .dashboard-home #countriesSection .table-responsive,
        .dashboard-home #nationalitiesSection .table-responsive,
        .dashboard-home #categoriesSection .table-responsive {
            max-height: 240px;
            overflow: auto;
        }
        .dashboard-home .reviews-table th,
        .dashboard-home .reviews-table td {
            padding: 6px;
            font-size: 0.7rem;
            overflow-wrap: anywhere;
        }
        .dashboard-home .reviews-table { table-layout: fixed; }

        @media (max-width: 1199px) {
            .main-content.dashboard-home { display: block; }
            .dashboard-home #countriesSection,
            .dashboard-home #nationalitiesSection,
            .dashboard-home #airportsSection,
            .dashboard-home #categoriesSection {
                margin-bottom: 16px;
            }
            .dashboard-home #airportsSection { display: block !important; }
            .dashboard-home #airportsSection .admin-card { margin-bottom: 16px; }
            .dashboard-home #categoriesSection { display: block !important; }
            .dashboard-home #categoriesSection .admin-card { margin-bottom: 16px; }
        }

        .dashboard-home #countriesSection,
        .dashboard-home #nationalitiesSection,
        .dashboard-home #airportsSection,
        .dashboard-home #categoriesSection {
            display: none !important;
        }
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
                    <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1); color: var(--accent-blue);"><i class="fas fa-file-signature"></i></div>
                    <div class="stat-info"><p>Total Requests</p><h3 data-count="{{ $stats['total_requests'] ?? 0 }}">0</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(210, 153, 34, 0.1); color: var(--accent-warning);"><i class="fas fa-clock"></i></div>
                    <div class="stat-info"><p>Pending Requests</p><h3 data-count="{{ $stats['pending_requests'] ?? 0 }}">0</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(35, 134, 54, 0.1); color: var(--accent-success);"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info"><p>Approved Requests</p><h3 data-count="{{ $stats['approved_requests'] ?? 0 }}">0</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(163, 113, 247, 0.1); color: var(--accent-purple);"><i class="fas fa-th-large"></i></div>
                    <div class="stat-info"><p>Total Categories</p><h3 data-count="{{ $stats['total_categories'] ?? 0 }}">0</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(88, 166, 255, 0.1); color: var(--accent-blue);"><i class="fas fa-list"></i></div>
                    <div class="stat-info"><p>Total Subcategories</p><h3 data-count="{{ $stats['total_subcategories'] ?? 0 }}">0</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(240, 136, 62, 0.1); color: var(--accent-warning);"><i class="fas fa-user-tie"></i></div>
                    <div class="stat-info"><p>Total Professions</p><h3 data-count="{{ $stats['total_professions'] ?? 0 }}">0</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(86, 211, 100, 0.1); color: var(--accent-success);"><i class="fas fa-briefcase"></i></div>
                    <div class="stat-info"><p>Total Job Titles</p><h3 data-count="{{ $stats['total_job_titles'] ?? 0 }}">0</h3></div>
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
                                <td>
                                    {{ $req->id }}<br>
                                    <small class="text-info">{{ $req->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($req->id, $req->created_at) }}</small>
                                </td>
                                <td>
                                    <strong>{{ $req->first_name }} {{ $req->last_name }}</strong><br>
                                    <small class="text-muted">DOB: {{ $req->dob }}</small><br>
                                    <small class="text-muted">Nationality: {{ $req->nationality ?: 'Not provided' }}</small>
                                    @if(!empty($req->profession))
                                        <br><small class="text-muted">Profession: {{ $req->profession }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $req->email }}<br>
                                    {{ $req->mobile_number }}
                                </td>
                                <td>
                                    {{ $req->destination_country }}<br>
                                    <small>{{ $req->visa_category }} - {{ $req->visa_type }}</small>
                                    @if(!empty($req->job_title) || !empty($req->selected_job_titles))
                                        <br><small class="text-info">Job title: {{ $req->job_title ?: $req->selected_job_titles }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $req->passport_number }}<br>
                                    @if($req->passport_photo)
                                        <a href="{{ $req->passport_photo }}" target="_blank" class="btn btn-sm btn-outline-info py-0">View Photo</a>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ in_array($req->status, ['Visa Approved from Embassy', 'Visa Approved', 'Payment Verified', 'Visa Issued', 'Flight Ticket Booked'], true) ? 'success' : ($req->status === 'Fee Payment' ? 'warning text-dark' : 'secondary') }}">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.requests.edit', $req->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit request, profession and job title" aria-label="Edit request, profession and job title for applicant {{ $req->first_name }} {{ $req->last_name }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @php
                                        $requestNationalityCurrency = $nationalities->firstWhere('name', $req->nationality)->currency ?? '';
                                    @endphp
                                    <button type="button" class="btn btn-sm btn-outline-info me-1" title="View and update status" aria-label="View and update status for request {{ $req->id }}"
                                        data-id="{{ $req->id }}"
                                        data-pdf-url="{{ route('admin.requests.pdf', $req->id) }}"
                                        data-status="{{ $req->status }}"
                                        data-fee="{{ $req->visa_fee ?? '' }}"
                                        data-currency="{{ $req->visa_fee_currency ?? $requestNationalityCurrency }}"
                                        data-bank="{{ $req->bank_name ?? '' }}"
                                        data-account-number="{{ $req->account_number ?? '' }}"
                                        data-account-holder="{{ $req->account_holder_name ?? '' }}"
                                        data-agent-name="{{ $req->agent_name ?? '' }}"
                                        data-agent-contact-number="{{ $req->agent_contact_number ?? '' }}"
                                        data-has-issued-document="{{ !empty($req->issued_visa_document) ? '1' : '0' }}"
                                        data-issued-document-url="{{ !empty($req->issued_visa_document) ? route('admin.requests.visa_document', $req->id) : '' }}"
                                        onclick="openRequestStatusModal(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
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

            @php
                $statusCurrencies = $nationalities->pluck('currency')
                    ->filter(fn ($currency) => !empty(trim($currency ?? '')))
                    ->map(fn ($currency) => strtoupper(trim($currency)))
                    ->unique()
                    ->sort()
                    ->values();
            @endphp
            <div id="requestStatusModal" class="request-status-modal d-none" role="dialog" aria-modal="true" aria-labelledby="requestStatusModalTitle">
                <form id="requestStatusForm" class="request-status-dialog">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 id="requestStatusModalTitle" class="mb-0">Update Request Status</h5>
                        <button type="button" class="btn btn-sm btn-outline-light" onclick="closeRequestStatusModal()" aria-label="Close">&times;</button>
                    </div>
                    <input type="hidden" name="id" id="requestStatusId">
                    <div class="mb-3">
                        <label class="form-label" for="requestStatusValue">Status</label>
                        <select name="status" id="requestStatusValue" class="form-select" required>
                            @foreach(['Visa Application Submitted', 'Documents Verification', 'Visa Approved from Embassy', 'Visa Issued', 'Visa Rejected due to Documents Verification Failed', 'Visa Rejected due to Non Payment of Fee'] as $statusOption)
                                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="requestIssuedVisaDocumentFields" class="mb-3 d-none">
                        <label class="form-label" for="requestIssuedVisaDocument">Issued Visa Document</label>
                        <input id="requestIssuedVisaDocument" type="file" name="issued_visa_document" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        <div id="requestIssuedVisaDocumentHelp" class="form-text">PDF, JPG, JPEG, or PNG; maximum 10 MB.</div>
                        <a id="requestIssuedVisaDocumentCurrent" class="btn btn-sm btn-outline-info mt-2 d-none" href="#" target="_blank" rel="noopener">View current document</a>
                    </div>
                    <div id="requestVerificationAgentFields" class="row g-3 d-none">
                        <div class="col-md-6">
                            <label class="form-label" for="requestAgentName">Agent Name</label>
                            <input id="requestAgentName" type="text" name="agent_name" class="form-control" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="requestAgentContactNumber">Agent Contact Number</label>
                            <input id="requestAgentContactNumber" type="text" name="agent_contact_number" class="form-control" maxlength="50">
                        </div>
                    </div>
                    <div id="requestApprovalPaymentFields" class="row g-3 d-none">
                        <div class="col-md-4">
                            <label class="form-label" for="requestVisaFee">Visa Fee</label>
                            <input id="requestVisaFee" type="number" name="visa_fee" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="requestVisaCurrency">Currency</label>
                            <select id="requestVisaCurrency" name="visa_fee_currency" class="form-select">
                                <option value="">Select currency</option>
                                @foreach($statusCurrencies as $currency)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" for="requestBankName">Bank Name</label>
                            <input id="requestBankName" type="text" name="bank_name" class="form-control" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="requestAccountNumber">Account Number</label>
                            <input id="requestAccountNumber" type="text" name="account_number" class="form-control" maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="requestAccountHolder">Account Holder Name</label>
                            <input id="requestAccountHolder" type="text" name="account_holder_name" class="form-control" maxlength="255">
                        </div>
                    </div>
                    <div id="requestStatusError" class="alert alert-danger d-none mt-3 mb-0" role="alert"></div>
                    <div class="d-flex justify-content-between gap-2 mt-4">
                        <a id="requestStatusPdf" href="#" target="_blank" rel="noopener" class="btn btn-outline-success"><i class="fas fa-file-pdf me-1"></i>Download PDF</a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-light" onclick="closeRequestStatusModal()">Cancel</button>
                            <button type="submit" id="requestStatusSave" class="btn btn-primary">Save Status</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Section: Ticket Requests -->
        <section id="ticketsSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Flight Ticket Requests</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Applicant</th>
                                <th>Destination / Visa</th>
                                <th>Preferred Dates</th>
                                <th>Airport</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ticket_requests as $ticketRequest)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.requests.edit', $ticketRequest->visa_request_id) }}" class="text-info">#{{ $ticketRequest->id }}</a><br>
                                    <small>Visa #{{ $ticketRequest->visa_request_id }}</small>
                                </td>
                                <td>
                                    {{ $ticketRequest->first_name }} {{ $ticketRequest->last_name }}<br>
                                    <small>{{ $ticketRequest->email }}</small>
                                </td>
                                <td>
                                    {{ $ticketRequest->destination_country }}<br>
                                    <small>{{ $ticketRequest->visa_category }} - {{ $ticketRequest->visa_type }}</small>
                                </td>
                                <td>
                                    {{ $ticketRequest->preferred_date_start ? \Carbon\Carbon::parse($ticketRequest->preferred_date_start)->format('d M Y') : '—' }}
                                    to
                                    {{ $ticketRequest->preferred_date_end ? \Carbon\Carbon::parse($ticketRequest->preferred_date_end)->format('d M Y') : '—' }}
                                </td>
                                <td>{{ $airports->firstWhere('code', $ticketRequest->preferred_airport)->name ?? $ticketRequest->preferred_airport }}</td>
                                <td><span class="badge bg-info text-dark">{{ $ticketRequest->status }}</span></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-info" title="View and update ticket status" aria-label="View and update ticket {{ $ticketRequest->id }}"
                                        data-ticket-id="{{ $ticketRequest->id }}"
                                        data-ticket-status="{{ $ticketRequest->status }}"
                                        data-ticket-details="{{ $ticketRequest->details ?? '' }}"
                                        onclick="openTicketStatusModal(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4">No ticket requests yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="ticketStatusModal" class="request-status-modal d-none" role="dialog" aria-modal="true" aria-labelledby="ticketStatusModalTitle">
                <form id="ticketStatusForm" class="request-status-dialog">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 id="ticketStatusModalTitle" class="mb-0">Update Ticket Request</h5>
                        <button type="button" class="btn btn-sm btn-outline-light" onclick="closeTicketStatusModal()" aria-label="Close">&times;</button>
                    </div>
                    <input type="hidden" name="id" id="ticketStatusId">
                    <div class="mb-3">
                        <label class="form-label" for="ticketStatusValue">Ticket Status</label>
                        <select name="status" id="ticketStatusValue" class="form-select" required>
                            @foreach(['Requested', 'Processing', 'Booked', 'Cancelled'] as $ticketStatus)
                                <option value="{{ $ticketStatus }}">{{ $ticketStatus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ticketDetailsValue">Ticket Details</label>
                        <textarea name="details" id="ticketDetailsValue" class="form-control" rows="4" maxlength="10000" placeholder="Airline, flight number, route, departure time, ticket number..."></textarea>
                    </div>
                    <div id="ticketStatusError" class="alert alert-danger d-none" role="alert"></div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-light" onclick="closeTicketStatusModal()">Cancel</button>
                        <button type="submit" id="ticketStatusSave" class="btn btn-primary">Save Ticket Status</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Section: Countries -->
        <section id="countriesSection" class="dashboard-section d-none">
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

                    <div id="countryFormError" class="alert alert-danger mt-3 d-none" role="alert"></div>
                    <button type="submit" id="addCountrySubmit" class="btn-primary-custom mt-3">Add Country</button>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Manage Countries</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Flag</th><th>Country Name</th><th>Currencies</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($countries as $country)
                            @php
                                $displayCurrencies = json_decode($country->currencies ?? '[]', true);
                                $displayCurrencies = is_array($displayCurrencies) ? $displayCurrencies : [];
                                if (empty($displayCurrencies) && !empty($country->visa_fee_details)) {
                                    $legacyFees = json_decode($country->visa_fee_details, true);
                                    if (is_array($legacyFees)) {
                                        $displayCurrencies = array_column($legacyFees, 'currency');
                                    }
                                }
                                if (empty($displayCurrencies) && !empty($country->currency)) {
                                    $displayCurrencies = [$country->currency];
                                }
                                $displayCurrencies = array_values(array_unique(array_filter(array_map('strtoupper', $displayCurrencies))));
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
                                <td>{{ !empty($displayCurrencies) ? implode(', ', $displayCurrencies) : 'N/A' }}</td>
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
                            <label class="form-label">Phone Digits</label>
                            <input type="number" name="phone_number_length" class="form-control" placeholder="10" min="1" max="30">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">ID Digits</label>
                            <input type="number" name="id_number_length" class="form-control" placeholder="13" min="1" max="30">
                        </div>
                    </div>
                    <h6 class="section-title mt-3">Airports for this nationality</h6>
                    <div id="nationalityAirportRows">
                        <div class="nationality-airport-row row g-2 align-items-end mb-2">
                            <div class="col-md-5">
                                <label class="form-label">Airport Name</label>
                                <input type="text" name="airports[0][name]" class="form-control" maxlength="255" placeholder="e.g. Jinnah International Airport" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">City</label>
                                <input type="text" name="airports[0][city]" class="form-control" maxlength="255" placeholder="e.g. Karachi" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger w-100" data-remove-nationality-airport aria-label="Remove airport row" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="addNationalityError" class="alert alert-danger d-none mt-3" role="alert"></div>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <button type="button" id="addNationalityAirportRow" class="btn btn-outline-info">
                            <i class="fas fa-plus me-1"></i> Add Airport Row
                        </button>
                        <button type="submit" id="addNationalitySubmit" class="btn-primary-custom">Add Nationality and Airports</button>
                    </div>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Manage Nationalities</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Nationality</th><th>Currency</th><th>Phone Code</th><th>Phone Digits</th><th>ID Digits</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($nationalities as $nationality)
                            <tr>
                                <td>{{ $nationality->id }}</td>
                                <td>{{ $nationality->name }}</td>
                                <td>{{ $nationality->currency ?? '—' }}</td>
                                <td>{{ $nationality->phone_code ?? '—' }}</td>
                                <td>{{ $nationality->phone_number_length ?? '—' }}</td>
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
                <h5 class="section-title">Manage Airports</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>Airport Name</th><th>City</th><th>Nationality</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($airports as $airport)
                            <tr>
                                <td>{{ $airport->name }}</td>
                                <td>{{ $airport->city ?? '—' }}</td>
                                <td>{{ $airport->country ?? '—' }}</td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteAirport({{ $airport->id }})" title="Delete airport"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">No airports added.</td></tr>
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
                <form id="addCategoryForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Tourist Visa" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <select name="country_id" class="form-select" required>
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-suitcase-rolling" value="fas fa-suitcase-rolling">
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
                        <thead><tr><th>ID</th><th>Icon</th><th>Category Name & Types</th><th>Country</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(!empty($cat->icon))
                                            <div class="cat-icon-preview"><i class="{{ $cat->icon }}"></i></div>
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
                                <td>{{ $countries->firstWhere('id', $cat->country_id)->name ?? '—' }}</td>
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
            const isDashboard = sectionId === 'dashboard';
            document.querySelector('.main-content').classList.toggle('dashboard-home', isDashboard);
            const targetSection = document.getElementById(sectionId + 'Section');
            if (targetSection) targetSection.classList.remove('d-none');
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            const targetNav = document.getElementById('nav-' + sectionId);
            if (targetNav) targetNav.classList.add('active');
        }

        function animateDashboardCounts() {
            document.querySelectorAll('#dashboardSection [data-count]').forEach(counter => {
                const target = Number.parseInt(counter.dataset.count, 10) || 0;
                const duration = 1000;
                const startTime = performance.now();

                function updateCount(currentTime) {
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    counter.textContent = Math.floor(target * progress).toLocaleString();
                    if (progress < 1) requestAnimationFrame(updateCount);
                }

                counter.textContent = '0';
                requestAnimationFrame(updateCount);
            });
        }

        window.onload = function() {
            const activeTab = localStorage.getItem('activeAdminTab') || 'dashboard';
            showSection(activeTab === 'jobs' ? 'dashboard' : activeTab);
            animateDashboardCounts();
        };

        const requestStatusModal = document.getElementById('requestStatusModal');
        const requestStatusForm = document.getElementById('requestStatusForm');
        const requestStatusValue = document.getElementById('requestStatusValue');
        const requestVerificationAgentFields = document.getElementById('requestVerificationAgentFields');
        const requestApprovalPaymentFields = document.getElementById('requestApprovalPaymentFields');
        const requestIssuedVisaDocumentFields = document.getElementById('requestIssuedVisaDocumentFields');
        const requestIssuedVisaDocumentInput = document.getElementById('requestIssuedVisaDocument');
        const requestIssuedVisaDocumentCurrent = document.getElementById('requestIssuedVisaDocumentCurrent');
        let requestHasIssuedVisaDocument = false;

        function toggleRequestApprovalFields() {
            const isApproved = requestStatusValue.value === 'Visa Approved from Embassy';
            const isVerification = requestStatusValue.value === 'Documents Verification';
            const isVisaIssued = requestStatusValue.value === 'Visa Issued';

            requestVerificationAgentFields.classList.toggle('d-none', !isVerification);
            requestVerificationAgentFields.querySelectorAll('input').forEach(field => {
                field.required = isVerification;
            });

            requestApprovalPaymentFields.classList.toggle('d-none', !isApproved);
            requestApprovalPaymentFields.querySelectorAll('input, select').forEach(field => {
                field.required = isApproved;
            });

            requestIssuedVisaDocumentFields.classList.toggle('d-none', !isVisaIssued);
            requestIssuedVisaDocumentInput.required = isVisaIssued && !requestHasIssuedVisaDocument;
        }

        function openRequestStatusModal(button) {
            requestStatusForm.reset();
            document.getElementById('requestStatusId').value = button.dataset.id;
            document.getElementById('requestStatusPdf').href = button.dataset.pdfUrl;
            requestHasIssuedVisaDocument = button.dataset.hasIssuedDocument === '1';
            requestIssuedVisaDocumentCurrent.href = button.dataset.issuedDocumentUrl || '#';
            requestIssuedVisaDocumentCurrent.classList.toggle('d-none', !requestHasIssuedVisaDocument);
            const legacyStatusLabels = {
                'Verification of Documents Successful': 'Documents Verification Completed, Request Submitted to Embassy',
                'Visa Approved': 'Visa Approved from Embassy',
                'Fee Payment': 'Visa Approved from Embassy',
                'Payment Verified': 'Visa Approved from Embassy',
                'Flight Ticket Booked': 'Visa Approved from Embassy',
                'Visa Rejected - Document Verification Failed': 'Visa Rejected due to Documents Verification Failed',
                'Application Rejected': 'Visa Rejected due to Documents Verification Failed',
                'rejected': 'Visa Rejected due to Documents Verification Failed',
                'Visa Rejected - Fee Not Paid': 'Visa Rejected due to Non Payment of Fee'
            };
            requestStatusValue.value = legacyStatusLabels[button.dataset.status] || button.dataset.status;
            document.getElementById('requestVisaFee').value = button.dataset.fee;
            document.getElementById('requestBankName').value = button.dataset.bank;
            document.getElementById('requestAccountNumber').value = button.dataset.accountNumber;
            document.getElementById('requestAccountHolder').value = button.dataset.accountHolder;
            document.getElementById('requestAgentName').value = button.dataset.agentName || '';
            document.getElementById('requestAgentContactNumber').value = button.dataset.agentContactNumber || '';

            const currencySelect = document.getElementById('requestVisaCurrency');
            const currency = (button.dataset.currency || '').toUpperCase();
            if (currency && !Array.from(currencySelect.options).some(option => option.value === currency)) {
                currencySelect.add(new Option(currency, currency));
            }
            currencySelect.value = currency;

            const errorBox = document.getElementById('requestStatusError');
            errorBox.classList.add('d-none');
            errorBox.textContent = '';
            toggleRequestApprovalFields();
            requestStatusModal.classList.remove('d-none');
            document.getElementById('requestStatusValue').focus();
        }

        function closeRequestStatusModal() {
            requestStatusModal.classList.add('d-none');
        }

        requestStatusValue.addEventListener('change', toggleRequestApprovalFields);

        requestStatusForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const saveButton = document.getElementById('requestStatusSave');
            const errorBox = document.getElementById('requestStatusError');
            saveButton.disabled = true;
            errorBox.classList.add('d-none');

            try {
                const formData = new FormData(requestStatusForm);
                const response = await fetch("{{ route('admin.requests.update_status') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const contentType = response.headers.get('content-type') || '';
                const result = contentType.includes('application/json') ? await response.json() : {};
                if (!response.ok || !contentType.includes('application/json')) {
                    const messages = result.errors ? Object.values(result.errors).flat().join(' ') : '';
                    const message = response.redirected
                        ? 'Your admin session may have expired. Please sign in again.'
                        : `Unable to update request status (HTTP ${response.status}). Check the application log for details.`;
                    throw new Error(messages || result.message || message);
                }
                location.reload();
            } catch (error) {
                errorBox.textContent = error.message;
                errorBox.classList.remove('d-none');
                saveButton.disabled = false;
            }
        });

        const ticketStatusModal = document.getElementById('ticketStatusModal');
        const ticketStatusForm = document.getElementById('ticketStatusForm');

        function openTicketStatusModal(button) {
            ticketStatusForm.reset();
            document.getElementById('ticketStatusId').value = button.dataset.ticketId;
            document.getElementById('ticketStatusValue').value = button.dataset.ticketStatus;
            document.getElementById('ticketDetailsValue').value = button.dataset.ticketDetails;
            const errorBox = document.getElementById('ticketStatusError');
            errorBox.classList.add('d-none');
            errorBox.textContent = '';
            ticketStatusModal.classList.remove('d-none');
            document.getElementById('ticketStatusValue').focus();
        }

        function closeTicketStatusModal() {
            ticketStatusModal.classList.add('d-none');
        }

        ticketStatusForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const saveButton = document.getElementById('ticketStatusSave');
            const errorBox = document.getElementById('ticketStatusError');
            saveButton.disabled = true;
            errorBox.classList.add('d-none');

            try {
                const formData = Object.fromEntries(new FormData(ticketStatusForm).entries());
                const response = await fetch("{{ route('admin.ticket_requests.update_status') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                const result = await response.json();
                if (!response.ok) {
                    const messages = result.errors ? Object.values(result.errors).flat().join(' ') : '';
                    throw new Error(messages || result.message || 'Unable to update ticket status.');
                }
                location.reload();
            } catch (error) {
                errorBox.textContent = error.message;
                errorBox.classList.remove('d-none');
                saveButton.disabled = false;
            }
        });

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
            const form = this;
            const errorBox = document.getElementById('addNationalityError');
            const submitButton = document.getElementById('addNationalitySubmit');
            errorBox.classList.add('d-none');
            errorBox.textContent = '';
            submitButton.disabled = true;

            try {
                const response = await fetch("{{ route('admin.nationalities.add') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });
                const result = await response.json();
                if (!response.ok) {
                    const messages = result.errors ? Object.values(result.errors).flat().join(' ') : '';
                    throw new Error(messages || result.message || 'Unable to add nationality and airports.');
                }
                location.reload();
            } catch (error) {
                errorBox.textContent = error.message || 'Unable to add nationality and airports.';
                errorBox.classList.remove('d-none');
                submitButton.disabled = false;
            }
        };

        const nationalityAirportRows = document.getElementById('nationalityAirportRows');
        let nextNationalityAirportIndex = nationalityAirportRows.querySelectorAll('.nationality-airport-row').length;

        document.getElementById('addNationalityAirportRow').addEventListener('click', function() {
            const row = document.createElement('div');
            const index = nextNationalityAirportIndex++;
            row.className = 'nationality-airport-row row g-2 align-items-end mb-2';
            row.innerHTML = `
                <div class="col-md-5">
                    <label class="form-label">Airport Name</label>
                    <input type="text" name="airports[${index}][name]" class="form-control" maxlength="255" placeholder="e.g. Jinnah International Airport" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">City</label>
                    <input type="text" name="airports[${index}][city]" class="form-control" maxlength="255" placeholder="e.g. Karachi" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100" data-remove-nationality-airport aria-label="Remove airport row">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>`;
            nationalityAirportRows.appendChild(row);
        });

        nationalityAirportRows.addEventListener('click', function(event) {
            const removeButton = event.target.closest('[data-remove-nationality-airport]');
            if (removeButton && !removeButton.disabled) {
                removeButton.closest('.nationality-airport-row').remove();
            }
        });

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
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
            else alert((await res.json()).message || 'Unable to add category.');
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
