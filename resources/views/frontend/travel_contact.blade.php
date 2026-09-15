<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - {{ $settings->app_name ?? 'VisaBook' }}</title>
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
        .contact-detail-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 30px;
            height: 100%;
            transition: transform 0.3s;
        }
        .contact-detail-card:hover {
            transform: translateY(-5px);
            border-color: var(--btn-primary);
        }
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 102, 255, 0.1);
            color: var(--btn-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <!-- Sub-Banner Header -->
        <div class="visa-hero-section" style="min-height: 350px; padding: 40px 5%; background-position: top center;">
            <div class="hero-overlay-content reveal reveal-left" style="max-width: 100%;">
                <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; Contact Us</p>
                <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">Contact Us</h2>
                <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Have questions? We're here to help you with your journey.</p>
            </div>
        </div>

        <div class="section-wrapper-global" style="padding-top: 60px; padding-bottom: 80px;">
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 reveal reveal-up delay-1">
                    <div class="contact-detail-card">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <h4 class="text-white">Phone Number</h4>
                        <p class="text-muted">{{ $settings->phone ?? '+92 300 123 4567' }}</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-up delay-2">
                    <div class="contact-detail-card">
                        <div class="contact-icon"><i class="far fa-envelope"></i></div>
                        <h4 class="text-white">Email Address</h4>
                        <p class="text-muted">{{ $settings->email ?? 'info@visabook.com' }}</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-up delay-3">
                    <div class="contact-detail-card">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <h4 class="text-white">Office Address</h4>
                        <p class="text-muted">{{ $settings->address ?? '123 Travel Street, Islamabad' }}</p>
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
