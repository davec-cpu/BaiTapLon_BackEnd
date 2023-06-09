<?php

namespace App\Http\Controllers;

use App\Models\CaLamViec_DauBep;
use Illuminate\Http\Request;

class CaLamViec_DauBepController extends Controller
{
    //

    public function themDauBep(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idDauBep    = $request->input('idDauBep');

        $daubep = new CaLamViec_DauBep();

        $daubep->idCaLamViec =  $idCaLamViec;
        $daubep->idDauBep = $idDauBep;

        if($daubep->save()){
            return response()->json(['mess'=>'Them moi thanh cong'], 200);
        }else{
            return response()->json(['mess'=>'Co loi xay ra'], 404);
        }
    }
}
