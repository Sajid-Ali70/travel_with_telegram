<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#063b86">
    <title>{{ $settings->app_name ?? 'Travel & Visa Services' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travel-home.css') }}">
</head>
<body class="travel-home-page">
    @php
        $homeCountries = collect($countries ?? [])->take(12);
        if ($homeCountries->isEmpty()) {
            $homeCountries = collect([
                (object) ['name' => 'Azerbaijan', 'code' => 'az'],
                (object) ['name' => 'Canada', 'code' => 'ca'],
                (object) ['name' => 'Japan', 'code' => 'jp'],
                (object) ['name' => 'Kuwait', 'code' => 'kw'],
                (object) ['name' => 'Oman', 'code' => 'om'],
                (object) ['name' => 'Saudi Arabia', 'code' => 'sa'],
                (object) ['name' => 'United Arab Emirates', 'code' => 'ae'],
                (object) ['name' => 'United Kingdom', 'code' => 'gb'],
                (object) ['name' => 'United States', 'code' => 'us'],
                (object) ['name' => 'Turkey', 'code' => 'tr'],
                (object) ['name' => 'Italy', 'code' => 'it'],
                (object) ['name' => 'Bangladesh', 'code' => 'bd'],
            ]);
        }
        $countryCodeMap = [
            'australia' => 'au',
            'azerbaijan' => 'az',
            'bangladesh' => 'bd',
            'canada' => 'ca',
            'china' => 'cn',
            'france' => 'fr',
            'germany' => 'de',
            'india' => 'in',
            'indonesia' => 'id',
            'italy' => 'it',
            'japan' => 'jp',
            'jordan' => 'jo',
            'kuwait' => 'kw',
            'lebanon' => 'lb',
            'malaysia' => 'my',
            'nepal' => 'np',
            'oman' => 'om',
            'pakistan' => 'pk',
            'philippines' => 'ph',
            'qatar' => 'qa',
            'saudi arabia' => 'sa',
            'singapore' => 'sg',
            'south korea' => 'kr',
            'sri lanka' => 'lk',
            'turkey' => 'tr',
            'türkiye' => 'tr',
            'united arab emirates' => 'ae',
            'uae' => 'ae',
            'united kingdom' => 'gb',
            'uk' => 'gb',
            'united states' => 'us',
            'usa' => 'us',
        ];
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
                <a class="nav-link-item active" href="{{ url('/') }}">Home</a>
                <a class="nav-link-item" href="{{ route('travel.apply') }}">Apply Visa</a>
                <a class="nav-link-item" href="{{ route('travel.verify') }}">Check Status</a>
                <a class="nav-link-item" href="{{ route('jobs.index') }}">Jobs Abroad</a>
                <a class="nav-link-item" href="{{ route('travel.services') }}">Services</a>
                <a class="nav-link-item" href="{{ route('travel.countries') }}">Countries</a>
                <a class="nav-link-item" href="{{ route('travel.bank_guarantee') }}">Bank Guarantee &amp; Financial Verification</a>
                <a class="nav-link-item" href="{{ route('travel.contact') }}">Contact Support</a>
            </nav>
        </header>
    </div>

    <main>
        <div class="travel-home-shell">
            <section class="home-hero" aria-labelledby="home-hero-title">
                <div class="home-hero-content">
                    <p class="home-hero-eyebrow">YOUR GLOBAL CAREER DESTINATION</p>
                    <h1 id="home-hero-title">Apply for International<br><span>Work Opportunities</span></h1>
                    <p class="home-hero-with">with <span>{{ $settings->app_name ?? 'Our Travel Team' }}</span></p>
                    <ul class="home-hero-benefits">
                        <li><i class="fas fa-check-circle"></i> Work &amp; employment visas</li>
                        <li><i class="fas fa-check-circle"></i> Simple application process</li>
                        <li><i class="fas fa-check-circle"></i> Professional visa assistance</li>
                    </ul>
                    <div class="home-hero-actions">
                        <a class="home-apply-button" href="{{ route('travel.apply') }}">
                            <i class="fas fa-edit"></i><span>Apply Now</span><i class="fas fa-arrow-right"></i>
                        </a>
                        <a class="home-status-button" href="{{ route('travel.verify') }}">
                            <i class="fas fa-search"></i><span>Check Status</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="home-services" id="home-services" aria-label="Our services">
                <a class="home-service-card" href="{{ route('travel.apply') }}">
                    <span class="home-service-icon service-visa"><i class="fas fa-plane"></i></span>
                    <span>Visas</span>
                </a>
                <a class="home-service-card" href="{{ route('jobs.index') }}">
                    <span class="home-service-icon service-jobs"><i class="fas fa-briefcase"></i></span>
                    <span>Jobs Abroad</span>
                </a>
                <a class="home-service-card" href="{{ route('travel.about') }}">
                    <span class="home-service-icon service-travel"><i class="fas fa-umbrella-beach"></i></span>
                    <span>Travel Packages</span>
                </a>
                <a class="home-service-card" href="{{ route('travel.contact') }}">
                    <span class="home-service-icon service-support"><i class="fas fa-headset"></i></span>
                    <span>Contact Support</span>
                </a>
            </section>

            <section class="home-destinations" id="home-destinations" aria-labelledby="home-destinations-title">
                <div class="home-section-heading">
                    <span class="home-heading-rule" aria-hidden="true"></span>
                    <h2 id="home-destinations-title">Our Services for Top Destinations</h2>
                    <span class="home-heading-rule" aria-hidden="true"></span>
                </div>
                <div class="home-destination-grid">
                    @foreach($homeCountries as $country)
                        @php
                            $countryName = trim((string) ($country->name ?? ''));
                            $countryCode = strtolower((string) ($country->code ?? $countryCodeMap[mb_strtolower($countryName)] ?? ''));
                            $countryFlagEmoji = strlen($countryCode) === 2
                                ? mb_chr(127397 + ord(strtoupper($countryCode[0])), 'UTF-8') . mb_chr(127397 + ord(strtoupper($countryCode[1])), 'UTF-8')
                                : '🌐';
                            $countryFlag = !empty($country->flag)
                                ? (str_starts_with($country->flag, 'http') || str_starts_with($country->flag, '//') ? $country->flag : asset($country->flag))
                                : ($countryCode ? 'https://flagcdn.com/w80/' . $countryCode . '.png' : null);
                        @endphp
                        <a class="home-destination" href="{{ route('jobs.index', ['country' => $countryName]) }}" title="{{ $countryName }}">
                            @if($countryFlag)
                                <img src="{{ $countryFlag }}" data-fallback="{{ $countryCode ? 'https://flagcdn.com/w80/' . $countryCode . '.png' : '' }}" alt="" loading="lazy">
                                <span class="home-destination-fallback" hidden>{{ $countryFlagEmoji }}</span>
                            @else
                                <span class="home-destination-fallback">{{ $countryFlagEmoji }}</span>
                            @endif
                            <span>{{ $countryName }}</span>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="home-confidence" aria-labelledby="home-confidence-title">
                <div class="home-confidence-heading">
                    <h2 id="home-confidence-title">Book with confidence</h2>
                    <p>We're with you every step of the way</p>
                </div>
                <div class="home-confidence-grid">
                    <a class="home-confidence-card" href="{{ route('travel.apply') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-list-check"></i></span>
                        <span>Simple application process</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.apply') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-passport"></i></span>
                        <span>Visa application support</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.verify') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-magnifying-glass"></i></span>
                        <span>Track your application</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.countries') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-earth-americas"></i></span>
                        <span>Explore destinations</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.services') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-plane"></i></span>
                        <span>Travel services</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('jobs.index') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
                        <span>Work opportunities</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.contact') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><i class="fas fa-headset"></i></span>
                        <span>Contact our team</span>
                    </a>
                </div>
            </section>

            <section class="home-contact-promo" aria-labelledby="home-contact-promo-title">
                <h2 id="home-contact-promo-title">Get in touch and plan your next journey with {{ $settings->app_name ?? 'Hays Travel' }}</h2>
                <p>
                    Our team can help you explore visa, travel, and overseas work options.
                    <a href="{{ route('travel.contact') }}">Speak with our team</a>,
                    <a href="{{ route('travel.services') }}">explore our services</a>, or
                    <a href="{{ route('travel.apply') }}">start an application</a> to plan your next step.
                </p>
            </section>

            <section class="home-contact-options" aria-label="Contact our team">
                <div class="home-contact-options-grid">
                    <a class="home-contact-option" href="{{ !empty($settings->phone) ? 'tel:' . preg_replace('/[^0-9+]/', '', $settings->phone) : route('travel.contact') }}">
                        <span class="home-contact-option-image">
                            <img src="{{ asset('uploads/home_banner_1789472460.png') }}" alt="" loading="lazy">
                        </span>
                        <span class="home-contact-option-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
                        <strong>Call our experts</strong>
                        <span class="home-contact-option-button">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                            {{ !empty($settings->phone) ? $settings->phone : 'Contact our team' }}
                        </span>
                    </a>
                    <a class="home-contact-option" href="{{ route('travel.contact') }}">
                        <span class="home-contact-option-image">
                            <img src="{{ asset('uploads/home_banner_1791029243.png') }}" alt="" loading="lazy">
                        </span>
                        <span class="home-contact-option-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                        <strong>Enquire today</strong>
                        <span class="home-contact-option-button">
                            <i class="far fa-envelope" aria-hidden="true"></i>
                            Enquire now
                        </span>
                    </a>
                </div>
            </section>
        </div>

        @php
            $averageRating = (float) $reviews->avg('rating');
            $reviewCount = $reviews->count();
        @endphp
        <section class="home-reviews" aria-labelledby="home-reviews-title">
            <div class="home-reviews-inner">
                <h2 id="home-reviews-title">What our customers are saying about us</h2>
                <div class="home-reviews-layout">
                    <aside class="home-reviews-summary" aria-label="Customer rating summary">
                        <p class="home-reviews-summary-label">Average customer rating</p>
                        <p class="home-reviews-score">
                            @if($reviewCount){{ number_format($averageRating, 1) }}@else &mdash;@endif
                            <span>/ 5</span>
                        </p>
                        <div class="home-review-stars home-review-stars-summary" role="img" aria-label="{{ $reviewCount ? number_format($averageRating, 1) . ' out of 5 stars' : 'No customer ratings yet' }}">
                            @for($star = 1; $star <= 5; $star++)
                                <span class="home-review-star-box {{ $reviewCount && $star <= round($averageRating) ? '' : 'home-review-star-box-empty' }}"><i class="fas fa-star" aria-hidden="true"></i></span>
                            @endfor
                        </div>
                        <p class="home-reviews-count">
                            @if($reviewCount)
                                Based on {{ number_format($reviewCount) }} customer {{ \Illuminate\Support\Str::plural('review', $reviewCount) }}
                            @else
                                No customer reviews yet
                            @endif
                        </p>
                    </aside>
                    <div class="home-reviews-content">
                        @if($reviewCount)
                            <div class="home-review-carousel-wrap">
                                <button class="home-review-arrow home-review-arrow-prev" type="button" aria-label="Show previous reviews" data-review-direction="-1">
                                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                                </button>
                                <div class="home-review-carousel" data-review-carousel tabindex="0" aria-label="Customer reviews">
                                    @foreach($reviews as $review)
                                        @php $reviewedAt = \Illuminate\Support\Carbon::parse($review->created_at); @endphp
                                        <article class="home-review-card">
                                            <div class="home-review-card-heading">
                                                <div class="home-review-stars" role="img" aria-label="{{ $review->rating }} out of 5 stars">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <span class="home-review-star-box {{ $star <= $review->rating ? '' : 'home-review-star-box-empty' }}"><i class="fas fa-star" aria-hidden="true"></i></span>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="home-review-card-meta">
                                                <strong>{{ $review->reviewer_name }}</strong>,
                                                <time datetime="{{ $reviewedAt->toDateString() }}">{{ $reviewedAt->diffForHumans() }}</time>
                                            </p>
                                            <h3>{{ $review->review_title }}</h3>
                                            <blockquote>{{ $review->review_text }}</blockquote>
                                        </article>
                                    @endforeach
                                </div>
                                <button class="home-review-arrow home-review-arrow-next" type="button" aria-label="Show more reviews" data-review-direction="1">
                                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>
                            <p class="home-reviews-caption">Showing {{ number_format($reviewCount) }} published {{ \Illuminate\Support\Str::plural('review', $reviewCount) }}</p>
                        @else
                            <div class="home-review-empty" role="status">
                                <i class="far fa-comment-dots" aria-hidden="true"></i>
                                <p>No customer reviews have been published yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.querySelectorAll('.home-destination img').forEach(image => {
            image.addEventListener('error', function() {
                const fallbackUrl = this.dataset.fallback;
                if (fallbackUrl && !this.dataset.fallbackAttempted) {
                    this.dataset.fallbackAttempted = 'true';
                    this.src = fallbackUrl;
                    return;
                }

                this.hidden = true;
                this.nextElementSibling.hidden = false;
            });
        });

        const reviewCarousel = document.querySelector('[data-review-carousel]');
        if (reviewCarousel) {
            const reviewButtons = Array.from(document.querySelectorAll('[data-review-direction]'));
            const updateReviewButtons = () => {
                const maxScroll = reviewCarousel.scrollWidth - reviewCarousel.clientWidth;
                reviewButtons.forEach(button => {
                    const direction = Number(button.dataset.reviewDirection);
                    button.disabled = direction < 0
                        ? reviewCarousel.scrollLeft <= 1
                        : reviewCarousel.scrollLeft >= maxScroll - 1;
                });
            };

            reviewCarousel.addEventListener('scroll', updateReviewButtons, { passive: true });
            reviewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    reviewCarousel.scrollBy({
                        left: reviewCarousel.clientWidth * Number(this.dataset.reviewDirection) * 0.8,
                        behavior: 'smooth'
                    });
                });
            });
            updateReviewButtons();
        }
    </script>
</body>
</html>
