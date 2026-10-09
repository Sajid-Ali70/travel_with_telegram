<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa Application {{ $visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at) }}</title>
    <style>
        body { color: #1f2937; font: 14px Arial, sans-serif; margin: 0; padding: 32px; }
        h1 { margin: 0 0 6px; font-size: 24px; }
        .subtitle { color: #6b7280; margin-bottom: 24px; }
        h2 { border-bottom: 1px solid #d1d5db; font-size: 16px; margin: 24px 0 10px; padding-bottom: 6px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #d1d5db; padding: 9px 10px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; width: 30%; }
        .passport-photo { display: block; max-width: 240px; max-height: 320px; object-fit: contain; }
        .passport-photo-cell { background: #fff; }
        .print-action { margin-bottom: 20px; }
        @media print {
            body { padding: 0; }
            .print-action { display: none; }
        }
    </style>
</head>
<body>
    <button class="print-action" type="button" onclick="window.print()">Print / Save as PDF</button>
    <h1>Visa Application</h1>
    <div class="subtitle">Reference {{ $visaRequest->reference_number ?: \App\Http\Controllers\AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at) }} · {{ $visaRequest->created_at ?: 'Submission date not available' }}</div>

    <h2>Applicant</h2>
    <table>
        <tr><th>Full name</th><td>{{ trim(($visaRequest->first_name ?? '') . ' ' . ($visaRequest->last_name ?? '')) ?: '—' }}</td></tr>
        <tr><th>Date of birth</th><td>{{ $visaRequest->dob ?: '—' }}</td></tr>
        <tr><th>Gender</th><td>{{ $visaRequest->gender ?: '—' }}</td></tr>
        <tr><th>Nationality</th><td>{{ $visaRequest->nationality ?: '—' }}</td></tr>
        <tr><th>National identity</th><td>{{ $visaRequest->national_identity ?: '—' }}</td></tr>
        <tr><th>Profession</th><td>{{ $visaRequest->profession ?: '—' }}</td></tr>
        <tr><th>Email</th><td>{{ $visaRequest->email ?: '—' }}</td></tr>
        <tr><th>Mobile number</th><td>{{ $visaRequest->mobile_number ?: '—' }}</td></tr>
    </table>

    <h2>Passport</h2>
    <table>
        <tr><th>Passport number</th><td>{{ $visaRequest->passport_number ?: '—' }}</td></tr>
        <tr><th>Passport expiry</th><td>{{ $visaRequest->passport_expiry ?: '—' }}</td></tr>
        @if($passportPhotoDataUri)
            <tr>
                <th>Passport photo</th>
                <td class="passport-photo-cell"><img class="passport-photo" src="{{ $passportPhotoDataUri }}" alt="Applicant passport photo"></td>
            </tr>
        @endif
    </table>

    <h2>Application details</h2>
    <table>
        <tr><th>Destination country</th><td>{{ $visaRequest->destination_country ?: '—' }}</td></tr>
        <tr><th>Visa category</th><td>{{ $visaRequest->visa_category ?: '—' }}</td></tr>
        <tr><th>Visa type</th><td>{{ $visaRequest->visa_type ?: '—' }}</td></tr>
        <tr><th>Job title</th><td>{{ $visaRequest->job_title ?: (implode(', ', $selectedJobTitles) ?: '—') }}</td></tr>
        <tr><th>Driving license</th><td>{{ $visaRequest->driving_license_available ?: '—' }}</td></tr>
        <tr><th>Status</th><td>{{ $visaRequest->status ?: '—' }}</td></tr>
    </table>

    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>
</html>
