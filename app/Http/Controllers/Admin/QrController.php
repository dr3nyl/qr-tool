<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function index()
    {
        return view('admin.qr.create', [
            'user' => auth()->user()
        ]);
    }
}
