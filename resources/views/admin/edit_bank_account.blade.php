<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bank Account - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color: #0b0e14; --sidebar-bg: #0f131a; --card-bg: #161b22; --text-main: #ffffff; --text-secondary: #8b949e; --accent-blue: #007bff; --border-color: #30363d; }
        body { background: var(--bg-color); color: var(--text-main); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; }
        .sidebar { width: 260px; height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); position: fixed; padding: 20px; display: flex; flex-direction: column; z-index: 1200; overflow-y: auto; overscroll-behavior-y: contain; }
        .brand-section { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }
        .brand-logo-img { width: 80px; height: 80px; object-fit: contain; }
        .brand-name { font-size: 1.15rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-badge { background: rgba(0, 123, 255, .1); color: #58a6ff; font-size: .7rem; padding: 2px 8px; border-radius: 4px; border: 1px solid var(--accent-blue); margin-left: auto; }
        .nav-link { color: var(--text-secondary); padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; display: flex; align-items: center; text-decoration: none; }
        .nav-link i { width: 20px; margin-right: 12px; }
        .nav-link:hover { color: var(--text-main); background: rgba(255, 255, 255, .05); }
        .logout-btn { margin-top: auto; color: var(--text-secondary); border: 1px solid var(--border-color); background: transparent; padding: 10px; border-radius: 8px; width: 100%; text-align: left; }
        .main-content { margin-left: 260px; padding: 32px; min-height: 100vh; }
        .page-shell { max-width: 900px; }
        .editor-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; }
        .form-label { color: #c9d1d9; }
        .form-control { background: #0d1117; border-color: var(--border-color); color: var(--text-main); }
        .form-control:focus { background: #0d1117; border-color: var(--accent-blue); color: var(--text-main); box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .2); }
        .form-control::placeholder { color: #6e7681; }
        .text-muted { color: var(--text-secondary) !important; }
        .btn-light { background: transparent; border-color: var(--border-color); color: var(--text-secondary); }
        .btn-light:hover { background: rgba(255, 255, 255, .05); color: var(--text-main); }
        @media (max-width: 768px) { .sidebar { width: 220px; padding: 15px; } .main-content { margin-left: 220px; padding: 20px 15px; } .admin-badge { display: none; } }
        @media (max-width: 575px) { .sidebar { position: static; width: 100%; height: auto; } .main-content { margin-left: 0; padding: 20px 12px; } }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="container page-shell py-1 py-md-3">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" onclick="localStorage.setItem('activeAdminTab', 'bank-accounts')">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <div>
                    <h1 class="h3 mb-1">Edit Bank Account</h1>
                    <p class="text-muted mb-0">Account #{{ $bankAccount->id }}</p>
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

            <form action="{{ route('admin.bank_accounts.update', $bankAccount->id) }}" method="POST" class="editor-card p-3 p-md-4">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="bank_name">Bank Name</label>
                        <input id="bank_name" type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $bankAccount->bank_name) }}" maxlength="255" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="account_name">Account Holder Name</label>
                        <input id="account_name" type="text" name="account_name" class="form-control" value="{{ old('account_name', $bankAccount->account_name) }}" maxlength="255" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="account_number">Account Number</label>
                        <input id="account_number" type="text" name="account_number" class="form-control" value="{{ old('account_number', $bankAccount->account_number) }}" maxlength="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="iban">IBAN</label>
                        <input id="iban" type="text" name="iban" class="form-control" value="{{ old('iban', $bankAccount->iban) }}" maxlength="100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="branch">Branch</label>
                        <input id="branch" type="text" name="branch" class="form-control" value="{{ old('branch', $bankAccount->branch) }}" maxlength="255">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="swift_code">SWIFT / BIC Code</label>
                        <input id="swift_code" type="text" name="swift_code" class="form-control" value="{{ old('swift_code', $bankAccount->swift_code) }}" maxlength="50">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="currency">Currency</label>
                        <input id="currency" type="text" name="currency" class="form-control" value="{{ old('currency', $bankAccount->currency) }}" maxlength="10" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light" onclick="localStorage.setItem('activeAdminTab', 'bank-accounts')">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
