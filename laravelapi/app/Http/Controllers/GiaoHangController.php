<?php

namespace App\Http\Controllers;

use App\Models\GiaoHang;
use App\Models\GiaoHang_DanhGia;
use App\Models\GioHang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiaoHangController extends Controller
{
    //
    public function themGiaoHang(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNhanVienGiaoHang = $request->input('idNhanVienGiaoHang');
        $idDonHang = $request->input('idDonHang');
        $trangThaiDonHang = 'daChiDinhGiaoHang';

        $giaoHang = new GiaoHang();
        $giaoHang->idCaLamViec = $idCaLamViec;
        $giaoHang->idNhanVienGiaoHang = $idNhanVienGiaoHang;
        $giaoHang->trangThaiDonHang = $trangThaiDonHang;
        $giaoHang->idDonHang = $idDonHang;
        $thoigian = Carbon::now('Asia/Ho_Chi_Minh');
        $thoigianchidinh = $thoigian->toTimeString();
        $giaoHang->thoiGianDonHangDuocChiDinh = $thoigianchidinh;

        $gioHangCanCapNhatTrangThai = GioHang::where('id', '=', $idDonHang);
        $gioHangCanCapNhatTrangThai->update([
            'trangThaiDonHang' => 'daChiDinhGiao'
        ]);
        if($giaoHang->save()){
            return response()->json(['mess'=>'Them giao thanh cong'], 200);
        }else{
            return response()->json(['mess'=>'Co loi xay ra'], 500);
        }
    }

    

    public function themDanhGia(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNhanVienGiaoHang = $request->input('idNhanVienGiaoHang');
        $idDonHang = $request->input('idDonHang');
        $danhGiaKhachHang = $request->input('danhGia');

        $giaoHangCanCapNhatDanhGia = GiaoHang::where('idCaLamViec', $idCaLamViec)
                        ->where('idDonHang', $idDonHang)
                        ->where('idNhanVienGiaoHang', $idNhanVienGiaoHang);
        
        $check = $giaoHangCanCapNhatDanhGia->update([
            'danhGiaKhachHang' => $danhGiaKhachHang
        ]);

        $gioHangCanCapNhatTrangThai = GioHang::where('id', '=', $idDonHang);
        $gioHangCanCapNhatTrangThai->update([
            'trangThaiDonHang' => 'daDanhGiaNguoiGiao'
        ]);


        return response()->json([
            'mess'=>$check
        ]);
    }

    public static  function themDanhGia2(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNhanVienGiaoHang = $request->input('idNhanVienGiaoHang');
        $idDonHang = $request->input('idDonHang');
        $idKhachHangDanhGia = $request->input('idKhachHang');
        $danhGiaKhachHang = $request->input('danhGia');

        $themDanhGia = GiaoHang_DanhGia::where('idNguoiGiaoHang', '=', $idNhanVienGiaoHang)
        ->where('idDonHang', '=', $idDonHang)
        ->where('idKhachHangDanhGia', '=', $idKhachHangDanhGia);

        $check = GiaoHang_DanhGia::insert([
            'idNguoiGiaoHang' => $idNhanVienGiaoHang,
            'idDonHang' => $idDonHang,
            'idKhachHangDanhGia' => $idKhachHangDanhGia,
            'soSaoDanhGia' => $danhGiaKhachHang
        ]);
        
        $gioHangCanCapNhatTrangThai = GioHang::where('id', '=', $idDonHang);
        $gioHangCanCapNhatTrangThai->update([
            'trangThaiDonHang' => 'daDanhGiaNguoiGiao'
        ]);


        return response()->json([
            'mess'=>$check
        ]);
    }

    public function capNhatDanhGia(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNhanVienGiaoHang = $request->input('idNhanVienGiaoHang');
        $idDonHang = $request->input('idDonHang');
        $idKhachHangDanhGia = $request->input('idKhachHang');
        $danhGiaKhachHang = $request->input('danhGia');

        $themDanhGia = GiaoHang_DanhGia::where('idNguoiGiaoHang', '=', $idNhanVienGiaoHang)
        ->where('idDonHang', '=', $idDonHang)
        ->where('idKhachHangDanhGia', '=', $idKhachHangDanhGia);

        $check = $themDanhGia->update([
            'soSaoDanhGia' => $danhGiaKhachHang
        ]);


        return response()->json([
            'mess'=>$check
        ]);
    }

    public function checkTruocKhiThemDanhGia(Request $request){
        $idCaLamViec = $request->input('idCaLamViec');
        $idNhanVienGiaoHang = $request->input('idNhanVienGiaoHang');
        $idDonHang = $request->input('idDonHang');
        $idKhachHangDanhGia = $request->input('idKhachHang');
        $danhGiaKhachHang = $request->input('danhGia');

        $themDanhGia = GiaoHang_DanhGia::where('idNguoiGiaoHang', '=', $idNhanVienGiaoHang)
        ->where('idDonHang', '=', $idDonHang)
        ->where('idKhachHangDanhGia', '=', $idKhachHangDanhGia)
        ->get();

        $check = 0;

        if(!count($themDanhGia)){
            //them moi;
            echo '123';
            GiaoHangController::themDanhGia2($request);
        }else{
           //cap nhat
           echo '456';
           GiaoHangController::capNhatDanhGia($request);
        }
        


    }
    public function sapXepNhanVienGiaoHang($kieusapxep){
        if($kieusapxep === 'giamdan'){
            $kieusapxep = 'ASC';
        }elseif($kieusapxep === 'tangdan'){
            $kieusapxep = 'DESC';
        }
        $nvsapxep = DB::table('giao_hangs')
        ->select('idNhanVienGiaoHang', DB::raw('AVG(danhGiaKhachHang) AS danhgiatrungbinh'))
        ->groupBy('idNhanVienGiaoHang')
        ->orderBy('danhgiatrungbinh', $kieusapxep)
        ->get();

        return response()->json([
            'mess'=>$nvsapxep
        ]);
        
    }

    public function layDsChiDinhGiaoHang($idCaLamViec, $idNguoiGiaoHang){
        
        $dsDonhangChiDinh = GiaoHang::select(['giao_hangs.idDonHang', 'gio_hangs.idKhachHang', 'gio_hangs.tongTien', 'gio_hangs.idKhachHang', 'khach_hangs.tenDayDu', 'khach_hangs.soDienThoai', 'gio_hangs.diaChiNguoiNhan'])
       ->join('gio_hangs', function($join){
        $join->on('gio_hangs.id', '=', 'giao_hangs.idDonHang');
       })
       ->join('khach_hangs', function($join){
        $join->on('gio_hangs.idKhachHang', '=', 'khach_hangs.id');
         
       })
       ->where('giao_hangs.idNhanVienGiaoHang','=', $idNguoiGiaoHang)
       ->where('giao_hangs.idCaLamViec', '=', $idCaLamViec)
       ->where('gio_hangs.trangThaiDonHang', '=', 'daChiDinhGiao')
       
       ->get();

       return response()->json($dsDonhangChiDinh);
    }


    public function layDsDanhGiaCuaKhachHang($idNhanVienGiaoHang){
        $dsDanhGia = GiaoHang_DanhGia::select(['giao_hangs__danh_gia.idDonHang', 'giao_hangs__danh_gia.idKhachHangDanhGia', 'khach_hangs.tenDangNhap', 'khach_hangs.tenDayDu', 'giao_hangs__danh_gia.soSaoDanhGia'])
        ->join('khach_hangs', function($join){
            $join->on('khach_hangs.id', '=', 'giao_hangs__danh_gia.idKhachHangDanhGia');
        })
        ->where('giao_hangs__danh_gia.idNguoiGiaoHang', '=', $idNhanVienGiaoHang)
        ->get()
        ;

        return response()->json($dsDanhGia);
    }

    
     
    


}
