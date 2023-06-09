<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CaLamViec;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\RequestFactoryInterface;

class AdminController extends Controller
{
    //

    

    public function adminDangNhap(Request $request){
        $tendangnhap = $request->input('tenDangNhap');
        $matkhau = $request->input('matKhau');
        $khachhang = Admin::where('tenDangNhap', $tendangnhap)->first();
       // echo "ten dang nhap: ".$tendangnhap.", email: ".$matkhau;
        if(is_null($khachhang)){
            
            return response()->json([ 
            'mess'=>'Ten dang nhap khong ton tai',
          //  'matkhautusql'=>$matkhautuSql,
        ], 404);
        } else{
            $matkhautuSql = Admin::where('tenDangNhap', $tendangnhap)->value('matKhau');
            $id = Admin::where('tenDangNhap', $tendangnhap)->value('id');
            if( $matkhautuSql===$matkhau){

              //      App::make('App\Http\Controllers\GioHangController')->taoGioHang();

                return response()->json([
                    'mess'=> 'Dang nhap thanh cong',
                    'thongtinadmin' => $khachhang,
                    'id'=>$id,
                    'idCaLamViec'=>'1'
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
    public function themnv(Request $request){
        $tenDangNhap = $request->input('tenDangNhap');
        $matKhau = $request->input('matKhau');
        $tenDayDu = $request->input('tenDayDu');
        $diaChi = $request->input('diaChi');
        $soDienThoai = $request->input('soDienThoai');
        $vaiTro = $request->input('vaiTro');
        $email = $request->input('email');
        $nhanvien = Admin::where('tenDangNhap', $tenDangNhap)->first();

        if(is_null($nhanvien)){
            $nhanvien = new Admin();
            $nhanvien->tenDangNhap = $tenDangNhap;
            $nhanvien->matKhau = $matKhau;
            $nhanvien->tenDayDu = $tenDayDu;
            $nhanvien->diaChi = $diaChi;
            $nhanvien->soDienThoai = $soDienThoai;
            $nhanvien->vaiTro = $vaiTro;
            $nhanvien->email = $email;
            if($nhanvien->save()){
                return response()->json(['mess'=>'Them nhan vien moi thanh cong'], 200);
            }else{
                return response()->json(['mess'=>'Co loi xay ra'], 400);
            }
        }else{
            return response()->json([
                'mess'=>'Ten nhan vien da ton tai'
            ]);
        }
    }

    public function layDsNhanVien(){
        return response()->json(Admin::all(), 200);
    }

    public function layMotNhanVien($id){

        // $sanPham = SanPham::find($id);
        // if(is_null($sanPham)){
        //     return response()->json(
        //         ['mess'=>'Khong tim thay san pham'],
        //         404);
        // } 
        //     $sanPham->update($request->all());
        //     return response()->json([
        //     $sanPham,
        //     'mess'=>'Cap nhat thanh cong'
        // ], 200);
        $nhanvien = Admin::find($id);
        if(is_null($nhanvien)){
            return response()->json(
                ['mess'=>'Khong tim thay nhan vien'],
                404);
        } 
            
            return response()->json([
                'nhanvien' => $nhanvien
            ], 200);
    }

    public function suaNhanVien(Request $request, $id){
        $nhanviensua = Admin::find($id);
        
        if(is_null($nhanviensua)){
            return response()->json([
                'mess'=>'Khong tim thay nhan vien sua'
            ], 404);

        }else{
            $nhanviensua->update($request->all());
            return response()->json([
                'mess'=>'Cap nhat thong tin nhan vien thanh cong'
            ], 200);
        }
    }

    public function xoaNhanVien($id){
        $nhanvienxoa = Admin::find($id);
     
        if(is_null($nhanvienxoa)){
            return response()->json([
                'mess'=>'Khong tim thay nhan vien'
            ], 404);
        }else{
              $nhanvienxoa->delete();
            return response()->json([
                'mess'=>'Xoa nhan vien thanh cong'
            ], 200);
        }
    }

    public function layTatCaDauBep(){
        $dsDauBep = Admin::all()->where('vaiTro', 'dauBep');
        return response()->json($dsDauBep, 200);
    }

    public function layTatCaNguoiGiaoHang(){
        $dsNguoiGiaoHang = Admin::all()->where('vaiTro', 'giaoHang');
        return response()->json($dsNguoiGiaoHang, 200);
    }


    public function dsDauBepCoTheChiDinh(){
        $timeorg = Carbon::now();
        $Date = $timeorg->toDateString();
        $Time = $timeorg->toTimeString();

        $test = CaLamViec::whereDate('ngayLamViec', '=', '2022-05-12')
       ->where('gioBatDau', '<=', '8:00:00')
       ->where('gioKetThuc', '>=', '8:00:00')
       ->toSql();

       $dsDauBep = CaLamViec::select(['ca_lam_viecs__dau_bep.idDauBep', 'admins.tenDangNhap', 'ca_lam_viecs.gioBatDau', 'ca_lam_viecs.id', 'admins.tenDayDu'])
       ->join('ca_lam_viecs__dau_bep', function($join){
            $join->on('ca_lam_viecs__dau_bep.idCaLamViec', '=', 'ca_lam_viecs.id');
       })

       ->join('admins', function ($join){
        $join->on('admins.id', '=', 'ca_lam_viecs__dau_bep.idDauBep');
    })
       ->whereDate('ngayLamViec', '=', '2022-05-12')
       ->where('gioBatDau', '<=', '8:00:00')
       ->where('gioKetThuc', '>=', '8:00:00')
   //    ->where('admins.trangThai', '=', 'dangCho')
       ->get();

        return response()->json($dsDauBep);
        
         
    }

    public function dsNGiaoHangCoTheChiDinh(){
        $timeorg = Carbon::now();
        $Date = $timeorg->toDateString();
        $Time = $timeorg->toTimeString();

        $test = CaLamViec::whereDate('ngayLamViec', '=', '2022-05-12')
       ->where('gioBatDau', '<=', '8:00:00')
       ->where('gioKetThuc', '>=', '8:00:00')
       ->toSql();

       $dsDauBep = CaLamViec::select(['ca_lam_viecs__ngiao_hang.idNGiaoHang', 'admins.tenDangNhap', 'ca_lam_viecs.gioBatDau', 'ca_lam_viecs.id as idCaLamViec', 'admins.tenDayDu'])
       ->join('ca_lam_viecs__ngiao_hang', function($join){
            $join->on('ca_lam_viecs__ngiao_hang.idCaLamViec', '=', 'ca_lam_viecs.id');
       })

       ->join('admins', function ($join){
        $join->on('admins.id', '=', 'ca_lam_viecs__ngiao_hang.idNGiaoHang');
    })
       ->whereDate('ngayLamViec', '=', '2022-05-12')
       ->where('gioBatDau', '<=', '8:00:00')
       ->where('gioKetThuc', '>=', '8:00:00')
       //->where('admins.trangThai', '=', 'dangCho')
       ->get();

        return response()->json($dsDauBep);
    }

    public function layThongTinNguoiGiaoHang($idNguoiGiaoHang){
        $thongTinCaNhan = Admin::select(['admins.tenDayDu', 'admins.diaChi', 'admins.soDienThoai', DB::raw('count(giao_hangs.idDonHang) as total'), 'gio_hangs.trangThaiDonHang', 'admins.id'])
        ->join('giao_hangs', function ($join){
            $join->on('giao_hangs.idNhanVienGiaoHang', '=', 'admins.id');
        })
        ->join('gio_hangs', function ($join){
            $join->on('giao_hangs.idDonHang', '=', 'gio_hangs.id');
        })
        //->where('admins.id', '=', $idNguoiGiaoHang)
        ->where(function($query) use ($idNguoiGiaoHang){
            $query->where('admins.id','=', $idNguoiGiaoHang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daGiaoToiNoi');
        })
        ->orWhere(function($query) use ($idNguoiGiaoHang){
            $query->where('admins.id','=', $idNguoiGiaoHang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daThanhToan');
        })
        ->orWhere(function($query) use ($idNguoiGiaoHang){
            $query->where('admins.id','=', $idNguoiGiaoHang);
            $query->where('gio_hangs.trangThaiDonHang', '=', 'daDanhGiaNguoiGiao');
        })
        // ->orWhere('gio_hangs.trangThaiDonHang', '=', 'daGiaoToiNoi')
        // ->orWhere('gio_hangs.trangThaiDonHang', '=', 'daThanhToan')
        // ->orWhere('gio_hangs.trangThaiDonHang', '=', 'daDanhGiaNguoiGiao')
        ->groupBy('admins.id')
        //->toSql()
        ->get()
        ;
        return response()->json($thongTinCaNhan);

 
   }
    


}
