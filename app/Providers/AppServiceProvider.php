<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin;
use App\Policies\AdminPolicy;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

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

        // Register model policy for Admin
        Gate::policy(Admin::class, AdminPolicy::class);

        // Ensure Filament uses the configured auth guard (defaults to 'admin').
        Filament::serving(function () {
            $guard = config('filament.auth.guard', 'admin');

            try {
                Filament::getDefaultPanel()->authGuard($guard);
            } catch (\Throwable $e) {
                // If panels aren't registered yet or something else goes wrong,
                // we silently ignore so it won't break bootstrapping.
            }

            // Ensure the framework uses the admin guard for the current request
            // while Filament is serving. This prevents `web` users from being
            // treated as authenticated for the admin panel.
            try {
                Auth::shouldUse($guard);
            } catch (\Throwable $e) {
                // no-op
            }

            // (diagnostic logging removed)
        });

        // Explicitly register Livewire components that may not be auto-discovered
        try {
            Livewire::component('ticket-chat', \App\Http\Livewire\TicketChat::class);
            Livewire::component('admin-ticket-chat', \App\Http\Livewire\AdminTicketChat::class);
        } catch (\Throwable $e) {
            // ignore if Livewire isn't available at boot time
        }
    }
}
