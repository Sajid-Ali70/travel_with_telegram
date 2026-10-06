<aside class="sidebar admin-sidebar" id="sidebar">
    <div class="brand-section">
        <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="Logo" class="brand-logo-img">
        <span class="brand-name">{{ $settings->app_name ?? 'VisaBook' }}</span>
        <div class="admin-badge">Admin</div>
    </div>

    <nav class="nav flex-column">
        <a href="/" class="nav-link admin-nav-link" target="_blank" rel="noopener">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>
        <a href="{{ route('admin.dashboard') }}" id="nav-dashboard" class="nav-link admin-nav-link" onclick="localStorage.setItem('activeAdminTab', 'dashboard')">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="{{ route('admin.dashboard') }}" id="nav-requests" class="nav-link admin-nav-link" onclick="localStorage.setItem('activeAdminTab', 'requests')">
            <i class="fas fa-file-signature"></i> Visa Requests
        </a>
        <a href="{{ route('admin.dashboard') }}" id="nav-tickets" class="nav-link admin-nav-link" onclick="localStorage.setItem('activeAdminTab', 'tickets')">
            <i class="fas fa-ticket-alt"></i> Ticket Requests
        </a>
        <a href="{{ route('admin.catalog.index') }}" class="nav-link admin-nav-link {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}">
            <i class="fas fa-list-alt"></i> Manage Catalog
        </a>
        <a href="{{ route('admin.jobs.index') }}" id="nav-jobs" class="nav-link admin-nav-link {{ request()->routeIs('admin.jobs.index', 'admin.jobs.edit', 'admin.jobs.update') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> Jobs
        </a>
        <a href="{{ route('admin.jobs.create') }}" class="nav-link admin-nav-link {{ request()->routeIs('admin.jobs.create') ? 'active' : '' }}">
            <i class="fas fa-plus"></i> Add Job
        </a>

        <a href="{{ route('admin.dashboard') }}" id="nav-security" class="nav-link admin-nav-link" onclick="localStorage.setItem('activeAdminTab', 'security')">
            <i class="fas fa-shield-alt"></i> Security
        </a>
        <a href="{{ route('admin.dashboard') }}" id="nav-playstore" class="nav-link admin-nav-link" onclick="localStorage.setItem('activeAdminTab', 'playstore')">
            <i class="fas fa-cog"></i> Settings
        </a>
    </nav>

    <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </button>
    </form>
</aside>
