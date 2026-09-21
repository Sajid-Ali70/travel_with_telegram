<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.footer', function ($view) {
            $footerCategories = collect();

            try {
                $footerCategories = DB::table('app_categories')
                    ->orderBy('name', 'asc')
                    ->get();
            } catch (\Exception $e) {
                // Keep the footer available if the categories table is unavailable.
            }

            $view->with('footerCategories', $footerCategories);
        });
    }
}
