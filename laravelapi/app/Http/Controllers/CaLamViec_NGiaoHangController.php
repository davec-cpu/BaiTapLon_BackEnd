<?php

namespace App\Http\Controllers;

use App\Models\CaLamViec_NGiaoHang;
use Illuminate\Http\Request;

class CaLamViec_NGiaoHangController extends Controller
{
    //

    public function themNGiaoHang(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNGiaoHang    = $request->input('idNGiaoHang');

        $giaohang = new CaLamViec_NGiaoHang();

        $giaohang->idCaLamViec =  $idCaLamViec;
        $giaohang->idNGiaoHang = $idNGiaoHang;

        if($giaohang->save()){
            return response()->json(['mess'=>'Them moi thanh cong'], 200);
        }else{
            return response()->json(['mess'=>'Co loi xay ra'], 404);
        }
    }

    
}
