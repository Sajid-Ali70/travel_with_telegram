<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Job Management') - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <link rel="icon" type="image/png" href="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color: #0b0e14; --sidebar-bg: #0f131a; --card-bg: #161b22; --text-main: #ffffff; --text-secondary: #8b949e; --accent-blue: #007bff; --border-color: #30363d; }
        body { background: var(--bg-color); color: var(--text-main); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; }
        .admin-sidebar { width: 250px; min-height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); position: fixed; inset: 0 auto 0 0; padding: 20px; display: flex; flex-direction: column; z-index: 10; overflow-y: auto; }
        .brand-section { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; }
        .brand-logo-img { width: 56px; height: 56px; object-fit: contain; }
        .brand-name { font-size: 1rem; font-weight: 700; overflow-wrap: anywhere; }
        .admin-nav-link { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 7px; margin-bottom: 5px; color: var(--text-secondary); text-decoration: none; }
        .admin-nav-link:hover, .admin-nav-link.active { color: var(--text-main); background: rgba(0, 123, 255, .12); }
        .admin-nav-link i { width: 18px; }
        .admin-sidebar nav { display: flex; flex-direction: column; }
        .logout-btn { margin-top: auto; color: var(--text-secondary); border: 1px solid var(--border-color); background: transparent; padding: 10px; border-radius: 7px; width: 100%; text-align: left; }
        .admin-main { margin-left: 250px; padding: 32px; min-height: 100vh; }
        .admin-content { max-width: 1250px; margin: 0 auto; }
        .admin-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px; padding: 22px; }
        .form-label { color: #c9d1d9; }
        .form-control, .form-select { background-color: #0d1117; border-color: var(--border-color); color: var(--text-main); }
        .form-control:focus, .form-select:focus { background-color: #0d1117; color: var(--text-main); border-color: var(--accent-blue); box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .2); }
        .form-control::placeholder { color: #6e7681; }
        .text-muted { color: var(--text-secondary) !important; }
        .table { --bs-table-bg: transparent; --bs-table-color: var(--text-main); --bs-table-border-color: var(--border-color); }
        .table th { color: var(--text-secondary); white-space: nowrap; }
        .table td { vertical-align: middle; }
        .table details { min-width: 170px; }
        .table details div { margin-top: 4px; }
        @media (max-width: 767px) {
            .admin-sidebar { position: static; width: 100%; min-height: 0; }
            .admin-sidebar nav { gap: 2px; }
            .admin-nav-link { margin: 0; }
            .logout-btn { margin-top: 15px; }
            .admin-main { margin-left: 0; padding: 20px 12px; }
            .admin-card { padding: 16px; }
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</body>
</html>
