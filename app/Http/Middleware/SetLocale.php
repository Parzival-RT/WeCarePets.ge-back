<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language', 'ka');
        $locale = in_array($locale, ['ka', 'en']) ? $locale : 'ka';
        app()->setLocale($locale);

        return $next($request);
    }
}
