<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaLamViec_NGiaoHang extends Model
{
    use HasFactory;

    protected $table = 'ca_lam_viecs__ngiao_hang';

    protected $fillable=[
        'idCaLamViec',
        'idNGiaoHang'
    ];

    public $timestamps = false;
}
