<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySsoRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sharedKey = (string) config('services.sso.shared_key');
        $requestKey = (string) $request->header('X-SSO-KEY');

        if ($sharedKey === '' || ! hash_equals($sharedKey, $requestKey)) {
            abort(403, 'Unauthorized SSO request.');
        }
        return $next($request);
    }
}
