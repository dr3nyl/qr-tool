<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQrRequest;
use App\Models\QrDetail;
use App\Models\QrDetails;
use Illuminate\Http\Request;

class QrDetailController extends Controller
{
    public function index()
    {
        return view('admin.qr.create', [
            'user' => auth()->user()
        ]);
    }

    public function store(StoreQrRequest $request)
    {
        QrDetail::create([
            'part_number' => request('part_number'),
            'date_code' => request('date_code'),
            'vendor_code' => request('vendor_code'),
            'qr_code' => request('part_number').'-'.request('date_code').'-'.request('vendor_code'),
            'created_by' => auth()->user()->name
        ]);

        return redirect()->back();
    }
}
