<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
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
            } else {
                if (!Schema::hasColumn('app_countries', 'flag')) {
                    DB::statement("ALTER TABLE `app_countries` ADD `flag` VARCHAR(255) NULL DEFAULT NULL AFTER `name` ");
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
                    $table->string('first_name')->nullable();
                    $table->string('last_name')->nullable();
                    $table->string('email')->nullable();
                    $table->string('status')->default('pending'); // pending, approved, rejected
                    $table->timestamps();
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
        $categories = [];
        $visa_types = [];
        $stats = [
            'total_countries' => 0,
            'total_categories' => 0,
            'total_visa_types' => 0,
            'pending_requests' => 0,
            'approved_requests' => 0
        ];

        try {
            $settings = DB::table('app_settings')->where('id', 1)->first();
            $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
            $categories = DB::table('app_categories')->orderBy('id', 'desc')->get();

            $visa_types = DB::table('app_visa_types')
                ->join('app_categories', 'app_visa_types.category_id', '=', 'app_categories.id')
                ->select('app_visa_types.*', 'app_categories.name as category_name')
                ->orderBy('category_id', 'asc')
                ->get();

            $stats['total_countries'] = DB::table('app_countries')->count();
            $stats['total_categories'] = DB::table('app_categories')->count();
            $stats['total_visa_types'] = DB::table('app_visa_types')->count();
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

        return view('admin.dashboard', compact('settings', 'countries', 'categories', 'visa_types', 'stats'));
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
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
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
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
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
        $request->validate(['names' => 'required', 'category_id' => 'required']);

        $names = explode(',', $request->names);
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
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
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
