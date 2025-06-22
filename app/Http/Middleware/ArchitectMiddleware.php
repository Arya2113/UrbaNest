<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArchitectMiddleware
{

    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'architect') {
            abort(403, 'Unauthorized. Architect access only.');
        }

    return $next($request);
    }
}
