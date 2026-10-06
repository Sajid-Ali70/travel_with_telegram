<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add {{ ucfirst(str_replace('_', ' ', $type)) }} - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color);color:var(--text-main);font-family:'Segoe UI',sans-serif;margin:0; }
        .sidebar {width:260px;height:100vh;background:var(--sidebar-bg);border-right:1px solid var(--border-color);position:fixed;padding:20px;display:flex;flex-direction:column;z-index:1200;overflow-y:auto;}
        .brand-section {display:flex;align-items:center;gap:12px;margin-bottom:40px;}.brand-logo-img{width:80px;height:80px;object-fit:contain;}.brand-name{font-size:1.15rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}.admin-badge{margin-left:auto;color:#58a6ff;font-size:.7rem;}
        .nav-link{color:var(--text-secondary);padding:12px 15px;border-radius:8px;margin-bottom:5px;display:flex;align-items:center;text-decoration:none;}.nav-link i{width:20px;margin-right:12px;}.nav-link:hover,.nav-link.active{color:var(--text-main);background:rgba(255,255,255,.08);}.logout-btn{margin-top:auto;color:var(--text-secondary);border:1px solid var(--border-color);background:transparent;padding:10px;border-radius:8px;width:100%;text-align:left;}
        .main-content{margin-left:260px;padding:32px;min-height:100vh;}.form-card{max-width:850px;background:var(--card-bg);border:1px solid var(--border-color);border-radius:12px;padding:28px;}.form-label{color:#c9d1d9;}.form-control{background:#0d1117;border-color:var(--border-color);color:var(--text-main);}.form-control:focus{background:#0d1117;border-color:#007bff;color:var(--text-main);box-shadow:none;}
        @media(max-width:768px){.sidebar{width:220px;padding:15px;}.main-content{margin-left:220px;padding:20px 15px;}}
    </style>
</head><body>
    @include('admin.partials.sidebar')
    <main class="main-content"><div class="container-fluid">
        <div class="mb-4"><a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-light btn-sm mb-3"><i class="fas fa-arrow-left me-1"></i> Back to Manage Catalog</a><h1 class="h3 mb-0">Add {{ ucfirst(str_replace('_', ' ', $type)) }}</h1></div>
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('admin.catalog.store', $type) }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf
            @if(in_array($type, ['profession', 'job_title']))
                <div class="mb-3"><label for="name" class="form-label">{{ $type === 'profession' ? 'Profession' : 'Job Title' }}</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name') }}" required autofocus></div>
            @elseif($type === 'subcategory')
                <div class="mb-3"><label for="category_id" class="form-label">Parent Category</label><select id="category_id" name="category_id" class="form-select" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach</select></div>
                <div class="mb-3"><label for="name" class="form-label">Subcategory Name</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name') }}" required autofocus></div>
            @elseif($type === 'category')
                <div class="mb-3"><label for="name" class="form-label">Category Name</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name') }}" required autofocus></div>
                <div class="mb-3"><label for="icon" class="form-label">Icon Class (Font Awesome)</label><input id="icon" type="text" name="icon" class="form-control" maxlength="255" value="{{ old('icon', 'fas fa-suitcase-rolling') }}"></div>
                <div class="mb-3"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control" rows="4" maxlength="5000">{{ old('description') }}</textarea></div>
                <div class="mb-3"><label for="image_file" class="form-label">Category Image (optional)</label><input id="image_file" type="file" name="image_file" class="form-control" accept="image/jpeg,image/png,image/webp"></div>
            @elseif($type === 'country')
                <div class="mb-3"><label for="name" class="form-label">Country Name</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name') }}" required autofocus></div>
                <div class="mb-3"><label for="currency" class="form-label">Currencies (comma-separated)</label><input id="currency" type="text" name="currency" class="form-control" maxlength="255" placeholder="e.g. SAR, USD" value="{{ old('currency') }}"></div>
                <div class="mb-3"><label for="flag_file" class="form-label">Flag (optional)</label><input id="flag_file" type="file" name="flag_file" class="form-control" accept="image/jpeg,image/png,image/webp"></div>
            @else
                <div class="mb-3"><label for="name" class="form-label">Nationality</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name') }}" required autofocus></div>
                <div class="row g-3"><div class="col-md-3"><label for="currency" class="form-label">Currency</label><input id="currency" type="text" name="currency" class="form-control" maxlength="20" value="{{ old('currency') }}"></div><div class="col-md-3"><label for="phone_code" class="form-label">Phone Code</label><input id="phone_code" type="text" name="phone_code" class="form-control" maxlength="20" placeholder="+92" value="{{ old('phone_code') }}"></div><div class="col-md-3"><label for="phone_number_length" class="form-label">Phone Number Digits</label><input id="phone_number_length" type="number" name="phone_number_length" class="form-control" min="1" max="30" value="{{ old('phone_number_length') }}"></div><div class="col-md-3"><label for="id_number_length" class="form-label">National ID Digits</label><input id="id_number_length" type="number" name="id_number_length" class="form-control" min="1" max="30" value="{{ old('id_number_length') }}"></div></div>
                <h2 class="h6 mt-4 mb-3">First Airport for this Nationality</h2><div class="row g-3"><div class="col-md-6"><label for="airport_name" class="form-label">Airport Name</label><input id="airport_name" type="text" name="airport_name" class="form-control" maxlength="255" value="{{ old('airport_name') }}" required></div><div class="col-md-6"><label for="airport_city" class="form-label">Airport City</label><input id="airport_city" type="text" name="airport_city" class="form-control" maxlength="255" value="{{ old('airport_city') }}" required></div></div>
            @endif
            <div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-light">Cancel</a><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save {{ ucfirst(str_replace('_', ' ', $type)) }}</button></div>
        </form>
    </div></main>
</body></html>
