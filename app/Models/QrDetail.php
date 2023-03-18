<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number',
        'date_code',
        'vendor_code',
        'qr_code',
        'created_by'
    ];
}
