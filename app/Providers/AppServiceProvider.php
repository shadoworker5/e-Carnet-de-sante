<?php

namespace App\Providers;

// use App\Charts\PatientChart;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
// use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Paginator::useBootstrap();
        // Charts $chart
        // $chart->register([
        //     PatientChart::class
        // ]);
    }
}
