<?php

namespace App\Http\services;

use Illuminate\Support\Facades\Auth;


class MiddlewareService
{
    public function aksesRole()
    {
        return function ($request, $next) {
            if (Auth::user()->role === 'owner' && !in_array($request->routeIs('panel.*'), ['index', 'show', 'transaction.index', 'transaction.download'])) {
                abort(403);
            }

            return $next($request);
        };
    }
}
