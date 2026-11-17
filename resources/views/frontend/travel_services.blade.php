<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#063b86">
    <title>Our Services | {{ $settings->app_name ?? 'Travel & Visa Services' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travel-home.css') }}">
</head>
<body class="travel-home-page travel-services-page">
    <div class="travel-home-shell">
        <header class="home-header">
            <a class="home-brand" href="{{ url('/') }}" aria-label="{{ $settings->app_name ?? 'Hays Travel' }}">
                @if(!empty($settings->app_icon))
                    @php
                        $appIconUrl = str_starts_with($settings->app_icon, 'http') || str_starts_with($settings->app_icon, '//')
                            ? $settings->app_icon
                            : asset($settings->app_icon);
                    @endphp
                    <img class="home-brand-logo" src="{{ $appIconUrl }}" alt="{{ $settings->app_name ?? 'Hays Travel' }}">
                    <span class="home-brand-copy">
                        <small>{{ $settings->tags ?? 'Visa • Work • Travel • Jobs' }}</small>
                    </span>
                @else
                    <span class="home-brand-logo home-brand-logo-fallback"><i class="fas fa-plane"></i></span>
                    <span class="home-brand-copy">
                        <strong>{{ $settings->app_name ?? 'Hays Travel' }}</strong>
                        <small>{{ $settings->tags ?? 'Visa • Work • Travel • Jobs' }}</small>
                    </span>
                @endif
            </a>
            <div class="home-header-actions">
                <a class="home-header-action" href="{{ !empty($settings->phone) ? 'tel:' . preg_replace('/[^0-9+]/', '', $settings->phone) : route('travel.contact') }}" aria-label="Contact">
                    <span class="home-header-icon"><i class="fas fa-phone-alt"></i></span>
                    <span class="home-header-action-label">Contact</span>
                </a>
                <button class="home-header-action nav-toggle" id="nav-toggle" type="button" aria-controls="nav-menu" aria-expanded="false" aria-label="Menu">
                    <span class="home-header-icon"><i class="fas fa-bars"></i></span>
                    <span class="home-header-action-label">Menu</span>
                </button>
            </div>
            <nav class="nav-links" id="nav-menu" aria-label="Main navigation">
                <a class="nav-link-item" href="{{ url('/') }}">Home</a>
                <a class="nav-link-item" href="{{ route('travel.apply') }}">Apply Visa</a>
                <a class="nav-link-item" href="{{ route('travel.verify') }}">Check Status</a>
                <a class="nav-link-item" href="{{ route('jobs.index') }}">Jobs Abroad</a>
                <a class="nav-link-item active" href="{{ route('travel.services') }}">Services</a>
                <a class="nav-link-item" href="{{ route('travel.countries') }}">Countries</a>
                <a class="nav-link-item" href="{{ route('travel.contact') }}">Contact Support</a>
            </nav>
        </header>

        <main class="services-main">
            <section class="services-list" aria-labelledby="services-title">
                <h1 id="services-title">Our Services</h1>
                <p class="services-intro">Explore work, travel, and visa opportunities</p>
                <div class="services-cards">
                    @forelse($services as $service)
                        <a class="service-detail-card" href="{{ str_starts_with($service->link_url, '/') ? url(ltrim($service->link_url, '/')) : $service->link_url }}" aria-label="{{ $service->link_label }}: {{ $service->title }}">
                            <span class="service-detail-icon"><i class="{{ $service->icon }}"></i></span>
                            <span class="service-detail-copy">
                                <span class="service-detail-eyebrow">{{ $service->eyebrow }}</span>
                                <strong>{{ $service->title }}</strong>
                                <span class="service-detail-description">{{ $service->description }}</span>
                            </span>
                            <span class="service-detail-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    @empty
                        <p class="services-empty">Our services are being updated. Please contact our team for assistance.</p>
                    @endforelse
                </div>
            </section>

            <a class="service-inquiry" href="{{ route('travel.contact') }}">
                <span><strong>Inquire Today</strong><small>Get in touch with our team for help.</small></span>
                <i class="fas fa-edit" aria-hidden="true"></i>
            </a>
        </main>

    </div>
    @include('partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
