<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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
        Http::macro('user', function()
        {
            return Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->baseUrl(env('USER_SERVICE_URL'));
        });

        Http::macro('kursus', function()
        {
            return Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->baseUrl(env('COURSE_SERVICE_URL'));
        });

        Http::macro('transaksi', function()
        {
            return Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->baseUrl(env('TRANSACTION_SERVICE_URL'));
        });
    }
}
