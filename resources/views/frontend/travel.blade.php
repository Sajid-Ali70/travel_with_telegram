<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->app_name ?? 'VisaBook - Premium Visa Portal' }}</title>
    <!-- Modern Plus Jakarta Sans Font & UI Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        .visa-hero-section {
            @php
                $banner = !empty($settings->home_banner) ? $settings->home_banner : "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80";
                $bannerUrl = (str_starts_with($banner, 'http') || str_starts_with($banner, '//')) ? $banner : asset($banner);
            @endphp
            background-image: linear-gradient(180deg, rgba(3, 7, 18, 0.4) 0%, #030712 100%),
                              url('{{ $bannerUrl }}') !important;
        }

        /* Override button colors when they are together in the hero section */
        .hero-btn-group .btn-apply {
            background-color: #6200ee !important;
            color: #ffffff !important;
            border: none !important;
        }

        .hero-btn-group .btn-verify {
            background-color: #03dac6 !important;
            color: #000000 !important;
            border: none !important;
        }

        .btn + .btn, a[class*="btn"] + a[class*="btn"] {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <div class="visa-hero-section">
            <div class="hero-overlay-content reveal reveal-left">
                <div class="tag-reliable reveal reveal-down delay-1">FAST • SECURE • RELIABLE</div>
                <h2 class="reveal reveal-up delay-2">Get Your Visa<br><span>For a Better Tomorrow</span></h2>
                <p class="reveal reveal-up delay-3">{{ $settings->description ?? 'Apply for your visa online with ease. Track your application status in real-time and step closer to your next adventure.' }}</p>
                <div class="hero-btn-group reveal reveal-up delay-4">
                    <a href="{{ route('travel.apply') }}" class="btn-apply" style="margin:0; padding: 12px 28px; border-radius: 50px;">Apply for Visa <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="{{ route('travel.verify') }}" class="btn-verify" style="margin:0; padding: 12px 28px; border-radius: 50px;">Check Visa Status <i class="fas fa-search ms-2"></i></a>
                </div>
            </div>
        </div>

        <div class="features-grid-bar reveal reveal-fade">
            <div class="feature-bar-item reveal reveal-up delay-1">
                <div class="feature-bar-icon"><i class="fas fa-bolt"></i></div>
                <div class="feature-bar-text">
                    <h4>Easy Online Application</h4>
                    <p>Fill the form and upload your documents in minutes.</p>
                </div>
            </div>
            <div class="feature-bar-item reveal reveal-up delay-2">
                <div class="feature-bar-icon"><i class="far fa-clock"></i></div>
                <div class="feature-bar-text">
                    <h4>Track Your Status</h4>
                    <p>Get real-time updates on your visa application.</p>
                </div>
            </div>
            <div class="feature-bar-item reveal reveal-up delay-3">
                <div class="feature-bar-icon"><i class="fas fa-globe"></i></div>
                <div class="feature-bar-text">
                    <h4>Multiple Countries</h4>
                    <p>Apply for tourist, business, student and more.</p>
                </div>
            </div>
            <div class="feature-bar-item reveal reveal-up delay-4">
                <div class="feature-bar-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="feature-bar-text">
                    <h4>Secure & Trusted</h4>
                    <p>Your data is completely safe with our modern secure architecture.</p>
                </div>
            </div>
        </div>

        <div class="section-wrapper-global">
            <div class="section-header-flex reveal reveal-fade">
                <div>
                    <h3>Popular Visa Categories</h3>
                    <p>Choose the type of visa you need. We make the process simple and hassle-free.</p>
                </div>
                <a href="#" class="view-all-link">View All Categories <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

            <div class="categories-grid-cards">
                <div class="category-premium-card reveal reveal-up delay-1">
                    <div class="category-card-img" style="background-image: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80');"></div>
                    <div class="category-card-body">
                        <div class="category-card-icon-title"><i class="fas fa-suitcase-rolling"></i><h4>Tourist Visa</h4></div>
                        <p>Explore new destinations and create unforgettable lifelong memories with fast processing.</p>
                    </div>
                </div>
                <div class="category-premium-card reveal reveal-up delay-2">
                    <div class="category-card-img" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80');"></div>
                    <div class="category-card-body">
                        <div class="category-card-icon-title"><i class="fas fa-briefcase"></i><h4>Business Visa</h4></div>
                        <p>Attend essential international meetings, conferences, and grow your global business network.</p>
                    </div>
                </div>
                <div class="category-premium-card reveal reveal-up delay-3">
                    <div class="category-card-img" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80');"></div>
                    <div class="category-card-body">
                        <div class="category-card-icon-title"><i class="fas fa-graduation-cap"></i><h4>Student Visa</h4></div>
                        <p>Study at top-tier universal colleges and successfully establish your bright future path.</p>
                    </div>
                </div>
                <div class="category-premium-card reveal reveal-up delay-4">
                    <div class="category-card-img" style="background-image: url('https://images.unsplash.com/photo-1511895426328-dc8714191300?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80');"></div>
                    <div class="category-card-body">
                        <div class="category-card-icon-title"><i class="fas fa-users"></i><h4>Family Visa</h4></div>
                        <p>Reunite happily with your loved ones and smoothly build a much brighter domestic future together.</p>
                    </div>
                </div>
            </div>

            <div class="trusted-partner-banner reveal reveal-fade delay-3">
                <div class="row align-items-center">
                    <div class="col-md-8 reveal reveal-left">
                        <h4 class="fw-bold mb-2 text-white" style="font-size: 1.5rem;">Your Trusted Visa Partner</h4>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">{{ $settings->description ?? 'We help thousands of people every year to get their visas quickly and easily.' }}</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0 reveal reveal-up">
                        <a href="{{ route('travel.about') }}" class="btn-login" style="padding: 12px 30px;">Learn More <i class="fas fa-chevron-right ms-1" style="font-size: 11px;"></i></a>
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
