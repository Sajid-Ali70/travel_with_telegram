<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ session('payment_receipt_submitted') ? 'Payment Receipt Submitted' : 'Application Submitted' }} - {{ $settings->app_name ?? 'VisaBook' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <style>
        body {
            background: #f6f7fb;
            color: #1f2937;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .success-shell {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px 42px;
        }

        .success-card {
            width: 100%;
            max-width: 460px;
            background: #ffffff;
            border: 1px solid #d6e5dc;
            border-radius: 14px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.09);
            overflow: hidden;
        }

        .success-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 18px;
            color: #126b43;
            background: #e8f7ee;
            border-bottom: 1px solid #cce9d7;
        }

        .success-top-label {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            background: #17834f;
            border-radius: 50%;
            color: #fff;
            font-size: 1.1rem;
        }

        .success-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #126b43;
            margin: 0;
            line-height: 1.2;
        }

        .success-sub {
            color: #37634c;
            font-size: 0.82rem;
            margin: 4px 0 0;
            line-height: 1.45;
        }

        .success-note {
            display: none;
        }

        .summary-box {
            padding: 15px 16px 16px;
            border-bottom: 1px solid #e4e9ef;
        }

        .summary-title {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #304258;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 16px;
        }

        .client-details-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 72px;
            gap: 12px;
            align-items: start;
        }

        .applicant-photo {
            width: 72px;
            height: 88px;
            object-fit: cover;
            object-position: center;
            border: 1px solid #d8e0e8;
            border-radius: 8px;
            background: #f1f5f9;
        }

        .applicant-photo-placeholder {
            display: grid;
            place-items: center;
            color: #8290a2;
            font-size: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 0.78rem;
            color: #475569;
            padding: 5px 0;
            border-bottom: 1px solid #f0f2f5;
        }

        .summary-row strong {
            color: #111827;
            font-weight: 700;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .payment-box {
            padding: 15px 16px;
            border-bottom: 1px solid #e4e9ef;
        }

        .payment-total {
            font-size: 1rem;
            font-weight: 800;
            color: #111827;
            padding: 2px 0 10px;
            border-bottom: 1px solid #dfe5eb;
            margin-bottom: 9px;
        }

        .bank-entry {
            font-size: 0.76rem;
            line-height: 1.55;
            color: #435166;
            padding: 7px 0;
        }

        .bank-entry + .bank-entry {
            border-top: 1px solid #edf0f3;
        }

        .bank-entry strong {
            color: #1f2937;
        }

        .result-action-form {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #edf0f3;
        }

        .result-action-form label {
            display: block;
            color: #334155;
            font-size: 0.78rem;
            font-weight: 700;
            margin-bottom: 6px;
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
            font-size: 0.82rem;
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
            font-size: 0.82rem;
            font-weight: 700;
        }

        .action-submit:hover,
        .action-submit:focus {
            background: #124f85;
        }

        .action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .result-alert {
            margin: 12px 16px 0;
            padding: 10px 12px;
            border-radius: 7px;
            font-size: 0.8rem;
        }

        .tracking-box {
            padding: 14px 16px;
        }

        .success-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 9px;
            padding: 0 16px 16px;
        }

        .success-btn {
            border-radius: 7px;
            padding: 11px 12px;
            font-weight: 700;
            font-size: 0.82rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .success-btn.primary {
            background: #16834e;
            color: #ffffff;
            border: 1px solid #16834e;
        }

        .success-btn.secondary {
            background: #ffffff;
            color: #16834e;
            border: 1px solid #16834e;
        }

        .success-btn:hover, .success-btn:focus {
            color: #ffffff;
            background: #116b3f;
            border-color: #116b3f;
        }

        .receipt-success-shell {
            background: #f3f9fd;
            display: flex;
            justify-content: center;
            min-height: calc(100vh - 44px);
            padding: 10px 12px 14px;
        }

        .receipt-status-header {
            align-items: center;
            background: #fff;
            border-bottom: 1px solid #e6edf3;
            display: flex;
            height: 44px;
            justify-content: space-between;
            padding: 0 14px;
        }

        .receipt-status-header a,
        .receipt-status-header span {
            color: #17253d !important;
            font-size: .9rem;
            text-decoration: none;
        }

        .receipt-status-header span {
            font-weight: 700;
        }

        .receipt-success-card {
            align-self: flex-start;
            background: #fff;
            border: 1px solid #e1edf4;
            border-radius: 14px;
            box-shadow: 0 8px 22px rgba(20, 51, 77, .07);
            margin: 0 auto;
            max-width: 430px;
            overflow: hidden;
            padding: 16px 11px 11px;
            width: 100%;
        }

        .receipt-success-icon {
            align-items: center;
            background: #22ad69;
            border: 6px solid #dcf5e8;
            border-radius: 50%;
            box-shadow: 0 0 0 5px #f0fbf5;
            color: #fff;
            display: flex;
            font-size: 1.3rem;
            height: 52px;
            justify-content: center;
            margin: 0 auto 12px;
            width: 52px;
        }

        .receipt-success-title {
            color: #126b43;
            font-size: 1.12rem;
            font-weight: 800;
            margin: 0;
            text-align: center;
        }

        .receipt-success-subtitle {
            color: #617184;
            font-size: .82rem;
            line-height: 1.45;
            margin: 5px auto 13px;
            max-width: 330px;
            text-align: center;
        }

        .receipt-reference-card {
            align-items: center;
            background: #eaf7f1;
            border: 1px solid #d7eee3;
            border-radius: 9px;
            display: flex;
            gap: 10px;
            margin-top: 10px;
            padding: 11px;
        }

        .receipt-agent-card {
            background: #edf6fc;
            border: 1px solid #dcecf7;
            border-radius: 9px;
            margin-top: 10px;
            padding: 11px;
        }

        .receipt-reference-icon {
            align-items: center;
            background: #fff;
            border-radius: 8px;
            color: #148c58;
            display: flex;
            flex: 0 0 34px;
            font-size: 1rem;
            height: 34px;
            justify-content: center;
            position: relative;
        }

        .receipt-card-label {
            color: #516577;
            font-size: .76rem;
            margin: 0 0 3px;
        }

        .receipt-reference-number {
            color: #183956;
            font-size: .96rem;
            font-weight: 800;
            letter-spacing: .02em;
            overflow-wrap: anywhere;
        }

        .receipt-agent-heading {
            align-items: center;
            color: #173d63;
            display: flex;
            font-size: .86rem;
            font-weight: 800;
            gap: 7px;
            justify-content: center;
            margin: 0 0 3px;
        }

        .receipt-agent-intro {
            color: #617184;
            font-size: .76rem;
            line-height: 1.45;
            margin: 0 auto 9px;
            max-width: 330px;
            text-align: center;
        }

        .receipt-agent-details {
            align-items: center;
            background: #fff;
            border: 1px solid #e2edf4;
            border-radius: 8px;
            display: flex;
            gap: 9px;
            min-width: 0;
            padding: 9px;
        }

        .receipt-agent-avatar {
            align-items: center;
            background: #dbeafe;
            border-radius: 50%;
            color: #315b8d;
            display: flex;
            flex: 0 0 34px;
            font-size: 1rem;
            height: 34px;
            justify-content: center;
        }

        .receipt-agent-copy {
            flex: 1;
            min-width: 0;
        }

        .receipt-agent-name {
            color: #1d3249;
            font-size: .84rem;
            font-weight: 800;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .receipt-agent-role,
        .receipt-agent-company {
            color: #5c6f81;
            font-size: .74rem;
            line-height: 1.35;
            margin: 2px 0 0;
        }

        .receipt-agent-whatsapp {
            align-items: center;
            color: #119447 !important;
            display: flex;
            flex: 0 0 auto;
            flex-direction: column;
            font-size: .68rem;
            gap: 3px;
            text-decoration: none;
        }

        .receipt-agent-whatsapp i {
            color: #12a756 !important;
            font-size: 1.35rem;
        }

        .receipt-whatsapp-link {
            align-items: center;
            background: #fff;
            border: 1px solid #a8e5be;
            border-radius: 7px;
            color: #127b49 !important;
            display: flex;
            font-size: .8rem;
            font-weight: 700;
            gap: 7px;
            justify-content: flex-start;
            margin-top: 9px;
            padding: 9px 10px;
            text-decoration: none;
        }

        .receipt-whatsapp-link .fa-whatsapp {
            color: #18a85b;
            font-size: 1.05rem;
        }

        .receipt-whatsapp-link .fa-chevron-right {
            font-size: .74rem;
        }

        .receipt-support-card {
            background: #f5f9fc;
            border: 1px solid #e2edf4;
            border-radius: 9px;
            margin-top: 10px;
            padding: 9px 11px;
        }

        .receipt-support-row {
            align-items: flex-start;
            color: #526578;
            display: flex;
            font-size: .76rem;
            gap: 8px;
            line-height: 1.4;
            padding: 5px 0;
        }

        .receipt-support-row + .receipt-support-row {
            border-top: 1px solid #e6edf3;
        }

        .receipt-support-row i {
            color: #4284cf;
            margin-top: 2px;
            text-align: center;
            width: 15px;
        }

        .receipt-support-row strong {
            color: #304459;
            display: block;
            font-size: .74rem;
        }

        .receipt-support-row a {
            color: #2865a3 !important;
            overflow-wrap: anywhere;
            text-decoration: none;
        }

        .approved-contact-panel {
            background: #f0faf5;
            border: 1px solid #d8eee2;
            border-radius: 10px;
            margin: 12px 16px;
            padding: 12px;
        }

        .approved-contact-title {
            color: #126b43;
            font-size: .94rem;
            font-weight: 800;
            margin: 0;
            text-align: center;
        }

        .approved-contact-message {
            color: #526578;
            font-size: .76rem;
            line-height: 1.45;
            margin: 5px 0 10px;
            text-align: center;
        }

        .approved-contact-agent {
            align-items: center;
            display: flex;
            gap: 9px;
        }

        .approved-contact-agent-name {
            color: #1d3249;
            font-size: .8rem;
            font-weight: 800;
            margin: 0;
        }

        .approved-contact-phone {
            color: #526578;
            font-size: .72rem;
            margin: 2px 0 0;
        }

        @media (max-width: 480px) {
            .success-card {
                border-radius: 12px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .summary-row {
                font-size: 0.8rem;
            }

            .success-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $hasTicketRequest = $ticketRequest !== null || !empty($visaRequest->flight_ticket_requested_at);
        $paymentReceiptSubmitted = session('payment_receipt_submitted', false);
    @endphp
    <div class="mobile-container">
        @if($paymentReceiptSubmitted)
            @php
                $receiptAgentName = trim((string) ($visaRequest->approval_agent_name ?? '')) ?: 'Visa Consultant';
                $receiptAgentPhone = trim((string) ($visaRequest->approval_agent_contact_number ?? ''));
                $receiptWhatsappNumber = preg_replace('/\D+/', '', $receiptAgentPhone);
                $receiptSupportPhone = trim((string) ($settings->phone ?? ''));
                $receiptSupportTelephone = preg_replace('/[^0-9+]/', '', $receiptSupportPhone);
                $receiptSupportEmail = trim((string) ($settings->email ?? ''));
                $receiptSupportAddress = trim((string) ($settings->address ?? ''));
                $receiptWhatsappUrl = $receiptWhatsappNumber
                    ? 'https://wa.me/' . $receiptWhatsappNumber . '?text=' . rawurlencode('Hello, I have submitted my payment receipt. Application reference: ' . $referenceNumber)
                    : null;
            @endphp
            <header class="receipt-status-header">
                <a href="{{ url('/') }}" aria-label="Back to home"><i class="fas fa-arrow-left"></i></a>
                <span>Visa Status</span>
                <a href="{{ route('travel.verify') }}" aria-label="Check another application"><i class="fas fa-search"></i></a>
            </header>
            <main class="receipt-success-shell">
                <section class="receipt-success-card" aria-labelledby="receipt-success-title">
                    <div class="receipt-success-icon"><i class="fas fa-check"></i></div>
                    <h1 id="receipt-success-title" class="receipt-success-title">Payment Receipt Submitted</h1>
                    <p class="receipt-success-subtitle">Your payment receipt has been successfully submitted. Our team will review it shortly.</p>

                    <div class="receipt-reference-card">
                        <div class="receipt-reference-icon"><i class="fas fa-file-invoice"></i></div>
                        <div>
                            <p class="receipt-card-label">Application Reference Number</p>
                            <div class="receipt-reference-number">{{ $referenceNumber }}</div>
                            <p class="receipt-card-label mt-1 mb-0">Please keep this reference number for your communication.</p>
                        </div>
                    </div>

                    <div class="receipt-agent-card">
                        <h2 class="receipt-agent-heading"><i class="fas fa-headset"></i> Your Official Agent</h2>
                        <p class="receipt-agent-intro">For further updates, please contact your official agent who is handling your application.</p>
                        <div class="receipt-agent-details">
                            <div class="receipt-agent-avatar"><i class="fas fa-user"></i></div>
                            <div class="receipt-agent-copy">
                                <p class="receipt-agent-name">{{ $receiptAgentName }}</p>
                                <p class="receipt-agent-role">Visa Consultant</p>
                                <p class="receipt-agent-company">{{ $settings->app_name ?? 'Travel & Visa Processing Team' }}</p>
                            </div>
                            @if($receiptWhatsappUrl)
                                <a class="receipt-agent-whatsapp" href="{{ $receiptWhatsappUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp {{ $receiptAgentName }}">
                                    <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                                </a>
                            @endif
                        </div>
                        @if($receiptWhatsappUrl)
                            <a class="receipt-whatsapp-link" href="{{ $receiptWhatsappUrl }}" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i> Contact on WhatsApp <i class="fas fa-chevron-right ms-auto"></i>
                            </a>
                        @endif
                    </div>

                    <div class="receipt-support-card">
                        <div class="receipt-support-row">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><strong>Office Address</strong>{{ $receiptSupportAddress ?: 'Not available' }}</span>
                        </div>
                        <div class="receipt-support-row">
                            <i class="fas fa-phone-alt"></i>
                            <span>
                                <strong>Call Center</strong>
                                @if($receiptSupportPhone)
                                    <a href="tel:{{ $receiptSupportTelephone }}">{{ $receiptSupportPhone }}</a>
                                @else
                                    Not available
                                @endif
                            </span>
                        </div>
                        <div class="receipt-support-row">
                            <i class="fas fa-envelope"></i>
                            <span>
                                <strong>Email</strong>
                                @if($receiptSupportEmail)
                                    <a href="mailto:{{ $receiptSupportEmail }}">{{ $receiptSupportEmail }}</a>
                                @else
                                    Not available
                                @endif
                            </span>
                        </div>
                    </div>
                </section>
            </main>
        @else
            @include('partials.nav')

            @if(in_array($visaRequest->status, ['Visa Approved from Embassy', 'Visa Approved', 'approved'], true))
                @php
                    $approvedContactName = trim((string) ($visaRequest->approval_agent_name ?? '')) ?: ($settings->app_name ?? 'Rainbow Travels & Tours');
                    $approvedContactPhone = trim((string) ($visaRequest->approval_agent_contact_number ?? '')) ?: trim((string) ($settings->phone ?? ''));
                    $approvedWhatsappNumber = preg_replace('/\D+/', '', $approvedContactPhone);
                @endphp
                <section class="approved-contact-panel" aria-labelledby="approved-contact-title">
                    <h1 id="approved-contact-title" class="approved-contact-title"><i class="fas fa-check-circle me-1"></i> Visa Approved from Embassy</h1>
                    <p class="approved-contact-message">Congratulations! Contact your official agent for the next steps in your application.</p>
                    <div class="approved-contact-agent">
                        <div class="receipt-agent-avatar"><i class="fas fa-user"></i></div>
                        <div>
                            <p class="approved-contact-agent-name">{{ $approvedContactName }}</p>
                            <p class="approved-contact-phone">{{ $approvedContactPhone ?: 'Contact information is not available yet.' }}</p>
                        </div>
                    </div>
                    @if($approvedWhatsappNumber)
                        <a class="receipt-whatsapp-link" href="https://wa.me/{{ $approvedWhatsappNumber }}?text={{ rawurlencode('Hello, my visa application was approved by the embassy. Application reference: ' . $referenceNumber) }}" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i> Contact your agent on WhatsApp <i class="fas fa-chevron-right ms-auto"></i>
                        </a>
                    @endif
                </section>
            @endif

            <div class="success-shell">
            <div class="success-card">
                <div class="success-header">
                    <div class="success-top-label"><i class="fas fa-check"></i></div>
                    <div>
                        <div class="success-title">
                            @if($visaRequest->flight_ticket_requested_at)
                                {{ $visaRequest->ticket_status === 'Booked' ? 'Ticket Booking Confirmed!' : 'Flight Ticket Request Submitted!' }}
                            @else
                                {{ $statusText }}
                            @endif
                        </div>
                        <p class="success-sub">
                            @if($visaRequest->flight_ticket_requested_at)
                                Your ticket request is {{ strtolower($visaRequest->ticket_status ?? 'Requested') }}. Booking details are shown below.
                            @else
                                {{ $statusMessage }}
                            @endif
                        </p>
                    </div>
                </div>

                @if(session('result_notice'))
                    <div class="result-alert alert alert-success">{{ session('result_notice') }}</div>
                @endif
                @if($errors->any())
                    <div class="result-alert alert alert-danger">{{ $errors->first() }}</div>
                @endif
                @if($visaRequest->status === 'Documents Verification')
                    @php($requiredVerificationDocuments = json_decode($visaRequest->required_documents ?? '[]', true))
                    <div class="summary-box">
                        <div class="summary-title"><i class="fas fa-file-alt me-1"></i> Documents to Send for Verification</div>
                        <p>Please send these documents to the agent for verification:</p>
                        @if(is_array($requiredVerificationDocuments) && count($requiredVerificationDocuments))
                            <ol class="mb-3">
                                @foreach($requiredVerificationDocuments as $document)
                                    <li>{{ $document }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p>No specific document list is available yet. Please contact the agent for instructions.</p>
                        @endif
                        @if(!empty($visaRequest->agent_name))
                            <div class="summary-row"><span>Agent Name</span><strong>{{ $visaRequest->agent_name }}</strong></div>
                        @endif
                        @if(!empty($visaRequest->agent_contact_number))
                            <div class="summary-row"><span>Agent Contact Number</span><strong>{{ $visaRequest->agent_contact_number }}</strong></div>
                        @endif
                    </div>
                @endif
                @if(in_array($visaRequest->status, ['Visa Approved from Embassy', 'Visa Issued'], true) && !empty($visaRequest->issued_visa_document))
                    <div class="alert alert-success">
                        {{ $visaRequest->status === 'Visa Issued' ? 'Your visa has been issued.' : 'Your visa approval letter is ready.' }}
                        <a class="btn btn-success btn-sm ms-2" href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('travel.visa_document.download', now()->addMinutes(30), ['id' => $visaRequest->id]) }}">
                            <i class="fas fa-download me-1"></i>{{ $visaRequest->status === 'Visa Issued' ? 'Download Visa Document' : 'Download Approval Letter' }}
                        </a>
                    </div>
                @endif

                @if($visaRequest->flight_ticket_requested_at)
                <div class="summary-box">
                    <div class="summary-title"><i class="fas fa-ticket-alt me-1"></i> Booking Summary</div>
                    <div class="summary-row"><span>Booking Reference</span><strong>{{ $visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at) }}</strong></div>
                    <div class="summary-row"><span>Request submitted</span><strong>{{ \Carbon\Carbon::parse($visaRequest->flight_ticket_requested_at)->format('d M Y, h:i A') }}</strong></div>
                </div>
                @endif

                <div class="summary-box">
                    <div class="summary-title"><i class="fas fa-id-card me-1"></i> {{ $visaRequest->flight_ticket_requested_at ? 'Passenger Info' : 'Client Details' }}</div>
                    <div class="client-details-layout">
                        <div class="summary-grid">
                            <div class="summary-row"><span>Applicant</span><strong>{{ $visaRequest->first_name ?? '' }} {{ $visaRequest->last_name ?? '' }}</strong></div>
                            <div class="summary-row"><span>Passport</span><strong>{{ $visaRequest->passport_number ?? 'N/A' }}</strong></div>
                            <div class="summary-row"><span>Nationality</span><strong>{{ $visaRequest->nationality ?? 'N/A' }}</strong></div>
                            <div class="summary-row"><span>Date of Birth</span><strong>{{ $visaRequest->dob ?? 'N/A' }}</strong></div>
                            <div class="summary-row"><span>Gender</span><strong>{{ ucfirst($visaRequest->gender ?? 'N/A') }}</strong></div>
                            <div class="summary-row"><span>Visa Type</span><strong>{{ $visaRequest->visa_type ?? ($visaRequest->visa_category ?? 'N/A') }}</strong></div>
                            <div class="summary-row"><span>Expiry Date</span><strong>{{ $visaRequest->passport_expiry ?? 'N/A' }}</strong></div>
                            <div class="summary-row"><span>Country</span><strong>{{ $visaRequest->destination_country ?? 'N/A' }}</strong></div>
                            @unless($visaRequest->flight_ticket_requested_at)
                                <div class="summary-row"><span>Application Ref</span><strong>{{ $visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at) }}</strong></div>
                            @endunless
                        </div>
                        @if(!empty($visaRequest->passport_photo))
                            <img src="{{ $visaRequest->passport_photo }}" alt="Applicant passport photo" class="applicant-photo">
                        @else
                            <div class="applicant-photo applicant-photo-placeholder" role="img" aria-label="No applicant photo"><i class="fas fa-user"></i></div>
                        @endif
                    </div>
                </div>

                @if($statusText === 'Visa Approved from Embassy')
                <div class="summary-box">
                    <div class="summary-title"><i class="fas fa-money-bill-wave me-1"></i> Payment Details</div>
                    <div class="summary-row"><span>Visa Fee</span><strong>{{ $visaFee !== null ? ($visaFeeCurrency ?? 'PKR') . ' ' . number_format((float) $visaFee, 2) : 'Not set' }}</strong></div>
                    @if(!empty($visaRequest->bank_name))
                        <div class="summary-row"><span>Bank Name</span><strong>{{ $visaRequest->bank_name }}</strong></div>
                        <div class="summary-row"><span>Account Holder</span><strong>{{ $visaRequest->account_holder_name }}</strong></div>
                        <div class="summary-row"><span>Account Number</span><strong>{{ $visaRequest->account_number }}</strong></div>
                    @elseif($bankAccounts->isNotEmpty())
                        @foreach($bankAccounts as $bankAccount)
                            <div class="summary-row"><span>Bank Name</span><strong>{{ $bankAccount->bank_name }}</strong></div>
                            <div class="summary-row"><span>Account Holder</span><strong>{{ $bankAccount->account_name }}</strong></div>
                            <div class="summary-row"><span>Account Number</span><strong>{{ $bankAccount->account_number }}</strong></div>
                        @endforeach
                    @endif
                </div>
                @endif

                @if($statusText === 'Visa Approved from Embassy')
                <div class="tracking-box">
                    <div class="summary-title"><i class="fas fa-calendar-alt me-1"></i> {{ $visaRequest->flight_ticket_requested_at ? 'Flight Details' : 'Flight Ticket Booking Time Slot' }}</div>
                    @unless($visaRequest->flight_ticket_requested_at)
                        <p class="bank-entry">Please share your preferred dates and time for ticket booking.</p>
                    @endunless
                    @if($visaRequest->flight_ticket_requested_at)
                        <div class="bank-entry"><strong>Request submitted:</strong> {{ \Carbon\Carbon::parse($visaRequest->flight_ticket_requested_at)->format('d M Y, h:i A') }}</div>
                        <div class="bank-entry"><strong>Requested dates:</strong> {{ \Carbon\Carbon::parse($visaRequest->preferred_date_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($visaRequest->preferred_date_end)->format('d M Y') }}</div>
                        <div class="bank-entry"><strong>Preferred airport:</strong> {{ $flightAirports[$visaRequest->preferred_airport] ?? $visaRequest->preferred_airport }}</div>
                        @if($visaRequest->ticket_status)
                            <div class="bank-entry"><strong>Ticket status:</strong> {{ $visaRequest->ticket_status }}</div>
                        @endif
                        @if($visaRequest->ticket_details)
                            <div class="bank-entry"><strong>Ticket details:</strong><br>{!! nl2br(e($visaRequest->ticket_details)) !!}</div>
                        @endif
                    @endif
                    @if($hasTicketRequest)
                        <button type="button" id="showTicketReapplyForm" class="action-submit" aria-controls="ticketReapplyForm" aria-expanded="{{ $errors->any() ? 'true' : 'false' }}">
                            <i class="fas fa-redo me-2"></i>Reapply for Ticket
                        </button>
                    @endif
                    <form id="ticketReapplyForm" action="{{ route('travel.apply.flight_ticket', $visaRequest->id) }}" method="POST" class="result-action-form {{ $hasTicketRequest && !$errors->any() ? 'd-none' : '' }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $visaRequest->email }}">
                        <div class="action-grid">
                            <div>
                                <label for="preferred_date_start">Preferred date from</label>
                                <input id="preferred_date_start" type="date" name="preferred_date_start" min="{{ now()->toDateString() }}" value="{{ old('preferred_date_start', $visaRequest->preferred_date_start) }}" required>
                            </div>
                            <div>
                                <label for="preferred_date_end">Preferred date to</label>
                                <input id="preferred_date_end" type="date" name="preferred_date_end" min="{{ now()->toDateString() }}" value="{{ old('preferred_date_end', $visaRequest->preferred_date_end) }}" required>
                            </div>
                        </div>
                        <label for="preferred_airport" class="mt-3">Preferred Airport</label>
                        <select id="preferred_airport" name="preferred_airport" required>
                            <option value="">Select preferred airport</option>
                            @foreach($flightAirports as $code => $airport)
                                <option value="{{ $code }}" {{ old('preferred_airport', $visaRequest->preferred_airport) === $code ? 'selected' : '' }}>{{ $airport }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="action-submit"><i class="fas fa-paper-plane me-2"></i>{{ $hasTicketRequest ? 'Submit Ticket Reapplication' : 'Submit Flight Ticket Request' }}</button>
                    </form>
                </div>
                @endif

                <div class="tracking-box">
                    <div class="summary-title"><i class="fas fa-clock me-1"></i> {{ $visaRequest->flight_ticket_requested_at ? 'Ticket Tracking' : 'Application Tracking' }}</div>
                    <div class="summary-row"><span>Submitted</span><strong>{{ \Carbon\Carbon::parse($visaRequest->created_at ?? now())->format('d M Y, h:i A') }}</strong></div>
                    <div class="summary-row"><span>{{ $visaRequest->flight_ticket_requested_at ? 'Ticket Status' : 'Current Status' }}</span><strong>{{ $visaRequest->flight_ticket_requested_at ? ($visaRequest->ticket_status ?? 'Requested') : $statusText }}</strong></div>
                </div>

                <div class="success-actions">
                    <a href="{{ url('/') }}" class="success-btn secondary"><i class="fas fa-home me-2"></i>Back to Home</a>
                    <a href="{{ route('travel.verify') }}" class="success-btn primary"><i class="fas fa-search me-2"></i>Check Status</a>
                </div>
            </div>
        </div>

        @include('partials.footer')
        @endif
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const dateStart = document.getElementById('preferred_date_start');
        const dateEnd = document.getElementById('preferred_date_end');
        const reapplyButton = document.getElementById('showTicketReapplyForm');
        const ticketReapplyForm = document.getElementById('ticketReapplyForm');
        reapplyButton?.addEventListener('click', () => {
            const isHidden = ticketReapplyForm.classList.toggle('d-none');
            reapplyButton.setAttribute('aria-expanded', String(!isHidden));
            if (!isHidden) ticketReapplyForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
        dateStart?.addEventListener('change', () => {
            dateEnd.min = dateStart.value || dateEnd.min;
            if (dateEnd.value && dateEnd.value < dateStart.value) dateEnd.value = dateStart.value;
        });
    </script>
</body>
</html>
