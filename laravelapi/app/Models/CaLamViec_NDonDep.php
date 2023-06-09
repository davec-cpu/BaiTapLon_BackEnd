<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaLamViec_NDonDep extends Model
{
    use HasFactory;

    protected $table = 'ca_lam_viecs__n_don_dep';

    protected $fillable=[
        'idCaLamViec',
        'idNDonDep'
    ];

    public $timestamps = false;
}
