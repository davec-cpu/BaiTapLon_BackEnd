<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoHang extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'idCaLamViec',
        'idNhanVienGiaoHang',
        'idDonHang',
        'thoiGianDonHangDuocChiDinh',
        'thoiGianDonHangBatDauDuocGiao',
        'thoiGianDonHangDenNoi',
        'trangThaiDonHang'
    ];
}
