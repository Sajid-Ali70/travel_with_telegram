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
        .about-confidence {
            background: #fff;
            margin-top: 20px;
            padding: 18px 10px 20px;
        }
        .about-mission {
            margin: 0 auto;
            max-width: 1000px;
        }
        .about-confidence h2 {
            color: #073c67;
            font-size: 1.15rem;
            font-weight: 800;
            line-height: 1.2;
            margin: 0 0 12px;
            text-align: center;
        }
        .about-confidence-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .about-confidence-card {
            align-items: center;
            background: #f0f4f6;
            border-radius: 7px;
            color: #102f4f;
            display: flex;
            flex-direction: column;
            font-size: .72rem;
            font-weight: 600;
            gap: 8px;
            justify-content: flex-start;
            line-height: 1.35;
            min-height: 145px;
            padding: 12px 8px;
            text-align: center;
        }
        .about-confidence-mark {
            align-items: center;
            border: 3px solid #064879;
            border-radius: 50%;
            color: #064879;
            display: inline-flex;
            flex: 0 0 52px;
            height: 52px;
            justify-content: center;
            position: relative;
            width: 52px;
        }
        .about-confidence-mark-zero {
            font-size: 1.25rem;
            font-weight: 500;
        }
        .about-confidence-mark-abta {
            flex-direction: column;
            gap: 0;
        }
        .about-confidence-mark-abta i {
            font-size: .6rem;
        }
        .about-confidence-mark-abta strong {
            font-size: .62rem;
            line-height: 1;
        }
        .about-confidence-mark-atol i {
            font-size: 1.5rem;
        }
        .about-confidence-mark-atol span {
            background: #f0f4f6;
            bottom: 5px;
            font-size: .42rem;
            font-weight: 800;
            line-height: 1;
            padding: 0 2px;
            position: absolute;
        }
        .about-confidence-mark-globe {
            font-size: 1.8rem;
        }
        @media (min-width: 768px) {
            .about-confidence {
                margin-left: auto;
                margin-right: auto;
                max-width: 960px;
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <div class="section-wrapper-global" style="padding-top: 60px; padding-bottom: 80px;">
            <div class="premium-dark-box about-mission reveal reveal-up delay-1">
                <h3 class="text-white mb-4">Our Mission</h3>
                <div class="section-content text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                    {!! nl2br(e($settings->description ?: "We make visa applications simple, fast, and secure. Trust your journey to true industry specialists. Our platform is designed to provide a seamless experience for travelers worldwide.")) !!}
                </div>
            </div>

            {{-- <section class="about-confidence" aria-labelledby="about-confidence-title">
                <h2 id="about-confidence-title">Book with confidence</h2>
                <div class="about-confidence-grid">
                    <div class="about-confidence-card">
                        <span class="about-confidence-mark about-confidence-mark-zero" aria-hidden="true">0%</span>
                        <span>Interest Free Monthly Payments Available</span>
                    </div>
                    <div class="about-confidence-card">
                        <span class="about-confidence-mark about-confidence-mark-abta" aria-hidden="true">
                            <i class="fas fa-earth-europe"></i>
                            <strong>ABTA</strong>
                        </span>
                        <span>Travel with confidence</span>
                    </div>
                    <div class="about-confidence-card">
                        <span class="about-confidence-mark about-confidence-mark-atol" aria-hidden="true">
                            <i class="fas fa-shield-halved"></i>
                            <span>ATOL</span>
                        </span>
                        <span>Always ATOL Protected</span>
                    </div>
                    <div class="about-confidence-card">
                        <span class="about-confidence-mark about-confidence-mark-globe" aria-hidden="true">
                            <i class="fas fa-earth-americas"></i>
                        </span>
                        <span>Explore a wide selection of destinations</span>
                    </div>
                </div>
            </section> --}}
        </div>

        @include('partials.footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
