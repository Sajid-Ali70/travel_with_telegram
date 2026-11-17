<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color); color:var(--text-main); font-family:'Segoe UI',sans-serif; margin:0; }
        .sidebar { width:260px; height:100vh; background:var(--sidebar-bg); border-right:1px solid var(--border-color); position:fixed; padding:20px; display:flex; flex-direction:column; z-index:1200; overflow-y:auto; }
        .brand-section { display:flex; align-items:center; gap:12px; margin-bottom:40px; }.brand-logo-img { width:80px;height:80px;object-fit:contain; }.brand-name {font-size:1.15rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}.admin-badge {margin-left:auto;color:#58a6ff;font-size:.7rem;}
        .nav-link {color:var(--text-secondary);padding:12px 15px;border-radius:8px;margin-bottom:5px;display:flex;align-items:center;text-decoration:none;}.nav-link i {width:20px;margin-right:12px;}.nav-link:hover,.nav-link.active {color:var(--text-main);background:rgba(255,255,255,.08);}
        .logout-btn {margin-top:auto;color:var(--text-secondary);border:1px solid var(--border-color);background:transparent;padding:10px;border-radius:8px;width:100%;text-align:left;}.main-content {margin-left:260px;padding:32px;min-height:100vh;}
        .service-panel {background:var(--card-bg);border:1px solid var(--border-color);border-radius:12px;padding:22px;height:100%;}
        .form-label {color:#c9d1d9;}.form-control {background:#0d1117;border-color:var(--border-color);color:var(--text-main);}.form-control:focus {background:#0d1117;border-color:#007bff;color:var(--text-main);box-shadow:none;}
        .table {--bs-table-bg:transparent;--bs-table-color:var(--text-main);--bs-table-border-color:var(--border-color);}
        @media(max-width:768px){.sidebar{width:220px;padding:15px;}.main-content{margin-left:220px;padding:20px 15px;}}
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 mb-1">Manage Services</h1>
                <p class="text-secondary mb-0">Services shown on the public Services page are managed here.</p>
            </div>
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <div class="row g-4">
                <div class="col-12 col-xl-7">
                    <section class="service-panel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">Services</h2>
                            @if($editingService)
                                <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-light">Add new</a>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead><tr><th>Service</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                                <tbody>
                                    @forelse($services as $service)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold"><i class="{{ $service->icon }} text-info me-2"></i>{{ $service->title }}</div>
                                                <small class="text-secondary">{{ $service->eyebrow }}</small>
                                            </td>
                                            <td>{{ $service->sort_order }}</td>
                                            <td>{{ $service->is_active ? 'Active' : 'Hidden' }}</td>
                                            <td class="text-end text-nowrap">
                                                <a href="{{ route('admin.services.index', ['edit' => $service->id]) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit {{ $service->title }}" title="Edit"><i class="fas fa-pen"></i></a>
                                                <form class="d-inline" method="POST" action="{{ route('admin.services.delete', $service->id) }}" onsubmit="return confirm('Delete this service?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete {{ $service->title }}" title="Delete"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-secondary">No services added yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>

                <div class="col-12 col-xl-5">
                    <section class="service-panel">
                        <h2 class="h5 mb-3">{{ $editingService ? 'Edit service' : 'Add service' }}</h2>
                        <form method="POST" action="{{ route('admin.services.save') }}">
                            @csrf
                            @if($editingService)<input type="hidden" name="id" value="{{ $editingService->id }}">@endif
                            <div class="mb-3">
                                <label class="form-label" for="eyebrow">Small heading</label>
                                <input class="form-control" id="eyebrow" name="eyebrow" maxlength="100" value="{{ old('eyebrow', $editingService->eyebrow ?? '') }}" placeholder="WORK VISA" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="title">Service name</label>
                                <input class="form-control" id="title" name="title" maxlength="255" value="{{ old('title', $editingService->title ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="2000" required>{{ old('description', $editingService->description ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="icon">Font Awesome icon class</label>
                                <input class="form-control" id="icon" name="icon" maxlength="255" value="{{ old('icon', $editingService->icon ?? 'fas fa-plane') }}" placeholder="fas fa-passport" pattern="(fas|far|fab) fa-[a-z0-9-]+" required>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="link_label">Button text</label>
                                    <input class="form-control" id="link_label" name="link_label" maxlength="100" value="{{ old('link_label', $editingService->link_label ?? 'Learn more') }}" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="link_url">Destination URL</label>
                                    <input class="form-control" id="link_url" name="link_url" maxlength="500" value="{{ old('link_url', $editingService->link_url ?? '/contact') }}" placeholder="/apply or https://..." required>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="sort_order">Display order</label>
                                    <input class="form-control" id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $editingService->sort_order ?? ($services->max('sort_order') + 1)) }}" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $editingService->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Show on Services page</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">{{ $editingService ? 'Save changes' : 'Add service' }}</button>
                            @if($editingService)<a href="{{ route('admin.services.index') }}" class="btn btn-outline-light ms-2">Cancel</a>@endif
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
