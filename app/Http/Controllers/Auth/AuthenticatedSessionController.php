<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // Authenticate user
        $request->authenticate();
        $request->session()->regenerate();

        // Ensure role_name is set in session
        $role = Auth::user()->role_name ?? 'Unknown';
        Session::put('role_name', $role);
        Session::save(); // Force session save

        // Log for debugging
        Log::info('User logged in', [
            'user_id' => Auth::id(),
            'role' => $role,
            'email' => Auth::user()->email
        ]);

        // Role-based redirect
        switch (strtolower($role)) { // Case-insensitive check
            case 'admin':
            case 'super admin':
                Log::info('Redirecting to Admin Dashboard', ['route' => 'home']);
                return redirect()->route('home');
            case 'teachers':
                Log::info('Redirecting to Teacher Dashboard', ['route' => 'teacher.dashboard']);
                return redirect()->route('teacher.dashboard');
            case 'student':
                Log::info('Redirecting to Student Dashboard', ['route' => 'student.dashboard']);
                return redirect()->route('student.dashboard');
            case 'guardian':
                Log::info('Redirecting to Guardian Dashboard', ['route' => 'student.dashboard']);
                return redirect()->route('student.dashboard');
            default:
                Log::warning('Unknown role detected, falling back to login', ['role' => $role]);
                return redirect()->route('login'); // Fallback to login
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
