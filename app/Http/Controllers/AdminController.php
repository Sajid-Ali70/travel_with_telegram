<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Schema\Blueprint;

class AdminController extends Controller
{
    private const VISA_STATUSES = [
        'Visa Application Submitted',
        'Documents Verification',
        'Documents Verification Completed, Request Submitted to Embassy',
        'Visa Approved from Embassy',
        'Visa Rejected due to Documents Verification Failed',
        'Visa Rejected due to Non Payment of Fee',
    ];
    private const LEGACY_VISA_STATUSES = [
        'Verification of Documents Successful',
        'Visa Approved',
        'Visa Rejected - Document Verification Failed',
        'Visa Rejected - Fee Not Paid',
        'Fee Payment',
        'Payment Verified',
        'Visa Issued',
        'Flight Ticket Booked',
        'Application Rejected',
        'pending',
        'processing',
        'approved',
        'rejected',
    ];
    private const TICKET_STATUSES = ['Requested', 'Processing', 'Booked', 'Cancelled'];
    private const DEFAULT_FLIGHT_AIRPORTS = [
        'DAC' => 'Hazrat Shahjalal International Airport, Dhaka (DAC)',
        'CGP' => 'Shah Amanat International Airport, Chattogram (CGP)',
        'ZYL' => 'Osmani International Airport, Sylhet (ZYL)',
        'ISB' => 'Islamabad International Airport (ISB)',
        'LHE' => 'Allama Iqbal International Airport, Lahore (LHE)',
        'KHI' => 'Jinnah International Airport, Karachi (KHI)',
    ];

    private function getFlightAirports(?string $nationality = null): array
    {
        $query = DB::table('app_airports')->orderBy('name');

        if (!empty($nationality)) {
            $query->where(function ($q) use ($nationality) {
                $normalized = trim($nationality);
                $q->where('country', $normalized)
                  ->orWhereRaw('LOWER(country) = ?', [mb_strtolower($normalized)])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($normalized) . '%']);
            });

