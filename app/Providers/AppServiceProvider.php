<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
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
        // Guard against environments where APP_KEY is overridden/empty in HTTP context.
        if (empty(config('app.key'))) {
            $envPath = base_path('.env');

            if (is_file($envPath)) {
                $envContent = file_get_contents($envPath) ?: '';

                if (preg_match('/^APP_KEY=(.+)$/m', $envContent, $matches)) {
                    $resolvedKey = trim($matches[1], " \t\n\r\0\x0B\"'");

                    if ($resolvedKey !== '') {
                        config(['app.key' => $resolvedKey]);
                    }
                }
            }
        }

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
            // try {
            //     Auth::shouldUse($guard);
            // } catch (\Throwable $e) {
            //     // no-op
            // }
            try {
                $path = request()?->path();

                // Don't force admin guard for Livewire core endpoints (upload/update/preview/js)
                if (! str_starts_with($path ?? '', 'livewire/')) {
                    Auth::shouldUse($guard);
                }
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
