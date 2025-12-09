<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffRequestsController;
use App\Http\Controllers\GoodMoralRequestController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminGrievanceController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\SafeLoanRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OsasGmcDashboardController;
use App\Http\Controllers\OsasDuDashboardController;
use App\Http\Controllers\OsasGmcRequestsController;
use App\Http\Controllers\EmailVerificationController;

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
Route::post('/requests/good-moral', [GoodMoralRequestController::class, 'store'])->name('good-moral.store');
Route::get('/requests/good-moral/{requestModel}/success', [GoodMoralRequestController::class, 'success'])->name('good-moral.success');
Route::get('/requests/good-moral/{requestModel}/print', [GoodMoralRequestController::class, 'print'])->name('good-moral.print');
Route::post('/good-moral/{goodMoralRequest}/enter-or', [GoodMoralRequestController::class, 'enterOrNumber'])->name('good-moral.enter-or');
Route::get('/good-moral/{goodMoralRequest}/certificate', [GoodMoralRequestController::class, 'showCertificate'])->name('good-moral.certificate');
Route::post('/good-moral/{goodMoralRequest}/mark-completed', [GoodMoralRequestController::class, 'markCompleted'])->name('good-moral.mark-completed');
Route::delete('/good-moral/{goodMoralRequest}', [GoodMoralRequestController::class, 'destroy'])->name('good-moral.delete');
Route::post('/requests/safe-loan', [SafeLoanRequestController::class, 'store'])->name('safe-loan.store');
Route::get('/requests/safe-loan/{requestModel}', [SafeLoanRequestController::class, 'show'])->name('safe-loan.show');
Route::get('/requests/safe-loan/{requestModel}/print', [SafeLoanRequestController::class, 'print'])->name('safe-loan.print');
Route::get('/requests/safe-loan/{requestModel}/print', [SafeLoanRequestController::class, 'print'])->name('safe-loan.print');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Two-Factor Authentication Routes
Route::get('/2fa/verify', [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('/2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Email Verification Routes
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->middleware('auth')->name('verification.send');

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
    // Now uses a controller — can pass real stats, counts, etc.
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

    // Requests (Good Moral & Safe Loan)
    Route::get('/requests', [StaffRequestsController::class, 'index'])->name('staff.requests');
    Route::patch('/requests/{type}/{id}/check', [StaffRequestsController::class, 'check'])
        ->whereIn('type', ['goodmoral', 'safeloan'])
        ->name('staff.requests.check');
    Route::post('/requests/{type}/{id}/check', [StaffRequestsController::class, 'check'])->name('staff.requests.check');

    // Grievances
    Route::get('/grievances', [GrievanceController::class, 'index'])->name('staff.grievances');
    Route::get('/grievances/{grievance}', [GrievanceController::class, 'show'])->name('staff.grievances.show');
    Route::get('/grievances/{grievance}/edit', [GrievanceController::class, 'edit'])->name('staff.grievances.edit');
    Route::post('/grievances', [GrievanceController::class, 'store'])->name('staff.grievances.store');
    Route::patch('/grievances/{grievance}', [GrievanceController::class, 'update'])->name('staff.grievances.update');
    Route::patch('/grievances/{grievance}/status', [GrievanceController::class, 'updateStatus'])->name('staff.grievances.status');
    Route::patch('/grievances/{grievance}/resolve', [GrievanceController::class, 'resolve'])->name('staff.grievances.resolve');
    Route::post('/grievances/{grievance}/remarks', [GrievanceController::class, 'addRemarks'])->name('staff.grievances.remarks');
    Route::delete('/grievances/{grievance}', [GrievanceController::class, 'destroy'])->name('staff.grievances.destroy');

    // Student lookup for form autofill
    Route::get('/students/find/{studentId}', [GrievanceController::class, 'findStudent'])->name('students.find');

    Route::get('/file-grievances', [GrievanceController::class, 'create'])->name('staff.file-grievances');

    // Profile routes (view, edit, update)
    Route::get('/profile', [StaffProfileController::class, 'show'])->name('staff.profile');
    Route::get('/profile/edit', [StaffProfileController::class, 'edit'])->name('staff.profile.edit');
    Route::post('/profile', [StaffProfileController::class, 'update'])->name('staff.profile.update');

    // Password change routes
    Route::get('/change-password', function () {
        return view('staff.change-password');
    })->name('staff.change-password');
    Route::patch('/password', [StaffProfileController::class, 'updatePassword'])->name('staff.password.update');
});

/*
|--------------------------------------------------------------------------
| OSAS GMC ROUTES (Good Moral Certificate & Safe Loan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:osas_gmc'])->prefix('osas-gmc')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\OsasGmcDashboardController::class, 'index'])->name('osas-gmc.dashboard');

    // Requests Management
    Route::get('/requests', [\App\Http\Controllers\OsasGmcRequestsController::class, 'index'])->name('osas-gmc.requests');
    Route::post('/requests/{type}/{id}/check', [\App\Http\Controllers\OsasGmcRequestsController::class, 'check'])->name('osas-gmc.requests.check');

    // View-only Grievances
    Route::get('/grievances', [GrievanceController::class, 'index'])->name('osas-gmc.grievances');

    // Profile routes
    Route::get('/profile', [StaffProfileController::class, 'show'])->name('osas-gmc.profile');
    Route::get('/profile/edit', [StaffProfileController::class, 'edit'])->name('osas-gmc.profile.edit');
    Route::post('/profile', [StaffProfileController::class, 'update'])->name('osas-gmc.profile.update');

    // Password change
    Route::get('/change-password', function () {
        return view('staff.osas-gmc.change-password');
    })->name('osas-gmc.change-password');
    Route::patch('/password', [StaffProfileController::class, 'updatePassword'])->name('osas-gmc.password.update');
});

/*
|--------------------------------------------------------------------------
| OSAS DU ROUTES (Discipline Unit)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:osas_du'])->prefix('osas-du')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\OsasDuDashboardController::class, 'index'])->name('osas-du.dashboard');

    // Grievances (Full Access - File & View)
    Route::get('/grievances', [GrievanceController::class, 'index'])->name('osas-du.grievances');
    Route::get('/grievances/{grievance}', [GrievanceController::class, 'show'])->name('osas-du.grievances.show');
    Route::get('/grievances/{grievance}/edit', [GrievanceController::class, 'edit'])->name('osas-du.grievances.edit');
    Route::get('/file-grievances', [GrievanceController::class, 'create'])->name('osas-du.file-grievances');
    Route::post('/grievances', [GrievanceController::class, 'store'])->name('osas-du.grievances.store');
    Route::patch('/grievances/{grievance}', [GrievanceController::class, 'update'])->name('osas-du.grievances.update');
    Route::patch('/grievances/{grievance}/status', [GrievanceController::class, 'updateStatus'])->name('osas-du.grievances.status');
    Route::patch('/grievances/{grievance}/resolve', [GrievanceController::class, 'resolve'])->name('osas-du.grievances.resolve');
    Route::post('/grievances/{grievance}/remarks', [GrievanceController::class, 'addRemarks'])->name('osas-du.grievances.remarks');
    Route::delete('/grievances/{grievance}', [GrievanceController::class, 'destroy'])->name('osas-du.grievances.destroy');

    // Student lookup
    Route::get('/students/find/{studentId}', [GrievanceController::class, 'findStudent'])->name('osas-du.students.find');

    // View-only Requests
    Route::get('/requests', [\App\Http\Controllers\OsasGmcRequestsController::class, 'index'])->name('osas-du.requests');

    // Profile routes
    Route::get('/profile', [StaffProfileController::class, 'show'])->name('osas-du.profile');
    Route::get('/profile/edit', [StaffProfileController::class, 'edit'])->name('osas-du.profile.edit');
    Route::post('/profile', [StaffProfileController::class, 'update'])->name('osas-du.profile.update');

    // Password change
    Route::get('/change-password', function () {
        return view('staff.osas-du.change-password');
    })->name('osas-du.change-password');
    Route::patch('/password', [StaffProfileController::class, 'updatePassword'])->name('osas-du.password.update');
});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/grievances', [GrievanceController::class, 'studentIndex'])->name('student.grievances');
    // Good Moral / OSAS request page (moved outside student middleware - see separate public route)
    // Use controller so we can pass $user and $student into the view
    Route::get('/profile', [\App\Http\Controllers\StudentProfileController::class, 'show'])->name('student.profile');
    Route::get('/profile/edit', [\App\Http\Controllers\StudentProfileController::class, 'edit'])->name('student.profile.edit');
    Route::post('/profile', [\App\Http\Controllers\StudentProfileController::class, 'update'])->name('student.profile.update');
});

Route::get('/request', function () {
    $studentId = Auth::check() && Auth::user()->role === 'student'
        ? optional(Auth::user()->student)->id
        : null;
    return view('request', ['studentId' => $studentId]);
})->name('request');

// Local-only preview routes for adjusting print format
if (app()->environment('local')) {
    Route::get('/preview/print', function () {
        $req = (object) [
            'student' => (object) [
                'email' => 'student@example.com',
                'contact' => '0917 123 4567',
                'last_name' => 'Dela Cruz',
                'first_name' => 'Juan',
                'middle_name' => 'Santos',
                'gender' => 'Male',
                'program' => 'BSIT - 3rd Year',
                'year_level' => null,
                'status' => 'Currently Enrolled',
                'year_graduated' => null,
            ],
            'purpose' => 'For scholarship application',
            'copies' => 2,
        ];
        return view('print', compact('req'));
    })->name('print.preview');

    Route::get('/preview/print/custom', function (\Illuminate\Http\Request $r) {
        $req = (object) [
            'student' => (object) [
                'email' => $r->query('email', 'student@example.com'),
                'contact' => $r->query('contact', '0917 123 4567'),
                'last_name' => $r->query('last', 'Dela Cruz'),
                'first_name' => $r->query('first', 'Juan'),
                'middle_name' => $r->query('middle', 'Santos'),
                'gender' => $r->query('gender', 'Male'),
                'program' => $r->query('program', 'BSIT - 3rd Year'),
                'year_level' => null,
                'status' => $r->query('status', 'Currently Enrolled'),
                'year_graduated' => $r->query('grad', null),
            ],
            'purpose' => $r->query('purpose', 'For scholarship application'),
            'copies' => (int) $r->query('copies', 2),
        ];
        return view('print', compact('req'));
    })->name('print.preview.custom');
}

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Grievances Management
    Route::get('/grievances', [AdminGrievanceController::class, 'index'])->name('admin.grievances');
    Route::get('/grievances/{id}', [AdminGrievanceController::class, 'show'])->name('admin.grievances.show');
    Route::post('/grievances/{id}/status', [AdminGrievanceController::class, 'updateStatus'])->name('admin.grievances.update-status');
    Route::delete('/grievances/{id}', [AdminGrievanceController::class, 'destroy'])->name('admin.grievances.destroy');

    // Request Management
    Route::get('/requests/good-moral', [AdminRequestController::class, 'goodMoral'])->name('admin.requests.good-moral');
    Route::get('/requests/safe-loan', [AdminRequestController::class, 'safeLoan'])->name('admin.requests.safe-loan');

    // Student Management
    Route::get('/manage-students', [AdminStudentController::class, 'index'])->name('admin.manage-students');
    Route::get('/students/create', [AdminStudentController::class, 'create'])->name('admin.students.create');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('admin.students.store');
    Route::get('/students/{id}/edit', [AdminStudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/students/{id}', [AdminStudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])->name('admin.students.destroy');

    // Staff Management
    Route::get('/manage-staff', [AdminStaffController::class, 'index'])->name('admin.manage-staff');
    Route::get('/staff/create', [AdminStaffController::class, 'create'])->name('admin.staff.create');
    Route::post('/staff', [AdminStaffController::class, 'store'])->name('admin.staff.store');
    Route::get('/staff/{id}/edit', [AdminStaffController::class, 'edit'])->name('admin.staff.edit');
    Route::put('/staff/{id}', [AdminStaffController::class, 'update'])->name('admin.staff.update');
    Route::delete('/staff/{id}', [AdminStaffController::class, 'destroy'])->name('admin.staff.destroy');

    // Admin Management
    Route::get('/manage-admins', [AdminManagementController::class, 'index'])->name('admin.manage-admins');
    Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admin.admins.create');
    Route::post('/admins', [AdminManagementController::class, 'store'])->name('admin.admins.store');
    Route::get('/admins/{id}/edit', [AdminManagementController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admins/{id}', [AdminManagementController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admins/{id}', [AdminManagementController::class, 'destroy'])->name('admin.admins.destroy');

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'adminIndex'])->name('admin.audit-logs');

    // System Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/test-email', [AdminSettingsController::class, 'testEmail'])->name('admin.settings.test-email');

    // Profile routes (view, edit, update)
    Route::get('/profile', [\App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('/profile/edit', [\App\Http\Controllers\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/profile', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Password change routes
    Route::get('/change-password', function () {
        return view('admin.change-password');
    })->name('admin.change-password');
    Route::patch('/password', [\App\Http\Controllers\AdminProfileController::class, 'updatePassword'])->name('admin.password.update');
});

/*
|--------------------------------------------------------------------------
| Default Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});
