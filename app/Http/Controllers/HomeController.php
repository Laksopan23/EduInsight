<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the Admin Dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Session::get('role_name') ?? 'Unknown';
        Log::info('HomeController::index accessed', ['role' => $role, 'user_id' => Auth::id()]);

        // Only Admin/Super Admin can access /home
        if (!in_array(strtolower($role), ['admin', 'super admin'])) {
            Log::info('Non-Admin role accessing home, redirecting to role-specific dashboard', ['role' => $role]);
            switch (strtolower($role)) {
                case 'teachers':
                    return redirect()->route('teacher.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                case 'guardian':
                    return redirect()->route('guardian.dashboard');
                default:
                    Toastr::error('Access denied da!', 'Error');
                    Log::warning('Unknown role accessing home, redirecting to login', ['role' => $role]);
                    return redirect()->route('login');
            }
        }

        return view('dashboard.home');
    }

    /**
     * Show the User Profile Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userProfile()
    {
        return view('dashboard.profile');
    }

    /**
     * Show the Teacher Dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function teacherDashboardIndex()
    {
        $role = Session::get('role_name') ?? 'Unknown';
        Log::info('HomeController::teacherDashboardIndex accessed', ['role' => $role, 'user_id' => Auth::id()]);

        // Only Admin/Super Admin/Teachers can access
        if (!in_array(strtolower($role), ['admin', 'super admin', 'teachers'])) {
            Toastr::error('Access denied da!', 'Error');
            Log::warning('Unauthorized access to teacher dashboard', ['role' => $role]);
            return redirect()->route('home');
        }

        return view('dashboard.teacher_dashboard');
    }

    /**
     * Show the Student Dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function studentDashboardIndex()
    {
        $role = Session::get('role_name') ?? 'Unknown';
        Log::info('HomeController::studentDashboardIndex accessed', ['role' => $role, 'user_id' => Auth::id()]);

        // Only Admin/Super Admin/Teachers/Student can access
        if (!in_array(strtolower($role), ['admin', 'super admin', 'teachers', 'student'])) {
            Toastr::error('Access denied da!', 'Error');
            Log::warning('Unauthorized access to student dashboard', ['role' => $role]);
            return redirect()->route('home');
        }

        return view('dashboard.student_dashboard');
    }

    /**
     * Show the Parent Dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function parentDashboardIndex()
    {
        $role = Session::get('role_name') ?? 'Unknown';
        Log::info('HomeController::parentDashboardIndex accessed', ['role' => $role, 'user_id' => Auth::id()]);

        // Only Admin/Super Admin/Parent can access
        if (!in_array(strtolower($role), ['admin', 'super admin', 'parent'])) {
            Toastr::error('Access denied da!', 'Error');
            Log::warning('Unauthorized access to parent dashboard', ['role' => $role]);
            return redirect()->route('home');
        }

        return view('dashboard.parent_dashboard');
    }

    /**
     * Show the Guardian Dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function guardianDashboardIndex()
    {
        $role = Session::get('role_name') ?? 'Unknown';
        Log::info('HomeController::guardianDashboardIndex accessed', ['role' => $role, 'user_id' => Auth::id()]);

        // Only Admin/Super Admin/Guardian can access
        if (!in_array(strtolower($role), ['admin', 'super admin', 'guardian'])) {
            Toastr::error('Access denied da!', 'Error');
            Log::warning('Unauthorized access to guardian dashboard', ['role' => $role]);
            return redirect()->route('home');
        }

        return view('dashboard.guardian_dashboard');
    }
}
