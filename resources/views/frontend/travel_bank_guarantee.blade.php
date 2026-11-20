<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#063b86">
    <title>Bank Guarantee &amp; Financial Verification | {{ $settings->app_name ?? 'Hays Travel' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/travel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travel-home.css') }}">
    <style>
        .bank-guarantee-main {
            background: #e8f3ff;
            min-height: 100vh;
            padding: 12px 10px 24px;
        }
        .bank-guarantee-promo-stage {
            background: linear-gradient(135deg, #073e77, #126047);
            border-radius: 12px;
            margin: 0 auto 12px;
            max-width: 460px;
            padding: 7px;
        }
        .bank-guarantee-promo {
            align-items: center;
            background: #fff;
            border: 3px solid #c9a84e;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(11, 34, 53, .2);
            display: grid;
            gap: 12px;
            grid-template-columns: 58px minmax(0, 1fr);
            padding: 12px 10px;
        }
        .bank-guarantee-promo-shield {
            align-items: center;
            background: #c9a84e;
            clip-path: polygon(50% 0, 95% 18%, 91% 70%, 50% 100%, 9% 70%, 5% 18%);
            color: #f4cb50;
            display: flex;
            font-size: 24px;
            height: 74px;
            justify-content: center;
            padding: 4px;
            width: 58px;
        }
        .bank-guarantee-promo-shield i {
            align-items: center;
            background: #073d70;
            clip-path: polygon(50% 0, 95% 18%, 91% 70%, 50% 100%, 9% 70%, 5% 18%);
            display: flex;
            height: 100%;
            justify-content: center;
            width: 100%;
        }
        .bank-guarantee-promo-copy h2 {
            color: #10233d;
            font-size: clamp(.95rem, 3.8vw, 1.55rem);
            font-weight: 800;
            line-height: 1.15;
            margin: 0 0 6px;
        }
        .bank-guarantee-promo-copy p {
            color: #28374a;
            font-size: clamp(.72rem, 2.5vw, .95rem);
            line-height: 1.35;
            margin: 0 0 10px;
        }
        .bank-guarantee-promo-copy strong {
            color: #111827;
            white-space: nowrap;
        }
        .bank-guarantee-promo-link {
            align-items: center;
            background: #ffca05;
            border: 1px solid #e8b900;
            border-radius: 999px;
            box-shadow: 0 3px 6px rgba(142, 106, 0, .24);
            color: #12233b !important;
            display: inline-flex;
            font-size: clamp(.9rem, 3vw, 1.15rem);
            font-weight: 800;
            gap: 9px;
            justify-content: center;
            min-height: 43px;
            padding: 8px 18px;
            text-decoration: none;
        }
        .bank-guarantee-promo-link:hover {
            background: #f3bb00;
            color: #12233b !important;
        }
        .financial-verification-panel {
            background: #fff;
            border: 1px solid #d5e0ed;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(18, 50, 86, .12);
            margin: 0 auto;
            max-width: 460px;
            overflow: hidden;
            width: 100%;
        }
        .financial-verification-title {
            background: #07508a;
            color: #fff;
            padding: 12px 14px;
        }
        .financial-verification-title h2 {
            color: #fff;
            font-size: .95rem;
            font-weight: 800;
            line-height: 1.25;
            margin: 0;
        }
        .financial-verification-form {
            padding: 12px;
        }
        .financial-verification-form label {
            color: #203047;
            display: block;
            font-size: .73rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .financial-verification-form .form-control,
        .financial-verification-form .form-select {
            border: 1px solid #bccbdb;
            border-radius: 5px;
            color: #23364e;
            font-size: .82rem;
            min-height: 38px;
            width: 100%;
        }
        .verification-field {
            margin-bottom: 9px;
        }
        .passport-fetch-row {
            display: grid;
            gap: 7px;
            grid-template-columns: minmax(0, 1fr) 88px;
        }
        .fetch-application-button {
            background: #ffca05;
            border: 1px solid #e4b600;
            border-radius: 5px;
            color: #172a43;
            font-size: .73rem;
            font-weight: 800;
            min-height: 38px;
            padding: 5px 8px;
        }
        .fetch-application-button:disabled {
            cursor: wait;
            opacity: .7;
        }
        .application-lookup-message {
            color: #b42318;
            font-size: .75rem;
            margin: -2px 0 7px;
        }
        .application-lookup-result {
            background: #edf5fc;
            border: 1px solid #c9daeb;
            border-radius: 6px;
            color: #203047;
            display: grid;
            font-size: .75rem;
            gap: 5px;
            margin: 0 0 10px;
            padding: 8px 10px;
        }
        .application-lookup-title {
            color: #193b62;
            font-size: .78rem;
            font-weight: 800;
            margin: 0;
        }
        .application-lookup-result label {
            color: #52657b;
            font-size: .68rem;
            font-weight: 700;
            margin: 0 0 3px;
        }
        .application-lookup-result .form-control {
            background: #fff;
            font-size: .76rem;
            min-height: 34px;
        }
        .application-lookup-result.d-none {
            display: none;
        }
        .financial-verification-section {
            background: #f1f6fc;
            border: 1px solid #d9e3ef;
            border-radius: 8px;
            margin-top: 13px;
            padding: 10px;
        }
        .financial-verification-section h2 {
            color: #193b62;
            font-size: .92rem;
            font-weight: 800;
            margin: 0 0 9px;
        }
        .financial-verification-note {
            background: #fff;
            border-left: 3px solid #1682bf;
            color: #52657b;
            font-size: .72rem;
            line-height: 1.45;
            margin: 9px 0;
            padding: 7px 9px;
        }
        .financial-verification-consent {
            align-items: center;
            display: flex;
            gap: 7px;
            margin: 11px 1px;
        }
        .financial-verification-consent input {
            accent-color: #07508a;
            flex: 0 0 auto;
            margin: 0;
        }
        .financial-verification-consent label {
            color: #52657b;
            font-size: .7rem;
            font-weight: 500;
            margin: 0;
        }
        .financial-verification-submit {
            align-items: center;
            background: #07508a;
            border: 1px solid #07508a;
            border-radius: 999px;
            color: #fff;
            display: flex;
            font-size: .9rem;
            font-weight: 800;
            justify-content: center;
            min-height: 42px;
            padding: 8px 14px;
            width: 100%;
        }
        .financial-verification-submit:hover {
            background: #063e6b;
        }
        #financial-verification-form {
            scroll-margin-top: 14px;
        }
        @media (max-width: 360px) {
            .bank-guarantee-promo {
                gap: 8px;
                grid-template-columns: 48px minmax(0, 1fr);
                padding: 10px 8px;
            }
            .bank-guarantee-promo-shield {
                font-size: 20px;
                height: 62px;
                width: 48px;
            }
            .bank-guarantee-promo-link {
                min-height: 39px;
                padding: 7px 12px;
            }
        }
    </style>
</head>
<body class="travel-home-page bank-guarantee-page">
    <div class="travel-home-shell">
        @include('partials.trust-mark-header')

        <main class="bank-guarantee-main">
            <section class="bank-guarantee-promo-stage" aria-labelledby="bank-guarantee-promo-title">
                <div class="bank-guarantee-promo">
                    <div class="bank-guarantee-promo-shield" aria-hidden="true">
                        <i class="fas fa-building-columns"></i>
                    </div>
                    <div class="bank-guarantee-promo-copy">
                        <h2 id="bank-guarantee-promo-title">Bank Guarantee &amp; Financials Verification</h2>
                        <p>Show solid proof of funds with our approved partners for <strong>UK £10,000+</strong> and <strong>USA $15,000+</strong> visa requirements.</p>
                        <a class="bank-guarantee-promo-link" href="#financial-verification-form">
                            Analyze My Funds <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </section>

            <section class="financial-verification-panel" aria-labelledby="financial-verification-title">
                <header class="financial-verification-title">
                    <h2 id="financial-verification-title">Financial Verification</h2>
                </header>

                @if(session('success'))
                    <div class="alert alert-success m-3 mb-0" role="status">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger m-3 mb-0" role="alert">{{ $errors->first() }}</div>
                @endif

                <form class="financial-verification-form" id="financial-verification-form" action="{{ route('travel.bank_guarantee.store') }}" method="POST">
                    @csrf
                    <div class="verification-field">
                        <label for="nationality">Select Nationality</label>
                        <select class="form-select" id="nationality" name="nationality" required>
                            <option value="" disabled {{ old('nationality') ? '' : 'selected' }}>Select Nationality</option>
                            @foreach($nationalities as $nationality)
                                <option value="{{ $nationality }}" {{ old('nationality') === $nationality ? 'selected' : '' }}>{{ $nationality }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="verification-field">
                        <label for="passport_number">Passport No.</label>
                        <div class="passport-fetch-row">
                            <input class="form-control" id="passport_number" name="passport_number" type="text" value="{{ old('passport_number') }}" maxlength="100" autocomplete="off" required>
                            <button class="fetch-application-button" id="fetch-application-button" type="button">Fetch Data</button>
                        </div>
                    </div>
                    <input id="visa_request_id" name="visa_request_id" type="hidden" value="{{ old('visa_request_id') }}">
                    <div class="application-lookup-message" id="application-lookup-message" role="status" aria-live="polite"></div>
                    <div class="application-lookup-result d-none" id="application-lookup-result" aria-live="polite">
                        <h3 class="application-lookup-title">Matched Application Details</h3>
                        <div>
                            <label for="fetched-application-number">Application No.</label>
                            <input class="form-control" id="fetched-application-number" type="text" readonly>
                        </div>
                        <div>
                            <label for="fetched-applicant-name">Applicant Name</label>
                            <input class="form-control" id="fetched-applicant-name" type="text" readonly>
                        </div>
                    </div>

                    <section class="financial-verification-section" aria-labelledby="financial-verification-details-title">
                        <h2 id="financial-verification-details-title">Financial Verification</h2>
                        <div class="verification-field">
                            <label for="verification_country">Visa Destination</label>
                            <select class="form-select" id="verification_country" name="verification_country" required>
                                <option value="UK" {{ old('verification_country', 'UK') === 'UK' ? 'selected' : '' }}>United Kingdom (UK)</option>
                                <option value="USA" {{ old('verification_country') === 'USA' ? 'selected' : '' }}>United States (USA)</option>
                            </select>
                        </div>
                        <div class="verification-field">
                            <label for="requested_amount">Funds to Verify (<span id="verification-currency">GBP</span>)</label>
                            <input class="form-control" id="requested_amount" name="requested_amount" type="number" min="10000" step="0.01" value="{{ old('requested_amount') }}" placeholder="Minimum 10,000" required>
                        </div>
                        <div class="verification-field mb-0">
                            <label for="bank_name">Bank Name (Optional)</label>
                            <input class="form-control" id="bank_name" name="bank_name" type="text" value="{{ old('bank_name') }}" maxlength="255" autocomplete="organization">
                        </div>
                    </section>

                    <p class="financial-verification-note">Submit a request for our team to review. Do not enter card numbers, security codes, expiry dates, or one-time passwords on this page.</p>
                    <div class="financial-verification-consent">
                        <input id="consent" name="consent" type="checkbox" value="1" required {{ old('consent') ? 'checked' : '' }}>
                        <label for="consent">I confirm these application details are mine and agree to submit this request for review.</label>
                    </div>
                    <button class="financial-verification-submit" id="submit-verification" type="submit" disabled>Submit for Verification</button>
                </form>
            </section>
        </main>
    </div>
    @include('partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const nationalitySelect = document.getElementById('nationality');
        const passportNumberInput = document.getElementById('passport_number');
        const visaRequestIdInput = document.getElementById('visa_request_id');
        const fetchApplicationButton = document.getElementById('fetch-application-button');
        const applicationLookupMessage = document.getElementById('application-lookup-message');
        const applicationLookupResult = document.getElementById('application-lookup-result');
        const submitVerificationButton = document.getElementById('submit-verification');

        function clearFetchedApplication() {
            visaRequestIdInput.value = '';
            document.getElementById('fetched-application-number').value = '';
            document.getElementById('fetched-applicant-name').value = '';
            applicationLookupResult.classList.add('d-none');
            applicationLookupMessage.textContent = '';
            submitVerificationButton.disabled = true;
        }

        nationalitySelect.addEventListener('change', clearFetchedApplication);
        passportNumberInput.addEventListener('input', clearFetchedApplication);
        fetchApplicationButton.addEventListener('click', async function () {
            clearFetchedApplication();
            if (!nationalitySelect.value || !passportNumberInput.value.trim()) {
                applicationLookupMessage.textContent = 'Select your nationality and enter your passport number.';
                return;
            }

            fetchApplicationButton.disabled = true;
            fetchApplicationButton.textContent = 'Searching...';
            try {
                const response = await fetch('{{ route('travel.bank_guarantee.fetch_application') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        nationality: nationalitySelect.value,
                        passport_number: passportNumberInput.value.trim(),
                    }),
                });
                const data = await response.json();
                if (!response.ok) {
                    applicationLookupMessage.textContent = data.message
                        || Object.values(data.errors || {}).flat()[0]
                        || 'Unable to fetch application details. Please try again.';
                    return;
                }

                visaRequestIdInput.value = data.visa_request_id;
                document.getElementById('fetched-application-number').value = data.application_number;
                document.getElementById('fetched-applicant-name').value = data.name || 'Name not available';
                applicationLookupResult.classList.remove('d-none');
                submitVerificationButton.disabled = false;
            } catch (error) {
                applicationLookupMessage.textContent = 'Unable to fetch application details. Please check your connection and try again.';
            } finally {
                fetchApplicationButton.disabled = false;
                fetchApplicationButton.textContent = 'Fetch Data';
            }
        });

        document.getElementById('verification_country').addEventListener('change', function () {
            var isUk = this.value === 'UK';
            document.getElementById('verification-currency').textContent = isUk ? 'GBP' : 'USD';
            document.getElementById('requested_amount').min = isUk ? '10000' : '15000';
            document.getElementById('requested_amount').placeholder = isUk ? 'Minimum 10,000' : 'Minimum 15,000';
        });
        document.getElementById('verification_country').dispatchEvent(new Event('change'));
    </script>
</body>
</html>