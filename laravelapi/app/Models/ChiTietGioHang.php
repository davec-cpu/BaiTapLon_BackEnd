<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'soLuongSanPham',
        'giaSanPham',
        'idSanPham',
        'idGioHang'
    ];
    public $timestamps = false;
}
