<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - {{ $settings->app_name ?? 'VisaBook' }}</title>
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
    @php($hasTicketRequest = $ticketRequest !== null || !empty($visaRequest->flight_ticket_requested_at))
    <div class="mobile-container">
        @include('partials.nav')

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
                @if($visaRequest->status === 'Visa Issued' && !empty($visaRequest->issued_visa_document))
                    <div class="alert alert-success">
                        Your visa has been issued.
                        <a class="btn btn-success btn-sm ms-2" href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('travel.visa_document.download', now()->addMinutes(30), ['id' => $visaRequest->id]) }}">
                            <i class="fas fa-download me-1"></i>Download Visa Document
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
