<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

function getAppSettings() {
    $settings = null;
    try {
        $settings = DB::table('app_settings')->where('id', 1)->first();
    } catch (\Exception $e) {}

    if (!$settings) {
        $settings = (object)[
            'app_name' => 'Rainbow Travels & Tours',
            'developer' => 'Rainbow Travels',
            'category' => 'Travel',
            'tags' => 'Visa Services · Tours',
            'app_icon' => '',
            'rating_score' => '4.8',
            'reviews_count' => '5K reviews',
            'downloads_count' => '10K+',
            'content_rating' => 'Rated for 3+',
            'updated_date' => 'Oct 20, 2023',
            'description' => 'Journey Beyond Boundaries with Rainbow Travels & Tours.',
            'release_notes' => '• Improved visa tracking\r\n• Bug fixes',
            'screenshots' => '[]',
            'apk_url' => '/apk/app-release.apk',
            'active_theme' => 'travel',
            'home_banner' => '',
            'inner_banner' => '',
            'phone' => '+92 300 123 4567',
            'email' => 'info@visabook.com',
            'address' => '123 Travel Street, Islamabad',
            'footer_text' => 'All rights reserved.'
        ];
    }
    return $settings;
}

Route::get('/', function () {
    $settings = getAppSettings();
    $theme = $settings->active_theme ?? 'travel';

    if ($theme === 'playstore') {
        return view('frontend.index', compact('settings'));
    }

    if ($theme === 'landing') {
        return view('index', compact('settings'));
    }

    return view('frontend.travel', compact('settings'));
});

// Travel App Routes
Route::get('/dashboard', function () {
    $settings = getAppSettings();
    return view('frontend.travel_dashboard', compact('settings'));
})->name('travel.dashboard');

Route::get('/verify', function () {
    $settings = getAppSettings();
    return view('frontend.travel_verify', compact('settings'));
})->name('travel.verify');

Route::get('/apply', function () {
    $settings = getAppSettings();
    $countries = [];
    try {
        $countries = DB::table('app_countries')->orderBy('name', 'asc')->get();
    } catch (\Exception $e) {}
    return view('frontend.travel_apply', compact('settings', 'countries'));
})->name('travel.apply');

Route::get('/about', function () {
    $settings = getAppSettings();
    return view('frontend.travel_about', compact('settings'));
})->name('travel.about');

Route::get('/contact', function () {
    $settings = getAppSettings();
    return view('frontend.travel_contact', compact('settings'));
})->name('travel.contact');

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// Protected Admin Routes
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Play Store Settings API
    Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/admin/settings/remove-screenshot', [AdminController::class, 'removeScreenshot'])->name('admin.settings.remove_screenshot');

    // APK Management API
    Route::post('/admin/apk/update-url', [AdminController::class, 'updateApkUrl'])->name('admin.apk.update_url');
    Route::post('/admin/apk/upload', [AdminController::class, 'uploadApk'])->name('admin.apk.upload');

    // Country Management API
    Route::post('/admin/countries/add', [AdminController::class, 'addCountry'])->name('admin.countries.add');
    Route::post('/admin/countries/delete', [AdminController::class, 'deleteCountry'])->name('admin.countries.delete');

    // Security API
    Route::post('/admin/password/update', [AdminController::class, 'updatePassword'])->name('admin.password.update');
});
