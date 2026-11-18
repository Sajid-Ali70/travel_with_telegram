<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#063b86">
    <title>Countries | {{ $settings->app_name ?? 'Travel & Visa Services' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travel-home.css') }}">
</head>
<body class="travel-home-page travel-countries-page">
    @php
        $countryCodeMap = [
            'australia' => 'au',
            'azerbaijan' => 'az',
            'bangladesh' => 'bd',
            'brazil' => 'br',
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
            'russia' => 'ru',
            'saudi arabia' => 'sa',
            'singapore' => 'sg',
            'south africa' => 'za',
            'south korea' => 'kr',
            'sri lanka' => 'lk',
            'spain' => 'es',
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
                <a class="nav-link-item" href="{{ url('/') }}">Home</a>
                <a class="nav-link-item" href="{{ route('travel.apply') }}">Apply Visa</a>
                <a class="nav-link-item" href="{{ route('travel.verify') }}">Check Status</a>
                <a class="nav-link-item" href="{{ route('jobs.index') }}">Jobs Abroad</a>
                <a class="nav-link-item active" href="{{ route('travel.countries') }}">Countries</a>
                <a class="nav-link-item" href="{{ route('travel.bank_guarantee') }}">Bank Guarantee &amp; Financial Verification</a>
                <a class="nav-link-item" href="{{ route('travel.contact') }}">Contact Support</a>
            </nav>
        </header>

        <main class="countries-main">
            <section class="countries-section" aria-labelledby="countries-title">
                <h1 id="countries-title">Our Services for Top Destinations</h1>
                <div class="countries-grid" id="countries-grid">
                    @foreach($countries as $country)
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
                        <a class="country-card" href="{{ route('jobs.index', ['country' => $countryName]) }}" data-country-name="{{ mb_strtolower($countryName) }}">
                            <span class="country-flag-wrap">
                                @if($countryFlag)
                                    <img src="{{ $countryFlag }}" data-fallback="{{ $countryCode ? 'https://flagcdn.com/w80/' . $countryCode . '.png' : '' }}" alt="" loading="lazy">
                                    <span class="country-flag-fallback" hidden>{{ $countryFlagEmoji }}</span>
                                @else
                                    <span class="country-flag-fallback">{{ $countryFlagEmoji }}</span>
                                @endif
                            </span>
                            <span class="country-card-name">{{ $countryName }}</span>
                        </a>
                    @endforeach
                </div>
                <p class="countries-empty" id="countries-empty" hidden>No destinations match your search.</p>
            </section>

            <section class="popular-destinations" aria-labelledby="popular-destinations-title">
                <h2 id="popular-destinations-title">Popular Destinations</h2>
                <form class="destination-search" role="search" onsubmit="return false">
                    <span class="destination-search-icon" aria-hidden="true"><i class="fas fa-search"></i></span>
                    <input type="search" id="destination-search-input" placeholder="Search destinations..." aria-label="Search destinations">
                </form>
            </section>
        </main>

    </div>
    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const destinationInput = document.getElementById('destination-search-input');
        const countryCards = [...document.querySelectorAll('.country-card')];
        const emptyMessage = document.getElementById('countries-empty');

        destinationInput.addEventListener('input', () => {
            const query = destinationInput.value.trim().toLocaleLowerCase();
            let visibleCount = 0;

            countryCards.forEach(card => {
                const matches = card.dataset.countryName.includes(query);
                card.hidden = !matches;
                visibleCount += matches ? 1 : 0;
            });

            emptyMessage.hidden = visibleCount > 0;
        });

        document.querySelectorAll('.country-card img').forEach(image => {
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
    </script>
</body>
</html>
