<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/transact', [TransactionController::class, 'store'])->name('transact.store');
Route::get('/transactions', [TransactionController::class, 'show'])->name('transact.show');

Route::get('/qrcode', function(){
    $qrCode = QrCode::format('eps')->size(200)->generate('testtesttest');
    $response = response($qrCode);
    $fileName = 'qrcode.png';
    return $response;
});
