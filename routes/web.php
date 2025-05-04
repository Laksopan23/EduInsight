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
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\ResultController;

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
        Route::get('guardian/{id}/schedules', 'viewSchedules')->name('guardian/schedules');
    });

    // Exam Schedule Routes
    Route::controller(ExamScheduleController::class)->group(function () {
        Route::get('exam_schedule/list', [App\Http\Controllers\ExamScheduleController::class, 'index'])->name('exam_schedule/list');
        Route::get('exam_schedule/add', [App\Http\Controllers\ExamScheduleController::class, 'create'])->name('exam_schedule/add');
        Route::post('exam_schedule/store', [App\Http\Controllers\ExamScheduleController::class, 'store'])->name('exam_schedule/store');
        Route::get('exam_schedule/edit/{id}', [App\Http\Controllers\ExamScheduleController::class, 'edit'])->name('exam_schedule/edit');
        Route::put('exam_schedule/update/{id}', [App\Http\Controllers\ExamScheduleController::class, 'update'])->name('exam_schedule/update');
        Route::delete('exam_schedule/delete', [App\Http\Controllers\ExamScheduleController::class, 'destroy'])->name('exam_schedule/delete');
        Route::post('exam_schedule/store-schedule', [App\Http\Controllers\ExamScheduleController::class, 'storeSchedule'])->name('exam_schedule.store_schedule');
        Route::post('exam_schedule/store-tutorial', [App\Http\Controllers\ExamScheduleController::class, 'storeTutorial'])->name('exam_schedule.store_tutorial');
        Route::get('/exam-schedule/download/{id}', [ExamScheduleController::class, 'download'])->name('exam_schedule.download');
    });

    //Results
    Route::middleware(['auth'])->group(function () {
        Route::get('/results', [ResultController::class, 'index'])->name('results.list');
        Route::get('/results/add', [ResultController::class, 'create'])->name('results.add');
        Route::post('/results/store', [ResultController::class, 'store'])->name('results.store');
        Route::get('/results/edit/{id}', [ResultController::class, 'edit'])->name('results.edit');
        Route::put('/results/update/{id}', [ResultController::class, 'update'])->name('results.update');
        Route::get('/results/show/{id}', [ResultController::class, 'show'])->name('results.show');
        Route::delete('/results/delete/{id}', [ResultController::class, 'destroy'])->name('results.delete');
        Route::get('/results/download', [ResultController::class, 'downloadListReport'])->name('results.download.list');
        Route::get('/results/download/{id}', [ResultController::class, 'downloadProfileReport'])->name('results.download.profile');
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
        Route::get('student/download', 'downloadListReport')->name('student.download.list');
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
        Route::post('communication/delete', 'communicationDelete')->name('communication/delete');
        Route::get('communication/profile/{id}', 'communicationProfile')->name('communication/profile');
        Route::get('zoom/authorize', 'authorizeZoom')->name('zoom.authorize');
        Route::get('callback', 'handleCallback')->name('zoom.callback');
    });

    // Subjects
    Route::controller(SubjectController::class)->group(function () {
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    });

    // Accounts
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->name('account/fees/collections/page');
        Route::get('add/fees/collection/page', 'addFeesCollection')->name('add/fees/collection/page');
        Route::post('fees/collection/save', 'saveRecord')->name('fees/collection/save');
        Route::get('fees/collection/edit/{id}', 'edit')->name('fees/collection/edit');
        Route::put('fees/collection/update/{id}', 'updateRecord')->name('fees/collection/update');
        Route::post('fees/collection/delete', 'deleteRecord')->name('fees/collection/delete');
        Route::get('fees/collection/download', 'downloadReport')->name('fees/collection/download');
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
