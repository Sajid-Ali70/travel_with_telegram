<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->app_name ?? 'VisaBook - Premium Visa Portal' }}</title>
    <!-- Modern Jakarta Sans Font & UI Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        .visa-hero-section {
            @php
                $banner = !empty($settings->home_banner) ? $settings->home_banner : "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80";
                $bannerUrl = (str_starts_with($banner, 'http') || str_starts_with($banner, '//')) ? $banner : asset($banner);
            @endphp
            background-image: url('{{ $bannerUrl }}') !important;
        }

        /* Hero actions */
        .hero-btn-group .btn-apply {
            background: linear-gradient(135deg, #1683ff, #0c61d8) !important;
            box-shadow: 0 12px 28px rgba(22, 131, 255, .28);
        }

        .hero-btn-group .btn-verify {
            background: #ffffff !important;
            color: #166534 !important;
            border: 1px solid #b7d9c0 !important;
            box-shadow: 0 12px 28px rgba(22, 101, 52, .12);
        }

        .hero-btn-group a {
            align-items: center;
            display: inline-flex;
            font-size: .95rem;
            font-weight: 700;
            justify-content: center;
            letter-spacing: .01em;
            min-height: 52px;
            min-width: 220px;
            padding: 13px 25px !important;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .hero-btn-group a:hover {
            transform: translateY(-3px);
        }

        .hero-btn-group .btn-verify:hover {
            background: #eef8f0 !important;
            border-color: #15803d !important;
            box-shadow: 0 16px 32px rgba(22, 101, 52, .16);
        }

        @media (max-width: 480px) {
            .hero-btn-group {
                flex-direction: column;
                width: min(100%, 320px);
            }

            .hero-btn-group a {
                width: 100%;
            }
        }

        /* Compact Dynamic Country Ticker Styling */
        .ticker-section-wrapper {
            padding: 15px;
            background: #f1f3f4;
        }

        .ticker-blue-banner {
            background: linear-gradient(90deg, #0959c0 0%, #1e88e5 100%);
            border-radius: 12px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(9, 89, 192, 0.25);
            min-height: 90px;
        }

        .ticker-left-part {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            z-index: 2;
            max-width: 45%;
        }

        .ticker-plane-icon {
            font-size: 24px;
            transform: rotate(-10deg);
            color: white;
            opacity: 0.9;
        }

        .ticker-info-text h3 {
            font-size: 0.85rem;
            font-weight: 600;
            margin: 0;
            line-height: 1;
        }

        .ticker-info-text h4 {
            font-size: 1.05rem;
            font-weight: 800;
            margin: 2px 0 0;
            line-height: 1;
        }

        .ticker-info-text p {
            font-size: 0.65rem;
            margin: 4px 0 0;
            font-weight: 500;
            opacity: 0.9;
            white-space: nowrap;
        }

        .ticker-white-capsule {
            background: white;
            border-radius: 15px;
            padding: 5px 0;
            flex-grow: 1;
            margin-left: 15px;
            overflow: hidden;
            display: flex;
            align-items: center;
            z-index: 2;
            height: 70px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
            position: relative;
        }

        /* Gradient mask for smooth entry/exit inside capsule */
        .ticker-white-capsule::before,
        .ticker-white-capsule::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 20px;
            z-index: 3;
            pointer-events: none;
        }
        .ticker-white-capsule::before {
            left: 0;
            background: linear-gradient(to right, white, transparent);
        }
        .ticker-white-capsule::after {
            right: 0;
            background: linear-gradient(to left, white, transparent);
        }

        .ticker-slide-track {
            display: flex;
            animation: ticker-slide-anim 25s linear infinite;
            white-space: nowrap;
            width: max-content;
        }

        .ticker-country-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 12px;
            flex-shrink: 0;
        }

        .ticker-flag-rect {
            width: 35px;
            height: 24px;
            border-radius: 4px;
            object-fit: cover;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 3px;
            border: 1px solid #f1f5f9;
        }

        .ticker-country-label {
            font-size: 0.55rem;
            color: #334155;
            font-weight: 700;
            text-transform: none;
        }

        @keyframes ticker-slide-anim {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .ticker-blue-banner:hover .ticker-slide-track {
            animation-play-state: paused;
        }

        /* NEW Visa Types Grid Styling matched to image */
        .visa-types-section {
            padding: 30px 15px;
            background: #fff;
        }

        .visa-types-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .visa-header-title-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .visa-header-icon {
            width: 42px;
            height: 42px;
            background: #2563eb;
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .visa-header-title-box h3 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .view-all-link {
            color: #2563eb !important;
            text-decoration: none !important;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .visa-types-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .visa-type-card {
            border-radius: 16px;
            padding: 20px 15px;
            text-decoration: none !important;
            position: relative;
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-height: 140px;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .visa-type-card:hover {
            transform: translateY(-5px);
        }

        .vt-icon-box {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .vt-info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .vt-info p {
            font-size: 0.75rem;
            margin: 0;
            opacity: 0.8;
            font-weight: 500;
        }

        .vt-arrow {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            opacity: 0.6;
        }

        /* Background Variants */
        .bg-vt-1 { background-color: #f0f7ff; color: #2563eb; } /* Blue */
        .bg-vt-2 { background-color: #f0fdf4; color: #16a34a; } /* Green */
        .bg-vt-3 { background-color: #f5f3ff; color: #7c3aed; } /* Purple */
        .bg-vt-4 { background-color: #fffaf0; color: #d97706; } /* Orange */
        .bg-vt-5 { background-color: #ecfeff; color: #0891b2; } /* Cyan */
        .bg-vt-6 { background-color: #fff1f2; color: #db2777; } /* Pink */

        .bg-vt-1 .vt-info h4, .bg-vt-1 .vt-info p { color: #1e40af; }
        .bg-vt-2 .vt-info h4, .bg-vt-2 .vt-info p { color: #166534; }
        .bg-vt-3 .vt-info h4, .bg-vt-3 .vt-info p { color: #5b21b6; }
        .bg-vt-4 .vt-info h4, .bg-vt-4 .vt-info p { color: #92400e; }
        .bg-vt-5 .vt-info h4, .bg-vt-5 .vt-info p { color: #155e75; }
        .bg-vt-6 .vt-info h4, .bg-vt-6 .vt-info p { color: #9d174d; }

        @media (max-width: 576px) {
            .ticker-blue-banner {
                padding: 10px;
            }
            .ticker-left-part {
                gap: 8px;
            }
            .ticker-white-capsule {
                margin-left: 10px;
                height: 65px;
            }
            .ticker-info-text h4 {
                font-size: 0.95rem;
            }
            .visa-header-title-box h3 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <div class="visa-hero-section">
            <div class="hero-overlay-content">
                <div class="tag-reliable">Your Dream Destination</div>
                <h2>Our Priority<br><span>Get Your Visa With<br>Rainbow Travels Kuwait</span></h2>
                <p>{{ $settings->description ?? 'Apply for your visa online with ease. Track your application status in real-time and step closer to your next adventure.' }}</p>
                <div class="hero-btn-group">
                    <a href="{{ route('travel.apply') }}" class="btn-apply" style="margin:0; border-radius: 12px;">Apply Visa Now <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="{{ route('travel.verify') }}" class="btn-verify" style="margin:0; border-radius: 12px;">Check Status <i class="fas fa-search ms-2"></i></a>
                </div>
            </div>
        </div>

        <!-- Precisely Matched Compact Dynamic Country Ticker -->
        <div class="ticker-section-wrapper">
            <div class="ticker-blue-banner">
                <div class="ticker-left-part">
                    <i class="fas fa-plane ticker-plane-icon"></i>
                    <div class="ticker-info-text">
                        <h3>Multiple Countries</h3>
                        <h4>One Trusted Partner</h4>
                        <p>Your Visa &bull; Our Support &bull; Your Journey</p>
                    </div>
                </div>
                <div class="ticker-white-capsule">
                    <div class="ticker-slide-track">
                        @php
                            $tickerCountries = (isset($countries) && count($countries) > 0) ? $countries : [
                                (object)['name' => 'UK', 'code' => 'gb'],
                                (object)['name' => 'Kuwait', 'code' => 'kw'],
                                (object)['name' => 'Oman', 'code' => 'om'],
                                (object)['name' => 'Saudi Arabia', 'code' => 'sa'],
                                (object)['name' => 'Dubai', 'code' => 'ae'],
                                (object)['name' => 'Qatar', 'code' => 'qa'],
                                (object)['name' => 'Turkey', 'code' => 'tr'],
                                (object)['name' => 'USA', 'code' => 'us']
                            ];
                        @endphp
                        {{-- Double the list for seamless loop --}}
                        @foreach(array_merge($tickerCountries instanceof \Illuminate\Support\Collection ? $tickerCountries->toArray() : $tickerCountries, $tickerCountries instanceof \Illuminate\Support\Collection ? $tickerCountries->toArray() : $tickerCountries) as $c)
                            @php
                                $c = (object)$c;
                                $flagUrl = !empty($c->flag) ? (str_starts_with($c->flag, 'http') ? $c->flag : asset($c->flag)) : 'https://flagcdn.com/w160/'.strtolower($c->code ?? 'pk').'.png';
                            @endphp
                            <div class="ticker-country-unit">
                                <img src="{{ $flagUrl }}" class="ticker-flag-rect" alt="{{ $c->name }}">
                                <span class="ticker-country-label">{{ $c->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW Visa Types Section matched to reference image -->
        <section class="visa-types-section">
            <div class="visa-types-header">
                <div class="visa-header-title-box">
                    <div class="visa-header-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3 id="visa-types">Visa Types</h3>
                </div>
                <a href="{{ route('travel.apply') }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="visa-types-grid">
                @php
                    // Default categories if none exist in database
                    $displayCategories = collect((isset($categories) && count($categories) > 0) ? $categories : [
                        (object)['id' => 1, 'name' => 'Tourist Visa', 'icon' => 'fas fa-plane-departure', 'tagline' => 'Explore the World'],
                        (object)['id' => 2, 'name' => 'Private Sector Work Visa', 'icon' => 'fas fa-briefcase', 'tagline' => 'Build Your Career'],
                        (object)['id' => 3, 'name' => 'Government Sector Work Visa', 'icon' => 'fas fa-building', 'tagline' => 'Serve Your Nation'],
                        (object)['id' => 4, 'name' => 'Domestic Worker Visa', 'icon' => 'fas fa-house-user', 'tagline' => 'Better Tomorrow'],
                        (object)['id' => 5, 'name' => 'Student Visa', 'icon' => 'fas fa-graduation-cap', 'tagline' => 'Shape Your Future'],
                        (object)['id' => 6, 'name' => 'Medical Visa', 'icon' => 'fas fa-heartbeat', 'tagline' => 'For Better Health']
                    ])->shuffle()->take(6);
                @endphp

                @foreach($displayCategories as $index => $cat)
                    @php
                        $variant = ($index % 6) + 1;
                        $catIcon = !empty($cat->icon) ? $cat->icon : 'fas fa-passport';
                        // Use dynamic description as tagline if available
                        $tagline = !empty($cat->tagline) ? $cat->tagline : (!empty($cat->description) ? \Illuminate\Support\Str::limit($cat->description, 20) : 'Apply Now');
                    @endphp
                    <a href="{{ route('travel.apply', ['category' => $cat->id]) }}" class="visa-type-card bg-vt-{{ $variant }}">
                        <div class="vt-icon-box">
                            <i class="{{ $catIcon }}"></i>
                        </div>
                        <div class="vt-info">
                            <h4>{{ $cat->name }}</h4>
                            <p>{{ $tagline }}</p>
                        </div>
                        <div class="vt-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="trusted-partner-banner mt-5">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="trusted-banner-title">Your Trusted Visa Partner</h4>
                        <p class="trusted-banner-description">{{ $settings->description ?? 'We help thousands of people every year to get their visas quickly and easily.' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="features-grid-bar">
            <div class="feature-bar-item">
                <div class="feature-bar-icon"><i class="fas fa-bolt"></i></div>
                <div class="feature-bar-text">
                    <h4>Easy Online Application</h4>
                    <p>Fill the form and upload your documents in minutes.</p>
                </div>
            </div>
            <div class="feature-bar-item">
                <div class="feature-bar-icon"><i class="far fa-clock"></i></div>
                <div class="feature-bar-text">
                    <h4>Track Your Status</h4>
                    <p>Get real-time updates on your visa application.</p>
                </div>
            </div>
            <div class="feature-bar-item">
                <div class="feature-bar-icon"><i class="fas fa-globe"></i></div>
                <div class="feature-bar-text">
                    <h4>Multiple Countries</h4>
                    <p>Apply for tourist, business, student and more.</p>
                </div>
            </div>
            <div class="feature-bar-item">
                <div class="feature-bar-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="feature-bar-text">
                    <h4>Secure & Trusted</h4>
                    <p>Your data is completely safe with our modern secure architecture.</p>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>

    <!-- Firebase Dependencies -->
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-firestore-compat.js"></script>
    <script src="{{ asset('js/firebase-config.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
