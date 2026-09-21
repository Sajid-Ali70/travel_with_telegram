<!-- Premium Modern Global Footer -->
<footer class="main-footer-global">
    <div class="footer-columns-wrapper">
        <div class="footer-brand-col">
            <a href="{{ url('/') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    @if(!empty($settings->app_icon))
                        @php
                            $icon = $settings->app_icon;
                            $iconUrl = (str_starts_with($icon, 'http') || str_starts_with($icon, '//')) ? $icon : asset($icon);
                        @endphp
                        <img src="{{ $iconUrl }}" alt="Logo" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                    @else
                        <i class="fas fa-passport"></i>
                    @endif
                </div>
                <div class="nav-logo-text">
                    <h1 style="font-size: 1.2rem;">{{ $settings->app_name ?? 'VisaBook' }}</h1>
                </div>
            </a>
            <p>{{ $settings->description ?? 'We make visa applications simple, fast, and secure. Trust your journey to true industry specialists.' }}</p>
        </div>
        <div class="footer-links-col">
            <h5>Quick Links</h5>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('travel.apply') }}">Apply Visa</a></li>
                <li><a href="{{ route('travel.verify') }}">Check Status</a></li>
                <li><a href="{{ route('travel.about') }}">About Us</a></li>
                <li><a href="{{ route('travel.contact') }}">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-links-col">
            <h5>Visa Categories</h5>
            <ul>
                @forelse($footerCategories as $category)
                    <li><a href="{{ route('travel.apply') }}">{{ $category->name }}</a></li>
                @empty
                    <li><span class="text-muted">No categories available</span></li>
                @endforelse
            </ul>
        </div>
        <div class="footer-links-col">
            <h5>Contact Us</h5>
            <ul class="text-muted" style="font-size: 0.9rem; line-height: 1.6;">
                <li><i class="fas fa-phone-alt me-2 text-white"></i> {{ $settings->phone ?? '+92 300 123 4567' }}</li>
                <li><i class="far fa-envelope me-2 text-white"></i> {{ $settings->email ?? 'info@visabook.com' }}</li>
                <li><i class="fas fa-map-marker-alt me-2 text-white"></i> {{ $settings->address ?? '123 Travel Street, Islamabad' }}</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom-copyright">
        <p>{{ $settings->footer_text ?? '&copy; ' . date('Y') . ' ' . ($settings->app_name ?? 'VisaBook') . '. All rights reserved.' }}</p>
        <p style="gap: 16px; display: flex;">
            <a href="#" class="text-muted text-decoration-none">Privacy Policy</a>
            <a href="#" class="text-muted text-decoration-none">Terms & Conditions</a>
        </p>
    </div>
</footer>
