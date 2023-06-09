<?php

namespace App\Http\Controllers;

use App\Models\CaLamViec_NDonDep;
use Illuminate\Http\Request;

class CaLamViec_NDonDepController extends Controller
{
    //
    public function themNDonDep(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNDonDep    = $request->input('idNDonDep');

        $dondep = new CaLamViec_NDonDep();

        $dondep->idCaLamViec =  $idCaLamViec;
        $dondep->idNDonDep = $idNDonDep;

        if($dondep->save()){
            return response()->json(['mess'=>'Them moi thanh cong'], 200);
        }else{
            return response()->json(['mess'=>'Co loi xay ra'], 404);
        }
    }
}
