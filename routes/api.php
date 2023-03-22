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
    $qrCode = QrCode::format('png')->size(200)->generate('$qrcode')->toHtml();
   $x = 'data:image/png;base64,'.base64_encode($qrCode);
    // dd($qrCode); die();
    // $response = response($qrCode);
    // $fileName = 'qrcode.png';
    // public function downloadQRCode($data)
    // {
    //     $qrCode = QrCode::format('png')->size(200)->generate($data);
    //     $response = response($qrCode)->header('Content-Type', 'image/png');
    //     $fileName = 'qrcode.png';
    //     return $response->header('Content-Disposition', "attachment; filename=$fileName");
    // }
        //    $x = 'data:image/png;base64,'.base64_encode($qrCode);
        //    // dd($x);
        // $response = response(base64_decode($x))->header('Content-Type', 'image/png');
        // $fileName = 'qrcode.png';
        // return $response->header('Content-Disposition', "attachment; filename=$fileName");



    $data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
           . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
           . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
           . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';

    $zip = new ZipArchive;
    $fileName = 'zipFileName2.zip';
    if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
    {
        for ($i=0; $i < 2; $i++) { 
            $qrCode = QrCode::format('png')->size(200)->generate('$qrcode'.$i)->toHtml();
            $relativeNameInZipFile = 'qrcode'.$i.'.png';
            $zip->addFromString($relativeNameInZipFile,$qrCode);
        }
        $zip->close();
    }
    return response()->download(public_path($fileName));
});
