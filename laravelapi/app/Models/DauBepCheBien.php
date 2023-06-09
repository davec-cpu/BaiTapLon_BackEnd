<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DauBepCheBien extends Model
{
    use HasFactory;

    protected $table = 'dau_bep_che_biens';
    public $timestamps = false;

    protected $fillable = [
        'idDauBep',
        'idSanPhamDuocGiao',
        'idDonHang',
        'thoiGianCheBien',
        'danhGiaKhachHang'
    ];
}
