<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\JobTitleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\UserShiftController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\AttendanceLogController;
use App\Http\Controllers\Admin\FaceLogController;
use App\Http\Controllers\Admin\ReimbursementController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\SalaryRuleController;
use App\Http\Controllers\Admin\OvertimeRuleController;
use App\Http\Controllers\HR\DashboardController as HRDashboardController;
use App\Http\Controllers\HR\AttendanceController as HRAttendanceController;
use App\Http\Controllers\HR\LeaveController as HRLeaveController;
use App\Http\Controllers\HR\PayrollController as HRPayrollController;
use App\Http\Controllers\HR\ReimbursementController as HRReimbursementController;
use App\Http\Controllers\Admin\PayrollDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role && $user->role->nama_role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role && $user->role->nama_role === 'hr') {
        return redirect()->route('hr.dashboard');
    }
    return redirect()->route('employee.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/tour/dismiss', function () {
        session()->forget('show_tour');
        return response()->json(['ok' => true]);
    })->name('tour.dismiss');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'general'])->name('settings.general');
    Route::post('/settings/clear-cache', [App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clearCache');
    Route::resource('users', UserController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('leaves', LeaveController::class);
    Route::resource('payrolls', PayrollController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('job-titles', JobTitleController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('user-shifts', UserShiftController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('holidays', HolidayController::class);
    Route::resource('attendance-logs', AttendanceLogController::class)->only(['index', 'show', 'destroy']);
    Route::resource('face-logs', FaceLogController::class)->only(['index', 'show', 'destroy']);
    Route::resource('reimbursements', ReimbursementController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('salary-rules', SalaryRuleController::class);
    Route::resource('overtime-rules', OvertimeRuleController::class);
    Route::resource('payroll-details', PayrollDetailController::class);

    Route::post('leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::post('leaves/bulk/approve', [LeaveController::class, 'bulkApprove'])->name('leaves.bulkApprove');
    Route::post('leaves/bulk/reject', [LeaveController::class, 'bulkReject'])->name('leaves.bulkReject');
    Route::get('leaves/export', [LeaveController::class, 'export'])->name('leaves.export');

    Route::post('reimbursements/{reimbursement}/approve', [ReimbursementController::class, 'approve'])->name('reimbursements.approve');
    Route::post('reimbursements/{reimbursement}/reject', [ReimbursementController::class, 'reject'])->name('reimbursements.reject');
    Route::post('reimbursements/bulk/approve', [ReimbursementController::class, 'bulkApprove'])->name('reimbursements.bulkApprove');
    Route::post('reimbursements/bulk/reject', [ReimbursementController::class, 'bulkReject'])->name('reimbursements.bulkReject');
    Route::get('reimbursements/export', [ReimbursementController::class, 'export'])->name('reimbursements.export');

    Route::get('attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
    Route::get('payrolls/export', [PayrollController::class, 'export'])->name('payrolls.export');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
});

Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('attendances', App\Http\Controllers\Employee\AttendanceController::class)->only(['index', 'create', 'store']);
    Route::post('attendances/checkout', [App\Http\Controllers\Employee\AttendanceController::class, 'checkout'])->name('attendances.checkout');
    Route::get('attendances/logs', [App\Http\Controllers\Employee\AttendanceController::class, 'logs'])->name('attendances.logs');
    Route::resource('leaves', App\Http\Controllers\Employee\LeaveController::class);
    Route::resource('reimbursements', App\Http\Controllers\Employee\ReimbursementController::class);
    Route::resource('payrolls', App\Http\Controllers\Employee\PayrollController::class)->only(['index', 'show']);
    Route::resource('announcements', App\Http\Controllers\Employee\AnnouncementController::class)->only(['index', 'show']);
});

Route::middleware(['auth', 'hr'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
    Route::resource('attendances', HRAttendanceController::class)->only(['index']);
    Route::get('attendances/export', [HRAttendanceController::class, 'export'])->name('attendances.export');
    Route::resource('leaves', HRLeaveController::class)->only(['index']);
    Route::post('leaves/{leave}/approve', [HRLeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [HRLeaveController::class, 'reject'])->name('leaves.reject');
    Route::get('leaves/export', [HRLeaveController::class, 'export'])->name('leaves.export');
    Route::resource('payrolls', HRPayrollController::class)->only(['index']);
    Route::resource('reimbursements', HRReimbursementController::class)->only(['index']);
    Route::post('reimbursements/{reimbursement}/approve', [HRReimbursementController::class, 'approve'])->name('reimbursements.approve');
    Route::post('reimbursements/{reimbursement}/reject', [HRReimbursementController::class, 'reject'])->name('reimbursements.reject');
    Route::get('reimbursements/export', [HRReimbursementController::class, 'export'])->name('reimbursements.export');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';
