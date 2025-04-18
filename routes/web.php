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
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ExamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/** for sidebar menu active */
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
    Route::get('home', function () {
        return view('home');
    });
    Route::get('home', function () {
        return view('home');
    });
});



Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    // ----------------------------login ------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('change/password', 'changePassword')->name('change/password');
    });

    // ----------------------------- register -------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'storeUser')->name('register');
    });
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // -------------------------- main dashboard ----------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->middleware('auth')->name('home');
        Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
        Route::get('parent/dashboard', 'parentDashboardIndex')->middleware('auth')->name('parent/dashboard');
    });

    // ----------------------------- user controller ---------------------//
    Route::controller(UserManagementController::class)->middleware('auth')->group(function () {
        Route::get('list/users', 'index')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView')->name('view/user/edit');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data');
    });

    // ------------------------ setting -------------------------------//
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
    });

    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->middleware('auth')->name('student/list');
        Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid');
        Route::get('student/add/page', 'studentAdd')->middleware(['auth', 'admin'])->name('student/add/page');
        Route::post('student/add/save', 'studentSave')->middleware(['auth', 'admin'])->name('student/add/save');
        Route::get('student/edit/{id}', 'studentEdit')->middleware(['auth', 'admin'])->name('student/edit');
        Route::post('student/update', 'studentUpdate')->middleware(['auth', 'admin'])->name('student/update');
        Route::post('student/delete', 'studentDelete')->middleware(['auth', 'admin'])->name('student/delete');
        Route::get('student/profile/{id}', 'studentProfile')->middleware('auth')->name('student/profile');
    });

    // ------------------------ teacher -------------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add', 'teacherAdd')->middleware(['auth', 'admin'])->name('teacher/add');
        Route::get('teacher/list', 'teacherList')->middleware('auth')->name('teacher/list');
        Route::get('teacher/grid', 'teacherGrid')->middleware('auth')->name('teacher/grid');
        Route::post('teacher/save', 'saveRecord')->middleware(['auth', 'admin'])->name('teacher/save');
        Route::get('teacher/edit/{id}', 'editRecord')->middleware(['auth', 'admin'])->name('teacher/edit');
        Route::post('teacher/update', 'updateRecordTeacher')->middleware(['auth', 'admin'])->name('teacher/update');
        Route::post('teacher/delete', 'teacherDelete')->middleware(['auth', 'admin'])->name('teacher/delete');
    });


    // ----------------------- Communication -----------------------------//
    Route::controller(CommunicationController::class)->group(function () {
        Route::get('communication/list', 'communicationList')->name('communication/list');
        Route::get('communication/grid', 'communicationGrid')->name('communication/grid');
        Route::get('communication/add/page', 'communicationAdd')->name('communication/add/page');
        Route::post('communication/add/save', 'communicationSave')->name('communication/add/save');
        Route::get('communication/edit/{id}', 'communicationEdit')->name('communication/edit');
        Route::post('communication/update', 'communicationUpdate')->name('communication/update');
        Route::get('communication/profile/{id}', 'communicationProfile')->name('communication/profile');
    });

    // ----------------------- subject -----------------------------//
    Route::controller(SubjectController::class)->group(function () {
        Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject/list/page'); // subject/list/page
        Route::get('subject/add/page', 'subjectAdd')->middleware('auth')->name('subject/add/page'); // subject/add/page
        Route::post('subject/save', 'saveRecord')->name('subject/save'); // subject/save
        Route::post('subject/update', 'updateRecord')->name('subject/update'); // subject/update
        Route::post('subject/delete', 'deleteRecord')->name('subject/delete'); // subject/delete
        Route::get('subject/edit/{subject_id}', 'subjectEdit'); // subject/edit/page
    });

    // ----------------------- invoice -----------------------------//
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice/list/page', 'invoiceList')->middleware('auth')->name('invoice/list/page'); // subjeinvoicect/list/page
        Route::get('invoice/paid/page', 'invoicePaid')->middleware('auth')->name('invoice/paid/page'); // invoice/paid/page
        Route::get('invoice/overdue/page', 'invoiceOverdue')->middleware('auth')->name('invoice/overdue/page'); // invoice/overdue/page
        Route::get('invoice/draft/page', 'invoiceDraft')->middleware('auth')->name('invoice/draft/page'); // invoice/draft/page
        Route::get('invoice/recurring/page', 'invoiceRecurring')->middleware('auth')->name('invoice/recurring/page'); // invoice/recurring/page
        Route::get('invoice/cancelled/page', 'invoiceCancelled')->middleware('auth')->name('invoice/cancelled/page'); // invoice/cancelled/page
        Route::get('invoice/grid/page', 'invoiceGrid')->middleware('auth')->name('invoice/grid/page'); // invoice/grid/page
        Route::get('invoice/add/page', 'invoiceAdd')->middleware('auth')->name('invoice/add/page'); // invoice/add/page
        Route::post('invoice/add/save', 'saveRecord')->name('invoice/add/save'); // invoice/add/save
        Route::post('invoice/update/save', 'updateRecord')->name('invoice/update/save'); // invoice/update/save
        Route::post('invoice/delete', 'deleteRecord')->name('invoice/delete'); // invoice/delete
        Route::get('invoice/edit/{invoice_id}', 'invoiceEdit')->middleware('auth')->name('invoice/edit/page'); // invoice/edit/page
        Route::get('invoice/view/{invoice_id}', 'invoiceView')->middleware('auth')->name('invoice/view/page'); // invoice/view/page
        Route::get('invoice/settings/page', 'invoiceSettings')->middleware('auth')->name('invoice/settings/page'); // invoice/settings/page
        Route::get('invoice/settings/tax/page', 'invoiceSettingsTax')->middleware('auth')->name('invoice/settings/tax/page'); // invoice/settings/tax/page
        Route::get('invoice/settings/bank/page', 'invoiceSettingsBank')->middleware('auth')->name('invoice/settings/bank/page'); // invoice/settings/bank/page
    });

    // ----------------------- accounts ----------------------------//
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->middleware('auth')->name('account/fees/collections/page'); // account/fees/collections/page
        Route::get('add/fees/collection/page', 'addFeesCollection')->middleware('auth')->name('add/fees/collection/page'); // add/fees/collection
        Route::post('fees/collection/save', 'saveRecord')->middleware('auth')->name('fees/collection/save'); // fees/collection/save
    });

    // ----------------------- Exams ----------------------------//
    Route::resource('exams', ExamController::class);  // Automatically maps all resource routes
    Route::post('exams/{exam}/addResult', [ExamController::class, 'addResult'])->name('exams.addResult');
    Route::get('exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('exams/store', [ExamController::class, 'store'])->name('exams.store');
    Route::get('exam/list', [ExamController::class, 'index'])->name('exam.list');
    Route::get('exam/edit/{exam}', [ExamController::class, 'edit'])->name('exam.edit');
    Route::post('exam/update', [ExamController::class, 'update'])->name('exam.update');
    Route::delete('exam/delete/{exam}', [ExamController::class, 'destroy'])->name('exam.delete');
});
