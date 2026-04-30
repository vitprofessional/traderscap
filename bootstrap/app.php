<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\TrustProxies::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'livewire/upload-file',
            'livewire/message/*',
            'sso/login-request',
            'sso/register-request',
            'sso/forgot-password',
            'sso/reset-password',
            'api/broker-finder/match',
            'api/broker-finder/questions',
            'api/broker-finder/recommendations',
        ]);

        $middleware->alias([
            'verify.sso' => \App\Http\Middleware\VerifySsoRequest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();