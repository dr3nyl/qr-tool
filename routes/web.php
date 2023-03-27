<?php

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\QrDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TransactionController::class, 'index'])->name('home');
Route::get('/admin', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/qrcode/{data}', [QrDetailController::class, 'download'])->name('qrcode.download');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group([
        'prefix' => 'admin',
        'middleware' => 'is_admin',
        'as' => 'admin.'
    ], function () {
        Route::get('qr', [QrDetailController::class, 'index'])->name('qr.index');
        Route::post('qr', [QrDetailController::class, 'store'])->name('qr.store');

        Route::get('export', [ExportController::class, 'index'])->name('export');
    });
});


require __DIR__.'/auth.php';
