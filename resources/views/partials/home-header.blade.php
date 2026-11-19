@php
    $activePage = $activePage ?? null;
    $showServices = $showServices ?? true;
    $headerClass = $headerClass ?? '';
    $showWizardBack = $showWizardBack ?? false;
    $showApplyStepper = $showApplyStepper ?? false;
    $headerPhoneLink = $headerPhoneLink ?? (!empty($settings->phone)
        ? 'tel:' . preg_replace('/[^0-9+]/', '', $settings->phone)
        : route('travel.contact'));
@endphp

<header class="home-header {{ $headerClass }}">
    @if($showWizardBack)
        <button type="button" id="wizardHeaderBack" class="apply-wizard-header-back" aria-label="Go back">
            <i class="fas fa-arrow-left"></i>
        </button>
    @endif
    <a class="home-brand" href="{{ url('/') }}" aria-label="{{ $settings->app_name ?? 'Hays Travel' }}">
        @if(!empty($settings->app_icon))
            @php
                $appIconUrl = str_starts_with($settings->app_icon, 'http') || str_starts_with($settings->app_icon, '//')
                    ? $settings->app_icon
                    : asset($settings->app_icon);
            @endphp
            <img class="home-brand-logo" src="{{ $appIconUrl }}" alt="{{ $settings->app_name ?? 'Hays Travel' }}">
        @else
            <span class="home-brand-logo home-brand-logo-fallback"><i class="fas fa-plane"></i></span>
            <span class="home-brand-copy">
                <strong>{{ $settings->app_name ?? 'Hays Travel' }}</strong>
            </span>
        @endif
    </a>
    <div class="home-header-actions">
        <a class="home-header-action" href="{{ $headerPhoneLink }}" aria-label="Contact">
            <span class="home-header-icon"><i class="fas fa-phone-alt"></i></span>
            <span class="home-header-action-label">Contact</span>
        </a>
        <button class="home-header-action nav-toggle" id="nav-toggle" type="button" aria-controls="nav-menu" aria-expanded="false" aria-label="Menu">
            <span class="home-header-icon"><i class="fas fa-bars"></i></span>
            <span class="home-header-action-label">Menu</span>
        </button>
    </div>
    <nav class="nav-links" id="nav-menu" aria-label="Main navigation">
        <a class="nav-link-item {{ $activePage === 'home' ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
        <a class="nav-link-item {{ $activePage === 'apply' ? 'active' : '' }}" href="{{ route('travel.apply') }}">Apply Visa</a>
        <a class="nav-link-item" href="{{ route('travel.verify') }}">Check Status</a>
        <a class="nav-link-item" href="{{ route('jobs.index') }}">Jobs Abroad</a>
        @if($showServices)
            <a class="nav-link-item {{ $activePage === 'services' ? 'active' : '' }}" href="{{ route('travel.services') }}">Services</a>
        @endif
        <a class="nav-link-item {{ $activePage === 'countries' ? 'active' : '' }}" href="{{ route('travel.countries') }}">Countries</a>
        <a class="nav-link-item" href="{{ route('travel.bank_guarantee') }}">Bank Guarantee &amp; Financial Verification</a>
        <a class="nav-link-item {{ $activePage === 'contact' ? 'active' : '' }}" href="{{ route('travel.contact') }}">{{ $activePage === 'contact' ? 'Support' : 'Contact Support' }}</a>
    </nav>
    @if($showApplyStepper)
        <ol class="apply-stepper visually-hidden" aria-label="Application progress">
            <li class="is-active" data-step-indicator="0"><span class="apply-stepper-icon"><i class="far fa-user"></i></span>Personal<br>Details</li>
            <li data-step-indicator="1"><span class="apply-stepper-icon"><i class="far fa-id-card"></i></span>Additional<br>Details</li>
            <li data-step-indicator="2"><span class="apply-stepper-icon">3</span>Destination &amp;<br>Profession</li>
        </ol>
    @endif
</header>
@include('partials.whatsapp-button')
