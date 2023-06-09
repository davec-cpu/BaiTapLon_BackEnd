<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ChiTietGioHang;
use App\Models\GioHang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GiaoHang;
use App\Models\GiaoHang_DanhGia;
use App\Models\KhachHang_DiaChiNhanHang;

use function PHPUnit\Framework\isNull;

class GioHangController extends Controller
{
    //
    public function taoGioHang($idkhachhang){
        $trangThai= 'gioHang';
        $mess = '';
        $truyVanGoc = GioHang::where('idKhachHang', $idkhachhang)->where('trangThaiDonHang', $trangThai);
        $giohangkhachhang = $truyVanGoc->first();

        //echo 'Sql: '.$giohangkhachhang.'        ----';
        $idgiohang = 0;
        if(is_null($giohangkhachhang)){
             

            $idgiohang = GioHang::insertGetId([
                'idKhachHang' => $idkhachhang,
                'trangThaiDonHang'=>$trangThai
            ]);
            $mess = 'Khach hang chua co gio';
          
          

        }else{
           // echo 'Khach da co gio hang ';
           $idgiohang = $truyVanGoc->value('id');
             
            $mess = 'Khach hang da co gio';
        }

        
        return response()->json([
            'icasd'=>$giohangkhachhang,
            'id'=>$idgiohang,
            'mess'=> $mess
        ]);
    }
    public function testTaoGioHang($id){
        $trangThai= 'gioHang';
        $mess = '';
        $idgiohang = 0;
        $sample = GioHang::where('idKhachHang', $id)->where('trangThaiDonHang', $trangThai);
        $giohangkhachhang = $sample->first();
        if(is_null($giohangkhachhang)){
            echo 'khach hang chua co gio';
        }else{
            $idgiohang = $sample->value('id');
            echo 'Khach hang da co gio';
        }

         
        return response()->json([
            'icasd'=>$giohangkhachhang,
            'idgiohang'=>$idgiohang,
            'mess'=> $mess
        ]);
    }

     

    public function datHang($idgiohang){
        $giohangdathang = GioHang::find($idgiohang);
        
        if(is_null($giohangdathang)){
            return response()->json([
                'mess'=>'Khong tim thay gio hang'
            ], 404);
        }else{
            $giohangdathang->update(['trangThaiDonHang' => 'donHang']);
            return response()->json([
                'mess'=>'Dat hang thanh cong'
            ], 200);
        }
    }

    public function nhanHoacTuChoiDonHang($idgiohang, $trangthai){
        $giohang  = GioHang::find($idgiohang);
        
        if(is_null($giohang)){
            return response()->json([
                'mess'=>'Khong tim thay gio hang'
            ], 404);
        }else{
            if($trangthai === 'chapNhan'){
                $giohang->update(['trangThaiDonHang' => 'daChapNhan']);
                return response()->json([
                'mess'=>'Don hang da duoc chap nhan'
            ], 200);
            }else{
                $giohang->update(['trangThaiDonHang' => 'daTuChoi']);
                return response()->json([
                'mess'=>'Don hang da bi tu choi'
            ], 200);
            }
        }
    }

    public function layDanhSachDonHangDaCheBienXong(){
        $donHangCheBienXong = GioHang::select(['gio_hangs.id', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'khach_hangs.tenDangNhap', 'khach_hangs.tenDayDu'])
        ->join('khach_hangs', function ($join){
            $join->on('gio_hangs.idKhachHang', '=', 'khach_hangs.id');
        })
        ->where('gio_hangs.trangThaiDonHang', '=', 'daCheBienXong')
        ->get();
        return response()->json($donHangCheBienXong, 200);


    }

    public function sample($x){
        return  $x +1;
    }

    public function layDanhSachDonHang(){
        // SELECT gio_hangs.id, gio_hangs.idKhachHang, gio_hangs.tongTien, khach_hangs.tenDangNhap, khach_hangs.tenDayDu FROM gio_hangs
        //     INNER JOIN khach_hangs ON gio_hangs.idKhachHang = khach_hangs.id WHERE  gio_hangs.trangThaiDonHang = 'donHang'


        $query2 = GioHang::select(['gio_hangs.id', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'khach_hangs.tenDangNhap', 'khach_hangs.tenDayDu'])
                ->join('khach_hangs', function ($join){
                    $join->on('gio_hangs.idKhachHang', '=', 'khach_hangs.id');
                })
                ->where('gio_hangs.trangThaiDonHang', '=', 'daDat')
                ->get();

                return response()->json($query2);
    }

