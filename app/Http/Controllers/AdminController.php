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
                    $table->string('flag')->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable('app_nationalities')) {
                Schema::create('app_nationalities', function (Blueprint $table) {
                    $table->id();
                    $table->string('name')->unique();
                    $table->timestamps();
                });
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
            }

            if (!Schema::hasTable('app_visa_types')) {
                Schema::create('app_visa_types', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('category_id');
                    $table->string('name');
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable('app_visa_requests')) {
                Schema::create('app_visa_requests', function (Blueprint $table) {
                    $table->id();
                    $table->date('apply_date')->nullable();
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
                    $table->string('status')->default('pending');
                    $table->timestamps();
                });
            } else {
                $visaColumns = [
                    'apply_date' => "ALTER TABLE `app_visa_requests` ADD `apply_date` DATE NULL DEFAULT NULL AFTER `id` ",
                    'mobile_number' => "ALTER TABLE `app_visa_requests` ADD `mobile_number` VARCHAR(50) NULL DEFAULT NULL ",
                    'dob' => "ALTER TABLE `app_visa_requests` ADD `dob` VARCHAR(50) NULL DEFAULT NULL ",
                    'gender' => "ALTER TABLE `app_visa_requests` ADD `gender` VARCHAR(50) NULL DEFAULT NULL ",
                    'nationality' => "ALTER TABLE `app_visa_requests` ADD `nationality` VARCHAR(255) NULL DEFAULT NULL ",
                    'passport_number' => "ALTER TABLE `app_visa_requests` ADD `passport_number` VARCHAR(100) NULL DEFAULT NULL ",
                    'passport_expiry' => "ALTER TABLE `app_visa_requests` ADD `passport_expiry` VARCHAR(50) NULL DEFAULT NULL ",
                    'passport_photo' => "ALTER TABLE `app_visa_requests` ADD `passport_photo` VARCHAR(255) NULL DEFAULT NULL ",
                    'destination_country' => "ALTER TABLE `app_visa_requests` ADD `destination_country` VARCHAR(255) NULL DEFAULT NULL ",
                    'visa_category' => "ALTER TABLE `app_visa_requests` ADD `visa_category` VARCHAR(255) NULL DEFAULT NULL ",
                    'visa_type' => "ALTER TABLE `app_visa_requests` ADD `visa_type` VARCHAR(255) NULL DEFAULT NULL "
                ];
                foreach ($visaColumns as $column => $sql) {
                    if (!Schema::hasColumn('app_visa_requests', $column)) {
                        DB::statement($sql);
                    }
                }
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
        $visa_requests = [];
        $stats = [
            'total_countries' => 0,
            'total_categories' => 0,
            'total_visa_types' => 0,
            'total_requests' => 0,
            'pending_requests' => 0,
            'approved_requests' => 0
        ];

        try {
            $settings = DB::table('app_settings')->where('id', 1)->first();
            $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
            $nationalities = DB::table('app_nationalities')->orderBy('name', 'asc')->get();
            $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();

            foreach($categories as $cat) {
                $cat->types = DB::table('app_visa_types')->where('category_id', $cat->id)->get();
            }

            $visa_requests = DB::table('app_visa_requests')->orderBy('id', 'desc')->get();

            $stats['total_countries'] = DB::table('app_countries')->count();
            $stats['total_categories'] = DB::table('app_categories')->count();
            $stats['total_visa_types'] = DB::table('app_visa_types')->count();
            $stats['total_requests'] = DB::table('app_visa_requests')->count();
            $stats['pending_requests'] = DB::table('app_visa_requests')->where('status', 'pending')->count();
            $stats['approved_requests'] = DB::table('app_visa_requests')->where('status', 'approved')->count();
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

        return view('admin.dashboard', compact('settings', 'countries', 'nationalities', 'categories', 'visa_requests', 'stats'));
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
        $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();
        foreach ($categories as $category) {
            $category->types = DB::table('app_visa_types')->where('category_id', $category->id)->get();
        }

        return view('admin.edit_request', compact('visaRequest', 'settings', 'countries', 'nationalities', 'categories'));
    }

    public function updateRequest(Request $request, $id)
    {
        $data = $request->validate([
            'apply_date' => 'nullable|date',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:50',
            'dob' => 'nullable|string|max:50',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'nullable|string|max:255',
            'passport_number' => 'required|string|max:100',
            'passport_expiry' => 'nullable|string|max:50',
            'destination_country' => 'required|string|max:255',
            'visa_category' => 'required|string|max:255',
            'visa_type' => 'nullable|string|max:255',
            'status' => 'required|in:pending,processing,approved,rejected',
            'passport_photo_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

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

        $request->validate([
            'nationality' => 'required|string|max:255|exists:app_nationalities,name',
        ]);

        $data = $request->except(['_token', 'passport_photo_file']);

        if ($request->hasFile('passport_photo_file')) {
            $file = $request->file('passport_photo_file');
            $fileName = 'passport_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/passports'), $fileName);
            $data['passport_photo'] = '/uploads/passports/' . $fileName;
        }

        try {
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $requestId = DB::table('app_visa_requests')->insertGetId($data);
            $visaRequest = DB::table('app_visa_requests')->where('id', $requestId)->first();
            $this->sendApplicationReceivedEmail($visaRequest);

            return redirect()->route('travel.apply.success', $requestId);
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function applicationSuccess($id)
    {
        $settings = getAppSettings();
        $visaRequest = DB::table('app_visa_requests')->where('id', $id)->first();

        if (!$visaRequest) {
            abort(404);
        }

        return view('frontend.travel_success', compact('settings', 'visaRequest'));
    }

    public function checkVisaStatus(Request $request)
    {
        $settings = getAppSettings();
        $visaRequest = null;
        $statusError = null;

        if ($request->filled('reference') || $request->filled('email')) {
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
        }

        return view('frontend.travel_verify', compact('settings', 'visaRequest', 'statusError'));
    }

    private function sendApplicationReceivedEmail($visaRequest)
    {
        if (!$visaRequest || empty($visaRequest->email)) {
            return;
        }

        try {
            $reference = $this->formatVisaReference($visaRequest->id);
            Mail::raw(
                "Hello {$visaRequest->first_name},\n\n" .
                "APPLICATION SENT\n\n" .
                "Your visa application has been sent successfully.\n\n" .
                "Reference number: {$reference}\n" .
                "Destination: {$visaRequest->destination_country}\n" .
                "Status: Pending\n\n" .
                "You can use this reference number and your email address to check your application status.\n\n" .
                "Regards,\nVisa Support Team",
                function ($message) use ($visaRequest, $reference) {
                    $message->to($visaRequest->email)
                    ->subject('APPLICATION SENT - ' . $reference);
                }
            );
        } catch (\Exception $e) {
            Log::error('Visa application email failed: ' . $e->getMessage());
        }
    }

    private function sendVisaStatusEmail($visaRequest)
    {
        if (!$visaRequest || empty($visaRequest->email)) {
            return;
        }

        try {
            $reference = $this->formatVisaReference($visaRequest->id);
            Mail::raw(
                "Hello {$visaRequest->first_name},\n\n" .
                "The status of your visa application has been updated.\n\n" .
                "Reference number: {$reference}\n" .
                "Destination: {$visaRequest->destination_country}\n" .
                "New status: " . ucfirst($visaRequest->status) . "\n\n" .
                "Use your reference number and email address on the Check Visa Status page for the latest details.\n\n" .
                "Regards,\nVisa Support Team",
                function ($message) use ($visaRequest, $reference) {
                    $message->to($visaRequest->email)
                    ->subject('Visa application status updated - ' . $reference);
                }
            );
        } catch (\Exception $e) {
            Log::error('Visa status email failed: ' . $e->getMessage());
        }
    }

    private function formatVisaReference($id)
    {
        return 'V' . str_pad((string) $id, 6, '0', STR_PAD_LEFT);
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
        try {
            $existingRequest = DB::table('app_visa_requests')->where('id', $request->id)->first();
            DB::table('app_visa_requests')->where('id', $request->id)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            $updatedRequest = DB::table('app_visa_requests')->where('id', $request->id)->first();
            if ($existingRequest && $updatedRequest && $existingRequest->status !== $updatedRequest->status) {
                $this->sendVisaStatusEmail($updatedRequest);
            }
            return response()->json(['message' => 'Status updated']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function addCountry(Request $request)
    {
        $request->validate(['name' => 'required']);
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
        $data = $request->validate(['name' => 'required|string|max:255|unique:app_nationalities,name']);

        try {
            DB::table('app_nationalities')->insert([
                'name' => $data['name'],
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

    public function addCategory(Request $request)
    {
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
