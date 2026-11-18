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
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

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
