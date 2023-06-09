<?php

namespace App\Http\Controllers;

use App\Models\CaLamViec;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaLamViecController extends Controller
{
    //
    public function themCaLamViec(Request $request){
        $gioBatDau = $request->input('gioBatDau');
        $ngayLamViec = $request->input('ngayLamViec');

        $caLamViec = new CaLamViec();

        $caLamViec->gioBatDau =  date('H:i', strtotime($gioBatDau));
        $caLamViec->ngayLamViec = date('Y-m-d', strtotime($ngayLamViec));

        
        if($caLamViec->save()){
            return response()->json(['mess'=>'Them ca lam viec moi thanh cong'], 200);
        }else{
            return response()->json(['mess'=>'Co loi xay ra, them ca lam viec that bai'], 404);
        }
    }

    public function suaCaLamViec(Request $request){
        
    }

    public function layCaLamViec(Request $request){
        $thoigianhientai = Carbon::now('Asia/Ho_Chi_Minh');
        $giohientai = $thoigianhientai->toTimeString();
        $giohientai2 = '08:00:00';
        $ngayhientai = $thoigianhientai->toDateString();
        $caLamviec = CaLamViec::where('gioBatDau', '<', $giohientai2)
                ->where('gioKetThuc', '>', $giohientai2)
                ->where('ngayLamViec', '=', '2022-05-12')
                ->get();
        
        $time = '7:50:00';
        $trugio = CaLamViec::select([DB::raw('id, SUBTIME(gioBatDau, "'.$time.'") AS thoigianbatdau, SUBTIME(gioKetThuc, "'.$time.'") AS thoigianketthuc')])
        ->orderBy('thoigianbatdau', 'ASC')
        ->orderBy('thoigianketthuc', 'ASC')
        ->where('ngayLamViec', '=', '2022-05-12')
        ->first();





        return response()->json([
            'gio' => $giohientai,
            'ngay'=> $ngayhientai,
           // 'caLamViec'=>$caLamviec,
            'trugio'=>$trugio
        ]);
    }
}
