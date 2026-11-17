<footer class="main-footer-global">
    <div class="footer-columns-wrapper">
        <div class="footer-contact-col">
            <h2>Speak to one of our expert advisors</h2>
            <p>Whether you are planning a trip or exploring work opportunities abroad, our team is here to help you with the next steps.</p>
            <div class="footer-contact-card">
                @if(!empty($settings->phone))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->phone) }}">
                        <i class="fas fa-phone-alt" aria-hidden="true"></i>
                        <span>{{ $settings->phone }}</span>
                    </a>
                @endif
                <a href="{{ route('travel.contact') }}">
                    <i class="fas fa-headset" aria-hidden="true"></i>
                    <span>Contact our team</span>
                </a>
            </div>
        </div>
        <div class="footer-links-col">
            <h2>{{ $settings->app_name ?? 'Hays Travel' }}</h2>
            <ul>
                <li><a href="{{ route('travel.about') }}">About Us</a></li>
                <li><a href="{{ route('travel.contact') }}">Contact Us</a></li>
                <li><a href="{{ route('travel.services') }}">Services</a></li>
                <li><a href="{{ route('travel.countries') }}">Countries</a></li>
                <li><a href="{{ route('jobs.index') }}">Careers</a></li>
            </ul>
        </div>
        <div class="footer-links-col">
            <h2>Useful links</h2>
            <ul>
                <li><a href="{{ route('travel.apply') }}">Apply for a visa</a></li>
                <li><a href="{{ route('travel.verify') }}">Check application status</a></li>
                <li><a href="{{ route('travel.services') }}">Visa and travel services</a></li>
                <li><a href="{{ route('jobs.index') }}">Explore job opportunities</a></li>
            </ul>
        </div>
        <div class="footer-assurance-col">
            <h2>Travel with confidence</h2>
            <span class="footer-assurance-icon" aria-hidden="true"><i class="fas fa-globe-americas"></i></span>
            <p>Visa decisions are made by the relevant government authorities. We provide application support; approval, processing times and entry requirements are determined by those authorities. Please confirm current requirements before you travel.</p>
        </div>
    </div>
    <div class="footer-bottom-copyright">
        <p>{{ $settings->footer_text ?? '© ' . date('Y') . ' ' . ($settings->app_name ?? 'Hays Travel') . '. All rights reserved.' }}</p>
        <a href="{{ route('travel.contact') }}">Need help? Contact our team</a>
    </div>
</footer>
