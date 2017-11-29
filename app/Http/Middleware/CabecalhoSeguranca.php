<?php

namespace App\Http\Middleware;

use Closure;

class CabecalhoSeguranca
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $next($request)
            ->header('Content-Security-Policy', "script-src 'self'")
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('X-XSS-Protection', '1; mode=block')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Referrer-Policy', 'same-origin')
        ;

        return $next($request);
    }
}
