<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Visa Status - {{ $settings->app_name ?? 'VisaBook' }}</title>
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
                <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; Check Status</p>
                <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">Check Visa Status</h2>
                <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Track your visa application in real-time. Enter your reference number and email address below to check the latest updates on your application.</p>
            </div>
        </div>

        <div class="section-wrapper-global" style="padding-top: 40px; padding-bottom: 60px;">
            <!-- Form & Sidebar Dual Layout Grid -->
            <div class="form-sidebar-grid">
                <!-- Left Side: Verification Box -->
                <div class="premium-dark-box reveal reveal-up delay-1">
                    <div class="text-center mb-4">
                        <div class="card-icon-circle reveal reveal-fade" style="width: 56px; height: 56px; font-size: 22px; background-color: rgba(0, 102, 255, 0.12); margin-bottom: 12px;">
                            <i class="fas fa-search text-primary"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-2" style="font-size: 1.25rem;">Enter Your Details</h4>
                        <p class="text-muted" style="font-size: 0.85rem;">Please enter your application reference number and email address to check your visa status.</p>
                    </div>

                    <form action="#" method="POST">
                        <div class="form-group">
                            <label>Application Reference Number *</label>
                            <div class="input-with-icon">
                                <i class="far fa-id-card"></i>
                                <input type="text" placeholder="e.g. V123456789" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email Address *</label>
                            <div class="input-with-icon">
                                <i class="far fa-envelope"></i>
                                <input type="email" placeholder="Enter your email address" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit mt-4 py-3" style="border-radius: 50px;">
                            Check Status <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Side: Sidebar Info Widget Panels -->
                <div class="sidebar-sticky-panel reveal reveal-up delay-2">
                    <div class="sidebar-widget-card">
                        <h4>Where can I find my reference number?</h4>
                        <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.6;">Your reference number is provided in your confirmation email after you submit your application.</p>
                    </div>

                    <div class="sidebar-widget-card">
                        <h4>Need Assistance?</h4>
                        <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.5;">Our support team is here to help you with any questions.</p>
                        <a href="tel:{{ $settings->phone ?? '' }}" class="btn-submit py-2" style="background: transparent; border: 1px solid var(--btn-primary); color: #fff; font-size: 0.9rem;"><i class="fas fa-phone-alt me-2"></i> Call Us</a>
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
