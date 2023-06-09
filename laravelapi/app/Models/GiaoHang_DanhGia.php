<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoHang_DanhGia extends Model
{
    use HasFactory;
    protected $table = 'giao_hangs__danh_gia';
    public $timestamps = false;

    protected $fillable = [
        'idDonHang',
        'idKhachHangDanhGia',
        'idNguoiGiaoHang',
        'soSaoDanhGia'
    ];
}
