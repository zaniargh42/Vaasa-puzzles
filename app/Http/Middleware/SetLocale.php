<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('locales.default', 'fa'));

        if (! array_key_exists($locale, config('locales.supported', []))) {
            $locale = config('locales.default', 'fa');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
