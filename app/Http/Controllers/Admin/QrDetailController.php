<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrDetail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrDetailController extends Controller
{
    public function index()
    {
        return view('admin.qr.create', [
            'user' => auth()->user()
        ]);
    }

    public function download($qr_id)
    {
        if(empty($qr_id)){
            die('no');
        }
        $data = QrDetail::where('id', $qr_id)->pluck('qr_code')->first();
        if(empty($data)){
            return false;
        }
        $qrCode = QrCode::format('png')->size(200)->margin(1)->errorCorrection('H')->generate($data);
        $response = response($qrCode)->header('Content-Type', 'image/png');

        $data = replace_special_chars__($data);
        $fileName = $data.'.png';
        
        activity_log('DOWNLOADQR', $data);

        return $response->header('Content-Disposition', "attachment; filename=$fileName");
    }
}
