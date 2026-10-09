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

        .status-result-wrapper {
            /* max-width: 460px; */
            margin: 0 auto;
            padding: 12px 0 0;
        }

        .status-result-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #dfe7f3;
            box-shadow: 0 18px 32px rgba(17, 24, 39, 0.08);
            overflow: hidden;
        }

        .status-result-header {
            text-align: center;
            padding: 26px 22px 14px;
            background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
            border-bottom: 1px solid #edf2f7;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.10em;
            color: #0f9f6e;
            background: #ebfff7;
            border: 1px solid #bcecd4;
            border-radius: 999px;
            padding: 9px 16px;
            margin-bottom: 18px;
        }

        .status-badge i {
            font-size: 0.72rem;
        }

        .status-title {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: #111827;
        }

        .status-subtitle {
            font-size: 1rem;
            color: #5f6f89;
            line-height: 1.6;
            margin: 0 auto;
            max-width: 320px;
        }

        .status-body {
            padding: 18px 18px 14px;
        }

        .field-group {
            margin-bottom: 18px;
        }

        .field-title {
            font-size: 0.84rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            color: #475569;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px 14px;
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
            background: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .detail-label {
            display: block;
            font-size: 0.76rem;
            color: #67758b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 0.88rem;
            color: #111827;
            font-weight: 700;
            line-height: 1.5;
            word-break: break-word;
        }

        .amount-box {
            background: #fbfdff;
            border: 1px solid #e7edf7;
            border-radius: 12px;
            padding: 14px 14px 10px;
            margin-top: 4px;
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

        .ticket-box {
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px solid #edf2f7;
        }

        .ticket-note {
            font-size: 0.86rem;
            color: #475569;
            line-height: 1.6;
            margin-top: 8px;
        }

        .ticket-note strong {
            color: #111827;
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
            .status-title {
                font-size: 1.5rem;
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

            .amount-box .detail-item > div {
                max-width: 100%;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        @include('partials.nav')

        <!-- Sub-Banner Header -->
        <div class="visa-hero-section" style="min-height: 350px; padding: 40px 5%; background-position: top center;">
            <div class="hero-overlay-content reveal reveal-left" style="max-width: 100%;">
                <p class="mb-1 reveal reveal-down delay-1" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 600;"><a href="{{ url('/') }}" style="color: var(--accent-color); text-decoration: none;">Home</a> &nbsp;&raquo;&nbsp; Check Status</p>
                <h2 class="reveal reveal-up delay-2" style="font-size: 2.2rem; margin-bottom: 8px;">Check Visa Status</h2>
                <p class="mb-0 reveal reveal-up delay-3" style="font-size: 0.95rem;">Track your visa application using your reference number or passport number.</p>
            </div>
        </div>

        <div class="section-wrapper-global" style="padding-top: 40px; padding-bottom: 60px;">
            <!-- Form & Sidebar Dual Layout Grid -->
            <div class="form-sidebar-grid">
                <!-- Left Side: Verification Box -->
                <div class="premium-dark-box reveal reveal-up delay-1">
                    <div class="text-center mb-4">
                        <div class="card-icon-circle reveal reveal-fade" style="width: 56px; height: 56px; font-size: 22px; background-color: #e8f5eb; margin-bottom: 12px;">
                            <i class="fas fa-search text-primary"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-2" style="font-size: 1.25rem;">Enter Your Details</h4>
                        <p class="text-muted" style="font-size: 0.85rem;">Choose a lookup method and enter the matching number. Email is not required.</p>
                    </div>

                    @if($statusError)
                        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>{{ $statusError }}</div>
                    @endif

                    <form action="{{ route('travel.verify') }}" method="POST">
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
                                <div class="status-result-header">
                                    <div class="status-badge">
                                        <i class="fas fa-check-circle"></i>
                                        {{ $visaRequest->flight_ticket_requested_at ? 'Ticket Status: ' . ($visaRequest->ticket_status ?? 'Requested') : $statusText }}
                                    </div>
                                    <div class="status-title">{{ $visaRequest->flight_ticket_requested_at ? 'Ticket Status: ' . ($visaRequest->ticket_status ?? 'Requested') : $statusText }}</div>
                                    <p class="status-subtitle">{{ $visaRequest->flight_ticket_requested_at ? 'Your flight ticket request is currently ' . strtolower($visaRequest->ticket_status ?? 'Requested') . '.' : $statusMessage }}</p>
                                </div>

                                @if(session('result_notice'))
                                    <div class="result-alert alert alert-success">{{ session('result_notice') }}</div>
                                @endif
                                @if($errors->any())
                                    <div class="result-alert alert alert-danger">{{ $errors->first() }}</div>
                                @endif
                                @if($visaRequest->status === 'Visa Issued' && !empty($visaRequest->issued_visa_document))
                                    <div class="alert alert-success">
                                        Your visa has been issued.
                                        <a class="btn btn-success btn-sm ms-2" href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('travel.visa_document.download', now()->addMinutes(30), ['id' => $visaRequest->id]) }}">
                                            <i class="fas fa-download me-1"></i>Download Visa Document
                                        </a>
                                    </div>
                                @endif

                                <div class="status-body" style="background-color: #c8d3de; color: white">
                                    <div class="field-group">
                                        <div class="field-title">Client Details</div>
                                        <div class="client-details-layout">
                                            <div class="detail-grid">
                                                <div class="detail-item">
                                                    <span class="detail-label">Applicant</span>
                                                    <div class="detail-value">{{ $visaRequest->first_name ?? '' }} {{ $visaRequest->last_name ?? '' }}</div>
                                                </div>
                                                <div class="detail-item">
                                                            <span class="detail-label">Application Reference</span>
                                                            <div class="detail-value">{{ $visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at) }}</div>
                                                        </div>
                                                        <div class="detail-item">
                                                            <span class="detail-label">Visa Type</span>
                                                    <div class="detail-value">{{ $visaRequest->visa_type ?? ($visaRequest->visa_category ?? 'N/A') }}</div>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Passport</span>
                                                    <div class="detail-value">{{ $visaRequest->passport_number ?? 'N/A' }}</div>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Mobile</span>
                                                    <div class="detail-value">{{ $visaRequest->mobile_number ?? 'N/A' }}</div>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Email</span>
                                                    <div class="detail-value">{{ $visaRequest->email ?? 'N/A' }}</div>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Country</span>
                                                    <div class="detail-value">{{ $visaRequest->destination_country ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                            @if(!empty($visaRequest->passport_photo))
                                                <img src="{{ $visaRequest->passport_photo }}" alt="Applicant passport photo" class="client-photo">
                                            @else
                                                <div class="client-photo client-photo-placeholder" role="img" aria-label="No applicant photo"><i class="fas fa-user"></i></div>
                                            @endif
                                        </div>
                                    </div>

                                    @if($visaRequest->status === 'Documents Verification')
                                        <div class="field-group">
                                            <div class="field-title">Verification Agent Details</div>
                                            <div class="detail-grid">
                                                @if(!empty($visaRequest->agent_name))
                                                    <div class="detail-item">
                                                        <span class="detail-label">Agent Name</span>
                                                        <div class="detail-value">{{ $visaRequest->agent_name }}</div>
                                                    </div>
                                                @endif
                                                @if(!empty($visaRequest->agent_contact_number))
                                                    <div class="detail-item">
                                                        <span class="detail-label">Agent Contact Number</span>
                                                        <div class="detail-value">{{ $visaRequest->agent_contact_number }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($statusText === 'Visa Approved from Embassy')
                                    <div class="amount-box">
                                        <div class="amount-title">
                                            <span>Payment Details</span>
                                            <span>Amount Payable</span>
                                        </div>
                                        <div class="amount-value">
                                            {{ $visaFee !== null ? ($visaFeeCurrency ?? 'PKR') . ' ' . number_format((float) $visaFee, 2) : 'Not set' }}
                                        </div>
                                        <div class="ticket-note mt-3">
                                            <strong>Bank Account Details</strong>
                                            @if(!empty($visaRequest->bank_name))
                                                <div class="detail-item mt-2">
                                                    <div class="detail-value">{{ $visaRequest->bank_name }}</div>
                                                    <div>Account Holder: {{ $visaRequest->account_holder_name }}</div>
                                                    <div>Account Number: {{ $visaRequest->account_number }}</div>
                                                </div>
                                            @elseif($bankAccounts->isNotEmpty())
                                                @foreach($bankAccounts as $bankAccount)
                                                    <div class="detail-item mt-2">
                                                        <div class="detail-value">{{ $bankAccount->bank_name }}</div>
                                                        <div>Account Holder: {{ $bankAccount->account_name }}</div>
                                                        <div>Account Number: {{ $bankAccount->account_number }}</div>
                                                        @if($bankAccount->iban)<div>IBAN: {{ $bankAccount->iban }}</div>@endif
                                                        @if($bankAccount->branch)<div>Branch: {{ $bankAccount->branch }}</div>@endif
                                                        @if($bankAccount->swift_code)<div>SWIFT / BIC: {{ $bankAccount->swift_code }}</div>@endif
                                                        <div>Currency: {{ $bankAccount->currency }}</div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="mt-2">Bank details are not available yet.</div>
                                            @endif
                                            @if($visaRequest->payment_receipt)
                                                <div class="mt-2"><strong>Uploaded Receipt:</strong> <a href="{{ $visaRequest->payment_receipt }}" target="_blank" rel="noopener">View payment receipt</a></div>
                                            @endif
                                            <form id="verify-payment-receipt-form" action="{{ route('travel.apply.payment_receipt', $visaRequest->id) }}" method="POST" enctype="multipart/form-data" class="result-action-form">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ $visaRequest->email }}">
                                                <input type="hidden" name="return_to" value="verify">
                                                <label for="verify_payment_receipt">Upload Payment Receipt / Screenshot</label>
                                                <input id="verify_payment_receipt" class="visually-hidden" type="file" name="payment_receipt" accept="image/jpeg,image/png,image/webp" required>
                                                <button id="verify-payment-receipt-picker" type="button" class="action-submit"><i class="fas fa-camera me-2"></i>Upload Payment Receipt / Screenshot</button>
                                                <div id="verify-payment-receipt-preview" class="mt-2" hidden>
                                                    <img id="verify-payment-receipt-image" alt="Selected payment receipt preview" style="display:block;max-width:100%;max-height:240px;border:1px solid #dfe7f3;border-radius:7px;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="ticket-box">
                                        <div class="field-title">Flight Ticket Booking Time Slot</div>
                                        <div class="ticket-note">Please share your preferred dates and time for ticket booking.</div>
                                        @if($visaRequest->flight_ticket_requested_at)
                                            <div class="ticket-note">
                                                <strong>Request submitted:</strong> {{ \Carbon\Carbon::parse($visaRequest->flight_ticket_requested_at)->format('d/m/Y, h:i A') }}<br>
                                                <strong>Requested dates:</strong> {{ \Carbon\Carbon::parse($visaRequest->preferred_date_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($visaRequest->preferred_date_end)->format('d M Y') }}<br>
                                                <strong>Preferred airport:</strong> {{ $flightAirports[$visaRequest->preferred_airport] ?? $visaRequest->preferred_airport }}
                                                @if($visaRequest->ticket_status)
                                                    <br><strong>Ticket status:</strong> {{ $visaRequest->ticket_status }}
                                                @endif
                                                @if($visaRequest->ticket_details)
                                                    <br><strong>Ticket details:</strong><br>{!! nl2br(e($visaRequest->ticket_details)) !!}
                                                @endif
                                            </div>
                                        @endif
                                        @if($ticketRequest)
                                            <button type="button" id="showVerifyTicketReapplyForm" class="action-submit" aria-controls="verifyTicketReapplyForm" aria-expanded="{{ $errors->any() ? 'true' : 'false' }}">
                                                <i class="fas fa-redo me-2"></i>Reapply for Ticket
                                            </button>
                                        @endif
                                        <form id="verifyTicketReapplyForm" action="{{ route('travel.apply.flight_ticket', $visaRequest->id) }}" method="POST" class="result-action-form {{ $ticketRequest && !$errors->any() ? 'd-none' : '' }}">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ $visaRequest->email }}">
                                            <div class="action-grid">
                                                <div>
                                                    <label for="verify_preferred_date_start">Preferred date from</label>
                                                    <input id="verify_preferred_date_start" type="date" name="preferred_date_start" min="{{ now()->toDateString() }}" value="{{ old('preferred_date_start', $visaRequest->preferred_date_start) }}" required>
                                                </div>
                                                <div>
                                                    <label for="verify_preferred_date_end">Preferred date to</label>
                                                    <input id="verify_preferred_date_end" type="date" name="preferred_date_end" min="{{ now()->toDateString() }}" value="{{ old('preferred_date_end', $visaRequest->preferred_date_end) }}" required>
                                                </div>
                                            </div>
                                            <label for="verify_preferred_airport" class="mt-3">Preferred Airport</label>
                                            <select id="verify_preferred_airport" name="preferred_airport" required>
                                                <option value="">Select preferred airport</option>
                                                @foreach($flightAirports as $code => $airport)
                                                    <option value="{{ $code }}" {{ old('preferred_airport', $visaRequest->preferred_airport) === $code ? 'selected' : '' }}>{{ $airport }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="action-submit"><i class="fas fa-paper-plane me-2"></i>{{ $ticketRequest ? 'Submit Ticket Reapplication' : 'Submit Flight Ticket Request' }}</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
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

        @include('partials.footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const verifyDateStart = document.getElementById('verify_preferred_date_start');
        const verifyDateEnd = document.getElementById('verify_preferred_date_end');
        const verifyTicketReapplyButton = document.getElementById('showVerifyTicketReapplyForm');
        const verifyTicketReapplyForm = document.getElementById('verifyTicketReapplyForm');
        const receiptInput = document.getElementById('verify_payment_receipt');
        const receiptPicker = document.getElementById('verify-payment-receipt-picker');
        const receiptPreview = document.getElementById('verify-payment-receipt-preview');
        const receiptImage = document.getElementById('verify-payment-receipt-image');

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

        verifyDateStart?.addEventListener('change', () => {
            verifyDateEnd.min = verifyDateStart.value || verifyDateEnd.min;
            if (verifyDateEnd.value && verifyDateEnd.value < verifyDateStart.value) {
                verifyDateEnd.value = verifyDateStart.value;
            }
        });
        verifyTicketReapplyButton?.addEventListener('click', () => {
            const isHidden = verifyTicketReapplyForm.classList.toggle('d-none');
            verifyTicketReapplyButton.setAttribute('aria-expanded', String(!isHidden));
            if (!isHidden) verifyTicketReapplyForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    </script>
</body>
</html>