    public function layDsDonHangDaNhan(){
        $query = GioHang::select(['gio_hangs.id', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'khach_hangs.tenDangNhap', 'khach_hangs.tenDayDu'])
                ->join('khach_hangs', function ($join){
                    $join->on('gio_hangs.idKhachHang', '=', 'khach_hangs.id');
                })
                ->where('gio_hangs.trangThaiDonHang', '=', 'daChapNhan')
                ->get()
                //->toSql()
                ;
                
        return response()->json($query);
    }

    public function layDsDonHangDaGiaoDenNoi($idkhachhang){
       // echo $idkhachhang;
        $query = GioHang::select(['gio_hangs.id AS idGioHang', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'admins.id AS idNguoiGiaoHang', 'admins.tenDangNhap', 'admins.tenDayDu'])
        ->join('giao_hangs', function ($join){
            $join->on('gio_hangs.id', '=', 'giao_hangs.idDonHang');
        })
        ->join('admins', function ($join){
            $join->on('admins.id', '=', 'giao_hangs.idNhanVienGiaoHang');
        })
        ->where('gio_hangs.idKhachHang','=', $idkhachhang)
        ->where('gio_hangs.trangThaiDonHang', '=', 'daGiaoToiNoi')
        ->get()
        //->toSql()
        ;

        return response()->json($query);
    }

    public function thayDoiTrangThai(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNhanVienGiaoHang = $request->input('idNhanVienGiaoHang');
        $idDonHang = $request->input('idDonHang');
        $trangThaiDonHang = $request->input('trangThaiDonHang');
         
      //  $thoiGianHoanThanhDonHang = $request->input('thoiGianHoanThanhDonHang');

        $giaoHangCanCapNhatTrangThai = GiaoHang::where('idCaLamViec', $idCaLamViec)
                        ->where('idDonHang', $idDonHang)
                        ->where('idNhanVienGiaoHang', $idNhanVienGiaoHang);

        $gioHangCanCapNhatTrangThai = GioHang::where('id', $idDonHang);
        
       

        if(is_null($gioHangCanCapNhatTrangThai)){
            return response()->json([
                'mess'=>'Khong tim thay daubepchebien'
            ]);
        }

        $thoiGian = Carbon::now('Asia/Ho_Chi_Minh');
        
        if($trangThaiDonHang === 'dangGiao'){ //bat dau giao hang
                
                $thoiGianDonHangBatDauDuocGiao = $thoiGian->toTimeString();

                $giaoHangCanCapNhatTrangThai->update([
                
                'thoiGianDonHangBatDauDuocGiao'=>$thoiGianDonHangBatDauDuocGiao
                ]);

                $gioHangCanCapNhatTrangThai->update([
                    'trangThaiDonHang'=>'dangGiao'
                ]);

                return response()->json([
                    'mess' => 'dangGiao thanh cong'
                ], 204);
        }
        elseif($trangThaiDonHang === 'daGiaoToiNoi'){ //chi dinh dau bep
                 
                $thoiGianDonHangDenNoi = $thoiGian->toTimeString();
                // $giaoHangCanCapNhatTrangThai->update([
                // 'trangThaiDonHang'=>'daGiaoToiNoi',
                // 'thoiGianDonHangDenNoi'=>$thoiGianDonHangDenNoi
                // ]);

                    $giaoHangCanCapNhatTrangThai->update([
                
                    'thoiGianDonHangDenNoi'=>$thoiGianDonHangDenNoi
                    ]);
    
                    $gioHangCanCapNhatTrangThai->update([
                        'trangThaiDonHang'=>'daGiaoToiNoi'
                    ]);

                return response()->json([
                    'mess' => 'daGiaoToiNoi thanh cong'
                ], 204);
        } elseif($trangThaiDonHang === 'daThanhToan'){
            $idKhachHangDanhGia = $request->input('idKhachHang');
            $danhGiaKhachHang = $request->input('danhGia');
            $thoiGianThanhToan = $thoiGian->toDateTimeString();

           // echo 'ndakvnwdk'.$thoiGianThanhToan;

            $gioHangCanCapNhatTrangThai->update([
                'trangThaiDonHang'=>'daThanhToan',
                'ngayGioThanhToan'=>$thoiGianThanhToan
            ]);
            $saoDanhGia = 0;
            $check = GiaoHang_DanhGia::insert([
                'idNguoiGiaoHang' => $idNhanVienGiaoHang,
                'idDonHang' => $idDonHang,
                'idKhachHangDanhGia' => $idKhachHangDanhGia,
                'soSaoDanhGia' => $saoDanhGia
            ]);
            

        return response()->json([
            'mess' => 'daThanhToan thanh cong',
            'idKhachHangDanhGia'=>$idKhachHangDanhGia
           // 'trangthaicapnhat' => $check
        ], 204);
        }elseif($trangThaiDonHang === 'daDat'){
            $idKhachHang = $request->input('idKhachHang');
            $diaChiNhanHang = $request->input('diaChiNhanHang');
            $gioHangCanCapNhatTrangThai->update([
                'trangThaiDonHang'=>'daDat',
                'diaChiNguoiNhan'=>$diaChiNhanHang
            ]);
            GioHangController::taoGioHang($idKhachHang);

            return response()->json([
                'mess' => 'daDat thanh cong'
            ], 204);
        }  
    }

