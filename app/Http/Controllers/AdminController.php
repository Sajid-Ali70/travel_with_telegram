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
        $stats = [
            'total_countries' => 0,
            'pending_requests' => 0,
            'approved_requests' => 0
        ];

        try {
            $settings = DB::table('app_settings')->where('id', 1)->first();
            $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();

            $stats['total_countries'] = DB::table('app_countries')->count();
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

        return view('admin.dashboard', compact('settings', 'countries', 'stats'));
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

    public function removeScreenshot(Request $request)
    {
        return response()->json(['message' => 'Feature removed']);
    }

    private function convertDriveLink($url)
    {
        if (strpos($url, 'drive.google.com') !== false) {
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return "https://drive.google.com/uc?export=download&id=" . $matches[1];
            }
            if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return "https://drive.google.com/uc?export=download&id=" . $matches[1];
            }
        }
        return $url;
    }

    public function updateApkUrl(Request $request)
    {
        $request->validate(['apk_url' => 'required']);
        $apkUrl = $this->convertDriveLink($request->apk_url);

        try {
            DB::table('app_settings')->updateOrInsert(['id' => 1], [
                'apk_url' => $apkUrl,
                'updated_at' => now()
            ]);
            return response()->json(['message' => 'URL updated successfully', 'url' => $apkUrl]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error'], 500);
        }
    }

    public function uploadApk(Request $request)
    {
        if (!$request->hasFile('apk_file')) {
            return response()->json(['message' => 'No file uploaded'], 400);
        }

        $file = $request->file('apk_file');
        try {
            $apkDir = public_path('uploads/apk');
            if (!File::isDirectory($apkDir)) File::makeDirectory($apkDir, 0777, true, true);

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($apkDir, $fileName);
            $apkUrl = '/uploads/apk/' . $fileName;

            DB::table('app_settings')->updateOrInsert(['id' => 1], [
                'apk_url' => $apkUrl,
                'updated_at' => now()
            ]);

            return response()->json(['message' => 'File uploaded successfully', 'url' => $apkUrl]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Upload error'], 500);
        }
    }

    public function addCountry(Request $request)
    {
        $request->validate(['name' => 'required']);
        try {
            DB::table('app_countries')->insert([
                'name' => $request->name,
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
