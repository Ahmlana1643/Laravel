<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'You must logged in to access this page.' );
        }

        if (! $this->hasRole($user, $role)) {
            return redirect('/panel/dashboard')->with('error', 'You do not have permission to access this page.' );
        }

        return $next($request);
    }

    private function hasRole($user, array $roles)
    {
        foreach ($roles as $role) {
            if (Session::get('role') === 'owner' && $role === 'operator') {
                return false;
            }

            if ($user->hasRole($role)) {
                return true;
            }
        }

        return false;
    }
}

