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
        @include('partials.home-header', ['activePage' => 'services'])

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
