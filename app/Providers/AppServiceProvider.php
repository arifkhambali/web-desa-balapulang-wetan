<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\Filament\Http\Responses\Auth\Contracts\LogoutResponse::class, \App\Http\Responses\LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\PengajuanSurat::observe(\App\Observers\PengajuanSuratObserver::class);

        try {
            $identitasDesa = \Illuminate\Support\Facades\Cache::remember('identitas_desa', 86400, function () {
                return \App\Models\IdentitasDesa::first();
            });
            \Illuminate\Support\Facades\View::share('identitasDesa', $identitasDesa);
        } catch (\Exception $e) {
            // Fallback if table doesn't exist yet or migration hasn't run
            \Illuminate\Support\Facades\View::share('identitasDesa', null);
        }
    }
}
