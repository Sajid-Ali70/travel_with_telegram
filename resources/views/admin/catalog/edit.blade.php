<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ ucfirst(str_replace('_', ' ', $type)) }} - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color);color:var(--text-main);font-family:'Segoe UI',sans-serif;margin:0; }
        .sidebar {width:260px;height:100vh;background:var(--sidebar-bg);border-right:1px solid var(--border-color);position:fixed;padding:20px;display:flex;flex-direction:column;z-index:1200;overflow-y:auto;}
        .brand-section {display:flex;align-items:center;gap:12px;margin-bottom:40px;}.brand-logo-img{width:80px;height:80px;object-fit:contain;}.brand-name{font-size:1.15rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}.admin-badge{margin-left:auto;color:#58a6ff;font-size:.7rem;}
        .nav-link{color:var(--text-secondary);padding:12px 15px;border-radius:8px;margin-bottom:5px;display:flex;align-items:center;text-decoration:none;}.nav-link i{width:20px;margin-right:12px;}.nav-link:hover,.nav-link.active{color:var(--text-main);background:rgba(255,255,255,.08);}.logout-btn{margin-top:auto;color:var(--text-secondary);border:1px solid var(--border-color);background:transparent;padding:10px;border-radius:8px;width:100%;text-align:left;}
        .main-content{margin-left:260px;padding:32px;min-height:100vh;}.form-card{max-width:850px;background:var(--card-bg);border:1px solid var(--border-color);border-radius:12px;padding:28px;}.form-label{color:#c9d1d9;}.form-control,.form-select{background:#0d1117;border-color:var(--border-color);color:var(--text-main);}.form-control:focus,.form-select:focus{background:#0d1117;border-color:#007bff;color:var(--text-main);box-shadow:none;}.current-image{max-height:100px;max-width:180px;object-fit:contain;display:block;margin-bottom:8px;}
        @media(max-width:768px){.sidebar{width:220px;padding:15px;}.main-content{margin-left:220px;padding:20px 15px;}}
    </style>
</head><body>
    @include('admin.partials.sidebar')
    <main class="main-content"><div class="container-fluid">
        <div class="mb-4"><a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-light btn-sm mb-3"><i class="fas fa-arrow-left me-1"></i> Back to Manage Catalog</a><h1 class="h3 mb-0">Edit {{ ucfirst(str_replace('_', ' ', $type)) }}</h1></div>
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('admin.catalog.update', [$type, $id]) }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf @method('PUT')
            @if($type === 'job_title')
                <div class="mb-3"><label for="category_id" class="form-label">Category</label><select id="category_id" name="category_id" class="form-select" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach</select></div>
                <div class="mb-3"><label for="subcategory_id" class="form-label">Subcategory</label><select id="subcategory_id" name="subcategory_id" class="form-select" required><option value="">Select subcategory</option>@foreach($categories as $category)@foreach($category->types as $subcategory)<option value="{{ $subcategory->id }}" data-category-id="{{ $category->id }}" {{ old('subcategory_id', $item->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>@endforeach @endforeach</select></div>
                <div class="mb-3"><label for="profession_id" class="form-label">Profession</label><select id="profession_id" name="profession_id" class="form-select" required><option value="">Select profession</option>@foreach($professions as $profession)<option value="{{ $profession->id }}" data-category-id="{{ $profession->category_id }}" data-subcategory-id="{{ $profession->subcategory_id }}" {{ old('profession_id', $item->profession_id) == $profession->id ? 'selected' : '' }}>{{ $profession->name }}</option>@endforeach</select></div>
                <div class="mb-3"><label for="name" class="form-label">Job Title</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name', $item->name) }}" required autofocus></div>
            @elseif($type === 'profession')
                <div class="mb-3"><label for="name" class="form-label">Profession</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name', $item->name) }}" required autofocus></div>
            @elseif($type === 'subcategory')
                <div class="mb-3"><label for="category_id" class="form-label">Parent Category</label><select id="category_id" name="category_id" class="form-select" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach</select></div>
                <div class="mb-3"><label for="name" class="form-label">Subcategory Name</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name', $item->name) }}" required autofocus></div>
            @elseif($type === 'category')
                <div class="mb-3"><label for="name" class="form-label">Category Name</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name', $item->name) }}" required autofocus></div>
                <div class="mb-3"><label for="country_id" class="form-label">Country</label><select id="country_id" name="country_id" class="form-select" required><option value="">Select country</option>@foreach($countries as $country)<option value="{{ $country->id }}" {{ old('country_id', $item->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>@endforeach</select></div>
                <div class="mb-3"><label for="icon" class="form-label">Icon Class (Font Awesome)</label><input id="icon" type="text" name="icon" class="form-control" maxlength="255" value="{{ old('icon', $item->icon) }}"></div>
                <div class="mb-3"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control" rows="4" maxlength="5000">{{ old('description', $item->description) }}</textarea></div>
            @elseif($type === 'country')
                <div class="mb-3"><label for="name" class="form-label">Country Name</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name', $item->name) }}" required autofocus></div>
                <div class="mb-3"><label for="currency" class="form-label">Currencies (comma-separated)</label><input id="currency" type="text" name="currency" class="form-control" maxlength="255" value="{{ old('currency', implode(', ', $currencies)) }}"></div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Cities</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addCountryCity"><i class="fas fa-plus me-1"></i> Add City</button>
                    </div>
                    <div id="countryCities" class="d-flex flex-column gap-2">
                        @foreach(old('cities', $cities ?: ['']) as $city)
                            <div class="input-group country-city-row">
                                <input type="text" name="cities[]" class="form-control" maxlength="255" value="{{ $city }}" placeholder="Enter city name">
                                <button type="button" class="btn btn-outline-danger remove-country-city" aria-label="Remove city"><i class="fas fa-trash"></i></button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if($item->flag)<img src="{{ asset($item->flag) }}" alt="Current country flag" class="current-image">@endif
                <div class="mb-3"><label for="flag_file" class="form-label">Replace Flag (optional)</label><input id="flag_file" type="file" name="flag_file" class="form-control" accept="image/jpeg,image/png,image/webp"></div>
            @else
                <div class="mb-3"><label for="name" class="form-label">Nationality</label><input id="name" type="text" name="name" class="form-control" maxlength="255" value="{{ old('name', $item->name) }}" required autofocus></div>
                <div class="row g-3"><div class="col-md-3"><label for="currency" class="form-label">Currency</label><input id="currency" type="text" name="currency" class="form-control" maxlength="20" value="{{ old('currency', $item->currency) }}"></div><div class="col-md-3"><label for="phone_code" class="form-label">Phone Code</label><input id="phone_code" type="text" name="phone_code" class="form-control" maxlength="20" value="{{ old('phone_code', $item->phone_code) }}"></div><div class="col-md-3"><label for="phone_number_length" class="form-label">Phone Number Digits</label><input id="phone_number_length" type="number" name="phone_number_length" class="form-control" min="1" max="30" value="{{ old('phone_number_length', $item->phone_number_length) }}"></div><div class="col-md-3"><label for="id_number_length" class="form-label">National ID Digits</label><input id="id_number_length" type="number" name="id_number_length" class="form-control" min="1" max="30" value="{{ old('id_number_length', $item->id_number_length) }}"></div></div>
                <h2 class="h6 mt-4 mb-3">Primary Airport</h2><div class="row g-3"><div class="col-md-6"><label for="airport_name" class="form-label">Airport Name</label><input id="airport_name" type="text" name="airport_name" class="form-control" maxlength="255" value="{{ old('airport_name', $primaryAirport->name ?? '') }}"></div><div class="col-md-6"><label for="airport_city" class="form-label">Airport City</label><input id="airport_city" type="text" name="airport_city" class="form-control" maxlength="255" value="{{ old('airport_city', $primaryAirport->city ?? '') }}"></div></div>
                @if($airports->count() > 1)<p class="form-text mt-2">Other linked airports are unchanged.</p>@endif
            @endif
            <div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-light">Cancel</a><button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button></div>
        </form>
    </div></main>
    @if($type === 'job_title')
        <script>
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');
            const professionSelect = document.getElementById('profession_id');

            function filterDependentOptions(select, filters, resetSelection) {
                let selectedOptionIsAvailable = false;
                Array.from(select.options).forEach((option) => {
                    const available = filters.every(([attribute, value]) => !value || option.dataset[attribute] === value);
                    option.hidden = !available && option.value !== '';
                    if (option.selected && available) selectedOptionIsAvailable = true;
                });
                if (resetSelection || !selectedOptionIsAvailable) select.value = '';
                select.disabled = filters.some(([, value]) => !value);
            }

            function updateCatalogSelectors(resetSelection) {
                const categoryId = categorySelect.value;
                filterDependentOptions(subcategorySelect, [['categoryId', categoryId]], resetSelection);
                @if($type === 'job_title')
                    filterDependentOptions(professionSelect, [['categoryId', categoryId], ['subcategoryId', subcategorySelect.value]], resetSelection);
                @endif
            }

            categorySelect.addEventListener('change', () => updateCatalogSelectors(true));
            subcategorySelect.addEventListener('change', () => {
                @if($type === 'job_title')
                    filterDependentOptions(professionSelect, [['categoryId', categorySelect.value], ['subcategoryId', subcategorySelect.value]], true);
                @endif
            });
            updateCatalogSelectors(false);
        </script>
    @endif
    @if($type === 'country')
        <script>
            const countryCities = document.getElementById('countryCities');
            document.getElementById('addCountryCity').addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'input-group country-city-row';
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'cities[]';
                input.maxLength = 255;
                input.className = 'form-control';
                input.placeholder = 'Enter city name';
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-outline-danger remove-country-city';
                removeButton.setAttribute('aria-label', 'Remove city');
                removeButton.innerHTML = '<i class="fas fa-trash"></i>';
                row.append(input, removeButton);
                countryCities.appendChild(row);
                input.focus();
            });
            countryCities.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-country-city');
                if (removeButton && countryCities.querySelectorAll('.country-city-row').length > 1) {
                    removeButton.closest('.country-city-row').remove();
                }
            });
        </script>
    @endif
</body></html>
