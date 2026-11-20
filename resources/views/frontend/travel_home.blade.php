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
        @include('partials.home-header', ['activePage' => 'home'])
    </div>

    <main>
        <div class="travel-home-shell">
            <section class="home-hero" aria-labelledby="home-hero-title">
                <div class="home-hero-content">
                    <div class="home-hero-copy">
                        <p class="home-hero-eyebrow">
                            <i class="fas fa-briefcase" aria-hidden="true"></i>
                            <span>Hays Travel Careers Portal</span>
                        </p>
                        <h1 id="home-hero-title">Apply for International <span>Work Opportunities</span></h1>
                        <p class="home-hero-with">with <span>{{ $settings->app_name ?? 'Our Travel Team' }}</span></p>
                        <ul class="home-hero-benefits">
                            <li><i class="fas fa-check-circle"></i> Work &amp; employment visas</li>
                            <li><i class="fas fa-check-circle"></i> Simple application process</li>
                            <li><i class="fas fa-check-circle"></i> Professional visa assistance</li>
                        </ul>
                    </div>
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
                <div class="home-destination-viewport">
                    <div class="home-destination-track">
                        @foreach ([false, true] as $isDuplicateSet)
                            <div class="home-destination-grid{{ $isDuplicateSet ? ' home-destination-grid-duplicate' : '' }}" @if($isDuplicateSet) aria-hidden="true" @endif>
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
                                    <a class="home-destination" href="{{ route('jobs.index', ['country' => $countryName]) }}" title="{{ $countryName }}" @if($isDuplicateSet) tabindex="-1" @endif>
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
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="home-confidence" aria-labelledby="home-confidence-title">
                <div class="home-confidence-heading">
                    <h2 id="home-confidence-title">Book with confidence</h2>
                    <p>We're with you every step of the way</p>
                </div>
                <div class="home-confidence-grid">
                    <a class="home-confidence-card" href="{{ route('travel.apply') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/interest.jpeg') }}" alt="Interest Free Monthly Payments" height="60" width="60"></span>
                        <span>Interest Free Monthly Payments Available</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.apply') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/abta.jpeg') }}" height="70px" width="70px" alt="Travel with confidence"></span>
                        <span>Travel with confidence</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.verify') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/protected.jpeg') }}" height="70px" width="70px" alt="Always ATOL Protected"></span>
                        <span>Always ATOL Protected</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.countries') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/test.jpeg') }}" height="70px" width="70px" alt="Worldwide Holidays"></span>
                        <span>UK's largest selection of worldwide holidays</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.services') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/review.jpeg') }}" height="70px" width="70px"     alt="Customer Rating"></span>
                        <span>4.9/5 Customer Rating</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('jobs.index') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/which.jpeg') }}" height="70px" width="70px" alt="Which? recommended"></span>
                        <span>Which? recommended</span>
                    </a>
                    <a class="home-confidence-card" href="{{ route('travel.contact') }}">
                        <span class="home-confidence-icon" aria-hidden="true"><img src="{{ asset('img/peace.jpeg') }}" height="70px" width="70px" alt="Peace of Mind Guarantee"></span>
                        <span>Peace of Mind Guarantee</span>
                    </a>
                </div>
            </section>

            <section class="home-contact-section" aria-labelledby="home-contact-title">
                <div class="home-contact-heading">
                    <h2 id="home-contact-title">Get in touch and book your perfect holiday with {{ $settings->app_name ?? 'Hays Travel' }}</h2>
                </div>
                <p class="home-contact-description">
                    With so much choice out there, stop the endless searching - our experts at {{ $settings->app_name ?? 'Hays Travel' }} will find the perfect holiday for you.
                    Speak with an expert now, <a href="{{ route('travel.contact') }}">find a branch near you</a>,
                    search online for <a href="{{ route('travel.services') }}">great deals</a>, or
                    <a href="{{ route('travel.contact') }}">enquire today</a> to start planning your dream getaway.
                </p>
                <div class="home-contact-grid">
                    <a class="home-contact-card" href="{{ !empty($settings->phone) ? 'tel:' . preg_replace('/[^0-9+]/', '', $settings->phone) : route('travel.contact') }}">
                        <span class="home-contact-card-image">
                            <img src="{{ asset('img/call.png') }}" alt="" loading="lazy">
                        </span>
                        {{-- <span class="home-contact-card-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span> --}}
                        <strong>Call our experts</strong>
                        <span class="home-contact-card-action">
                            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
                            Call {{ !empty($settings->phone) ? $settings->phone : 'our team' }}
                        </span>
                    </a>
                    <a class="home-contact-card" href="{{ route('travel.contact') }}">
                        <span class="home-contact-card-image">
                            <img src="{{ asset('img/contact.png') }}" alt="" loading="lazy">
                        </span>
                        {{-- <span class="home-contact-card-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span> --}}
                        <strong>Enquire today</strong>
                        <span class="home-contact-card-action">
                            <i class="far fa-envelope" aria-hidden="true"></i>
                            Enquire now
                        </span>
                    </a>
                    {{-- <a class="home-contact-card" href="{{ route('travel.contact') }}">
                        <span class="home-contact-card-image">
                            <img src="{{ asset('uploads/home_banner_1791029243.png') }}" alt="" loading="lazy">
                        </span>
                        <span class="home-contact-card-icon" aria-hidden="true"><i class="fas fa-house"></i></span>
                        <strong>Visit us in branch</strong>
                        <span class="home-contact-card-action">
                            <i class="fas fa-house" aria-hidden="true"></i>
                            Find your branch
                        </span>
                    </a> --}}
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
                        <p class="home-reviews-summary-label">
                            @if(!$reviewCount)
                                No ratings yet
                            @elseif($averageRating >= 4.5)
                                Excellent
                            @elseif($averageRating >= 3.5)
                                Very good
                            @elseif($averageRating >= 2.5)
                                Good
                            @elseif($averageRating >= 1.5)
                                Fair
                            @else
                                Poor
                            @endif
                        </p>
                        <div class="home-review-stars home-review-stars-summary" role="img" aria-label="{{ $reviewCount ? number_format($averageRating, 1) . ' out of 5 stars' : 'No customer ratings yet' }}">
                            @for($star = 1; $star <= 5; $star++)
                                <span class="home-review-star-box {{ $reviewCount && $star <= round($averageRating) ? '' : 'home-review-star-box-empty' }}"><i class="fas fa-star" aria-hidden="true"></i></span>
                            @endfor
                        </div>
                        <a class="home-reviews-count" href="https://uk.trustpilot.com/review/www.haystravel.co.uk?utm_medium=trustbox&amp;utm_source=Carousel">
                            @if($reviewCount)
                                Based on 452,044 
                            @else
                                Be the first to share your experience
                            @endif
                        </a>
                        <p class="home-reviews-trustmark"><span aria-hidden="true">★</span> Customer reviews</p>
                    </aside>
                    <div class="home-reviews-content">
                        @if($reviewCount)
                            <div class="home-review-carousel-wrap">
                                <button class="home-review-arrow home-review-arrow-prev" type="button" aria-label="Show previous reviews" data-review-direction="-1">
                                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                                </button>
                                <div class="home-review-carousel home-review-carousel-count-{{ min($reviewCount, 3) }}" data-review-carousel tabindex="0" aria-label="Customer reviews">
                                    @foreach($reviews as $review)
                                        @php $reviewedAt = \Illuminate\Support\Carbon::parse($review->created_at); @endphp
                                        <article class="home-review-card">
                                            <div class="home-review-card-heading">
                                                <div class="home-review-stars" role="img" aria-label="{{ $review->rating }} out of 5 stars">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <span class="home-review-star-box {{ $star <= $review->rating ? '' : 'home-review-star-box-empty' }}"><i class="fas fa-star" aria-hidden="true"></i></span>
                                                    @endfor
                                                </div>
                                                <span class="home-review-published"><i class="fas fa-circle-check" aria-hidden="true"></i> Published</span>
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
                    button.hidden = maxScroll <= 1;
                    button.disabled = direction < 0
                        ? reviewCarousel.scrollLeft <= 1
                        : reviewCarousel.scrollLeft >= maxScroll - 1;
                });
            };

            reviewCarousel.addEventListener('scroll', updateReviewButtons, { passive: true });
            reviewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const firstCard = reviewCarousel.querySelector('.home-review-card');
                    const gap = parseFloat(getComputedStyle(reviewCarousel).columnGap) || 0;
                    const scrollDistance = firstCard
                        ? firstCard.getBoundingClientRect().width + gap
                        : reviewCarousel.clientWidth;

                    reviewCarousel.scrollBy({
                        left: scrollDistance * Number(this.dataset.reviewDirection),
                        behavior: 'smooth'
                    });
                });
            });
            window.addEventListener('resize', updateReviewButtons);
            updateReviewButtons();
        }
    </script>
</body>
</html>
