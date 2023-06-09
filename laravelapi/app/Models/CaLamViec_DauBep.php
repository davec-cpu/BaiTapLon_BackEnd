<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaLamViec_DauBep extends Model
{
    use HasFactory;

    protected $table = 'ca_lam_viecs__dau_bep';
    
    protected $fillable=[
        'idCaLamViec',
        'idDauBep'
    ];

    public $timestamps = false;
}
