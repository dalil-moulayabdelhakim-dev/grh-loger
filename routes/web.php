<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login'); // الصفحة الرئيسية = login
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::middleware('manager')->group(function () {
        Route::get('/records', [ManagerController::class, 'index']);
        Route::get('/grh/{id}', [ManagerController::class, 'getData']);
        Route::post('/verify', [ManagerController::class, 'verifyRecord']);
        Route::post('/verify_multiple', [ManagerController::class, 'verifyMultipleRecord']);
        Route::post('/delete', [ManagerController::class, 'deleteRecord']);
        Route::post('/delete_multiple', [ManagerController::class, 'deleteMultipleRecord']);
        Route::post('/delete_multiple', [ManagerController::class, 'deleteMultipleRecord']);
        Route::post('/grh_verify_all', [ManagerController::class, 'grhVerifyAllRecord']);
        Route::get('/get_workers', [ManagerController::class, 'getWorkers']);
        Route::get('/worker_stats/{id}', [ManagerController::class, 'workerStats']);

        // إرسال الطلب (AJAX)
        Route::post('/shift-request/send', [ManagerController::class, 'send']);


    });


    // صفحة التحقق
    Route::get('/shift-request/verify', [ManagerController::class, 'verify'])
        ->name('shift.verify')
        ->middleware('signed');

    // قبول
    Route::get('/shift-request/approve', [ManagerController::class, 'approve'])
        ->name('shift.approve')
        ->middleware('signed');

    // رفض - صفحة السبب
    Route::get('/shift-request/reject', [ManagerController::class, 'rejectPage'])
        ->name('shift.reject')
        ->middleware('signed');

    // إرسال سبب الرفض
    Route::post('/shift-request/reject', [ManagerController::class, 'submitReject'])
        ->name('shift.reject.submit');

    Route::get('/records', [DashboardController::class, 'records']);
    Route::post('/add_record', [DashboardController::class, 'addRecords']);
    Route::post('/add_user', [DashboardController::class, 'addUser']);
    Route::post('/save-shift', [DashboardController::class, 'store']);



    Route::get('/people', function () {
        return \App\Models\User::select('id', 'name')->get();
    });


    Route::get('/session-info', function () {
        return response()->json([
            'logged' => true,
            'user' => auth()->user()
        ]);
    })->name('session.info');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
