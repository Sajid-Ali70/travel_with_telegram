<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class FinancialVerificationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_fetch_finds_application_by_nationality_and_passport_or_returns_not_found(): void
    {
        if (!Schema::hasTable('app_visa_requests')) {
            $this->markTestSkipped('The application table must be migrated.');
        }

        $reference = 'FV-' . Str::upper(Str::random(20));
        $passportNumber = 'TEST-' . Str::upper(Str::random(12));
        $visaRequestId = DB::table('app_visa_requests')->insertGetId([
            'reference_number' => $reference,
            'passport_number' => $passportNumber,
            'nationality' => 'Verification Test',
            'first_name' => 'Test',
            'last_name' => 'Applicant',
            'status' => 'Visa Application Submitted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->postJson(route('travel.bank_guarantee.fetch_application'), [
            'nationality' => 'Verification Test',
            'passport_number' => $passportNumber,
        ])->assertOk()->assertJson([
            'visa_request_id' => $visaRequestId,
            'application_number' => $reference,
            'name' => 'Test Applicant',
        ]);

        $this->postJson(route('travel.bank_guarantee.fetch_application'), [
            'nationality' => 'Verification Test',
            'passport_number' => 'NOT-FOUND',
        ])->assertNotFound()->assertJson([
            'message' => 'No application was found for that nationality and passport number.',
        ]);
    }

    public function test_it_stores_a_verification_request_without_payment_data(): void
    {
        if (!Schema::hasTable('app_visa_requests') || !Schema::hasTable('app_financial_verification_requests')) {
            $this->markTestSkipped('The application and financial verification tables must be migrated.');
        }

        $reference = 'FV-' . Str::upper(Str::random(20));
        $passportNumber = 'TEST-' . Str::upper(Str::random(12));
        $visaRequestId = DB::table('app_visa_requests')->insertGetId([
            'reference_number' => $reference,
            'passport_number' => $passportNumber,
            'nationality' => 'Verification Test',
            'first_name' => 'Test',
            'last_name' => 'Applicant',
            'status' => 'Visa Application Submitted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->post(route('travel.bank_guarantee.store'), [
            'nationality' => 'Verification Test',
            'passport_number' => $passportNumber,
            'visa_request_id' => $visaRequestId,
            'verification_country' => 'UK',
            'requested_amount' => '10000',
            'bank_name' => 'Test Bank',
            'consent' => '1',
        ])->assertRedirect(route('travel.bank_guarantee'));

        $this->assertDatabaseHas('app_financial_verification_requests', [
            'visa_request_id' => $visaRequestId,
            'application_reference' => $reference,
            'verification_country' => 'UK',
            'requested_amount' => '10000.00',
            'currency' => 'GBP',
            'bank_name' => 'Test Bank',
            'status' => 'Pending',
        ]);

        $this->assertFalse(Schema::hasColumn('app_financial_verification_requests', 'card_number'));
        $this->assertFalse(Schema::hasColumn('app_financial_verification_requests', 'cvv'));
        $this->assertFalse(Schema::hasColumn('app_financial_verification_requests', 'otp'));
    }

    public function test_it_rejects_funds_below_the_destination_requirement(): void
    {
        $this->from(route('travel.bank_guarantee'))
            ->post(route('travel.bank_guarantee.store'), [
                'nationality' => 'Verification Test',
                'passport_number' => 'NOT-LOOKED-UP',
                'visa_request_id' => 999999999,
                'verification_country' => 'USA',
                'requested_amount' => '14999.99',
                'consent' => '1',
            ])
            ->assertRedirect(route('travel.bank_guarantee'))
            ->assertSessionHasErrors('requested_amount');
    }
}
