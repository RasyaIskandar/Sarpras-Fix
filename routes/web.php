<?php

use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','admin'])->group(function() {
    Route::get('/dashboard', [AdminLaporanController::class, 'index'])->name('dashboard');
    Route::patch('/laporan/{id}/update-status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
});

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


require __DIR__.'/auth.php';
