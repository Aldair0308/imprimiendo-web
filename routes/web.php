<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrinterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QRController::class, 'index'])->name('home');
Route::get('/scan/{token}', [QRController::class, 'scan'])->name('qr.scan');
Route::post('/qr/refresh', [QRController::class, 'refresh'])->name('qr.refresh');
Route::post('/qr/validate', [QRController::class, 'validateToken'])->name('qr.validate');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('printers', PrinterController::class);
    });
});

require __DIR__.'/auth.php';
