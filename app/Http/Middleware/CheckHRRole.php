<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckHRRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $role = Auth::user()->role->nama_role;
        if ($role !== 'hr' && $role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. HR only.');
        }

        return $next($request);
    }
}
