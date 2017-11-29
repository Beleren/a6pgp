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
        $response = $next($request);

        $response
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('X-XSS-Protection', '1; mode=block')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Referrer-Policy', 'same-origin')
        ;

        if (! app()->environment('local')) {
            $response->header('Content-Security-Policy', "default-src 'self' cod-besouro.herokuapp.com");
        }

        return $response;
    }
}
