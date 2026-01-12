<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RedirectToRegisterIfNoUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the URI without the full path
        $uri = $request->getRequestUri();
        
        // If accessing login and no users exist, redirect to register
        if (str_contains($uri, '/admin/login') && User::count() === 0) {
            return redirect('admin/register');
        }

        // Allow registration to proceed - removed the redirect that blocks registration when users exist
        // if (str_contains($uri, '/admin/register') && User::count() > 0) {
        //     return redirect('admin/login');
        // }

        return $next($request);
    }
}
