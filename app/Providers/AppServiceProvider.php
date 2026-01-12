<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Replace Livewire's HandleRequests with our custom one that returns full URLs
        $this->app->singleton(
            \Livewire\Mechanisms\HandleRequests\HandleRequests::class,
            \App\Livewire\CustomHandleRequests::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force root URL to include subfolder path
        URL::forceRootUrl(config('app.url'));
    }
}
