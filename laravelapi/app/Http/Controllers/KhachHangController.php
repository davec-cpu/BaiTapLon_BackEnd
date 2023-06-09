<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
class KhachHangController extends Controller
{
    //

    public function khachHangDangNhap(Request $request){
        $tendangnhap = $request->input('tenDangNhap');
        $matkhau = $request->input('matKhau');
        $khachhang = KhachHang::where('tenDangNhap', $tendangnhap)->first();
       // echo "ten dang nhap: ".$tendangnhap.", email: ".$matkhau;
        if(is_null($khachhang)){
            
            return response()->json([ 
            'mess'=>'Ten dang nhap khong ton tai',
          //  'matkhautusql'=>$matkhautuSql,
        ], 404);
        } else{
            $matkhautuSql = KhachHang::where('tenDangNhap', $tendangnhap)->value('matKhau');
            $tendangnhaptuSql = KhachHang::where('tenDangNhap', $tendangnhap)->value('matKhau');
            if( $matkhautuSql===$matkhau){

              //      App::make('App\Http\Controllers\GioHangController')->taoGioHang();

                return response()->json([
                    'mess'=> 'Dang nhap thanh cong',
                    'idkhachhang' => $khachhang
                ]);
            }else{
                return response()->json(['mess'=> 'Sai mat khau']);
            }
            return response()->json([
            //$khachhang,
            'matkhautusql'=>$matkhautuSql,
            'matkhauinput'=>$matkhau,
        ], 200);
        }


        
    }

    
    
    public function khachHangDangKi(Request $request){
        $tendangki = $request->input('tenDangKi');
        $matkhau = $request->input('matKhau');
        $tenDayDu = $request->input('tenDayDu');
        $soDonHangDaDat = 0;
        $soDonHangDaHuy = 0;
        $soDienThoai = $request->input('soDienThoai');
        $khachhang = KhachHang::where('tenDangNhap', $tendangki)->first();
        
        if(is_null($khachhang)){
            
            $khachhang = new KhachHang();
            $khachhang->tenDangNhap = $tendangki;
            $khachhang->matKhau = $matkhau;
            $khachhang->tenDayDu = $tenDayDu;
            $khachhang->soDonHangDaDat = $soDonHangDaDat;
            $khachhang->soDonHangDaHuy = $soDonHangDaHuy;
            $khachhang->soDienThoai = $soDienThoai;


            if($khachhang->save()){
                return response()->json(['mess'=>'Dang ki thanh cong']);
            }else{
                return response()->json(['mess'=>'Dang ki that bai']);
            }
        } else{
             
            return response()->json([
            'mess'=>'Ten tai khoan da ton tai'
        ], 200);
        }
    }    

    public function layThongTinCaNhan($id){
        $khachhang = KhachHang::find($id);
        if(is_null($khachhang)){
            return response()->json(['message'=>'Khong tim thay khach hang'], 404);
        }

        return response()->json($khachhang, 200);
    }

    public function chinhSuaThongTinCaNhan(Request $request, $id){
        $khachhang = KhachHang::find($id);

        if(is_null($khachhang)){
            return response()->json(
                ['mess'=>'Khong tim thay khach hang'],
                404);
        } 
            $khachhang->update($request->all());
            return response()->json([
            $khachhang,
            'mess'=>'Cap nhat thong tin khach hang thanh cong'
        ], 200);
    }

    public function layDanhSachKhachHang(){
       $x =  App::make('App\Http\Controllers\GioHangController')->sample(12);
        return response()->json([KhachHang::all(),
        'Mess'=>$x
    ], 200);
    }

    

    
}
