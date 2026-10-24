<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Visa Status - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <!-- Modern Plus Jakarta Sans Font & UI Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        .visa-hero-section {
            @php
                $banner = !empty($settings->inner_banner) ? $settings->inner_banner : "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80";
                $bannerUrl = (str_starts_with($banner, 'http') || str_starts_with($banner, '//')) ? $banner : asset($banner);
            @endphp
            background-image: url('{{ $bannerUrl }}') !important;
        }

        body {
            background: #eef2f7;
            color: #1f2937;
        }

        .visa-status-header {
            align-items: center;
            background: #fff;
            border-bottom: 1px solid #e6eaf0;
            display: flex;
            height: 44px;
            justify-content: space-between;
            padding: 0 14px;
        }
        .visa-status-header a,
        .visa-status-header span {
            color: #17253d !important;
            font-size: 1rem;
            text-decoration: none;
        }
        .visa-status-header span {
            font-weight: 700;
        }
        .status-result-page {
            flex: 1;
            padding: 10px 10px 24px !important;
        }
        .status-result-page .form-sidebar-grid {
            display: block;
        }
        .status-result-page .premium-dark-box {
            background: transparent;
            border: 0;
            box-shadow: none;
            padding: 0;
        }
        .status-result-page .status-search-intro,
        .status-result-page .status-lookup-form,
        .status-result-page .sidebar-sticky-panel {
            display: none;
        }
        .status-result-page .status-result-wrapper {
            margin-top: 0 !important;
        }
        .status-result-wrapper {
            /* max-width: 460px; */
            margin: 0 auto;
            padding: 0;
        }

        .status-result-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #dfe7f3;
            box-shadow: 0 5px 15px rgba(17, 24, 39, 0.08);
            overflow: hidden;
        }

        .status-result-header {
            align-items: center;
            background: #eef6fb;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            padding: 14px 16px;
            border-bottom: 1px solid #dcebf4;
        }

        .status-result-header.is-approved {
            border-color: #dcebf4;
        }
        .status-result-header.is-rejected {
            border-color: #f2dada;
        }
        .status-reference-copy,
        .visa-status-display {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .status-reference-copy {
            min-width: 0;
        }
        .visa-status-display {
            align-items: flex-end;
            flex: 0 0 auto;
        }
        .visa-status-label {
            color: #526273 !important;
            font-size: .84rem;
            line-height: 1.2;
        }
        .visa-status-pill {
            background: #138a18;
            border-radius: 8px;
            color: #fff !important;
            display: inline-block;
            font-size: .94rem;
            font-weight: 800;
            line-height: 1.2;
            max-width: 210px;
            overflow-wrap: anywhere;
            padding: 8px 14px;
            text-align: center;
        }
        .status-result-header.is-rejected .visa-status-pill {
            background: #c93535;
        }
        .status-result-header.is-pending .visa-status-pill {
            background: #f4c542;
            color: #243449 !important;
        }
        .status-reference {
            color: #2865a3 !important;
            display: block;
            font-size: .88rem;
            font-weight: 700;
            overflow-wrap: anywhere;
        }
        .status-reference-label {
            color: #526273 !important;
            font-size: .82rem;
        }
        .status-result-message {
            color: #1f2937;
            padding: 10px 12px 6px;
            text-align: center;
        }
        .status-result-message strong {
            color: #111827;
            display: block;
            font-size: .92rem;
            margin-bottom: 2px;
        }
        .status-result-message p {
            color: #374151;
            font-size: .86rem;
            line-height: 1.45;
            margin: 0;
        }
        .status-body {
            background: #f2f5f8 !important;
            padding: 8px 10px 12px;
        }

        .field-group {
            margin-bottom: 10px;
        }

        .field-title {
            color: #1f2937;
            font-size: .9rem;
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
        }

        .detail-grid {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .client-details-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 72px;
            gap: 12px;
            align-items: start;
        }

        .client-photo {
            width: 72px;
            height: 88px;
            object-fit: cover;
            object-position: center;
            border: 1px solid #dfe7f3;
            border-radius: 8px;
            background: #f8fafc;
        }

        .client-photo-placeholder {
            display: grid;
            place-items: center;
            color: #8290a2;
            font-size: 2rem;
        }

        .detail-item {
            align-items: center;
            background: #fff;
            border: 1px solid #e3e8ee;
            border-radius: 5px;
            display: grid;
            grid-template-columns: minmax(0, 43%) minmax(0, 1fr);
            gap: 8px;
            min-height: 36px;
            padding: 6px 9px;
        }

        .detail-label {
            color: #475569;
            font-size: .78rem;
            margin: 0;
        }

        .detail-value {
            color: #111827;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.25;
            overflow-wrap: anywhere;
        }
        .status-detail-next {
            background: #1682bf;
            border-radius: 5px;
            color: #fff !important;
            display: block;
            font-size: .9rem;
            font-weight: 700;
            margin: 8px 0;
            padding: 8px 10px;
            text-align: center;
            text-decoration: none;
        }
        .status-result-step.d-none {
            display: none !important;
        }
        .payment-document-card,
        .payment-bank-card,
        .payment-receipt-card {
            background: #fff;
            border: 1px solid #dce7f3;
            border-radius: 10px;
            margin-bottom: 9px;
            padding: 10px;
        }
        .payment-document-card {
            align-items: center;
            display: flex;
            gap: 9px;
        }
        .payment-card-icon {
            align-items: center;
            background: #eef4fb;
            border-radius: 8px;
            color: #1765a8;
            display: flex;
            flex: 0 0 32px;
            height: 32px;
            justify-content: center;
        }
        .payment-card-title {
            color: #1f2937;
            font-size: .9rem;
            font-weight: 800;
            margin: 0 0 2px;
        }
        .payment-card-note {
            color: #526174;
            font-size: .78rem;
            line-height: 1.35;
            margin: 0;
        }
        .payment-download-link {
            background: #0875db;
            border-radius: 6px;
            color: #fff !important;
            display: block;
            font-size: .82rem;
            font-weight: 700;
            margin-top: 7px;
            padding: 7px 9px;
            text-align: center;
            text-decoration: none;
        }
        .verification-whatsapp-link {
            background: #18a558;
            border-radius: 8px;
            color: #fff !important;
            display: flex;
            font-size: .82rem;
            font-weight: 700;
            gap: 7px;
            justify-content: center;
            margin: 10px auto 0;
            max-width: 300px;
            padding: 10px 12px;
            text-align: center;
            text-decoration: none;
            transition: background-color .2s ease;
        }
        .verification-whatsapp-link:hover,
        .verification-whatsapp-link:focus {
            background: #128747;
            color: #fff !important;
        }
        .verification-whatsapp-link i {
            color: #fff !important;
            font-size: 1rem;
        }
        .payment-amount-card {
            align-items: center;
            background: #eaf4ff;
            border: 1px solid #d4e8ff;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 9px;
            padding: 11px 10px;
        }
        .payment-amount-card .amount-title {
            color: #18365b;
            font-size: .82rem;
            margin: 0;
        }
        .payment-amount-card .amount-value {
            color: #102c50;
            font-size: 1rem;
        }
        .payment-bank-card .field-title,
        .payment-receipt-card .field-title {
            align-items: center;
            display: flex;
            gap: 7px;
            justify-content: flex-start;
            margin-bottom: 7px;
            text-align: left;
        }
        .payment-bank-row {
            align-items: center;
            border-top: 1px solid #edf1f5;
            color: #44546a;
            display: flex;
            font-size: .82rem;
            gap: 8px;
            justify-content: space-between;
            padding: 7px 0;
        }
        .payment-bank-row strong {
            color: #1e293b;
            text-align: right;
        }
        .payment-receipt-card .result-action-form {
            border: 0;
            margin: 7px 0 0;
            padding: 0;
        }
        .payment-receipt-card .action-submit {
            background: #eaf3ff;
            border: 1px dashed #7ca9dd;
            color: #185a9d;
            margin: 0;
        }
        .payment-receipt-status {
            background: #effaf3;
            border: 1px solid #ccebd5;
            border-radius: 6px;
            color: #27643b;
            font-size: .78rem;
            margin-top: 7px;
            padding: 7px 8px;
        }
        .payment-step-navigation {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }
        .payment-step-navigation button {
            border: 0;
            border-radius: 7px;
            font-size: .86rem;
            font-weight: 700;
            min-height: 38px;
        }
        .payment-step-back {
            background: #e8edf3;
            color: #22364f;
            flex: 0 0 34%;
        }
        .payment-step-next {
            background: #0756a8;
            color: #fff;
            flex: 1;
        }
        .payment-step-error {
            color: #b42318;
            font-size: .78rem;
            margin: 7px 0 0;
        }
        .payment-verification-step {
            padding: 20px 14px;
            text-align: center;
        }
        .payment-verification-step .payment-card-icon {
            background: #e8f7ee;
            color: #28814a;
            font-size: 1.2rem;
            height: 48px;
            margin: 0 auto 10px;
            width: 48px;
        }
        .payment-verification-step h2 {
            color: #193a60;
            font-size: 1rem;
            font-weight: 800;
        }
        .payment-verification-step p {
            color: #526174;
            font-size: .78rem;
            line-height: 1.45;
        }
        .approved-contact-panel {
            background: #f0faf5;
            border: 1px solid #d8eee2;
            border-radius: 9px;
            margin: 8px 10px;
            padding: 10px;
        }
        .approved-contact-title {
            color: #126b43;
            font-size: .88rem;
            font-weight: 800;
            margin: 0;
            text-align: center;
        }
        .approved-contact-message {
            color: #526578;
            font-size: .74rem;
            line-height: 1.4;
            margin: 4px 0 9px;
            text-align: center;
        }
        .approved-contact-agent {
            align-items: center;
            display: flex;
            gap: 8px;
        }
        .approved-contact-agent .receipt-agent-avatar {
            align-items: center;
            background: #dbeafe;
            border-radius: 50%;
            color: #315b8d;
            display: flex;
            flex: 0 0 36px;
            height: 36px;
            justify-content: center;
        }
        .approved-contact-agent-name {
            color: #1d3249;
            font-size: .78rem;
            font-weight: 800;
            margin: 0;
        }
        .approved-contact-phone {
            color: #526578;
            font-size: .72rem;
            margin: 2px 0 0;
        }
        .status-download-note {
            color: #1f2937;
            font-size: .8rem;
            font-weight: 600;
            line-height: 1.3;
            margin: 4px auto 8px;
            max-width: 260px;
            text-align: center;
        }
        .detail-label i {
            color: #64748b;
            margin-right: 4px;
            width: 11px;
        }

        .amount-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.84rem;
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .amount-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: #111827;
            text-align: right;
        }

        .result-action-form {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #edf2f7;
        }

        .result-action-form label {
            display: block;
            color: #334155;
            font-size: 0.82rem;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .result-action-form input,
        .result-action-form select {
            width: 100%;
            min-height: 42px;
            padding: 8px 10px;
            color: #334155;
            background: #fff;
            border: 1px solid #cfd8e3;
            border-radius: 7px;
            font-size: 0.86rem;
        }

        .result-action-form input[type="file"] {
            padding: 6px;
        }

        .action-submit {
            width: 100%;
            min-height: 42px;
            margin-top: 10px;
            border: 0;
            border-radius: 7px;
            color: #fff;
            background: #1765a8;
            font-size: 0.84rem;
            font-weight: 700;
        }

        .action-submit:hover,
        .action-submit:focus {
            background: #124f85;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .result-alert {
            margin: 12px 18px 0;
            padding: 10px 12px;
            border-radius: 7px;
            font-size: 0.84rem;
        }

        @media (max-width: 480px) {
            .status-result-page .detail-item {
                grid-template-columns: minmax(0, 43%) minmax(0, 1fr);
            }

            .amount-title {
                flex-wrap: nowrap;
                gap: 6px;
                font-size: 0.65rem;
                letter-spacing: 0.02em;
            }

            .amount-title span {
                white-space: nowrap;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .client-details-layout {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .client-photo {
                order: -1;
                align-self: center;
            }

            .client-details-layout .detail-item {
                display: grid;
                grid-template-columns: minmax(74px, 30%) minmax(0, 1fr);
                align-items: center;
                gap: 8px;
                padding: 8px 10px;
            }

            .client-details-layout .detail-label {
                margin-bottom: 0;
                white-space: nowrap;
            }

            .client-details-layout .detail-value {
                min-width: 0;
                overflow-x: auto;
                white-space: nowrap;
            }

        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @if($visaRequest)
            <header class="visa-status-header">
                <a href="{{ url('/') }}" aria-label="Back to home"><i class="fas fa-arrow-left"></i></a>
                <span>Visa Status</span>
                <a href="{{ route('travel.verify') }}" aria-label="Search another visa status"><i class="fas fa-search"></i></a>
            </header>
        @else
            @include('partials.nav')

            <!-- Sub-Banner Header -->
            <div class="visa-hero-section" style="min-height: 350px; padding: 40px 5%; background-position: top center;">
                <div class="hero-overlay-content reveal reveal-left" style="max-width: 100%;">
                    <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; Check Status</p>
                    <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">Check Visa Status</h2>
                    <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Track your visa application using your reference number or passport number.</p>
                </div>
            </div>
        @endif

        <div class="section-wrapper-global {{ $visaRequest ? 'status-result-page' : '' }}" style="padding-top: {{ $visaRequest ? '10px' : '40px' }}; padding-bottom: {{ $visaRequest ? '24px' : '60px' }};">
            <!-- Form & Sidebar Dual Layout Grid -->
            <div class="form-sidebar-grid">
                <!-- Left Side: Verification Box -->
                <div class="premium-dark-box reveal reveal-up delay-1">
                    <div class="status-search-intro text-center mb-4">
                        <div class="card-icon-circle reveal reveal-fade" style="width: 56px; height: 56px; font-size: 22px; background-color: #e8f5eb; margin-bottom: 12px;">
                            <i class="fas fa-search text-primary"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-2" style="font-size: 1.25rem;">Enter Your Details</h4>
                        <p class="text-muted" style="font-size: 0.85rem;">Choose a lookup method and enter the matching number. Email is not required.</p>
                    </div>

                    @if($statusError)
                        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>{{ $statusError }}</div>
                    @endif

                    <form class="status-lookup-form" action="{{ route('travel.verify') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="visa_lookup_type">Search Using *</label>
                            <div class="input-with-icon">
                                <i class="far fa-id-card"></i>
                                <select id="visa_lookup_type" name="lookup_type" required>
                                    <option value="reference" {{ old('lookup_type', 'reference') === 'reference' ? 'selected' : '' }}>Reference Number</option>
                                    <option value="passport_number" {{ old('lookup_type') === 'passport_number' ? 'selected' : '' }}>Passport Number</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="visa_lookup_value">Reference or Passport Number *</label>
                            <div class="input-with-icon">
                                <i class="far fa-id-card"></i>
                                <input id="visa_lookup_value" type="text" name="lookup_value" value="{{ old('lookup_value') }}" placeholder="Enter the selected number" maxlength="100" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit mt-4 py-3" style="border-radius: 50px;">
                            Check Status <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                    @if($visaRequest)
                        <div class="status-result-wrapper mt-4">
                            <div class="status-result-card">
                                @php
                                    $resultApproved = in_array($visaRequest->status, ['Visa Approved from Embassy', 'Visa Approved', 'Payment Verified', 'Visa Issued', 'Flight Ticket Booked', 'approved'], true);
                                    $resultRejected = in_array($visaRequest->status, ['Visa Rejected - Document Verification Failed', 'Visa Rejected due to Documents Verification Failed', 'Visa Rejected - Fee Not Paid', 'Visa Rejected due to Non Payment of Fee', 'Application Rejected', 'rejected'], true);
                                    $resultStatusClass = $resultApproved ? 'is-approved' : ($resultRejected ? 'is-rejected' : 'is-pending');
                                    $hasVisaDocument = !empty($visaRequest->issued_visa_document)
                                        && \Illuminate\Support\Facades\Storage::disk('local')->exists($visaRequest->issued_visa_document);
                                    $resultHasPaymentStep = $statusText === 'Visa Approved from Embassy';
                                    $resultHasDocumentStep = $visaRequest->status === 'Visa Issued' && $hasVisaDocument;
                                    $resultHasNext = $resultHasPaymentStep || $resultHasDocumentStep;
                                @endphp
                                <div id="visa-details-step" class="status-result-step">
                                    <div class="status-result-header {{ $resultStatusClass }}">
                                        <div class="status-reference-copy">
                                            <span class="status-reference-label">Application Number</span>
                                            <span class="status-reference">{{ $visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at) }}</span>
                                        </div>
                                        <div class="visa-status-display">
                                            <span class="visa-status-label">Visa Status</span>
                                            <span class="visa-status-pill">{{ in_array($visaRequest->status, ['Visa Approved from Embassy', 'Visa Approved', 'approved'], true) ? 'Approved' : $statusText }}</span>
                                        </div>
                                    </div>
                                    <div class="status-result-message">
                                        @if($resultApproved)
                                            <strong>CONGRATULATIONS!</strong>
                                        @endif
                                        <p>{{ $statusMessage }}</p>
                                    </div>
                                    @if(session('result_notice'))
                                        <div class="result-alert alert alert-success">{{ session('result_notice') }}</div>
                                    @endif
                                    @if($errors->any())
                                        <div class="result-alert alert alert-danger">{{ $errors->first() }}</div>
                                    @endif
                                    <div class="status-body">
                                        <div class="field-group">
                                            <div class="field-title">{{ $visaRequest->status === 'Documents Verification' ? 'Applicant Details' : 'Visa Holder Details' }}</div>
                                            <div class="detail-grid">
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-user"></i> Full Name</span>
                                                <div class="detail-value">{{ trim(($visaRequest->first_name ?? '') . ' ' . ($visaRequest->last_name ?? '')) ?: 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-passport"></i> Passport Number</span>
                                                <div class="detail-value">{{ $visaRequest->passport_number ?? 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-flag"></i> Nationality</span>
                                                <div class="detail-value">{{ $visaRequest->nationality ?? 'N/A' }}</div>
                                            </div>
                                            @if($visaRequest->status !== 'Documents Verification')
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-user-tie"></i> Profession</span>
                                                <div class="detail-value">{{ $visaRequest->profession ?? $visaRequest->visa_type ?? 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-globe"></i> Destination Country</span>
                                                <div class="detail-value">{{ $visaRequest->destination_country ?? 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Job Location</span>
                                                <div class="detail-value">{{ $visaRequest->job_location ?? $visaRequest->destination_country ?? 'N/A' }}</div>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label"><i class="fas fa-file-alt"></i> Visa Type</span>
                                                <div class="detail-value">{{ $visaRequest->visa_category ?? 'N/A' }}</div>
                                            </div>
                                            @if(!empty($visaRequest->job_title))
                                                <div class="detail-item">
                                                    <span class="detail-label"><i class="fas fa-briefcase"></i> Job Title</span>
                                                    <div class="detail-value">{{ $visaRequest->job_title }}</div>
                                                </div>
                                            @endif
                                            @endif
                                            </div>
                                        </div>

                                        @if($visaRequest->status === 'Documents Verification')
                                            @php
                                                $verificationWhatsappNumber = preg_replace('/\D+/', '', (string) ($visaRequest->agent_contact_number ?? ''));
                                                $verificationWhatsappUrl = $verificationWhatsappNumber
                                                    ? 'https://wa.me/' . $verificationWhatsappNumber . '?text=' . rawurlencode(
                                                        'Hello, I need assistance with document verification. Application reference: '
                                                        . ($visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at))
                                                    )
                                                    : null;
                                            @endphp
                                            <div class="field-group">
                                                <div class="field-title">Verification Agent Details</div>
                                                <div class="detail-grid">
                                                    @if(!empty($visaRequest->agent_name))
                                                        <div class="detail-item">
                                                            <span class="detail-label">Agent Name</span>
                                                            <div class="detail-value">{{ $visaRequest->agent_name }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($verificationWhatsappUrl)
                                                    <a class="verification-whatsapp-link" href="{{ $verificationWhatsappUrl }}" target="_blank" rel="noopener">
                                                        <i class="fab fa-whatsapp me-1"></i>Contact verification agent on WhatsApp
                                                    </a>
                                                @endif
                                            </div>
                                            @php
                                                $requiredVerificationDocuments = json_decode($visaRequest->required_documents ?? '[]', true);
                                            @endphp
                                            <div class="field-group">
                                                <div class="field-title">Documents to Send for Verification</div>
                                                @if(is_array($requiredVerificationDocuments) && count($requiredVerificationDocuments))
                                                    <p class="payment-card-note mb-2">Please send these documents to the agent for verification:</p>
                                                    <ol class="mb-0 ps-4">
                                                        @foreach($requiredVerificationDocuments as $document)
                                                            <li class="detail-value mb-1">{{ $document }}</li>
                                                        @endforeach
                                                    </ol>
                                                @else
                                                    <p class="payment-card-note">No specific document list is available yet. Please contact the agent for instructions.</p>
                                                @endif
                                            </div>
                                        @endif

                                        @if($resultHasNext)
                                            <button type="button" id="visa-details-next" class="status-detail-next border-0 w-100">
                                                Next <i class="fas fa-arrow-right ms-1"></i>
                                            </button>
                                            <p class="status-download-note">Continue to your payment details or visa approval letter.</p>
                                        </div>
                                    @else
                                        </div>
                                    @endif
                                </div>

                                @if($resultHasNext)
                                    <div id="visa-payment-step" class="status-result-step d-none">
                                        @if($resultHasPaymentStep)
                                            <div class="status-body">
                                                <div class="payment-document-card">
                                                    <div class="payment-card-icon"><i class="fas fa-file-pdf"></i></div>
                                                    <div>
                                                        <h2 class="payment-card-title">Visa Approval Letter</h2>
                                                        <p class="payment-card-note">Download your visa approval letter.</p>
                                                        @if($hasVisaDocument)
                                                            <a class="payment-download-link" href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('travel.visa_document.download', now()->addMinutes(30), ['id' => $visaRequest->id]) }}">
                                                                <i class="fas fa-download me-1"></i>Download Visa Approval Letter
                                                            </a>
                                                        @else
                                                            <p class="payment-card-note mt-1">Your approval letter is not available yet. Please check back later.</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="payment-amount-card">
                                                    <div class="amount-title"><span>Amount Payable</span></div>
                                                    <div class="amount-value">{{ $visaFee !== null ? ($visaFeeCurrency ?? 'PKR') . ' ' . number_format((float) $visaFee, 2) : 'Not set' }}</div>
                                                </div>

                                                <div class="payment-bank-card">
                                                    <div class="field-title"><i class="fas fa-university"></i> Bank Account Details</div>
                                                    @if(!empty($visaRequest->bank_name))
                                                        <div class="payment-bank-row"><span>Bank Name</span><strong>{{ $visaRequest->bank_name }}</strong></div>
                                                        <div class="payment-bank-row"><span>Account Holder</span><strong>{{ $visaRequest->account_holder_name ?: 'N/A' }}</strong></div>
                                                        <div class="payment-bank-row"><span>Account Number</span><strong>{{ $visaRequest->account_number ?: 'N/A' }}</strong></div>
                                                    @elseif($bankAccounts->isNotEmpty())
                                                        @foreach($bankAccounts as $bankAccount)
                                                            <div class="payment-bank-row"><span>Bank Name</span><strong>{{ $bankAccount->bank_name }}</strong></div>
                                                            <div class="payment-bank-row"><span>Account Holder</span><strong>{{ $bankAccount->account_name }}</strong></div>
                                                            <div class="payment-bank-row"><span>Account Number</span><strong>{{ $bankAccount->account_number }}</strong></div>
                                                            @if($bankAccount->iban)<div class="payment-bank-row"><span>IBAN</span><strong>{{ $bankAccount->iban }}</strong></div>@endif
                                                            @if($bankAccount->branch)<div class="payment-bank-row"><span>Branch</span><strong>{{ $bankAccount->branch }}</strong></div>@endif
                                                            @if($bankAccount->swift_code)<div class="payment-bank-row"><span>SWIFT / BIC</span><strong>{{ $bankAccount->swift_code }}</strong></div>@endif
                                                            <div class="payment-bank-row"><span>Currency</span><strong>{{ $bankAccount->currency }}</strong></div>
                                                        @endforeach
                                                    @else
                                                        <p class="payment-card-note">Bank details are not available yet.</p>
                                                    @endif
                                                </div>

                                                <div class="payment-receipt-card">
                                                    <div class="field-title"><i class="fas fa-receipt"></i> Payment Receipt</div>
                                                    @if($visaRequest->payment_receipt)
                                                        <div class="payment-receipt-status">
                                                            <i class="fas fa-check-circle me-1"></i>
                                                            Receipt uploaded. <a href="{{ $visaRequest->payment_receipt }}" target="_blank" rel="noopener">View payment receipt</a>
                                                        </div>
                                                    @endif
                                                    <form id="verify-payment-receipt-form" action="{{ route('travel.apply.payment_receipt', $visaRequest->id) }}" method="POST" enctype="multipart/form-data" class="result-action-form">
                                                        @csrf
                                                        <input type="hidden" name="email" value="{{ $visaRequest->email }}">
                                                        <label for="verify_payment_receipt">Upload payment receipt or screenshot</label>
                                                        <input id="verify_payment_receipt" class="visually-hidden" type="file" name="payment_receipt" accept="image/jpeg,image/png,image/webp" required>
                                                        <button id="verify-payment-receipt-picker" type="button" class="action-submit"><i class="fas fa-camera me-2"></i>Upload Payment Receipt / Screenshot</button>
                                                        <div id="verify-payment-receipt-preview" class="mt-2" hidden>
                                                            <img id="verify-payment-receipt-image" alt="Selected payment receipt preview" style="display:block;max-width:100%;max-height:240px;border:1px solid #dfe7f3;border-radius:7px;">
                                                        </div>
                                                    </form>
                                                </div>
                                                <p id="payment-step-error" class="payment-step-error" role="alert" hidden>Upload your payment receipt before continuing for verification.</p>
                                                <div class="payment-step-navigation">
                                                    <button type="button" class="payment-step-back" id="visa-payment-back"><i class="fas fa-arrow-left me-1"></i>Back</button>
                                                    <button type="button" class="payment-step-next" id="visa-payment-next">Next for verification <i class="fas fa-arrow-right ms-1"></i></button>
                                                </div>
                                            </div>
                                        @elseif($resultHasDocumentStep)
                                            <div class="status-body">
                                                <div class="payment-document-card">
                                                    <div class="payment-card-icon"><i class="fas fa-file-pdf"></i></div>
                                                    <div>
                                                        <h2 class="payment-card-title">Visa Document</h2>
                                                        <p class="payment-card-note">Your issued visa document is ready to download.</p>
                                                        <a class="payment-download-link" href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('travel.visa_document.download', now()->addMinutes(30), ['id' => $visaRequest->id]) }}">
                                                            <i class="fas fa-download me-1"></i>Download Visa Document
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="payment-step-navigation">
                                                    <button type="button" class="payment-step-back" id="visa-payment-back"><i class="fas fa-arrow-left me-1"></i>Back</button>
                                                </div>
                                            </div>
                                        @endif
                                        @endif
                                    </div>
                                    @if($resultHasPaymentStep)
                                        <div id="visa-verification-step" class="status-result-step d-none" data-has-receipt="{{ $visaRequest->payment_receipt ? 'true' : 'false' }}">
                                            <div class="status-body payment-verification-step">
                                                <div class="payment-card-icon"><i class="fas fa-check"></i></div>
                                                <h2>Receipt Submitted</h2>
                                                <p>Your payment receipt has been submitted. Please allow our team to review it. You can check this page again for status updates.</p>
                                                <div class="payment-step-navigation">
                                                    <button type="button" class="payment-step-back" id="visa-verification-back"><i class="fas fa-arrow-left me-1"></i>Back</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Side: Sidebar Info Widget Panels -->
                <div class="sidebar-sticky-panel reveal reveal-up delay-2">
                    <div class="sidebar-widget-card">
                        <h4>What can I use to check?</h4>
                        <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.6;">Use the application reference number from your confirmation or the passport number on your application.</p>
                    </div>

                    <div class="sidebar-widget-card">
                        <h4>Need Assistance?</h4>
                        <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.5;">Our support team is here to help you with any questions.</p>
                        <a href="tel:{{ $settings->phone ?? '' }}" class="btn-submit py-2" style="background: transparent; border: 1px solid var(--btn-primary); color: var(--primary-color); font-size: 0.9rem;"><i class="fas fa-phone-alt me-2"></i> Call Us</a>
                    </div>
                </div>
            </div>
        </div>

        @if(!$visaRequest)
            @include('partials.footer')
        @endif
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const visaDetailsStep = document.getElementById('visa-details-step');
        const visaPaymentStep = document.getElementById('visa-payment-step');
        const visaVerificationStep = document.getElementById('visa-verification-step');
        const visaDetailsNext = document.getElementById('visa-details-next');
        const visaPaymentBack = document.getElementById('visa-payment-back');
        const visaPaymentNext = document.getElementById('visa-payment-next');
        const visaVerificationBack = document.getElementById('visa-verification-back');
        const paymentStepError = document.getElementById('payment-step-error');
        const receiptInput = document.getElementById('verify_payment_receipt');
        const receiptPicker = document.getElementById('verify-payment-receipt-picker');
        const receiptPreview = document.getElementById('verify-payment-receipt-preview');
        const receiptImage = document.getElementById('verify-payment-receipt-image');

        visaDetailsNext?.addEventListener('click', () => {
            visaDetailsStep.classList.add('d-none');
            visaPaymentStep.classList.remove('d-none');
            visaPaymentStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        visaPaymentBack?.addEventListener('click', () => {
            visaPaymentStep.classList.add('d-none');
            visaDetailsStep.classList.remove('d-none');
            visaDetailsStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        visaPaymentNext?.addEventListener('click', () => {
            if (visaVerificationStep.dataset.hasReceipt !== 'true') {
                paymentStepError.hidden = false;
                receiptPicker?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            visaPaymentStep.classList.add('d-none');
            visaVerificationStep.classList.remove('d-none');
            visaVerificationStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        visaVerificationBack?.addEventListener('click', () => {
            visaVerificationStep.classList.add('d-none');
            visaPaymentStep.classList.remove('d-none');
            visaPaymentStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        receiptPicker?.addEventListener('click', () => receiptInput?.click());
        receiptInput?.addEventListener('change', () => {
            const file = receiptInput.files?.[0];
            if (!file) {
                receiptPreview.hidden = true;
                receiptImage.removeAttribute('src');
                return;
            }

            receiptImage.src = URL.createObjectURL(file);
            receiptPreview.hidden = false;
            receiptPicker.disabled = true;
            receiptPicker.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading Payment Receipt / Screenshot';
            receiptInput.form?.requestSubmit();
        });
    </script>
</body>
</html>
