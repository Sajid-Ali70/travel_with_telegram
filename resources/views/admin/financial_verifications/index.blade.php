<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Verification Requests - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color); color:var(--text-main); font-family:'Segoe UI',sans-serif; margin:0; }
        .admin-sidebar { background:var(--sidebar-bg); border-right:1px solid var(--border-color); display:flex; flex-direction:column; inset:0 auto 0 0; overflow-y:auto; overscroll-behavior-y:contain; padding:20px; position:fixed; width:250px; z-index:1200; }
        .brand-section { align-items:center; display:flex; gap:12px; margin-bottom:32px; min-width:0; }
        .brand-logo-img { flex:0 0 56px; height:56px; object-fit:contain; width:56px; }
        .brand-name { flex:1 1 auto; font-size:1rem; font-weight:700; min-width:0; overflow-wrap:anywhere; }
        .admin-badge { background:rgba(0,123,255,.1); border:1px solid rgba(88,166,255,.45); border-radius:4px; color:#58a6ff; flex:0 0 auto; font-size:.7rem; margin-left:auto; padding:3px 6px; }
        .admin-sidebar nav { display:flex; flex-direction:column; }
        .admin-sidebar .admin-nav-link { align-items:center; border-radius:7px; color:var(--text-secondary)!important; display:flex; gap:12px; margin:0 0 5px; padding:11px 12px; text-decoration:none; transition:background-color .15s ease,color .15s ease; }
        .admin-sidebar .admin-nav-link i { flex:0 0 18px; text-align:center; }
        .admin-sidebar .admin-nav-link:hover,
        .admin-sidebar .admin-nav-link.active { background:rgba(0,123,255,.12); color:var(--text-main)!important; }
        .admin-sidebar .logout-btn { background:transparent; border:1px solid var(--border-color); border-radius:7px; color:var(--text-secondary); margin-top:auto; padding:10px; text-align:left; width:100%; }
        .admin-sidebar .logout-btn:hover { border-color:#58a6ff; color:var(--text-main); }
        .main-content { margin-left:250px; min-height:100vh; padding:32px; }
        .verification-panel { background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:22px; }
        .table { --bs-table-bg:transparent; --bs-table-color:var(--text-main); --bs-table-border-color:var(--border-color); }
        .text-secondary { color:var(--text-secondary)!important; }
        @media(max-width:767px) {
            .admin-sidebar { min-height:0; position:static; width:100%; }
            .admin-sidebar nav { gap:2px; }
            .admin-sidebar .admin-nav-link { margin:0; }
            .admin-sidebar .logout-btn { margin-top:15px; }
            .main-content { margin-left:0; padding:20px 12px; }
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 mb-1">Financial Verification Requests</h1>
                <p class="text-secondary mb-0">Review submitted application and funds details.</p>
            </div>
            <section class="verification-panel">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Application No.</th>
                                <th>Applicant</th>
                                <th>Nationality</th>
                                <th>Passport No.</th>
                                <th>Available Balance</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($verificationRequests as $verificationRequest)
                                <tr>
                                    <td class="text-nowrap">{{ $verificationRequest->reference_number }}</td>
                                    <td>{{ $verificationRequest->name ?: '—' }}</td>
                                    <td>{{ $verificationRequest->nationality }}</td>
                                    <td>{{ $verificationRequest->passport_number ?: '—' }}</td>
                                    <td class="text-nowrap">
                                        {{ $verificationRequest->balance !== null ? number_format((float) $verificationRequest->balance, 2) : '—' }}
                                    </td>
                                    <td class="text-nowrap">{{ $verificationRequest->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-4">No financial verification requests have been submitted.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $verificationRequests->links() }}
            </section>
        </div>
    </main>
</body>
</html>
