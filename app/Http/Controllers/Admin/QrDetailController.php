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
            $request->validated()
        ]);
    }
}