    public function layDsDonHangDaThanhToanXong($idkhachhang){
        // echo $idkhachhang;
         $dsDaThanhToanNhungChuaDanhGia = GioHang::select(['gio_hangs.id AS idDonHang', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'admins.id AS idNguoiGiaoHang', 'admins.tenDangNhap', 'admins.tenDayDu', 'giao_hangs.idCaLamViec', 'giao_hangs.danhGiaKhachHang', 'giao_hangs__danh_gia.soSaoDanhGia  as danhgiakh'])
         ->join('giao_hangs', function ($join){
             $join->on('gio_hangs.id', '=', 'giao_hangs.idDonHang');
         })
         ->join('admins', function ($join){
             $join->on('admins.id', '=', 'giao_hangs.idNhanVienGiaoHang');
         })
         ->join('giao_hangs__danh_gia', function ($join){
            $join->on('gio_hangs.id', '=', 'giao_hangs__danh_gia.idDonHang');
        })
         ->where(function($query) use ($idkhachhang){
            $query->where('gio_hangs.idKhachHang','=', $idkhachhang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daThanhToan');
         })
        ->orWhere(function($query) use ($idkhachhang){
            $query->where('gio_hangs.idKhachHang','=', $idkhachhang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daDanhGiaNguoiGiao');
         })
        // ->orWhere('gio_hangs.trangThaiDonHang', '=', 'daDanhGiaNguoiGiao')
         ->get()
        // ->toSql()
         ;

         $dsDaThanhToanVaDaDanhGia = GioHang::select(['gio_hangs.id AS idDonHang', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'admins.id AS idNguoiGiaoHang', 'admins.tenDangNhap', 'admins.tenDayDu', 'giao_hangs.idCaLamViec', 'giao_hangs.danhGiaKhachHang', 'giao_hangs__danh_gia.soSaoDanhGia  as danhgiakh'])
         ->join('giao_hangs', function ($join){
             $join->on('gio_hangs.id', '=', 'giao_hangs.idDonHang');
         })
         ->join('admins', function ($join){
             $join->on('admins.id', '=', 'giao_hangs.idNhanVienGiaoHang');
         })
         ->join('giao_hangs__danh_gia', function ($join){
            $join->on('gio_hangs.id', '=', 'giao_hangs__danh_gia.idDonHang');
        })
         ->where(function($query) use ($idkhachhang){
            $query->where('gio_hangs.idKhachHang','=', $idkhachhang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daThanhToan');
         })
        ->orWhere(function($query) use ($idkhachhang){
            $query->where('gio_hangs.idKhachHang','=', $idkhachhang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daDanhGiaNguoiGiao');
         })
        // ->orWhere('gio_hangs.trangThaiDonHang', '=', 'daDanhGiaNguoiGiao')
        ->get()
        //->toSql()
         ;

         


        //  $idNguoiGiaoHang = $query->value('idNguoiGiaoHang');
         
        //  $adminCanCapNhatDanhGia = Admin::where('id', '=', $idNguoiGiaoHang);

         return response()->json($dsDaThanhToanNhungChuaDanhGia);
     }

     public function themDiaChi(Request $request){
        $idKhachHang = $request->input('idKhachHang');
        $diaChiNhanHang = $request->input('diaChiNhanHang');

        $themMoi = KhachHang_DiaChiNhanHang::insert([
            'idKhachHang' => $idKhachHang,
            'diaChiNhanHang' => $diaChiNhanHang,
        ]);

        $datHang = GioHangController::thayDoiTrangThai($request);
 

        return response()->json($datHang);


        

     }

     public function dsDiaChiNhanHang($idKhachHang){
        $ds = KhachHang_DiaChiNhanHang::where('idKhachHang', '=', $idKhachHang)
            ->get();
         return response()->json($ds);
     }
}
