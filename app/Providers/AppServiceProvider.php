<?php

namespace App\Providers;

use App\Models\Wedding;
use App\Policies\WeddingPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Register Wedding Policy
        Gate::policy(Wedding::class, WeddingPolicy::class);
    }
}
