<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class DemoWebsiteDataSeeder extends Seeder
{
    private array $columnCache = [];

    public function run(): void
    {
        $requiredTables = [
            'app_countries',
            'app_nationalities',
            'app_categories',
            'app_visa_types',
            'app_profession_job_titles',
            'app_jobs',
            'app_visa_requests',
            'app_ticket_requests',
            'app_bank_accounts',
            'app_airports',
        ];

        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                throw new RuntimeException("Cannot seed demo records because the {$table} table does not exist.");
            }
        }

        $faker = \Faker\Factory::create();
        $faker->seed(20261007);
        $now = now();

        DB::transaction(function () use ($faker, $now) {
            $countries = [];
            foreach ([
                ['name' => 'QA Demo Kuwait', 'currency' => 'KWD', 'visa_fee' => 45],
                ['name' => 'QA Demo Canada', 'currency' => 'CAD', 'visa_fee' => 120],
            ] as $countryData) {
                $countries[$countryData['name']] = $this->upsertDemoRecord(
                    'app_countries',
                    ['name' => $countryData['name']],
                    [
                        'currency' => $countryData['currency'],
                        'currencies' => json_encode([$countryData['currency']]),
                        'visa_fee' => $countryData['visa_fee'],
                        'visa_fee_details' => 'QA demo payment details only.',
                        'flag' => null,
                    ],
                    $now
                );
            }

            $nationalityName = 'QA Demo Nationality';
            $this->upsertDemoRecord('app_nationalities', ['name' => $nationalityName], [
                'currency' => 'PKR',
                'phone_code' => '+999',
                'id_number_length' => 13,
                'phone_number_length' => 10,
            ], $now);

            $categories = [];
            foreach ([
                ['name' => 'QA Demo Work Visa', 'country' => 'QA Demo Kuwait'],
                ['name' => 'QA Demo Skilled Visa', 'country' => 'QA Demo Canada'],
            ] as $categoryData) {
                $categoryName = $categoryData['name'];
                $categories[$categoryName] = $this->upsertDemoRecord('app_categories', [
                    'name' => $categoryName,
                    'country_id' => $countries[$categoryData['country']],
                ], [
                    'icon' => 'fas fa-briefcase',
                    'image' => null,
                    'description' => 'Synthetic category for QA testing.',
                ], $now);
            }

            $visaTypes = [];
            foreach ([
                ['category' => 'QA Demo Work Visa', 'name' => 'QA Demo Employment'],
                ['category' => 'QA Demo Work Visa', 'name' => 'QA Demo Driver'],
                ['category' => 'QA Demo Skilled Visa', 'name' => 'QA Demo Skilled Employment'],
            ] as $visaTypeData) {
                $visaTypes[$visaTypeData['name']] = $this->upsertDemoRecord('app_visa_types', [
                    'category_id' => $categories[$visaTypeData['category']],
                    'name' => $visaTypeData['name'],
                ], [], $now);
            }

            $professions = [];
            foreach (['QA Demo Construction Worker', 'QA Demo Heavy Driver', 'QA Demo Registered Nurse'] as $professionName) {
                $professions[$professionName] = $this->upsertDemoRecord('app_profession_job_titles', [
                    'type' => 'profession',
                    'name' => $professionName,
                ], [
                    'category_id' => null,
                    'subcategory_id' => null,
                    'profession_id' => null,
                ], $now);
            }

            $jobs = [];
            $jobData = [
                [
                    'job_title' => 'QA Demo Construction Worker',
                    'country_location' => 'QA Demo Kuwait',
                    'profession' => 'QA Demo Construction Worker',
                    'category' => 'QA Demo Work Visa',
                    'category_visa_type' => 'QA Demo Employment',
                    'category_ids' => [$categories['QA Demo Work Visa']],
                    'salary' => 350,
                    'salary_currency' => 'KWD',
                    'salary_period' => 'month',
                    'number_of_vacancies' => 4,
                    'accommodation_provided' => 1,
                    'food_allowance_provided' => 1,
                    'medical_insurance' => 1,
                    'ticket_provided' => 1,
                ],
                [
                    'job_title' => 'QA Demo Heavy Driver',
                    'country_location' => 'QA Demo Kuwait',
                    'profession' => 'QA Demo Heavy Driver',
                    'category' => 'QA Demo Work Visa',
                    'category_visa_type' => 'QA Demo Driver',
                    'category_ids' => [$categories['QA Demo Work Visa']],
                    'salary' => 480,
                    'salary_currency' => 'KWD',
                    'salary_period' => 'month',
                    'number_of_vacancies' => 2,
                    'accommodation_provided' => 1,
                    'food_allowance_provided' => 0,
                    'medical_insurance' => 1,
                    'ticket_provided' => 0,
                ],
                [
                    'job_title' => 'QA Demo Registered Nurse',
                    'country_location' => 'QA Demo Canada',
                    'profession' => 'QA Demo Registered Nurse',
                    'category' => 'QA Demo Skilled Visa',
                    'category_visa_type' => 'QA Demo Skilled Employment',
                    'category_ids' => [$categories['QA Demo Skilled Visa']],
                    'salary' => 4200,
                    'salary_currency' => 'CAD',
                    'salary_period' => 'month',
                    'number_of_vacancies' => 3,
                    'accommodation_provided' => 0,
                    'food_allowance_provided' => 0,
                    'medical_insurance' => 1,
                    'ticket_provided' => 1,
                ],
                [
                    'job_title' => 'QA Demo Global Driver',
                    'country_location' => 'All Country (Global multi-select)',
                    'profession' => 'QA Demo Heavy Driver',
                    'category' => 'QA Demo Work Visa',
                    'category_visa_type' => 'QA Demo Driver',
                    'category_ids' => [$categories['QA Demo Work Visa'], $categories['QA Demo Skilled Visa']],
                    'salary' => 700,
                    'salary_currency' => 'USD',
                    'salary_period' => 'month',
                    'number_of_vacancies' => 1,
                    'accommodation_provided' => 1,
                    'food_allowance_provided' => 1,
                    'medical_insurance' => 1,
                    'ticket_provided' => 1,
                ],
            ];

            foreach ($jobData as $index => $job) {
                $jobTitle = $job['job_title'];
                unset($job['job_title']);
                $categoryIds = $job['category_ids'];
                $jobs[$jobTitle] = $this->upsertDemoRecord('app_jobs', ['job_title' => $jobTitle], array_merge($job, [
                    'category_ids' => json_encode($categoryIds),
                    'working_hours' => '08:00 AM - 05:00 PM',
                    'working_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']),
                    'overtime_policy' => 'QA demo overtime paid according to company policy.',
                    'contract_duration' => $index === 2 ? '24 months' : '12 months',
                    'paid_leave_days_after_one_year' => 30,
                    'job_description' => $faker->paragraph(3) . ' This is synthetic QA demo content.',
                    'requirements' => $faker->sentence(12) . ' (QA demo requirement)',
                    'status' => 'Active',
                ]), $now);
            }

            $airportCodes = [
                'QAKWI' => ['name' => 'QA Demo Kuwait International Airport', 'city' => 'QA Demo Kuwait City'],
                'QACAN' => ['name' => 'QA Demo Toronto Airport', 'city' => 'QA Demo Toronto'],
            ];
            foreach ($airportCodes as $code => $airport) {
                $this->upsertDemoRecord('app_airports', ['code' => $code], [
                    'name' => $airport['name'],
                    'city' => $airport['city'],
                    'country' => $nationalityName,
                ], $now);
            }

            $applicants = [];
            $statuses = [
                'Visa Application Submitted',
                'Documents Verification',
                'Visa Approved from Embassy',
                'Visa Rejected due to Documents Verification Failed',
            ];
            foreach ($statuses as $index => $status) {
                $email = 'qa-demo-applicant-' . ($index + 1) . '@example.test';
                $firstName = $faker->firstName();
                $lastName = $faker->lastName();
                $countryName = $index === 2 ? 'QA Demo Canada' : 'QA Demo Kuwait';
                $categoryName = $index === 2 ? 'QA Demo Skilled Visa' : 'QA Demo Work Visa';
                $professionName = $index === 2 ? 'QA Demo Registered Nurse' : ($index === 1 ? 'QA Demo Heavy Driver' : 'QA Demo Construction Worker');
                $jobTitle = $index === 2 ? 'QA Demo Registered Nurse' : ($index === 1 ? 'QA Demo Heavy Driver' : 'QA Demo Construction Worker');
                $jobKey = $index === 2 ? $jobTitle : $jobTitle;
                $requestId = $this->upsertDemoRecord('app_visa_requests', ['email' => $email], [
                    'national_identity' => 'QA' . str_pad((string) ($index + 1), 11, '0', STR_PAD_LEFT),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'mobile_number' => '+999 ' . $faker->numerify('##########'),
                    'dob' => $faker->date('Y-m-d', '-20 years'),
                    'gender' => $index % 2 === 0 ? 'male' : 'female',
                    'nationality' => $nationalityName,
                    'profession' => $professionName,
                    'passport_number' => 'QA' . str_pad((string) ($index + 100), 7, '0', STR_PAD_LEFT),
                    'passport_expiry' => now()->addYears(3)->format('Y-m-d'),
                    'passport_photo' => null,
                    'destination_country' => $countryName,
                    'visa_category' => $categoryName,
                    'visa_type' => $professionName,
                    'job_title' => $jobTitle,
                    'selected_job_ids' => json_encode([$jobs[$jobKey]]),
                    'driving_license_available' => $index === 1 ? 'yes' : null,
                    'status' => $status,
                    'visa_fee' => $index === 2 ? 120 : null,
                    'visa_fee_currency' => $index === 2 ? 'CAD' : null,
                    'bank_name' => $index === 2 ? 'QA Demo Bank' : null,
                    'account_number' => $index === 2 ? 'QA-DEMO-ACCOUNT' : null,
                    'account_holder_name' => $index === 2 ? $firstName . ' ' . $lastName : null,
                    'agent_name' => $index === 1 ? 'QA Demo Agent' : null,
                    'agent_contact_number' => $index === 1 ? '+999 5550000000' : null,
                    'created_at' => $now->copy()->subDays($index + 1),
                ], $now);
                $applicants[$index] = $requestId;
            }

            $ticketDetails = [
                ['visa_request_id' => $applicants[0], 'preferred_airport' => 'QAKWI', 'status' => 'Requested'],
                ['visa_request_id' => $applicants[2], 'preferred_airport' => 'QACAN', 'status' => 'Booked'],
            ];
            foreach ($ticketDetails as $ticket) {
                $this->upsertDemoRecord('app_ticket_requests', [
                    'visa_request_id' => $ticket['visa_request_id'],
                ], [
                    'preferred_date_start' => now()->addMonths(2)->toDateString(),
                    'preferred_date_end' => now()->addMonths(3)->toDateString(),
                    'preferred_airport' => $ticket['preferred_airport'],
                    'details' => 'Synthetic QA demo flight ticket request.',
                    'status' => $ticket['status'],
                    'status_updated_at' => $now,
                    'requested_at' => $now,
                ], $now);
            }

            $this->upsertDemoRecord('app_bank_accounts', [
                'bank_name' => 'QA Demo Bank',
                'account_number' => 'QA-DEMO-ACCOUNT',
            ], [
                'account_name' => 'QA Demo Payments',
                'iban' => 'QA00DEMO000000000001',
                'branch' => 'QA Demo Branch',
                'swift_code' => 'QADEMO00',
                'currency' => 'PKR',
            ], $now);
        });

        $this->command?->info('Synthetic QA demo data added or refreshed. Existing non-demo records were left untouched.');
    }

    private function upsertDemoRecord(string $table, array $identity, array $values, $now): int
    {
        $columns = $this->columnCache[$table] ??= Schema::getColumnListing($table);
        $identity = array_intersect_key($identity, array_flip($columns));
        if (!$identity) {
            throw new RuntimeException("Cannot identify the demo record in {$table}.");
        }

        $values = array_intersect_key($values, array_flip($columns));
        if (in_array('updated_at', $columns, true)) {
            $values['updated_at'] = $now;
        }
        if (!DB::table($table)->where($identity)->exists() && in_array('created_at', $columns, true) && !array_key_exists('created_at', $values)) {
            $values['created_at'] = $now;
        }

        DB::table($table)->updateOrInsert($identity, $values);

        $id = DB::table($table)->where($identity)->value('id');
        if ($id === null) {
            throw new RuntimeException("Unable to retrieve the seeded demo record from {$table}.");
        }

        return (int) $id;
    }
}
