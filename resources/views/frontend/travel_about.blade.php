<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - {{ $settings->app_name ?? 'VisaBook' }}</title>
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
                <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; About Us</p>
                <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">About {{ $settings->app_name ?? 'VisaBook' }}</h2>
                <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Learn more about our mission to simplify global travel and visa processing.</p>
            </div>
        </div>

        <div class="section-wrapper-global" style="padding-top: 60px; padding-bottom: 80px;">
            <div class="premium-dark-box reveal reveal-up delay-1">
                <h3 class="text-white mb-4">Our Mission</h3>
                <div class="section-content text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                    {!! nl2br(e($settings->description ?: "We make visa applications simple, fast, and secure. Trust your journey to true industry specialists. Our platform is designed to provide a seamless experience for travelers worldwide.")) !!}
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
