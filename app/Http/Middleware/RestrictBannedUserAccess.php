<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RestrictBannedUserAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('web')->user();

        if (! $user || ($user->account_status ?? 'registered') !== 'banned') {
            return $next($request);
        }

        $routeName = (string) optional($request->route())->getName();
        $path = trim($request->path(), '/');

        if (
            in_array($routeName, ['logout', 'customerLogout'], true)
            || Str::startsWith($routeName, 'complaints.')
            || Str::startsWith($path, ['complaints', 'livewire', 'logout', 'customer-logout'])
        ) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your account is restricted. Only ticket operations are allowed.',
            ], 403);
        }

        return redirect()
            ->route('complaints')
            ->with('status', 'Your account is restricted. You can only access complaint tickets.');
    }
}