            $filtered = $query->pluck('name', 'code')->all();
            if (!empty($filtered)) {
                return $filtered;
            }
        }

        return DB::table('app_airports')->orderBy('name')->pluck('name', 'code')->all();
    }

    private function autoManageSettingsColumns()
    {
        try {
            $columns = [
                'home_banner' => "ALTER TABLE `app_settings` ADD `home_banner` VARCHAR(255) NULL DEFAULT NULL AFTER `app_icon` ",
                'inner_banner' => "ALTER TABLE `app_settings` ADD `inner_banner` VARCHAR(255) NULL DEFAULT NULL AFTER `home_banner` ",
                'phone' => "ALTER TABLE `app_settings` ADD `phone` VARCHAR(100) NULL DEFAULT NULL ",
                'email' => "ALTER TABLE `app_settings` ADD `email` VARCHAR(255) NULL DEFAULT NULL ",
                'address' => "ALTER TABLE `app_settings` ADD `address` TEXT NULL DEFAULT NULL ",
                'footer_text' => "ALTER TABLE `app_settings` ADD `footer_text` TEXT NULL DEFAULT NULL "
            ];

            foreach ($columns as $column => $sql) {
                if (!Schema::hasColumn('app_settings', $column)) {
                    DB::statement($sql);
                }
            }

            if (!Schema::hasTable('app_countries')) {
                Schema::create('app_countries', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->decimal('visa_fee', 12, 2)->nullable();
                    $table->string('currency', 20)->nullable();
                    $table->text('visa_fee_details')->nullable();
                    $table->text('currencies')->nullable();
                    $table->string('flag')->nullable();
                    $table->timestamps();
                });
            } else {
                $countryColumns = [
                    'visa_fee' => "ALTER TABLE `app_countries` ADD `visa_fee` DECIMAL(12,2) NULL DEFAULT NULL AFTER `name` ",
                    'currency' => "ALTER TABLE `app_countries` ADD `currency` VARCHAR(20) NULL DEFAULT NULL AFTER `visa_fee` ",
                    'visa_fee_details' => "ALTER TABLE `app_countries` ADD `visa_fee_details` TEXT NULL DEFAULT NULL AFTER `currency` ",
                    'currencies' => "ALTER TABLE `app_countries` ADD `currencies` TEXT NULL DEFAULT NULL ",
                    'flag' => "ALTER TABLE `app_countries` ADD `flag` VARCHAR(255) NULL DEFAULT NULL AFTER `visa_fee_details` ",
                    'created_at' => "ALTER TABLE `app_countries` ADD `created_at` TIMESTAMP NULL DEFAULT NULL ",
                    'updated_at' => "ALTER TABLE `app_countries` ADD `updated_at` TIMESTAMP NULL DEFAULT NULL "
                ];
                foreach ($countryColumns as $column => $sql) {
                    if (!Schema::hasColumn('app_countries', $column)) {
                        DB::statement($sql);
                    }
                }
            }

            if (!Schema::hasTable('app_nationalities')) {
                Schema::create('app_nationalities', function (Blueprint $table) {
                    $table->id();
                    $table->string('name')->unique();
                    $table->string('currency', 20)->nullable();
                    $table->string('phone_code', 20)->nullable();
                    $table->unsignedInteger('id_number_length')->nullable();
                    $table->timestamps();
                });
            } else {
                $nationalityColumns = [
                    'currency' => "ALTER TABLE `app_nationalities` ADD `currency` VARCHAR(20) NULL DEFAULT NULL AFTER `name` ",
                    'phone_code' => "ALTER TABLE `app_nationalities` ADD `phone_code` VARCHAR(20) NULL DEFAULT NULL AFTER `currency` ",
                    'id_number_length' => "ALTER TABLE `app_nationalities` ADD `id_number_length` INT UNSIGNED NULL DEFAULT NULL AFTER `phone_code` "
                ];
                foreach ($nationalityColumns as $column => $sql) {
                    if (!Schema::hasColumn('app_nationalities', $column)) {
                        DB::statement($sql);
                    }
                }
            }

            if (!Schema::hasTable('app_categories')) {
                Schema::create('app_categories', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('icon')->nullable();
                    $table->string('image')->nullable();
                    $table->text('description')->nullable();
                    $table->timestamps();
                });
            } else {
                $categoryColumns = [
                    'icon' => "ALTER TABLE `app_categories` ADD `icon` VARCHAR(255) NULL DEFAULT NULL ",
                    'image' => "ALTER TABLE `app_categories` ADD `image` VARCHAR(255) NULL DEFAULT NULL ",
                    'description' => "ALTER TABLE `app_categories` ADD `description` TEXT NULL DEFAULT NULL ",
                    'created_at' => "ALTER TABLE `app_categories` ADD `created_at` TIMESTAMP NULL DEFAULT NULL ",
                    'updated_at' => "ALTER TABLE `app_categories` ADD `updated_at` TIMESTAMP NULL DEFAULT NULL ",
                ];
                foreach ($categoryColumns as $column => $sql) {
                    if (!Schema::hasColumn('app_categories', $column)) {
                        DB::statement($sql);
                    }
                }
            }

            if (!Schema::hasTable('app_visa_types')) {
                Schema::create('app_visa_types', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('category_id');
                    $table->string('name');
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable('app_jobs')) {
                Schema::create('app_jobs', function (Blueprint $table) {
                    $table->id();
                    $table->string('job_title');
                    $table->string('category_visa_type')->nullable();
                    $table->string('country_location')->nullable();
                    $table->unsignedInteger('number_of_vacancies')->default(1);
                    $table->text('job_description');
                    $table->text('requirements')->nullable();
                    $table->decimal('salary', 12, 2)->nullable();
                    $table->string('salary_currency', 10)->default('SAR');
                    $table->string('salary_period', 20)->default('month');
                    $table->string('working_hours')->nullable();
                    $table->text('working_days')->nullable();
                    $table->text('overtime_policy')->nullable();
                    $table->string('contract_duration')->nullable();
                    $table->boolean('accommodation_provided')->default(false);
                    $table->boolean('food_allowance_provided')->default(false);
                    $table->boolean('medical_insurance')->default(false);
                    $table->boolean('ticket_provided')->default(false);
                    $table->integer('paid_leave_days_after_one_year')->nullable();
                    $table->string('status', 20)->default('Active');
                    $table->timestamps();
                });
            } else {
                $jobColumns = [
                    'job_title' => "ALTER TABLE `app_jobs` ADD `job_title` VARCHAR(255) NULL DEFAULT NULL AFTER `id` ",
                    'category_visa_type' => "ALTER TABLE `app_jobs` ADD `category_visa_type` VARCHAR(255) NULL DEFAULT NULL ",
                    'country_location' => "ALTER TABLE `app_jobs` ADD `country_location` VARCHAR(255) NULL DEFAULT NULL ",
                    'number_of_vacancies' => "ALTER TABLE `app_jobs` ADD `number_of_vacancies` INT UNSIGNED NOT NULL DEFAULT 1 ",
                    'job_description' => "ALTER TABLE `app_jobs` ADD `job_description` TEXT NULL DEFAULT NULL ",
                    'requirements' => "ALTER TABLE `app_jobs` ADD `requirements` TEXT NULL DEFAULT NULL ",
                    'salary' => "ALTER TABLE `app_jobs` ADD `salary` DECIMAL(12,2) NULL DEFAULT NULL ",
                    'salary_currency' => "ALTER TABLE `app_jobs` ADD `salary_currency` VARCHAR(10) NOT NULL DEFAULT 'SAR' ",
                    'salary_period' => "ALTER TABLE `app_jobs` ADD `salary_period` VARCHAR(20) NOT NULL DEFAULT 'month' ",
                    'working_hours' => "ALTER TABLE `app_jobs` ADD `working_hours` VARCHAR(100) NULL DEFAULT NULL ",
                    'working_days' => "ALTER TABLE `app_jobs` ADD `working_days` TEXT NULL DEFAULT NULL ",
                    'overtime_policy' => "ALTER TABLE `app_jobs` ADD `overtime_policy` TEXT NULL DEFAULT NULL ",
                    'contract_duration' => "ALTER TABLE `app_jobs` ADD `contract_duration` VARCHAR(255) NULL DEFAULT NULL ",
                    'accommodation_provided' => "ALTER TABLE `app_jobs` ADD `accommodation_provided` TINYINT(1) NOT NULL DEFAULT 0 ",
                    'food_allowance_provided' => "ALTER TABLE `app_jobs` ADD `food_allowance_provided` TINYINT(1) NOT NULL DEFAULT 0 ",
                    'medical_insurance' => "ALTER TABLE `app_jobs` ADD `medical_insurance` TINYINT(1) NOT NULL DEFAULT 0 ",
                    'ticket_provided' => "ALTER TABLE `app_jobs` ADD `ticket_provided` TINYINT(1) NOT NULL DEFAULT 0 ",
                    'paid_leave_days_after_one_year' => "ALTER TABLE `app_jobs` ADD `paid_leave_days_after_one_year` INT NULL DEFAULT NULL ",
                    'status' => "ALTER TABLE `app_jobs` ADD `status` VARCHAR(20) NOT NULL DEFAULT 'Active' ",
                    'created_at' => "ALTER TABLE `app_jobs` ADD `created_at` TIMESTAMP NULL DEFAULT NULL ",
                    'updated_at' => "ALTER TABLE `app_jobs` ADD `updated_at` TIMESTAMP NULL DEFAULT NULL "
                ];
                foreach ($jobColumns as $column => $sql) {
                    if (!Schema::hasColumn('app_jobs', $column)) {
                        DB::statement($sql);
                    }
                }
            }

            if (!Schema::hasTable('app_visa_requests')) {
                Schema::create('app_visa_requests', function (Blueprint $table) {
                    $table->id();
                    $table->string('national_identity', 100)->nullable();
                    $table->string('first_name')->nullable();
                    $table->string('last_name')->nullable();
                    $table->string('email')->nullable();
                    $table->string('mobile_number')->nullable();
                    $table->string('dob')->nullable();
                    $table->string('gender')->nullable();
                    $table->string('nationality')->nullable();
                    $table->string('passport_number')->nullable();
                    $table->string('passport_expiry')->nullable();
                    $table->string('passport_photo')->nullable();
                    $table->string('destination_country')->nullable();
                    $table->string('visa_category')->nullable();
                    $table->string('visa_type')->nullable();
                    $table->text('selected_job_ids')->nullable();
                    $table->string('driving_license_available')->nullable();
                    $table->string('status')->default('Visa Application Submitted');
                    $table->decimal('visa_fee', 12, 2)->nullable();
                    $table->string('visa_fee_currency', 20)->nullable();
                    $table->string('bank_name')->nullable();
                    $table->string('account_number', 100)->nullable();
                    $table->string('account_holder_name')->nullable();
                    $table->string('agent_name')->nullable();
                    $table->string('agent_contact_number', 50)->nullable();
                    $table->string('payment_receipt')->nullable();
                    $table->timestamp('payment_receipt_uploaded_at')->nullable();
                    $table->date('preferred_date_start')->nullable();
                    $table->date('preferred_date_end')->nullable();
                    $table->string('preferred_airport', 10)->nullable();
                    $table->timestamp('flight_ticket_requested_at')->nullable();
                    $table->string('ticket_status', 50)->nullable();
                    $table->text('ticket_details')->nullable();
                    $table->timestamp('ticket_status_updated_at')->nullable();
                    $table->timestamps();
                });
            } else {
                if (Schema::hasColumn('app_visa_requests', 'apply_date') && !Schema::hasColumn('app_visa_requests', 'national_identity')) {
                    DB::statement("ALTER TABLE `app_visa_requests` CHANGE `apply_date` `national_identity` VARCHAR(100) NULL DEFAULT NULL");
                }

                $visaColumns = [
                    'national_identity' => "ALTER TABLE `app_visa_requests` ADD `national_identity` VARCHAR(100) NULL DEFAULT NULL AFTER `id` ",
                    'mobile_number' => "ALTER TABLE `app_visa_requests` ADD `mobile_number` VARCHAR(50) NULL DEFAULT NULL ",
                    'dob' => "ALTER TABLE `app_visa_requests` ADD `dob` VARCHAR(50) NULL DEFAULT NULL ",
                    'gender' => "ALTER TABLE `app_visa_requests` ADD `gender` VARCHAR(50) NULL DEFAULT NULL ",
                    'nationality' => "ALTER TABLE `app_visa_requests` ADD `nationality` VARCHAR(255) NULL DEFAULT NULL ",
                    'passport_number' => "ALTER TABLE `app_visa_requests` ADD `passport_number` VARCHAR(100) NULL DEFAULT NULL ",
                    'passport_expiry' => "ALTER TABLE `app_visa_requests` ADD `passport_expiry` VARCHAR(50) NULL DEFAULT NULL ",
                    'passport_photo' => "ALTER TABLE `app_visa_requests` ADD `passport_photo` VARCHAR(255) NULL DEFAULT NULL ",
                    'destination_country' => "ALTER TABLE `app_visa_requests` ADD `destination_country` VARCHAR(255) NULL DEFAULT NULL ",
                    'visa_category' => "ALTER TABLE `app_visa_requests` ADD `visa_category` VARCHAR(255) NULL DEFAULT NULL ",
                    'visa_type' => "ALTER TABLE `app_visa_requests` ADD `visa_type` VARCHAR(255) NULL DEFAULT NULL ",
                    'selected_job_ids' => "ALTER TABLE `app_visa_requests` ADD `selected_job_ids` TEXT NULL DEFAULT NULL ",
                    'driving_license_available' => "ALTER TABLE `app_visa_requests` ADD `driving_license_available` VARCHAR(10) NULL DEFAULT NULL ",
                    'visa_fee' => "ALTER TABLE `app_visa_requests` ADD `visa_fee` DECIMAL(12,2) NULL DEFAULT NULL ",
                    'visa_fee_currency' => "ALTER TABLE `app_visa_requests` ADD `visa_fee_currency` VARCHAR(20) NULL DEFAULT NULL ",
                    'bank_name' => "ALTER TABLE `app_visa_requests` ADD `bank_name` VARCHAR(255) NULL DEFAULT NULL ",
                    'account_number' => "ALTER TABLE `app_visa_requests` ADD `account_number` VARCHAR(100) NULL DEFAULT NULL ",
                    'account_holder_name' => "ALTER TABLE `app_visa_requests` ADD `account_holder_name` VARCHAR(255) NULL DEFAULT NULL ",
                    'agent_name' => "ALTER TABLE `app_visa_requests` ADD `agent_name` VARCHAR(255) NULL DEFAULT NULL ",
                    'agent_contact_number' => "ALTER TABLE `app_visa_requests` ADD `agent_contact_number` VARCHAR(50) NULL DEFAULT NULL ",
                    'payment_receipt' => "ALTER TABLE `app_visa_requests` ADD `payment_receipt` VARCHAR(255) NULL DEFAULT NULL ",
                    'payment_receipt_uploaded_at' => "ALTER TABLE `app_visa_requests` ADD `payment_receipt_uploaded_at` TIMESTAMP NULL DEFAULT NULL ",
                    'preferred_date_start' => "ALTER TABLE `app_visa_requests` ADD `preferred_date_start` DATE NULL DEFAULT NULL ",
                    'preferred_date_end' => "ALTER TABLE `app_visa_requests` ADD `preferred_date_end` DATE NULL DEFAULT NULL ",
                    'preferred_airport' => "ALTER TABLE `app_visa_requests` ADD `preferred_airport` VARCHAR(10) NULL DEFAULT NULL ",
                    'flight_ticket_requested_at' => "ALTER TABLE `app_visa_requests` ADD `flight_ticket_requested_at` TIMESTAMP NULL DEFAULT NULL ",
                    'ticket_status' => "ALTER TABLE `app_visa_requests` ADD `ticket_status` VARCHAR(50) NULL DEFAULT NULL ",
                    'ticket_details' => "ALTER TABLE `app_visa_requests` ADD `ticket_details` TEXT NULL DEFAULT NULL ",
                    'ticket_status_updated_at' => "ALTER TABLE `app_visa_requests` ADD `ticket_status_updated_at` TIMESTAMP NULL DEFAULT NULL "
                ];
                foreach ($visaColumns as $column => $sql) {
                    if (!Schema::hasColumn('app_visa_requests', $column)) {
                        DB::statement($sql);
                    }
                }
            }

            if (!Schema::hasTable('app_ticket_requests')) {
                Schema::create('app_ticket_requests', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('visa_request_id')->unique();
                    $table->date('preferred_date_start')->nullable();
                    $table->date('preferred_date_end')->nullable();
                    $table->string('preferred_airport', 10)->nullable();
                    $table->text('details')->nullable();
                    $table->string('status', 50)->default('Requested');
                    $table->timestamp('status_updated_at')->nullable();
                    $table->timestamp('requested_at')->nullable();
                    $table->timestamps();
                });
            }

            $ticketColumns = [
                'preferred_date_start' => "ALTER TABLE `app_ticket_requests` ADD `preferred_date_start` DATE NULL DEFAULT NULL ",
                'preferred_date_end' => "ALTER TABLE `app_ticket_requests` ADD `preferred_date_end` DATE NULL DEFAULT NULL ",
                'preferred_airport' => "ALTER TABLE `app_ticket_requests` ADD `preferred_airport` VARCHAR(10) NULL DEFAULT NULL ",
                'details' => "ALTER TABLE `app_ticket_requests` ADD `details` TEXT NULL DEFAULT NULL ",
                'status' => "ALTER TABLE `app_ticket_requests` ADD `status` VARCHAR(50) NOT NULL DEFAULT 'Requested' ",
                'status_updated_at' => "ALTER TABLE `app_ticket_requests` ADD `status_updated_at` TIMESTAMP NULL DEFAULT NULL ",
                'requested_at' => "ALTER TABLE `app_ticket_requests` ADD `requested_at` TIMESTAMP NULL DEFAULT NULL ",
                'created_at' => "ALTER TABLE `app_ticket_requests` ADD `created_at` TIMESTAMP NULL DEFAULT NULL ",
                'updated_at' => "ALTER TABLE `app_ticket_requests` ADD `updated_at` TIMESTAMP NULL DEFAULT NULL ",
            ];
            foreach ($ticketColumns as $column => $sql) {
                if (!Schema::hasColumn('app_ticket_requests', $column)) {
                    DB::statement($sql);
                }
            }

            $legacyTicketRequests = DB::table('app_visa_requests')
                ->whereNotNull('flight_ticket_requested_at')
                ->get();
            foreach ($legacyTicketRequests as $legacyTicketRequest) {
                DB::table('app_ticket_requests')->insertOrIgnore([
                    'visa_request_id' => $legacyTicketRequest->id,
                    'preferred_date_start' => $legacyTicketRequest->preferred_date_start,
                    'preferred_date_end' => $legacyTicketRequest->preferred_date_end,
                    'preferred_airport' => $legacyTicketRequest->preferred_airport,
                    'details' => $legacyTicketRequest->ticket_details,
                    'status' => $legacyTicketRequest->ticket_status ?: 'Requested',
                    'status_updated_at' => $legacyTicketRequest->ticket_status_updated_at ?: $legacyTicketRequest->flight_ticket_requested_at,
                    'requested_at' => $legacyTicketRequest->flight_ticket_requested_at,
                    'created_at' => $legacyTicketRequest->flight_ticket_requested_at,
                    'updated_at' => $legacyTicketRequest->ticket_status_updated_at ?: $legacyTicketRequest->flight_ticket_requested_at,
                ]);
            }

            if (!Schema::hasTable('app_bank_accounts')) {
                Schema::create('app_bank_accounts', function (Blueprint $table) {
                    $table->id();
                    $table->string('bank_name');
                    $table->string('account_name');
                    $table->string('account_number');
                    $table->string('iban')->nullable();
                    $table->string('branch')->nullable();
                    $table->string('swift_code')->nullable();
                    $table->string('currency', 10)->default('PKR');
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable('app_airports')) {
                Schema::create('app_airports', function (Blueprint $table) {
                    $table->id();
                    $table->string('code', 10)->unique();
                    $table->string('name')->unique();
                    $table->string('country')->nullable();
                    $table->timestamps();
                });

                $airports = [];
                foreach (self::DEFAULT_FLIGHT_AIRPORTS as $code => $name) {
                    $airports[] = [
                        'code' => $code,
                        'name' => $name,
                        'country' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('app_airports')->insert($airports);
            } elseif (!Schema::hasColumn('app_airports', 'country')) {
                Schema::table('app_airports', function (Blueprint $table) {
                    $table->string('country')->nullable()->after('name');
                });
            }
        } catch (\Exception $e) {}
    }

    public function showLogin()
    {
        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);

        try {
            $admin = DB::table('admins')->where('username', 'admin')->first();
            if ($admin && Hash::check($request->password, $admin->password)) {
                Session::put('admin_logged_in', true);
                return redirect()->route('admin.dashboard');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['password' => 'Database error: Ensure SQL files are imported.']);
        }
        return back()->withErrors(['password' => 'Password incorrect']);
    }

    public function dashboard()
    {
        $this->autoManageSettingsColumns();

        $settings = null;
        $countries = [];
        $nationalities = [];
        $categories = [];
        $jobs = [];
        $bankAccounts = [];
        $airports = [];
        $visa_requests = [];
        $ticket_requests = collect();
        $stats = [
            'total_countries' => 0,
            'total_categories' => 0,
            'total_visa_types' => 0,
            'total_jobs' => 0,
            'total_requests' => 0,
            'pending_requests' => 0,
            'approved_requests' => 0
        ];

        try {
            $settings = DB::table('app_settings')->where('id', 1)->first();
            $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
            $nationalities = DB::table('app_nationalities')->orderBy('name', 'asc')->get();
            $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();
            $jobs = DB::table('app_jobs')->orderBy('id', 'desc')->get();
            $bankAccounts = DB::table('app_bank_accounts')->orderBy('id', 'desc')->get();
            $airports = DB::table('app_airports')->orderBy('name')->get();

            foreach($categories as $cat) {
                $cat->types = DB::table('app_visa_types')->where('category_id', $cat->id)->get();
            }

            $visa_requests = DB::table('app_visa_requests')->orderBy('id', 'desc')->get();
            $ticket_requests = DB::table('app_ticket_requests')
                ->join('app_visa_requests', 'app_visa_requests.id', '=', 'app_ticket_requests.visa_request_id')
                ->select('app_ticket_requests.*', 'app_visa_requests.first_name', 'app_visa_requests.last_name', 'app_visa_requests.email', 'app_visa_requests.mobile_number', 'app_visa_requests.destination_country', 'app_visa_requests.visa_category', 'app_visa_requests.visa_type')
                ->orderByDesc('app_ticket_requests.requested_at')
                ->get();
            $jobsById = $jobs->keyBy('id');
            foreach ($visa_requests as $visaRequest) {
                $selectedJobIds = json_decode($visaRequest->selected_job_ids ?? '[]', true);
                $visaRequest->selected_job_titles = collect(is_array($selectedJobIds) ? $selectedJobIds : [])
                    ->map(fn ($jobId) => $jobsById->get($jobId)->job_title ?? null)
                    ->filter()
                    ->implode(', ');
            }

            $stats['total_countries'] = DB::table('app_countries')->count();
            $stats['total_categories'] = DB::table('app_categories')->count();
            $stats['total_visa_types'] = DB::table('app_visa_types')->count();
            $stats['total_jobs'] = DB::table('app_jobs')->count();
            $stats['total_requests'] = DB::table('app_visa_requests')->count();
            $stats['pending_requests'] = DB::table('app_visa_requests')->where('status', 'Visa Application Submitted')->count();
            $stats['approved_requests'] = DB::table('app_visa_requests')
                ->whereIn('status', ['Visa Approved from Embassy', 'Visa Approved', 'Payment Verified', 'Visa Issued', 'Flight Ticket Booked', 'approved'])
                ->count();
        } catch (\Exception $e) {}

        if (!$settings) {
            $settings = (object)[
                'app_name' => 'VisaBook',
                'tags' => 'Your Journey. Our Priority.',
                'app_icon' => '',
                'home_banner' => '',
                'inner_banner' => '',
                'phone' => '+92 300 123 4567',
                'email' => 'info@visabook.com',
                'address' => '123 Travel Street, Islamabad',
                'footer_text' => 'All rights reserved.',
                'description' => '',
                'active_theme' => 'travel'
            ];
        }

        return view('admin.dashboard', compact('settings', 'countries', 'nationalities', 'categories', 'jobs', 'bankAccounts', 'airports', 'visa_requests', 'ticket_requests', 'stats'));
    }

    public function publicJobs(Request $request)
    {
        $this->autoManageSettingsColumns();

        $settings = null;
        try {
            $settings = DB::table('app_settings')->where('id', 1)->first();
        } catch (\Exception $e) {}

        if (!$settings) {
            $settings = (object) [
                'app_name' => 'VisaBook',
                'tags' => 'Your Journey. Our Priority.',
                'app_icon' => '',
                'description' => 'Apply for your visa online with ease.'
            ];
        }

        $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
        $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();

        $selectedCountry = trim((string) $request->query('country', ''));
        $selectedCategory = trim((string) $request->query('category', ''));

        $jobsQuery = DB::table('app_jobs')->where('status', 'Active')->orderByDesc('id');

        if ($selectedCountry !== '') {
            $jobsQuery->whereRaw('LOWER(country_location) = ?', [mb_strtolower($selectedCountry)]);
        }

        if ($selectedCategory !== '') {
            $jobsQuery->whereRaw('LOWER(category_visa_type) = ?', [mb_strtolower($selectedCategory)]);
        }

        $jobs = $jobsQuery->get();

        return view('frontend.jobs', compact('settings', 'countries', 'categories', 'jobs', 'selectedCountry', 'selectedCategory'));
    }

    public function addJob(Request $request)
    {
        $this->autoManageSettingsColumns();
        $validated = $this->validateJobData($request);

        try {
            DB::table('app_jobs')->insert($this->jobDataFromValidated($request, $validated) + [
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.jobs.index')->with('success', 'Job posting added successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['job' => 'Unable to save the job posting.']);
        }
    }

    public function jobsIndex()
    {
        $pageData = $this->jobAdminPageData();
        $jobs = DB::table('app_jobs')->orderByDesc('id')->get();

        return view('admin.jobs.index', array_merge($pageData, compact('jobs')));
    }

    public function createJob()
    {
        $pageData = $this->jobAdminPageData();
        $job = null;
        $selectedWorkingDays = [];

        return view('admin.jobs.form', array_merge($pageData, compact('job', 'selectedWorkingDays')));
    }

    public function editJob($id)
    {
        $pageData = $this->jobAdminPageData();
        $job = DB::table('app_jobs')->where('id', $id)->first();
        if (!$job) {
            abort(404);
        }
        $selectedWorkingDays = json_decode($job->working_days ?? '[]', true) ?: [];

        return view('admin.jobs.form', array_merge($pageData, compact('job', 'selectedWorkingDays')));
    }

    public function updateJob(Request $request, $id)
    {
        $this->autoManageSettingsColumns();
        $validated = $this->validateJobData($request);
        $job = DB::table('app_jobs')->where('id', $id)->first();
        if (!$job) {
            abort(404);
        }

        try {
            DB::table('app_jobs')->where('id', $id)->update($this->jobDataFromValidated($request, $validated) + [
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.jobs.index')->with('success', 'Job posting updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['job' => 'Unable to update the job posting.']);
        }
    }

    private function jobAdminPageData(): array
    {
        $this->autoManageSettingsColumns();
        $settings = DB::table('app_settings')->where('id', 1)->first() ?: (object) ['app_name' => 'VisaBook', 'app_icon' => ''];
        $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();
        $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
        foreach ($categories as $category) {
            $category->types = DB::table('app_visa_types')->where('category_id', $category->id)->get();
        }

        return compact('settings', 'categories', 'countries');
    }

    private function validateJobData(Request $request): array
    {
        return $request->validate([
            'job_title' => 'required|string|max:255',
            'category_visa_type' => 'required|string|max:255',
            'country_location' => 'required|string|max:255',
            'number_of_vacancies' => 'required|integer|min:1|max:100000',
            'job_description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'required|numeric|min:0|max:9999999999.99',
            'salary_currency' => 'required|in:SAR,USD,AED,QAR,KWD,BHD,OMR,PKR',
            'salary_period' => 'required|in:month,week,day',
            'working_hours' => 'required|string|max:100',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'overtime_policy' => 'required|string|max:1000',
            'contract_duration' => 'required|string|max:255',
            'accommodation_provided' => 'required|in:0,1',
            'food_allowance_provided' => 'required|in:0,1',
            'medical_insurance' => 'nullable|boolean',
            'ticket_provided' => 'nullable|boolean',
            'paid_leave_days_after_one_year' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive'
        ]);
    }

    private function jobDataFromValidated(Request $request, array $validated): array
    {
        return [
            'job_title' => trim($validated['job_title']),
            'category_visa_type' => trim($validated['category_visa_type']),
            'country_location' => trim($validated['country_location']),
            'number_of_vacancies' => (int) $validated['number_of_vacancies'],
            'job_description' => trim($validated['job_description']),
            'requirements' => trim($validated['requirements']),
            'salary' => $validated['salary'],
            'salary_currency' => $validated['salary_currency'],
            'salary_period' => $validated['salary_period'],
            'working_hours' => trim($validated['working_hours']),
            'working_days' => json_encode($validated['working_days']),
            'overtime_policy' => trim($validated['overtime_policy']),
            'contract_duration' => trim($validated['contract_duration']),
            'accommodation_provided' => (int) $validated['accommodation_provided'],
            'food_allowance_provided' => (int) $validated['food_allowance_provided'],
            'medical_insurance' => $request->boolean('medical_insurance'),
            'ticket_provided' => $request->boolean('ticket_provided'),
            'paid_leave_days_after_one_year' => $validated['paid_leave_days_after_one_year'] ?? null,
            'status' => $validated['status'],
        ];
    }

    public function deleteJob(Request $request)
    {
        $this->autoManageSettingsColumns();
        $request->validate(['id' => 'required|integer']);

        try {
            DB::table('app_jobs')->where('id', $request->id)->delete();
            return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['job' => 'Unable to delete the job posting.']);
        }
    }

    public function addBankAccount(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:100',
            'iban' => 'nullable|string|max:100',
            'branch' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:50',
            'currency' => 'required|string|max:10',
        ]);

        try {
            $data['created_at'] = now();
            $data['updated_at'] = now();
            DB::table('app_bank_accounts')->insert($data);

            return response()->json(['message' => 'Bank account added successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function editBankAccount($id)
    {
        $this->autoManageSettingsColumns();

        $bankAccount = DB::table('app_bank_accounts')->where('id', $id)->first();
        if (!$bankAccount) {
            abort(404);
        }

        $settings = DB::table('app_settings')->where('id', 1)->first();
        if (!$settings) {
            $settings = (object) ['app_name' => 'VisaBook', 'app_icon' => ''];
        }

        return view('admin.edit_bank_account', compact('bankAccount', 'settings'));
    }

    public function updateBankAccount(Request $request, $id)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:100',
            'iban' => 'nullable|string|max:100',
            'branch' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:50',
            'currency' => 'required|string|max:10',
        ]);

        $bankAccount = DB::table('app_bank_accounts')->where('id', $id)->first();
        if (!$bankAccount) {
            abort(404);
        }

        $data['updated_at'] = now();
        DB::table('app_bank_accounts')->where('id', $id)->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Bank account updated successfully.');
    }

    public function deleteBankAccount(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        try {
            DB::table('app_bank_accounts')->where('id', $request->id)->delete();
            return response()->json(['message' => 'Bank account deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function updateSettings(Request $request)
    {
        $this->autoManageSettingsColumns();

        $data = $request->only([
            'app_name', 'tags', 'phone', 'email', 'address', 'footer_text',
            'description', 'active_theme', 'app_icon', 'home_banner', 'inner_banner'
        ]);

        if ($request->hasFile('app_icon_file')) {
            $file = $request->file('app_icon_file');
            $fileName = 'app_icon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $data['app_icon'] = '/uploads/' . $fileName;
        }

        if ($request->hasFile('home_banner_file')) {
            $file = $request->file('home_banner_file');
            $fileName = 'home_banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $data['home_banner'] = '/uploads/' . $fileName;
        }

        if ($request->hasFile('inner_banner_file')) {
            $file = $request->file('inner_banner_file');
            $fileName = 'inner_banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $data['inner_banner'] = '/uploads/' . $fileName;
        }

        try {
            $data['updated_at'] = now();
            DB::table('app_settings')->updateOrInsert(['id' => 1], $data);
            return response()->json(['message' => 'Settings updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function editRequest($id)
    {
        $this->autoManageSettingsColumns();

        $visaRequest = DB::table('app_visa_requests')->where('id', $id)->first();
        if (!$visaRequest) {
            abort(404);
        }

        $settings = DB::table('app_settings')->where('id', 1)->first();
        $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
        $nationalities = DB::table('app_nationalities')->orderBy('name', 'asc')->get();
        $nationalityCurrency = DB::table('app_nationalities')->where('name', $visaRequest->nationality)->value('currency') ?? '';
        $visaCurrencies = $nationalities->pluck('currency')
            ->filter(fn ($currency) => !empty(trim($currency ?? '')))
            ->map(fn ($currency) => strtoupper(trim($currency)))
            ->unique()
            ->sort()
            ->values();
        $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();
        foreach ($categories as $category) {
            $category->types = DB::table('app_visa_types')->where('category_id', $category->id)->get();
        }

        return view('admin.edit_request', compact('visaRequest', 'settings', 'countries', 'nationalities', 'nationalityCurrency', 'visaCurrencies', 'categories'));
    }

    public function updateRequest(Request $request, $id)
    {
        $this->autoManageSettingsColumns();
        $data = $request->validate([
            'national_identity' => 'sometimes|nullable|string|max:100',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'mobile_number' => 'sometimes|required|string|max:50',
            'dob' => 'sometimes|nullable|string|max:50',
            'gender' => 'sometimes|required|in:male,female,other',
            'nationality' => 'sometimes|nullable|string|max:255',
            'passport_number' => 'sometimes|required|string|max:100',
            'passport_expiry' => 'sometimes|nullable|string|max:50',
            'destination_country' => 'sometimes|required|string|max:255',
            'visa_category' => 'sometimes|required|string|max:255',
            'visa_type' => 'sometimes|nullable|string|max:255',
            'driving_license_available' => 'sometimes|nullable|in:yes,no',
            'status' => 'required|in:' . implode(',', array_merge(self::VISA_STATUSES, self::LEGACY_VISA_STATUSES)),
            'agent_name' => 'required_if:status,Documents Verification|nullable|string|max:255',
            'agent_contact_number' => 'required_if:status,Documents Verification|nullable|string|max:50',
            'visa_fee' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|numeric|min:0',
            'visa_fee_currency' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:20',
            'bank_name' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:255',
            'account_number' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:100',
            'account_holder_name' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:255',
            'passport_photo_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if (($data['status'] ?? null) === 'Documents Verification') {
            $data['agent_name'] = trim((string) ($data['agent_name'] ?? ''));
            $data['agent_contact_number'] = trim((string) ($data['agent_contact_number'] ?? ''));
        }

        unset($data['passport_photo_file']);
        if ($request->hasFile('passport_photo_file')) {
            $file = $request->file('passport_photo_file');
            $fileName = 'passport_' . time() . '_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/passports'), $fileName);
            $data['passport_photo'] = '/uploads/passports/' . $fileName;
        }

        $existingRequest = DB::table('app_visa_requests')->where('id', $id)->first();
        if (!$existingRequest) {
            abort(404);
        }

        $data['updated_at'] = now();
        DB::table('app_visa_requests')->where('id', $id)->update($data);

        $updatedRequest = DB::table('app_visa_requests')->where('id', $id)->first();
        if ($existingRequest->status !== $updatedRequest->status) {
            $this->sendVisaStatusEmail($updatedRequest);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Visa request updated successfully.');
    }

    // Visa Request Submission
    public function submitVisaRequest(Request $request)
    {
        $this->autoManageSettingsColumns();

        $validated = $request->validate([
            'nationality' => 'required|string|max:255|exists:app_nationalities,name',
            'national_identity' => 'required|string|max:100',
            'selected_job_ids' => 'nullable|array',
            'selected_job_ids.*' => 'required|integer|exists:app_jobs,id',
            'driving_license_available' => 'nullable|in:yes,no',
        ]);

        $identityDigitLength = DB::table('app_nationalities')
            ->where('name', $validated['nationality'])
            ->value('id_number_length');
        if ($identityDigitLength) {
            $request->validate([
                'national_identity' => 'required|digits:' . (int) $identityDigitLength,
            ]);
        }

        $data = $request->except(['_token', 'passport_photo_file']);
        $selectedJobIds = collect($validated['selected_job_ids'] ?? [])->map(fn ($id) => (int) $id)->unique()->values()->all();
        $data['selected_job_ids'] = null;

        if ($selectedJobIds) {
            $allowedJobCategories = array_values(array_filter([
                trim((string) ($data['visa_type'] ?? '')),
                trim((string) ($data['visa_category'] ?? '')),
            ]));
            $matchingJobIds = DB::table('app_jobs')
                ->whereIn('id', $selectedJobIds)
                ->where('status', 'Active')
                ->whereRaw('LOWER(country_location) = ?', [mb_strtolower(trim((string) ($data['destination_country'] ?? '')))])
                ->whereIn('category_visa_type', $allowedJobCategories)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->all();

            if (count($matchingJobIds) !== count($selectedJobIds)) {
                return back()->withErrors(['selected_job_ids' => 'One or more selected jobs are no longer available for this country and visa type.'])->withInput();
            }

            $data['selected_job_ids'] = json_encode($selectedJobIds);
        }

        if (is_string($data['visa_type'] ?? null) && preg_match('/driver/i', $data['visa_type'])) {
            $request->validate(['driving_license_available' => 'required|in:yes,no']);
        }

        if ($request->hasFile('passport_photo_file')) {
            $file = $request->file('passport_photo_file');
            $fileName = 'passport_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/passports'), $fileName);
            $data['passport_photo'] = '/uploads/passports/' . $fileName;
        }

        try {
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $data['status'] = self::VISA_STATUSES[0];
            $requestId = DB::table('app_visa_requests')->insertGetId($data);
            $visaRequest = DB::table('app_visa_requests')->where('id', $requestId)->first();
            $this->sendVisaStatusEmail($visaRequest);

            return redirect()->route('travel.apply.success', $requestId);
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function applicationSuccess($id)
    {
        $this->autoManageSettingsColumns();
        $settings = getAppSettings();
        $visaRequest = DB::table('app_visa_requests')->where('id', $id)->first();

        if (!$visaRequest) {
            abort(404);
        }

        $ticketRequest = DB::table('app_ticket_requests')->where('visa_request_id', $id)->first();
        $countryPayment = DB::table('app_countries')
            ->where('name', $visaRequest->destination_country)
            ->first(['visa_fee', 'currency']);
        $visaFee = $visaRequest->visa_fee ?? $countryPayment->visa_fee ?? null;
        $visaFeeCurrency = $visaRequest->visa_fee_currency ?? $countryPayment->currency ?? 'PKR';
        $bankAccounts = DB::table('app_bank_accounts')->orderBy('bank_name')->get();
        $statusText = $this->visaStatusTitle($visaRequest->status);
        $statusMessage = $this->visaStatusMessage($visaRequest->status);
        $flightAirports = $this->getFlightAirports($visaRequest->nationality ?? null);

        return view('frontend.travel_success', compact('settings', 'visaRequest', 'ticketRequest', 'visaFee', 'visaFeeCurrency', 'bankAccounts', 'statusText', 'statusMessage', 'flightAirports'));
    }

    public function uploadPaymentReceipt(Request $request, $id)
    {
        $this->autoManageSettingsColumns();
        $validatedEmail = $request->validate(['email' => 'required|email|max:255']);

        $visaRequest = DB::table('app_visa_requests')
            ->where('id', $id)
            ->where('email', $validatedEmail['email'])
            ->first();
        if (!$visaRequest) {
            abort(404);
        }
        if (!$this->isVisaApproved($visaRequest)) {
            abort(403);
        }
        $returnToVerify = $request->input('return_to') === 'verify';
        if ($returnToVerify) {
            session()->flash('verified_status_request_id', (int) $id);
        }

        $request->validate([
            'payment_receipt' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $directory = public_path('uploads/payment_receipts');
        File::ensureDirectoryExists($directory);
        $file = $request->file('payment_receipt');
        $fileName = 'payment_receipt_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $fileName);

        DB::table('app_visa_requests')->where('id', $id)->update([
            'payment_receipt' => '/uploads/payment_receipts/' . $fileName,
            'payment_receipt_uploaded_at' => now(),
            'updated_at' => now(),
        ]);

        if ($returnToVerify) {
            return redirect()->route('travel.verify')->with('verified_status_request_id', (int) $id)->with('result_notice', 'Payment receipt uploaded successfully.');
        }

        return redirect()->route('travel.apply.success', $id)->with('result_notice', 'Payment receipt uploaded successfully.');
    }

    public function submitFlightTicketRequest(Request $request, $id)
    {
        $this->autoManageSettingsColumns();
        $validatedEmail = $request->validate(['email' => 'required|email|max:255']);
        $visaRequest = DB::table('app_visa_requests')
            ->where('id', $id)
            ->where('email', $validatedEmail['email'])
            ->first();
        if (!$visaRequest) {
            abort(404);
        }
        if (!$this->isVisaApproved($visaRequest)) {
            abort(403);
        }
        $validated = $request->validate([
            'preferred_date_start' => 'required|date|after_or_equal:today',
            'preferred_date_end' => 'required|date|after_or_equal:preferred_date_start',
            'preferred_airport' => 'required|exists:app_airports,code',
        ]);

        $ticketRequest = DB::table('app_ticket_requests')->where('visa_request_id', $id)->first();
        if ($ticketRequest) {
            return back()->withErrors(['ticket' => 'A ticket request has already been submitted for this application.'])->withInput();
        }

        $ticketRequestId = DB::table('app_ticket_requests')->insertGetId([
            'visa_request_id' => $id,
            'preferred_date_start' => $validated['preferred_date_start'],
            'preferred_date_end' => $validated['preferred_date_end'],
            'preferred_airport' => $validated['preferred_airport'],
            'details' => null,
            'status' => 'Requested',
            'status_updated_at' => now(),
            'requested_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ticketRequest = DB::table('app_ticket_requests')->where('id', $ticketRequestId)->first();
        $this->sendTicketBookingEmail($visaRequest, $ticketRequest);

        return redirect()->route('travel.apply.success', $id)->with('result_notice', 'Flight ticket request submitted successfully.');
    }

    public function updateTicketRequestStatus(Request $request)
    {
        $this->autoManageSettingsColumns();
        $validated = $request->validate([
            'id' => 'required|integer|exists:app_ticket_requests,id',
            'status' => 'required|in:' . implode(',', self::TICKET_STATUSES),
            'details' => 'nullable|string|max:10000',
        ]);

        try {
            $ticketRequest = DB::table('app_ticket_requests')->where('id', $validated['id'])->first();
            $visaRequest = DB::table('app_visa_requests')->where('id', $ticketRequest->visa_request_id)->first();
            $statusChanged = $ticketRequest->status !== $validated['status'];

            DB::table('app_ticket_requests')->where('id', $ticketRequest->id)->update([
                'status' => $validated['status'],
                'details' => $validated['details'] ?? null,
                'status_updated_at' => $statusChanged ? now() : $ticketRequest->status_updated_at,
                'updated_at' => now(),
            ]);

            $updatedTicketRequest = DB::table('app_ticket_requests')->where('id', $ticketRequest->id)->first();
            if ($visaRequest && $statusChanged) {
                $this->sendTicketStatusEmail($visaRequest, $updatedTicketRequest);
            }

            return response()->json(['message' => 'Ticket status updated.']);
        } catch (\Exception $e) {
            Log::error('Ticket request status update failed: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to update ticket status.'], 500);
        }
    }

    public function checkVisaStatus(Request $request)
    {
        $this->autoManageSettingsColumns();
        $settings = getAppSettings();
        $visaRequest = null;
        $ticketRequest = null;
        $visaFee = null;
        $visaFeeCurrency = null;
        $bankAccounts = collect();
        $statusError = null;
        $statusText = null;
        $statusMessage = null;

        if ($request->filled('reference') && $request->filled('email')) {
            $validated = $request->validate([
                'reference' => 'required|string|max:50',
                'email' => 'required|email|max:255',
            ]);

            $reference = preg_replace('/^V/i', '', trim($validated['reference']));
            $reference = ltrim($reference, '0');
            $reference = $reference === '' ? '0' : $reference;
            $visaRequest = DB::table('app_visa_requests')
                ->where('id', $reference)
                ->where('email', $validated['email'])
                ->first();

            if (!$visaRequest) {
                $statusError = 'No application was found with those details.';
            }
        } elseif (session()->has('verified_status_request_id')) {
            $visaRequest = DB::table('app_visa_requests')
                ->where('id', session()->pull('verified_status_request_id'))
                ->first();
        }

        if ($visaRequest) {
            $ticketRequest = DB::table('app_ticket_requests')->where('visa_request_id', $visaRequest->id)->first();
            $countryPayment = DB::table('app_countries')
                ->where('name', $visaRequest->destination_country)
                ->first(['visa_fee', 'currency']);
            $visaFee = $visaRequest->visa_fee ?? $countryPayment->visa_fee ?? null;
            $visaFeeCurrency = $visaRequest->visa_fee_currency ?? $countryPayment->currency ?? 'PKR';
            $bankAccounts = DB::table('app_bank_accounts')->orderBy('bank_name')->get();
            $statusText = $this->visaStatusTitle($visaRequest->status);
            $statusMessage = $this->visaStatusMessage($visaRequest->status);
        }

        $flightAirports = $this->getFlightAirports($visaRequest->nationality ?? null);
        return view('frontend.travel_verify', compact('settings', 'visaRequest', 'ticketRequest', 'visaFee', 'visaFeeCurrency', 'bankAccounts', 'statusError', 'statusText', 'statusMessage', 'flightAirports'));
    }

    private function isVisaApproved($visaRequest): bool
    {
        return in_array($visaRequest->status, ['Visa Approved from Embassy', 'Visa Approved', 'Payment Verified', 'Visa Issued', 'Flight Ticket Booked', 'approved'], true);
    }

    private function visaStatusTitle(?string $status): string
    {
        return match ($status) {
            'pending' => 'Visa Application Submitted',
            'processing' => 'Documents Verification',
            'Verification of Documents Successful' => 'Documents Verification Completed, Request Submitted to Embassy',
            'Visa Approved', 'approved', 'Fee Payment', 'Payment Verified', 'Visa Issued', 'Flight Ticket Booked' => 'Visa Approved from Embassy',
            'Visa Rejected - Document Verification Failed', 'Application Rejected', 'rejected' => 'Visa Rejected due to Documents Verification Failed',
            'Visa Rejected - Fee Not Paid' => 'Visa Rejected due to Non Payment of Fee',
            default => $status ?: self::VISA_STATUSES[0],
        };
    }

    private function visaStatusMessage(?string $status): string
    {
        return match ($status) {
            'Visa Application Submitted', 'pending' => 'Your visa application has been successfully submitted and is now under process.',
            'Documents Verification', 'processing' => 'To support your visa application, please send the required documents via WhatsApp to our official agent.',
            'Documents Verification Completed, Request Submitted to Embassy', 'Verification of Documents Successful' => 'Your document verification has been completed, and your visa application has been sent to the Embassy for approval.',
            'Visa Approved from Embassy', 'Visa Approved', 'approved' => 'We are pleased to inform you that your visa has been approved by the Embassy.',
            'Fee Payment' => 'Your visa application has reached the fee payment stage. Please complete the required payment and upload the payment proof.',
            'Payment Verified' => 'Your visa processing fee payment has been successfully verified. Your visa issuance process will now proceed to the next stage.',
            'Visa Issued' => 'Your visa has been successfully issued. Please log in to view or download your visa document.',
            'Flight Ticket Booked' => 'Your flight ticket has been successfully booked. Please log in to view your flight schedule and ticket details.',
            'Visa Rejected due to Documents Verification Failed', 'Visa Rejected - Document Verification Failed', 'Application Rejected', 'rejected' => 'Your visa application has been rejected as the submitted documents did not pass the required verification process.',
            'Visa Rejected due to Non Payment of Fee', 'Visa Rejected - Fee Not Paid' => 'Your visa application has been rejected because the required visa processing fee was not paid within the specified time.',
            default => 'Please review your application details below for the latest status.',
        };
    }

    private function sendVisaStatusEmail($visaRequest)
    {
        if (!$visaRequest || empty($visaRequest->email)) {
            return;
        }

        try {
            $contactNumber = DB::table('app_settings')->where('id', 1)->value('phone') ?: 'Please contact our support team';
            $agentName = trim((string) ($visaRequest->agent_name ?? '')) ?: 'Rainbow Travels & Tours';
            $agentContactNumber = trim((string) ($visaRequest->agent_contact_number ?? '')) ?: $contactNumber;
            $signature = "Regards,\nRainbow Travels & Tours";
            $email = match ($visaRequest->status) {
                'Visa Application Submitted' => [
                    'Visa Application Submitted',
                    "Dear Applicant,\n\nYour visa application has been successfully submitted and is now under process.\n\n{$signature}",
                ],
                'Documents Verification' => [
                    'Documents Required for Verification',
                    "Dear Applicant,\n\nTo support your visa application, please send the following documents via WhatsApp to our official agent:\n\n- Passport\n- NIC / Aadhaar Card\n\nOfficial Agent Name: {$agentName}\nContact Number: {$agentContactNumber}\n\nPlease ensure that the documents are clear and complete.\n\n{$signature}",
                ],
                'Documents Verification Completed, Request Submitted to Embassy', 'Verification of Documents Successful' => [
                    'Visa Sent to Embassy for Approval',
                    "Dear Applicant,\n\nYour document verification has been completed, and your visa application has been sent to the Embassy for approval.\n\n{$signature}",
                ],
                'Visa Approved from Embassy', 'Visa Approved', 'approved' => [
                    'Visa Approved by Embassy',
                    "Dear Applicant,\n\nWe are pleased to inform you that your visa has been approved by the Embassy.\n\n{$signature}",
                ],
                'Visa Rejected due to Documents Verification Failed', 'Visa Rejected - Document Verification Failed', 'Application Rejected', 'rejected' => [
                    'Visa Rejected due to Documents Verification Failed',
                    "Dear Applicant,\n\nYour visa application has been rejected as the submitted documents did not pass the required verification process.\n\n{$signature}",
                ],
                'Visa Rejected due to Non Payment of Fee', 'Visa Rejected - Fee Not Paid' => [
                    'Visa Rejected due to Non Payment of Fee',
                    "Dear Applicant,\n\nYour visa application has been rejected because the required visa processing fee was not paid within the specified time.\n\n{$signature}",
                ],
                'Fee Payment' => [
                    'Visa Processing Fee Payment Required',
                    "Dear Customer,\n\nYour visa application has reached the fee payment stage.\n\nCurrent Status: Fee Payment\n\nPlease complete the required visa processing fee payment and upload the payment proof through your account.\n\nBest Regards,\nVisa Processing Team",
                ],
                'Payment Verified' => [
                    'Payment Verified',
                    "Dear Customer,\n\nYour visa processing fee payment has been successfully verified.\n\nCurrent Status: Payment Verified\n\nYour visa issuance process will now proceed to the next stage.\n\nBest Regards,\nVisa Processing Team",
                ],
                'Visa Issued' => [
                    'Visa Issued Successfully',
                    "Dear Customer,\n\nCongratulations! Your visa has been successfully issued.\n\nCurrent Status: Visa Issued\n\nPlease log in to your account to view or download your visa document.\n\nBest Regards,\nVisa Processing Team",
                ],
                'Flight Ticket Booked' => [
                    'Flight Ticket Booked',
                    "Dear Customer,\n\nYour flight ticket has been successfully booked.\n\nCurrent Status: Flight Ticket Booked\n\nPlease log in to your account to view your flight schedule and ticket details.\n\nBest Regards,\nTravel & Visa Processing Team",
                ],
                default => null,
            };

            if ($email === null) {
                return;
            }

            Mail::raw($email[1], function ($message) use ($visaRequest, $email) {
                $message->to($visaRequest->email)->subject($email[0]);
            });
        } catch (\Exception $e) {
            Log::error('Visa status email failed: ' . $e->getMessage());
        }
    }

    private function sendTicketBookingEmail($visaRequest, $ticketRequest): void
    {
        if (!$visaRequest || !$ticketRequest || empty($visaRequest->email)) {
            return;
        }

        try {
            $airportName = $this->getFlightAirports()[$ticketRequest->preferred_airport] ?? $ticketRequest->preferred_airport;
            $body = "Dear {$visaRequest->first_name},\n\n" .
                "We received your flight ticket booking request.\n\n" .
                "Preferred dates: {$ticketRequest->preferred_date_start} to {$ticketRequest->preferred_date_end}\n" .
                "Preferred airport: {$airportName}\n" .
                "Ticket status: Requested\n\n" .
                "We will email you when your ticket status changes.\n\n" .
                "Best Regards,\nTravel & Visa Processing Team";

            Mail::raw($body, function ($message) use ($visaRequest) {
                $message->to($visaRequest->email)->subject('Flight Ticket Request Received');
            });
        } catch (\Exception $e) {
            Log::error('Flight ticket request email failed: ' . $e->getMessage());
        }
    }

    private function sendTicketStatusEmail($visaRequest, $ticketRequest): void
    {
        if (!$visaRequest || !$ticketRequest || empty($visaRequest->email)) {
            return;
        }

        try {
            $body = "Dear {$visaRequest->first_name},\n\n" .
                "Your flight ticket status has been updated to: {$ticketRequest->status}.\n\n" .
                "Ticket details:\n" . ($ticketRequest->details ?: 'Details will be provided soon.') . "\n\n" .
                "Best Regards,\nTravel & Visa Processing Team";

            Mail::raw($body, function ($message) use ($visaRequest) {
                $message->to($visaRequest->email)->subject('Flight Ticket Status Updated');
            });
        } catch (\Exception $e) {
            Log::error('Flight ticket status email failed: ' . $e->getMessage());
        }
    }

    public function deleteRequest(Request $request)
    {
        $request->validate(['id' => 'required|integer|exists:app_visa_requests,id']);

        try {
            DB::table('app_visa_requests')->where('id', $request->id)->delete();
            return response()->json(['message' => 'Request deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function updateRequestStatus(Request $request)
    {
        $this->autoManageSettingsColumns();
        $validated = $request->validate([
            'id' => 'required|integer|exists:app_visa_requests,id',
            'status' => 'required|in:' . implode(',', array_merge(self::VISA_STATUSES, self::LEGACY_VISA_STATUSES)),
            'agent_name' => 'required_if:status,Documents Verification|nullable|string|max:255',
            'agent_contact_number' => 'required_if:status,Documents Verification|nullable|string|max:50',
            'visa_fee' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|numeric|min:0',
            'visa_fee_currency' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:20',
            'bank_name' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:255',
            'account_number' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:100',
            'account_holder_name' => 'required_if:status,Visa Approved from Embassy|required_if:status,Visa Approved|nullable|string|max:255',
        ]);

        try {
            $existingRequest = DB::table('app_visa_requests')->where('id', $validated['id'])->first();
            $updateData = [
                'status' => $validated['status'],
                'updated_at' => now()
            ];
            if ($validated['status'] === 'Documents Verification') {
                $updateData['agent_name'] = trim((string) ($validated['agent_name'] ?? ''));
                $updateData['agent_contact_number'] = trim((string) ($validated['agent_contact_number'] ?? ''));
            } elseif (isset($existingRequest->agent_name) || isset($existingRequest->agent_contact_number)) {
                $updateData['agent_name'] = $existingRequest->agent_name ?? null;
                $updateData['agent_contact_number'] = $existingRequest->agent_contact_number ?? null;
            }
            if (in_array($validated['status'], ['Visa Approved from Embassy', 'Visa Approved'], true)) {
                $updateData['visa_fee'] = $validated['visa_fee'];
                $updateData['visa_fee_currency'] = strtoupper($validated['visa_fee_currency']);
                $updateData['bank_name'] = trim($validated['bank_name']);
                $updateData['account_number'] = trim($validated['account_number']);
                $updateData['account_holder_name'] = trim($validated['account_holder_name']);
            }
            DB::table('app_visa_requests')->where('id', $validated['id'])->update($updateData);
            $updatedRequest = DB::table('app_visa_requests')->where('id', $validated['id'])->first();
            if ($existingRequest && $updatedRequest && $existingRequest->status !== $updatedRequest->status) {
                $this->sendVisaStatusEmail($updatedRequest);
            }
            return response()->json(['message' => 'Status updated']);
        } catch (\Exception $e) {
            Log::error('Visa request status update failed', [
                'request_id' => $validated['id'],
                'status' => $validated['status'],
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function addCountry(Request $request)
    {
        $this->autoManageSettingsColumns();

        $request->validate([
            'name' => 'required|string|max:255',
            'currency' => 'nullable|array',
            'currency.*' => 'nullable|string|max:20',
        ]);

        $currencies = collect($request->input('currency', []))
            ->map(fn ($currency) => strtoupper(trim($currency)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $flagUrl = null;
        if ($request->hasFile('flag_file')) {
            $file = $request->file('flag_file');
            $fileName = 'flag_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/flags'), $fileName);
            $flagUrl = '/uploads/flags/' . $fileName;
        }

        try {
            DB::table('app_countries')->insert([
                'name' => $request->name,
                'visa_fee' => null,
                'currency' => $currencies[0] ?? null,
                'visa_fee_details' => null,
                'currencies' => json_encode($currencies),
                'flag' => $flagUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Country added']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function deleteCountry(Request $request)
    {
        try {
            DB::table('app_countries')->where('id', $request->id)->delete();
            return response()->json(['message' => 'Country deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function addNationality(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:app_nationalities,name',
            'currency' => 'nullable|string|max:20',
            'phone_code' => 'nullable|string|max:20',
            'id_number_length' => 'nullable|integer|min:1|max:30',
        ]);

        try {
            DB::table('app_nationalities')->insert([
                'name' => trim($data['name']),
                'currency' => !empty($data['currency']) ? trim($data['currency']) : null,
                'phone_code' => !empty($data['phone_code']) ? trim($data['phone_code']) : null,
                'id_number_length' => $data['id_number_length'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Nationality added']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function deleteNationality(Request $request)
    {
        try {
            DB::table('app_nationalities')->where('id', $request->id)->delete();
            return response()->json(['message' => 'Nationality deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function addAirport(Request $request)
    {
        $this->autoManageSettingsColumns();
        $data = $request->validate([
            'code' => 'required|string|max:10|alpha_num|unique:app_airports,code',
            'name' => 'required|string|max:255|unique:app_airports,name',
            'country' => 'required|string|max:255|exists:app_nationalities,name',
        ]);

        DB::table('app_airports')->insert([
            'code' => strtoupper($data['code']),
            'name' => trim($data['name']),
            'country' => trim($data['country']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Airport added successfully.']);
    }

    public function deleteAirport(Request $request)
    {
        $this->autoManageSettingsColumns();
        $data = $request->validate([
            'id' => 'required|integer|exists:app_airports,id',
        ]);
        $airport = DB::table('app_airports')->where('id', $data['id'])->first();

        if (DB::table('app_visa_requests')->where('preferred_airport', $airport->code)->exists()) {
            return response()->json(['message' => 'This airport is assigned to an existing visa request.'], 422);
        }

        DB::table('app_airports')->where('id', $data['id'])->delete();
        return response()->json(['message' => 'Airport deleted successfully.']);
    }

    public function addCategory(Request $request)
    {
        $this->autoManageSettingsColumns();
        $request->validate(['name' => 'required']);
        $imageUrl = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'cat_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $imageUrl = '/uploads/categories/' . $fileName;
        }

        try {
            DB::table('app_categories')->insert([
                'name' => $request->name,
                'icon' => $request->icon ?? 'fas fa-suitcase-rolling',
                'description' => $request->description,
                'image' => $imageUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Category added']);
        } catch (\Exception $e) {
            Log::error('Failed to add category: ' . $e->getMessage());
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function deleteCategory(Request $request)
    {
        try {
            DB::table('app_categories')->where('id', $request->id)->delete();
            DB::table('app_visa_types')->where('category_id', $request->id)->delete();
            return response()->json(['message' => 'Category deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function addVisaType(Request $request)
    {
        $visaInput = $request->names ?? $request->name;
        if (!$visaInput || !$request->category_id) {
            return response()->json(['message' => 'Required fields missing'], 422);
        }
        $names = explode(',', $visaInput);
        $inserted = 0;
        try {
            foreach ($names as $name) {
                $trimmedName = trim($name);
                if (!empty($trimmedName)) {
                    DB::table('app_visa_types')->insert([
                        'category_id' => $request->category_id,
                        'name' => $trimmedName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $inserted++;
                }
            }
            return response()->json(['message' => $inserted . ' Visa types added']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function deleteVisaType(Request $request)
    {
        try {
            DB::table('app_visa_types')->where('id', $request->id)->delete();
            return response()->json(['message' => 'Visa type deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function getVisaTypesByCategory($categoryId)
    {
        try {
            $types = DB::table('app_visa_types')->where('category_id', $categoryId)->get();
            return response()->json($types);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate(['current_password' => 'required', 'new_password' => 'required|min:4|confirmed']);
        try {
            $admin = DB::table('admins')->where('username', 'admin')->first();
            if (!$admin || !Hash::check($request->current_password, $admin->password)) {
                return response()->json(['message' => 'Current password incorrect'], 422);
            }
            DB::table('admins')->where('username', 'admin')->update(['password' => Hash::make($request->new_password)]);
            return response()->json(['message' => 'Password updated']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
