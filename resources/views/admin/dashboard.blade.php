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
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-logo-img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
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
        .form-control {
            background: #0d1117;
            border: 1px solid var(--border-color);
            color: white;
            padding: 12px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            background: #0d1117;
            border-color: var(--accent-blue);
            color: white;
            box-shadow: none;
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

        /* Reviews Table */
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
        .review-text-cell {
            max-width: 300px;
            white-space: normal;
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
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="brand-section">
            <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="Logo" class="brand-logo-img">
            <span class="brand-name">{{ $settings->app_name ?? 'VisaBook' }}</span>
            <div class="admin-badge">Admin</div>
        </div>

        <nav class="nav flex-column">
            <a href="/" class="nav-link" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Site
            </a>
            <a class="nav-link" id="nav-dashboard" onclick="showSection('dashboard')">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a class="nav-link" id="nav-countries" onclick="showSection('countries')">
                <i class="fas fa-globe"></i> Countries
            </a>
            <a class="nav-link" id="nav-categories" onclick="showSection('categories')">
                <i class="fas fa-th-large"></i> Categories
            </a>
            <a class="nav-link" id="nav-security" onclick="showSection('security')">
                <i class="fas fa-shield-alt"></i> Security
            </a>
            <a class="nav-link" id="nav-playstore" onclick="showSection('playstore')">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>

        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>

    <main class="main-content">
        <div class="page-header d-flex align-items-center gap-3 mb-4">
            <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="App Icon" class="header-app-icon">
            <div>
                <h1 class="mb-0">Website Configuration</h1>
                <p class="mb-0">Update your portal identity, contact information, and banners.</p>
            </div>
        </div>

        <!-- Section: Dashboard -->
        <section id="dashboardSection" class="dashboard-section d-none">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1); color: var(--accent-blue);">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Countries</p>
                        <h3>{{ $stats['total_countries'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(163, 113, 247, 0.1); color: var(--accent-purple);">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Categories</p>
                        <h3>{{ $stats['total_categories'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(210, 153, 34, 0.1); color: var(--accent-warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <p>Pending Requests</p>
                        <h3>{{ $stats['pending_requests'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(35, 134, 54, 0.1); color: var(--accent-success);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <p>Approved Requests</p>
                        <h3>{{ $stats['approved_requests'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h5 class="section-title">Quick Actions</h5>
                <div class="d-flex gap-3 mt-3">
                    <button class="btn btn-outline-primary" onclick="showSection('countries')">Manage Countries</button>
                    <button class="btn btn-outline-purple" style="color:#a371f7; border-color:#a371f7;" onclick="showSection('categories')">Manage Categories</button>
                    <button class="btn btn-outline-info" onclick="showSection('playstore')">Edit Settings</button>
                </div>
            </div>
        </section>

        <!-- Section: Countries -->
        <section id="countriesSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add New Country</h5>
                <form id="addCountryForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Country Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. United Arab Emirates" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Country Flag</label>
                            <input type="file" name="flag_file" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn-primary-custom w-100">Add Country</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="admin-card">
                <h5 class="section-title">Manage Countries</h5>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Flag</th><th>Country Name</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($countries as $country)
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>
                                    @if($country->flag)
                                        <img src="{{ $country->flag }}" class="country-flag-sm">
                                    @else
                                        <span class="text-muted">No Flag</span>
                                    @endif
                                </td>
                                <td>{{ $country->name }}</td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteCountry({{ $country->id }})"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Section: Categories -->
        <section id="categoriesSection" class="dashboard-section d-none">
            <div class="admin-card">
                <h5 class="section-title">Add New Category</h5>
                <form id="addCategoryForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Tourist Visa" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-suitcase-rolling" value="fas fa-suitcase-rolling">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Display Image</label>
                            <input type="file" name="image_file" class="form-control" accept="image/*">
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
            <div class="admin-card">
                <h5 class="section-title">Manage Categories & Visa Types</h5>
                <p class="text-muted small">Add specific visa types (e.g., Driver, Electrician) to each category.</p>
                <div class="table-responsive mt-3">
                    <table class="reviews-table">
                        <thead><tr><th>ID</th><th>Icon/Image</th><th>Category Name & Types</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="cat-icon-preview"><i class="{{ $cat->icon }}"></i></div>
                                        @if($cat->image)
                                            <img src="{{ $cat->image }}" class="cat-image-sm">
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
                                        <input type="text" id="type-input-{{ $cat->id }}" class="form-control bg-dark text-white border-secondary" placeholder="New Type (e.g. Driver)">
                                        <button class="btn btn-outline-purple" type="button" onclick="addVisaType({{ $cat->id }})"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
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
            const targetSection = document.getElementById(sectionId + 'Section');
            if (targetSection) targetSection.classList.remove('d-none');
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            const targetNav = document.getElementById('nav-' + sectionId);
            if (targetNav) targetNav.classList.add('active');
        }

        window.onload = function() {
            const activeTab = localStorage.getItem('activeAdminTab') || 'dashboard';
            showSection(activeTab);
        };

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
            const res = await fetch("{{ route('admin.countries.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
        };

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
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: new FormData(this)
            });
            if (res.ok) location.reload();
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

        async function addVisaType(catId) {
            const name = document.getElementById('type-input-' + catId).value;
            if (!name) return;
            const res = await fetch("{{ route('admin.visa_types.add') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'},
                body: JSON.stringify({ category_id: catId, name: name })
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
