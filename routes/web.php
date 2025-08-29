<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController;

// Route::get('/login', function () {
//     return view('auth.login');
// });
// Route::get('/register', function () {
//     return view('auth.register');
// });
// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('inquiry');
//     }
//     return redirect()->route('login');
// });
Route::get('/', function () {
    if(auth()->check()){
        $user = auth()->user();
        switch($user->roleName()){
            case 'admin':
                return redirect()->route('register');
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

Route::get('/inquiry', function () {
    return view('inquiry');
})->middleware(['auth', 'verified'])->name('inquiry.form');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
// Route::middleware('auth')->group(function () {
//     Route::get('/department-tasks/{department}', [InquiryController::class, 'departmentTasks'])
//         ->name('departments.index')
//         ->middleware('can:access-department,department'); // Gateで権限チェック
// });

Route::middleware(['auth', 'can:access-it'])->prefix('it')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'itTasks'])->name('it.index');
    Route::post('/assign/{inquiry}', [InquiryController::class, 'assign'])->name('it.assign');
    Route::post('/logs/{id}', [InquiryController::class, 'itHandled'])->name('it.markHandled');
    Route::get('/logs', [InquiryController::class, 'itLogs'])->name('it.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('it.updateDetails');
});
Route::middleware(['auth', 'can:access-software'])->prefix('software')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'softwareTasks'])->name('software.index');
    Route::post('/handled/{inquiryId}/', [InquiryController::class, 'markHandled'])->name('software.markHandled');
    Route::get('/logs', [InquiryController::class, 'softwareLogs'])->name('software.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('software.updateDetails');
});
// Route::middleware(['auth', 'can:access-hardware'])->get('/hardware-tasks', [PostController::class, 'indexHardware'])->name('tasks.hardware');
Route::middleware(['auth', 'can:access-hardware'])->prefix('hardware')->group(function () {
    Route::get('/tasks', [InquiryController::class, 'hardwareTasks'])->name('hardware.index');
    Route::post('/handled/{inquiryId}/', [InquiryController::class, 'markHandled'])->name('hardware.markHandled');
    Route::get('/logs', [InquiryController::class, 'hardwareLogs'])->name('hardware.logs');
    Route::patch('/logs/{id}/update-details', [InquiryController::class, 'updateDetails'])
    ->name('hardware.updateDetails');
});
// Route::middleware(['auth', 'can:access-network'])->get('/network-tasks', [PostController::class, 'indexNetwork'])->name('tasks.network');
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
Route::post('store', 'App\Http\Controllers\InquiryController@store')->name('inquiry.store');
// Route::post('/it-log/update/{id}', [InquiryController::class, 'updateDetails'])->name('log.updateDetail');
// Route::get('/logs/{type}', [InquiryController::class, 'logIndex'])
//     ->where('department', 'network|hardware|software')
//     ->name('logs.index');
Route::middleware('auth')->group(function () {
    Route::get('/department/{department}/logs', [InquiryController::class, 'logIndex'])
        ->name('logs.index');
});

require __DIR__.'/auth.php';


