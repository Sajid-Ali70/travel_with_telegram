<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialVerificationController extends Controller
{
    public function create()
    {
        $settings = \getAppSettings();
        $nationalities = DB::table('app_nationalities')->orderBy('name')->pluck('name');

        return view('frontend.travel_bank_guarantee', compact('settings', 'nationalities'));
    }

    public function adminIndex()
    {
        $settings = \getAppSettings();
        $verificationRequests = DB::table('financial_verification_requests')
            ->select([
                'id',
                'nationality',
                'name',
                'reference_number',
                'visa_request_id',
                'passport_number',
                'balance',
                'created_at',
            ])
            ->orderByDesc('financial_verification_requests.id')
            ->paginate(25);

        return view('admin.financial_verifications.index', compact('settings', 'verificationRequests'));
    }

    public function fetchApplication(Request $request)
    {
        $validated = $request->validate([
            'nationality' => 'required|string|max:255',
            'passport_number' => 'required|string|max:100',
        ]);

        $visaRequest = DB::table('app_visa_requests')
            ->whereRaw('LOWER(passport_number) = ?', [mb_strtolower(trim($validated['passport_number']))])
            ->whereRaw('LOWER(nationality) = ?', [mb_strtolower(trim($validated['nationality']))])
            ->orderByDesc('id')
            ->first(['id', 'reference_number', 'first_name', 'last_name', 'created_at']);

        if (!$visaRequest) {
            return response()->json(
                ['message' => 'No application was found for that nationality and passport number.'],
                404,
                ['Cache-Control' => 'no-store, private']
            );
        }

        return response()->json([
            'visa_request_id' => $visaRequest->id,
            'application_number' => $visaRequest->reference_number
                ?: AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at),
            'name' => trim(($visaRequest->first_name ?? '') . ' ' . ($visaRequest->last_name ?? '')),
        ], 200, ['Cache-Control' => 'no-store, private']);
    }

    public function store(Request $request)
    {
        $request->replace($request->only([
            '_token',
            'nationality',
            'passport_number',
            'visa_request_id',
            'verification_country',
            'requested_amount',
            'bank_name',
            'consent',
        ]));

        $validated = $request->validate([
            'nationality' => 'required|string|max:255',
            'passport_number' => 'required|string|max:100',
            'visa_request_id' => 'required|integer|min:1',
            'verification_country' => 'required|in:UK,USA',
            'requested_amount' => 'required|numeric|min:0.01|max:999999999.99',
            'bank_name' => 'nullable|string|max:255',
            'consent' => 'accepted',
        ]);

        $minimumAmount = $validated['verification_country'] === 'UK' ? 10000 : 15000;
        if ((float) $validated['requested_amount'] < $minimumAmount) {
            return back()
                ->withInput()
                ->withErrors(['requested_amount' => 'The requested amount must meet the selected destination requirement.']);
        }

        $visaRequest = DB::table('app_visa_requests')
            ->where('id', $validated['visa_request_id'])
            ->whereRaw('LOWER(passport_number) = ?', [mb_strtolower(trim($validated['passport_number']))])
            ->whereRaw('LOWER(nationality) = ?', [mb_strtolower(trim($validated['nationality']))])
            ->first(['id', 'reference_number', 'first_name', 'last_name', 'created_at']);

        if (!$visaRequest) {
            return back()
                ->withInput()
                ->withErrors(['passport_number' => 'We could not match those details to an application. Please fetch the application details again.']);
        }

        DB::table('app_financial_verification_requests')->insert([
            'visa_request_id' => $visaRequest->id,
            'application_reference' => $visaRequest->reference_number
                ?: AdminController::formatVisaReference($visaRequest->id, $visaRequest->created_at),
            'applicant_name' => trim(($visaRequest->first_name ?? '') . ' ' . ($visaRequest->last_name ?? '')),
            'nationality' => $validated['nationality'],
            'verification_country' => $validated['verification_country'],
            'requested_amount' => $validated['requested_amount'],
            'currency' => $validated['verification_country'] === 'UK' ? 'GBP' : 'USD',
            'bank_name' => $validated['bank_name'] ?? null,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('travel.bank_guarantee')
            ->with('success', 'Your financial verification request has been submitted for review.');
    }
}
