<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GuardianController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
*/

if (!function_exists('set_active')) {
    function set_active($route)
    {
        if (is_array($route)) {
            return in_array(Request::path(), $route) ? 'active' : '';
        }
        return Request::path() == $route ? 'active' : '';
    }
}

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    // Dashboard Routes
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('user/profile/page', 'userProfile')->name('user/profile/page');
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->name('teacher.dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->name('student.dashboard');
        Route::get('parent/dashboard', 'parentDashboardIndex')->name('parent.dashboard');
        Route::get('guardian/dashboard', 'guardianDashboardIndex')->name('guardian.dashboard');
    });

    // User Management
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('list/users', 'index')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView')->name('view/user/edit');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data');
    });

    // Guardians
    Route::controller(GuardianController::class)->group(function () {
        Route::get('guardian/list', 'index')->name('guardian/list');
        Route::get('guardian/add', 'add')->name('guardian/add');
        Route::post('guardian/save', 'save')->name('guardian/save');
        Route::get('guardian/edit/{id}', 'edit')->name('guardian/edit');
        Route::post('guardian/update', 'update')->name('guardian/update');
        Route::post('guardian/delete', 'delete')->name('guardian/delete');
    });

    // Settings
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->name('setting/page');
    });

    // Students
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->name('student/list');
        Route::get('student/grid', 'studentGrid')->name('student/grid');
        Route::get('student/add/page', 'studentAdd')->middleware('admin')->name('student/add/page');
        Route::post('student/add/save', 'studentSave')->middleware('admin')->name('student/add/save');
        Route::get('student/edit/{id}', 'studentEdit')->middleware('admin')->name('student/edit');
        Route::post('student/update', 'studentUpdate')->middleware('admin')->name('student/update');
        Route::post('student/delete', 'studentDelete')->middleware('admin')->name('student/delete');
        Route::get('student/profile/{id}', 'studentProfile')->name('student/profile');
    });

    // Teachers
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add', 'teacherAdd')->middleware('admin')->name('teacher/add');
        Route::get('teacher/list', 'teacherList')->name('teacher/list');
        Route::get('teacher/grid', 'teacherGrid')->name('teacher/grid');
        Route::post('teacher/save', 'saveRecord')->middleware('admin')->name('teacher/save');
        Route::get('teacher/edit/{id}', 'editRecord')->middleware('admin')->name('teacher/edit');
        Route::post('teacher/update', 'updateRecordTeacher')->middleware('admin')->name('teacher/update');
        Route::post('teacher/delete', 'teacherDelete')->middleware('admin')->name('teacher/delete');
    });

    // Communication
    Route::controller(CommunicationController::class)->group(function () {
        Route::get('communication/list', 'communicationList')->name('communication/list');
        Route::get('communication/grid', 'communicationGrid')->name('communication/grid');
        Route::get('communication/add/page', 'communicationAdd')->name('communication/add/page');
        Route::post('communication/add/save', 'communicationSave')->name('communication/add/save');
        Route::get('communication/edit/{id}', 'communicationEdit')->name('communication/edit');
        Route::post('communication/update', 'communicationUpdate')->name('communication/update');
        Route::get('communication/profile/{id}', 'communicationProfile')->name('communication/profile');
    });

    // Subjects
    Route::controller(SubjectController::class)->group(function () {
        Route::get('subject/list/page', 'subjectList')->name('subject/list/page');
        Route::get('subject/add/page', 'subjectAdd')->middleware('admin')->name('subject/add/page');
        Route::post('subject/save', 'saveRecord')->middleware('admin')->name('subject/save');
        Route::get('subject/edit/{id}', 'subjectEdit')->middleware('admin')->name('subject/edit');
        Route::post('subject/update', 'updateRecord')->middleware('admin')->name('subject/update');
        Route::post('subject/delete', 'deleteRecord')->middleware('admin')->name('subject/delete');
    });

    // Invoices
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice/list/page', 'invoiceList')->name('invoice/list/page');
        Route::get('invoice/paid/page', 'invoicePaid')->name('invoice/paid/page');
        Route::get('invoice/overdue/page', 'invoiceOverdue')->name('invoice/overdue/page');
        Route::get('invoice/draft/page', 'invoiceDraft')->name('invoice/draft/page');
        Route::get('invoice/recurring/page', 'invoiceRecurring')->name('invoice/recurring/page');
        Route::get('invoice/cancelled/page', 'invoiceCancelled')->name('invoice/cancelled/page');
        Route::get('invoice/grid/page', 'invoiceGrid')->name('invoice/grid/page');
        Route::get('invoice/add/page', 'invoiceAdd')->name('invoice/add/page');
        Route::post('invoice/add/save', 'saveRecord')->name('invoice/add/save');
        Route::post('invoice/update/save', 'updateRecord')->name('invoice/update/save');
        Route::post('invoice/delete', 'deleteRecord')->name('invoice/delete');
        Route::get('invoice/edit/{invoice_id}', 'invoiceEdit')->name('invoice/edit/page');
        Route::get('invoice/view/{invoice_id}', 'invoiceView')->name('invoice/view/page');
        Route::get('invoice/settings/page', 'invoiceSettings')->name('invoice/settings/page');
        Route::get('invoice/settings/tax/page', 'invoiceSettingsTax')->name('invoice/settings/tax/page');
        Route::get('invoice/settings/bank/page', 'invoiceSettingsBank')->name('invoice/settings/bank/page');
    });

    // Accounts
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->name('account/fees/collections/page');
        Route::get('add/fees/collection/page', 'addFeesCollection')->name('add/fees/collection/page');
        Route::post('fees/collection/save', 'saveRecord')->name('fees/collection/save');
    });
});

// Auth Routes
Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('change/password', 'changePassword')->name('change/password');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'storeUser')->name('register');
    });
});
