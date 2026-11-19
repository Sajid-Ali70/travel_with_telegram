<header class="main-navbar">
    <a href="{{ url('/') }}" class="nav-logo" aria-label="{{ $settings->app_name ?? 'Hays Travel' }}">
        <div class="nav-logo-icon">
            @if(!empty($settings->app_icon))
                @php
                    $icon = $settings->app_icon;
                    $iconUrl = (str_starts_with($icon, 'http') || str_starts_with($icon, '//')) ? $icon : asset($icon);
                @endphp
                <img src="{{ $iconUrl }}" alt="{{ $settings->app_name ?? 'Hays Travel' }}" style="width:100%; height:100%; object-fit:contain; border-radius:0; background:transparent;">
            @else
                <i class="fas fa-passport"></i>
            @endif
        </div>
        @if(empty($settings->app_icon))
            <div class="nav-logo-text">
                <h1>{{ $settings->app_name ?? 'Hays Travel' }}</h1>
            </div>
        @endif
    </a>

    <div class="main-header-actions">
        <a class="main-header-action" href="{{ !empty($settings->phone) ? 'tel:' . preg_replace('/[^0-9+]/', '', $settings->phone) : route('travel.contact') }}" aria-label="Contact">
            <span class="main-header-action-icon"><i class="fas fa-phone-alt"></i></span>
            <span>Contact</span>
        </a>
        <button class="main-header-action nav-toggle" id="nav-toggle" type="button" aria-controls="nav-menu" aria-expanded="false" aria-label="Menu">
            <span class="main-header-action-icon"><i class="fas fa-bars"></i></span>
            <span class="main-header-action-label">Menu</span>
        </button>
    </div>

    <nav class="nav-links" id="nav-menu" aria-label="Main navigation">
        <a href="{{ url('/') }}" class="nav-link-item {{ Request::is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('travel.apply') }}" class="nav-link-item {{ Request::is('apply*') ? 'active' : '' }}">Apply Visa</a>
        <a href="{{ route('travel.verify') }}" class="nav-link-item {{ Request::is('verify*') ? 'active' : '' }}">Check Status</a>
        <a href="{{ route('jobs.index') }}" class="nav-link-item {{ Request::is('jobs*') ? 'active' : '' }}">Jobs Abroad</a>
        <a href="{{ route('travel.services') }}" class="nav-link-item {{ Request::is('services*') ? 'active' : '' }}">Services</a>
        <a href="{{ route('travel.countries') }}" class="nav-link-item {{ Request::is('countries*') ? 'active' : '' }}">Countries</a>
        <a href="{{ route('travel.bank_guarantee') }}" class="nav-link-item {{ Request::is('bank-guarantee-financial-verification*') ? 'active' : '' }}">Bank Guarantee &amp; Financial Verification</a>
        <a href="{{ route('travel.contact') }}" class="nav-link-item {{ Request::is('contact*') ? 'active' : '' }}">Contact Support</a>
    </nav>
</header>
@include('partials.whatsapp-button')
