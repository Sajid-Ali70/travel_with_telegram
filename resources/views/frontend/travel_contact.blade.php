<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#063b86">
    <title>Support &amp; FAQs | {{ $settings->app_name ?? 'Travel & Visa Services' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travel-home.css') }}">
</head>
<body class="travel-home-page travel-support-page">
    @php
        $phone = trim((string) ($settings->phone ?? ''));
        $email = trim((string) ($settings->email ?? ''));
        $phoneLink = preg_replace('/[^0-9+]/', '', $phone);
    @endphp

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
                <a class="home-header-action" href="{{ $phoneLink !== '' ? 'tel:' . $phoneLink : route('travel.contact') }}" aria-label="Contact">
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
                <a class="nav-link-item" href="{{ route('travel.services') }}">Services</a>
                <a class="nav-link-item" href="{{ route('travel.countries') }}">Countries</a>
                <a class="nav-link-item" href="{{ route('travel.bank_guarantee') }}">Bank Guarantee &amp; Financial Verification</a>
                <a class="nav-link-item active" href="{{ route('travel.contact') }}">Support</a>
            </nav>
        </header>

        <main class="support-main">
            <h1>Support &amp; FAQs</h1>
            <p class="support-subtitle">We are here to help you 24/7</p>

            <section class="support-contact-card" aria-label="Contact us">
                <a href="{{ $phoneLink !== '' ? 'tel:' . $phoneLink : route('travel.contact') }}" class="support-contact-item">
                    <span class="support-contact-button"><i class="fas fa-phone-alt"></i> Call Us</span>
                    <small>{{ $phone !== '' ? $phone : 'Contact number not available' }}</small>
                </a>
                <a href="{{ $email !== '' ? 'mailto:' . $email : route('travel.contact') }}" class="support-contact-item">
                    <span class="support-contact-button"><i class="far fa-envelope"></i> Email Us</span>
                    <small>{{ $email !== '' ? $email : 'Email address not available' }}</small>
                </a>
            </section>

            <section class="support-faq-section" aria-labelledby="support-faq-title">
                <h2 id="support-faq-title">Frequently Asked Questions</h2>
                <div class="support-faq-list">
                    @forelse($faqs as $faq)
                        <details class="support-faq">
                            <summary>{{ $faq->question }}<i class="fas fa-chevron-down" aria-hidden="true"></i></summary>
                            <p>{{ $faq->answer }}</p>
                        </details>
                    @empty
                        <p class="support-empty">There are no FAQs available right now. Please contact our team.</p>
                    @endforelse
                </div>
            </section>

        </main>

    </div>
    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
