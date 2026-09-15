<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <!-- Modern Plus Jakarta Sans Font & UI Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        .visa-hero-section {
            @php
                $banner = !empty($settings->inner_banner) ? $settings->inner_banner : "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80";
                $bannerUrl = (str_starts_with($banner, 'http') || str_starts_with($banner, '//')) ? $banner : asset($banner);
            @endphp
            background-image: linear-gradient(180deg, rgba(3, 7, 18, 0.4) 0%, #030712 100%),
                              url('{{ $bannerUrl }}') !important;
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <!-- Sub-Banner Header -->
        <div class="visa-hero-section" style="min-height: 350px; padding: 40px 5%; background-position: top center;">
            <div class="hero-overlay-content reveal reveal-left" style="max-width: 100%;">
                <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; Dashboard</p>
                <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">User Dashboard</h2>
                <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Manage your applications, launch brand new requests, or check real-time status.</p>
            </div>
        </div>

        <div class="section-wrapper-global" style="padding-top: 40px; padding-bottom: 60px;">
            <div class="form-sidebar-grid">
                <div class="d-flex flex-column gap-4 reveal reveal-up delay-1">
                    <div class="brand-banner">
                        <div class="logo-img" style="width: 48px; height: 48px; background: rgba(0, 102, 255, 0.1); color: var(--btn-primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 22px; overflow: hidden;">
                            @if(!empty($settings->app_icon))
                                @php
                                    $icon = $settings->app_icon;
                                    $iconUrl = (str_starts_with($icon, 'http') || str_starts_with($icon, '//')) ? $icon : asset($icon);
                                @endphp
                                <img src="{{ $iconUrl }}" alt="Logo" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <i class="fas fa-user-circle"></i>
                            @endif
                        </div>
                        <div class="brand-name">
                            <h1 style="color: #fff; font-size: 1.25rem; font-weight: 700; margin: 0;">{{ $settings->app_name ?? 'User Gateway' }}</h1>
                            <p class="mb-0" style="color: var(--text-muted); font-size: 0.85rem; margin-top: 2px;">Welcome to your secure visa portal.</p>
                        </div>
                    </div>

                    <div class="dashboard-cards-grid">
                        <div class="dashboard-card reveal reveal-up delay-2">
                            <div class="card-icon-circle"><i class="far fa-file-alt"></i></div>
                            <h3 class="text-white">Apply for new visa</h3>
                            <p>Start a secure and guided digital application for your dream destination.</p>
                            <a href="{{ route('travel.apply') }}" class="btn-card" style="border-radius: 50px;">START APPLICATION <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <div class="dashboard-card green reveal reveal-up delay-3">
                            <div class="card-icon-circle green"><i class="fas fa-shield-alt"></i></div>
                            <h3 class="text-white">Verify Issued Visa</h3>
                            <p>Instantly cross-check visa approval info and documentation validity.</p>
                            <a href="{{ route('travel.verify') }}" class="btn-card" style="background: var(--accent-color); border-radius: 50px;">VERIFY NOW <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-sticky-panel reveal reveal-up delay-4">
                    <div class="sidebar-widget-card">
                        <h4>Need Help?</h4>
                        <div class="help-contact-row">
                            <i class="fas fa-phone-alt"></i>
                            <div><p>Helpline</p><h5>{{ $settings->phone ?? '+92 300 123 4567' }}</h5></div>
                        </div>
                        <div class="help-contact-row">
                            <i class="far fa-envelope"></i>
                            <div><p>Email</p><h5>{{ $settings->email ?? 'info@visabook.com' }}</h5></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
