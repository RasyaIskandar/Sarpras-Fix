<?php

use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// Redirect to login with a message after email verification
Route::get('/email/verified', function () {
    return redirect()->route('login')->with('status', 'Email berhasil diverifikasi. Silakan login.');
})->name('verification.redirect');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminLaporanController::class, 'index'])->name('dashboard');
    Route::patch('/laporan/{id}/update-status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
});

Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
Route::patch('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('laporan', LaporanController::class);
});

Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])
    ->name('laporan.destroy');

Route::get('/chart-data', [LaporanController::class, 'chartData'])->name('chart.data');


Route::get('send-mail', [EmailsController::class, 'welcomeMail']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/laporan/export-pdf/{mode?}', [AdminLaporanController::class, 'exportPdf'])
        ->name('laporan.exportPdf');
});


require __DIR__ . '/auth.php';
