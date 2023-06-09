<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang_DiaChiNhanHang extends Model
{
    protected $table = 'khach_hang__dia_chi_nhan_hang';
    protected $fillable = [
        'idKhachHang',
        'diaChiNhanHang'
    ];
    use HasFactory;
}
