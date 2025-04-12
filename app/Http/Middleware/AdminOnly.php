<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            Toastr::error('Please login first!', 'Error');
            return redirect()->route('login');
        }

        // Get role_name from authenticated user
        $role_name = Auth::user()->role_name;

        // Store role_name in session if not already set
        if (!Session::has('role_name')) {
            Session::put('role_name', $role_name);
        }

        // Check if role is allowed
        if (!in_array($role_name, ['Admin', 'Student', 'Teacher'])) {
            Toastr::error('Unauthorized access!', 'Error');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
