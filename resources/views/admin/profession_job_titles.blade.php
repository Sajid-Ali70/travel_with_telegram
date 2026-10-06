<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professions &amp; Job Titles - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color: #0b0e14; --sidebar-bg: #0f131a; --card-bg: #161b22; --text-main: #fff; --text-secondary: #8b949e; --border-color: #30363d; }
        body { background: var(--bg-color); color: var(--text-main); font-family: 'Segoe UI', sans-serif; margin: 0; }
        .sidebar { width: 260px; height: 100vh; background: var(--sidebar-bg); border-right: 1px solid var(--border-color); position: fixed; padding: 20px; display: flex; flex-direction: column; z-index: 1200; overflow-y: auto; }
        .brand-section { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }
        .brand-logo-img { width: 80px; height: 80px; object-fit: contain; }
        .brand-name { font-size: 1.15rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-badge { margin-left: auto; color: #58a6ff; font-size: .7rem; }
        .nav-link { color: var(--text-secondary); padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; display: flex; align-items: center; text-decoration: none; }
        .nav-link i { width: 20px; margin-right: 12px; }
        .nav-link:hover, .nav-link.active { color: var(--text-main); background: rgba(255,255,255,.08); }
        .logout-btn { margin-top: auto; color: var(--text-secondary); border: 1px solid var(--border-color); background: transparent; padding: 10px; border-radius: 8px; width: 100%; text-align: left; }
        .main-content { margin-left: 260px; padding: 32px; min-height: 100vh; }
        .admin-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; }
        .form-control { background: #0d1117; border-color: var(--border-color); color: var(--text-main); }
        .form-control:focus { background: #0d1117; color: var(--text-main); }
        .table { --bs-table-bg: transparent; --bs-table-color: var(--text-main); --bs-table-border-color: var(--border-color); }
        @media (max-width: 768px) { .sidebar { width: 220px; padding: 15px; } .main-content { margin-left: 220px; padding: 20px 15px; } }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="main-content">
        <div class="container-fluid">
            <h1 class="h3 mb-4">Professions &amp; Job Titles</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="row g-4">
                @foreach([
                    'profession' => ['title' => 'Professions', 'options' => $professions],
                    'job_title' => ['title' => 'Job Titles', 'options' => $jobTitles],
                ] as $type => $group)
                    <div class="col-lg-6">
                        <section class="admin-card h-100">
                            <h2 class="h5 mb-3">{{ $group['title'] }}</h2>
                            <form action="{{ route('admin.profession_job_titles.add') }}" method="POST" class="row g-2 mb-4">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="col">
                                    <label class="visually-hidden" for="{{ $type }}_name">Add {{ strtolower($group['title']) }}</label>
                                    <input id="{{ $type }}_name" type="text" name="name" class="form-control" maxlength="255" placeholder="Enter a {{ $type === 'profession' ? 'profession' : 'job title' }}" required>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead><tr><th>{{ $group['title'] }}</th><th class="text-end">Action</th></tr></thead>
                                    <tbody>
                                        @forelse($group['options'] as $option)
                                            <tr>
                                                <td>{{ $option->name }}</td>
                                                <td class="text-end">
                                                    <form action="{{ route('admin.profession_job_titles.delete', $option->id) }}" method="POST" onsubmit="return confirm('Delete this option? Existing visa requests will keep their saved value.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Delete {{ $option->name }}"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="2" class="text-center text-secondary">No options added yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>
