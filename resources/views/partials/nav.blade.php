<!-- Modern Top Header Navbar -->
<nav class="main-navbar">
    <a href="{{ url('/') }}" class="nav-logo">
        <div class="nav-logo-icon">
            @if(!empty($settings->app_icon))
                @php
                    $icon = $settings->app_icon;
                    $iconUrl = (str_starts_with($icon, 'http') || str_starts_with($icon, '//')) ? $icon : asset($icon);
                @endphp
                <img src="{{ $iconUrl }}" alt="Logo" style="width:100%; height:100%; object-fit:contain; border-radius:0; background:transparent;">
            @else
                <i class="fas fa-passport"></i>
            @endif
        </div>
        <div class="nav-logo-text">
            <h1>{{ $settings->app_name ?? 'VisaBook' }}</h1>
            <p>{{ $settings->tags ?? 'Your Journey. Our Priority.' }}</p>
        </div>
    </a>

    <!-- Mobile Menu Toggle Button -->
    <div class="nav-toggle" id="nav-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <div class="nav-links" id="nav-menu">
        <a href="{{ url('/') }}" class="nav-link-item {{ Request::is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('travel.apply') }}" class="nav-link-item {{ Request::is('apply*') ? 'active' : '' }}">Apply Visa</a>
        <a href="{{ route('travel.verify') }}" class="nav-link-item {{ Request::is('verify*') ? 'active' : '' }}">Check Status</a>
        <a href="{{ route('travel.about') }}" class="nav-link-item {{ Request::is('about*') ? 'active' : '' }}">About Us</a>
        <a href="{{ route('travel.contact') }}" class="nav-link-item {{ Request::is('contact*') ? 'active' : '' }}">Contact</a>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('nav-toggle');
        const menu = document.getElementById('nav-menu');

        if (toggle && menu) {
            toggle.addEventListener('click', () => {
                menu.classList.toggle('show');
                // Change icon between bars and times (X)
                const icon = toggle.querySelector('i');
                if (menu.classList.contains('show')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        }
    });
</script>
