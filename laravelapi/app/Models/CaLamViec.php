<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaLamViec extends Model
{
    use HasFactory;

    protected $table = 'ca_lam_viecs';

    protected $fillable=[
        'gioBatDau',
        'ngayLamViec'
    ];

    public $timestamps = false;
}
