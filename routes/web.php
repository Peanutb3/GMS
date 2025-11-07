<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffProfileController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/signup/step1', [AuthController::class, 'showStep1'])->name('signup.step1');
Route::post('/signup/step1', [AuthController::class, 'storeStep1'])->name('signup.step1.store');

Route::get('/signup/step2', [AuthController::class, 'showStep2'])->name('signup.step2');
Route::post('/signup/step2', [AuthController::class, 'storeStep2'])->name('signup.step2.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Main Dashboard (Auto Redirect by Role)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| STAFF ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    // ✅ Now uses a controller — can pass real stats, counts, etc.
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

    // Grievances
    Route::get('/grievances', [GrievanceController::class, 'index'])->name('staff.grievances');
    Route::post('/grievances', [GrievanceController::class, 'store'])->name('staff.grievances.store');

    // Student lookup for form autofill
    Route::get('/students/find/{studentId}', [GrievanceController::class, 'findStudent'])->name('students.find');

    Route::get('/file-grievances', [GrievanceController::class, 'create'])->name('staff.file-grievances');

    // Profile routes (view, edit, update)
    Route::get('/profile', [StaffProfileController::class, 'show'])->name('staff.profile');
    Route::get('/profile/edit', [StaffProfileController::class, 'edit'])->name('staff.profile.edit');
    Route::patch('/profile', [StaffProfileController::class, 'update'])->name('staff.profile.update');
});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/grievances', [GrievanceController::class, 'studentIndex'])->name('student.grievances');
    // Good Moral / OSAS request page
    Route::get('/request', function () {
        return view('request');
    })->name('student.request-good-moral');
    // Use controller so we can pass $user and $student into the view
    Route::get('/profile', [\App\Http\Controllers\StudentProfileController::class, 'show'])->name('student.profile');
    Route::get('/profile/edit', [\App\Http\Controllers\StudentProfileController::class, 'edit'])->name('student.profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\StudentProfileController::class, 'update'])->name('student.profile.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Static admin pages
    Route::view('/manage-staff', 'admin.manageusers')->name('admin.manage-staff');
    Route::view('/manage-students', 'admin.managestudents')->name('admin.manage-students');
    Route::view('/all-grievances-reports', 'admin.allgrievancesreports')->name('admin.all-grievances-reports');
    Route::view('/action-history', 'admin.actionhistory')->name('admin.action-history');
    Route::view('/profile', 'admin.profile')->name('admin.profile');
    Route::view('/settings', 'admin.settings')->name('admin.settings');

    // Admin test routes (keep these for editing/deleting students)
    Route::get('/students/{student}/edit', function ($student) {
        return view('admin.editstudent', ['student' => $student]);
    })->name('admin.students.edit');

    Route::delete('/students/{student}', function ($student) {
        return redirect()->route('admin.manage-students');
    })->name('admin.students.destroy');
});

/*
|--------------------------------------------------------------------------
| Default Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});
