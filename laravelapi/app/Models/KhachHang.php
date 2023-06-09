<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class KhachHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenDangNhap',
        'matKhau',
        'tenDayDu',
        'soDonHangDaDat',
        'soDonHangDaHuy',
    ];


    public function khachHangDangNhap(Request $request){
        $tendangnhap = $request->input('tenDangNhap');
        $matkhau = $request->input('matKhau');
        $khachhang = KhachHang::where('tenDangNhap', $tendangnhap)->first();
        
        if(is_null($khachhang)){
            
            return response()->json([ 
            'mess'=>'Ten dang nhap khong ton tai',
          
        ], 404);
        } else{
            $matkhautuSql = KhachHang::where('tenDangNhap', $tendangnhap)->value('matKhau');
            $tendangnhaptuSql = KhachHang::where('tenDangNhap', $tendangnhap)->value('matKhau');
            if( $matkhautuSql===$matkhau){
                return response()->json(['mess'=> 'Dang nhap thanh cong']);
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
}
