<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Catalog - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color); color:var(--text-main); font-family:'Segoe UI',sans-serif; margin:0; }
        .sidebar { width:260px; height:100vh; background:var(--sidebar-bg); border-right:1px solid var(--border-color); position:fixed; padding:20px; display:flex; flex-direction:column; z-index:1200; overflow-y:auto; }
        .brand-section { display:flex; align-items:center; gap:12px; margin-bottom:40px; }.brand-logo-img { width:80px;height:80px;object-fit:contain; }.brand-name {font-size:1.15rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}.admin-badge {margin-left:auto;color:#58a6ff;font-size:.7rem;}
        .nav-link {color:var(--text-secondary);padding:12px 15px;border-radius:8px;margin-bottom:5px;display:flex;align-items:center;text-decoration:none;}.nav-link i {width:20px;margin-right:12px;}.nav-link:hover,.nav-link.active {color:var(--text-main);background:rgba(255,255,255,.08);}
        .logout-btn {margin-top:auto;color:var(--text-secondary);border:1px solid var(--border-color);background:transparent;padding:10px;border-radius:8px;width:100%;text-align:left;}.main-content {margin-left:260px;padding:32px;min-height:100vh;}
        .catalog-card {background:var(--card-bg);border:1px solid var(--border-color);border-radius:12px;padding:22px;height:100%;}.table {--bs-table-bg:transparent;--bs-table-color:var(--text-main);--bs-table-border-color:var(--border-color);}
        @media(max-width:768px){.sidebar{width:220px;padding:15px;}.main-content{margin-left:220px;padding:20px 15px;}}
    </style>
</head><body>
    @include('admin.partials.sidebar')
    <main class="main-content"><div class="container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"><div><h1 class="h3 mb-1">Manage Catalog</h1><p class="text-secondary mb-0">Manage the options used throughout the travel and visa application portal.</p></div></div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
        <div class="row g-4">
            @foreach([
                ['type' => 'category', 'title' => 'Categories', 'add_label' => 'Category', 'items' => $categories],
                ['type' => 'subcategory', 'title' => 'Subcategories', 'add_label' => 'Subcategory', 'items' => $subcategories],
                ['type' => 'nationality', 'title' => 'Nationalities', 'add_label' => 'Nationality', 'items' => $nationalities],
                ['type' => 'country', 'title' => 'Countries', 'add_label' => 'Country', 'items' => $countries],
                ['type' => 'profession', 'title' => 'Professions', 'add_label' => 'Profession', 'items' => $professions],
                ['type' => 'job_title', 'title' => 'Job Titles', 'add_label' => 'Job Title', 'items' => $jobTitles],
            ] as $catalog)
                <div class="col-xl-6">
                    <section class="catalog-card">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3"><h2 class="h5 mb-0">{{ $catalog['title'] }}</h2><a href="{{ route('admin.catalog.create', $catalog['type']) }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Add {{ $catalog['add_label'] }}</a></div>
                        <div class="table-responsive"><table class="table align-middle mb-0">
                            @if($catalog['type'] === 'nationality')
                                <thead><tr><th>Name</th><th>Currency</th><th>ID Digits</th><th>Phone Code</th><th>Phone Digits</th><th>Airports</th><th class="text-end">Actions</th></tr></thead>
                            @elseif($catalog['type'] === 'subcategory')
                                <thead><tr><th>Subcategory</th><th>Category</th><th class="text-end">Actions</th></tr></thead>
                            @else
                                <thead><tr><th>Name</th><th class="text-end">Actions</th></tr></thead>
                            @endif
                            <tbody>
                                @forelse($catalog['items'] as $item)
                                    <tr>
                                        @if($catalog['type'] === 'nationality')
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->currency ?: '?' }}</td>
                                            <td>{{ $item->id_number_length ?: '?' }}</td>
                                            <td>{{ $item->phone_code ?: '?' }}</td>
                                            <td>{{ $item->phone_number_length ?: '?' }}</td>
                                            <td>
                                                @forelse($item->airports as $airport)
                                                    <div>{{ $airport->name }}<small class="d-block text-secondary">{{ $airport->city ?: 'City not set' }}</small></div>
                                                @empty
                                                    <span class="text-secondary">No airports</span>
                                                @endforelse
                                            </td>
                                        @elseif($catalog['type'] === 'subcategory')
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->category_name }}</td>
                                        @else
                                            <td>{{ $item->name }}</td>
                                        @endif
                                        <td class="text-end text-nowrap">
                                            <a href="{{ route('admin.catalog.edit', [$catalog['type'], $item->id]) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit {{ $item->name }}" title="Edit"><i class="fas fa-pen"></i></a>
                                            <form class="d-inline" action="{{ route('admin.catalog.delete', [$catalog['type'], $item->id]) }}" method="POST" onsubmit="return confirm('Delete this {{ strtolower($catalog['add_label']) }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Delete {{ $item->name }}" title="Delete"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ $catalog['type'] === 'nationality' ? 7 : ($catalog['type'] === 'subcategory' ? 3 : 2) }}" class="text-center text-secondary py-3">No {{ strtolower($catalog['title']) }} added.</td></tr>
                                @endforelse
                            </tbody>
                        </table></div>
                    </section>
                </div>
            @endforeach
        </div>
    </div></main>
</body></html>
