<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Support Content - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color); color:var(--text-main); font-family:'Segoe UI',sans-serif; margin:0; }
        .sidebar { width:260px; height:100vh; background:var(--sidebar-bg); border-right:1px solid var(--border-color); position:fixed; padding:20px; display:flex; flex-direction:column; z-index:1200; overflow-y:auto; }
        .brand-section { display:flex; align-items:center; gap:12px; margin-bottom:40px; }.brand-logo-img { width:80px;height:80px;object-fit:contain; }.brand-name {font-size:1.15rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}.admin-badge {margin-left:auto;color:#58a6ff;font-size:.7rem;}
        .nav-link {color:var(--text-secondary);padding:12px 15px;border-radius:8px;margin-bottom:5px;display:flex;align-items:center;text-decoration:none;}.nav-link i {width:20px;margin-right:12px;}.nav-link:hover,.nav-link.active {color:var(--text-main);background:rgba(255,255,255,.08);}
        .logout-btn {margin-top:auto;color:var(--text-secondary);border:1px solid var(--border-color);background:transparent;padding:10px;border-radius:8px;width:100%;text-align:left;}.main-content {margin-left:260px;padding:32px;min-height:100vh;}
        .support-panel {background:var(--card-bg);border:1px solid var(--border-color);border-radius:12px;padding:22px;height:100%;}
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
                <h1 class="h3 mb-1">Manage Support Content</h1>
                <p class="text-secondary mb-0">Manage the frequently asked questions shown to visitors.</p>
            </div>
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <div class="row g-4">
                <div class="col-12">
                    <section class="support-panel mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">FAQs</h2>
                            @if($editingFaq)<a class="btn btn-sm btn-outline-light" href="{{ route('admin.support.index') }}">Add new</a>@endif
                        </div>
                        <form method="POST" action="{{ route('admin.support.faqs.save') }}" class="mb-4">
                            @csrf
                            @if($editingFaq)<input type="hidden" name="id" value="{{ $editingFaq->id }}">@endif
                            <div class="mb-3">
                                <label class="form-label" for="question">Question</label>
                                <input class="form-control" id="question" name="question" maxlength="500" value="{{ old('question', $editingFaq->question ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="answer">Answer</label>
                                <textarea class="form-control" id="answer" name="answer" rows="3" maxlength="5000" required>{{ old('answer', $editingFaq->answer ?? '') }}</textarea>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6 mb-3">
                                    <label class="form-label" for="faq_sort_order">Display order</label>
                                    <input class="form-control" id="faq_sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $editingFaq->sort_order ?? ($faqs->max('sort_order') + 1)) }}" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" id="faq_is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $editingFaq->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="faq_is_active">Show on support page</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">{{ $editingFaq ? 'Save FAQ' : 'Add FAQ' }}</button>
                            @if($editingFaq)<a href="{{ route('admin.support.index') }}" class="btn btn-outline-light ms-2">Cancel</a>@endif
                        </form>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead><tr><th>Question</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                                <tbody>
                                    @forelse($faqs as $faq)
                                        <tr>
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ $faq->is_active ? 'Visible' : 'Hidden' }}</td>
                                            <td class="text-end text-nowrap">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.support.index', ['edit_faq' => $faq->id]) }}" aria-label="Edit FAQ"><i class="fas fa-pen"></i></a>
                                                <form class="d-inline" method="POST" action="{{ route('admin.support.faqs.delete', $faq->id) }}" onsubmit="return confirm('Delete this FAQ?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete FAQ"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-secondary">No FAQs added yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
