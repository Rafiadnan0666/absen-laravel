<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role->nama_role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        return $next($request);
    }
}
