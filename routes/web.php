<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Auth\RegisteredUserController;

// 部署によるページルートの分岐
Route::get('/', function () {
    if(auth()->check()){
        $user = auth()->user();
        switch($user->roleName()){
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'employee':
                return redirect()->route('inquiry.form'); 
            case 'it':
                return redirect()->route('it.index');
            case 'software':
                return redirect()->route('software.index');
            case 'hardware':
                return redirect()->route('hardware.index');
            case 'network':
                return redirect()->route('network.index');
            default:
                return redirect()->route('login');
        }
    }
    return redirect()->route('login');
});

// 社員ログイン時ページ
Route::middleware('auth')->group(function () {
Route::get('/inquiry', [InquiryController::class, 'inquiry'])->name('inquiry.form');
Route::post('/store', [InquiryController::class, 'store'])->name('inquiry.store');
});

// IT部門ログイン時ページ
Route::middleware(['auth', 'can:access-it'])->prefix('it')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'itTasks'])->name('it.index');
    Route::post('/assign/{inquiry}', [InquiryController::class, 'assign'])->name('it.assign');
    Route::post('/logs/{id}', [InquiryController::class, 'itHandled'])->name('it.markHandled');
    Route::get('/logs', [InquiryController::class, 'itLogs'])->name('it.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('it.updateDetails');
});

// ソフトウェア部門ログイン時ページ
Route::middleware(['auth', 'can:access-software'])->prefix('software')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'softwareTasks'])->name('software.index');
    Route::post('/handled/{inquiryId}/', [InquiryController::class, 'markHandled'])->name('software.markHandled');
    Route::get('/logs', [InquiryController::class, 'softwareLogs'])->name('software.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('software.updateDetails');
});

// ハードウェア部門ログイン時ページ
Route::middleware(['auth', 'can:access-hardware'])->prefix('hardware')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'hardwareTasks'])->name('hardware.index');
    Route::post('/handled/{inquiryId}/', [InquiryController::class, 'markHandled'])->name('hardware.markHandled');
    Route::get('/logs', [InquiryController::class, 'hardwareLogs'])->name('hardware.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('hardware.updateDetails');
});

// ネットワーク部門ログイン時ページ
Route::middleware(['auth', 'can:access-network'])->prefix('network')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'networkTasks'])->name('network.index');
    Route::post('/handled/{inquiryId}/', [InquiryController::class, 'markHandled'])->name('network.markHandled');
    Route::get('/logs', [InquiryController::class, 'networkLogs'])->name('network.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('network.updateDetails');
});
Route::middleware(['auth', 'can:overview-logs'])->group(function () {
    Route::get('/overview', [InquiryController::class, 'overviewLogs'])->name('overview.logs');
});

// 管理者ログイン時ページ
Route::middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/dashboard', [InquiryController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/logs', [InquiryController::class, 'manageLogs'])->name('manage.logs');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::delete('/delete/{id}', [InquiryController::class, 'deleteInquiry'])->name('delete.inquiry');
});


require __DIR__.'/auth.php';


