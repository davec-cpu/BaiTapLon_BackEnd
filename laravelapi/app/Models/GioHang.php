<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $fillable = [
        'trangThaiDonHang',

    ];
    const CREATED_AT = 'ngayTao';
    const UPDATED_AT = 'ngayCapNhat';
}
