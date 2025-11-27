<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\SaleOrder;
use App\Observers\LeadObserver;
use App\Observers\SaleOrderObserver;
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
        Lead::observe(LeadObserver::class);
        SaleOrder::observe(SaleOrderObserver::class);
    }
}
