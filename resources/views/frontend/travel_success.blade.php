<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')
        <div class="section-wrapper-global" style="padding-top: 90px; padding-bottom: 100px;">
            <div class="premium-dark-box text-center mx-auto reveal reveal-up" style="max-width: 680px;">
                <div class="card-icon-circle mx-auto mb-4" style="width: 72px; height: 72px; font-size: 30px; background: rgba(25, 135, 84, .16); color: #47d18c;">
                    <i class="fas fa-check"></i>
                </div>
                <p class="mb-2" style="color: var(--accent-color); font-weight: 700; letter-spacing: .08em;">APPLICATION SENT</p>
                <h1 class="text-white mb-3" style="font-size: 2rem;">Your visa application was submitted</h1>
                <p class="text-muted mb-4">Thank you, {{ $visaRequest->first_name }}. We sent a confirmation email to <strong class="text-white">{{ $visaRequest->email }}</strong>.</p>

                <div class="row g-3 text-start mb-4">
                    <div class="col-sm-6"><div class="p-3 rounded border" style="border-color: var(--border-color) !important; background: rgba(255,255,255,.03);"><small class="text-muted d-block">Reference number</small><strong class="text-white fs-5">V{{ str_pad($visaRequest->id, 6, '0', STR_PAD_LEFT) }}</strong></div></div>
                    <div class="col-sm-6"><div class="p-3 rounded border" style="border-color: var(--border-color) !important; background: rgba(255,255,255,.03);"><small class="text-muted d-block">Current status</small><strong class="text-white fs-5">{{ ucfirst($visaRequest->status) }}</strong></div></div>
                </div>

                <p class="text-muted" style="font-size: .9rem;">Keep your reference number. You will need it together with your email address to check your visa status.</p>
                <div class="d-flex justify-content-center gap-2 flex-wrap mt-4">
                    <a href="{{ route('travel.verify') }}" class="btn-submit py-2 px-4" style="border-radius: 50px; text-decoration: none;">Check Visa Status <i class="fas fa-search ms-2"></i></a>
                    <a href="{{ url('/') }}" class="btn-submit py-2 px-4" style="border-radius: 50px; background: transparent; border: 1px solid var(--btn-primary); text-decoration: none;">Back to Home</a>
                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
