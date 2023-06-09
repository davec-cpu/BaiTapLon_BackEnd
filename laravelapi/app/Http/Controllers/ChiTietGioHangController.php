<?php

namespace App\Http\Controllers;

use App\Models\ChiTietGioHang;
use App\Models\DauBepCheBien;
use App\Models\GioHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use League\CommonMark\Extension\InlinesOnly\ChildRenderer;
//use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB;
use PDO;

class ChiTietGioHangController extends Controller
{
    //
    public function tinhTongTien($idgiohang){
        
        $tongtien = ChiTietGioHang::where('idGioHang', $idgiohang)
                    ->sum(DB::raw('chi_tiet_gio_hangs.soLuongSanPham * chi_tiet_gio_hangs.giaSanPham'));
            $giohangcapnhat = GioHang::find($idgiohang);
            $giohangcapnhat->tongTien = $tongtien;
            $giohangcapnhat->save();
            echo 'TOng tien: '.$tongtien.'id gio :'.$idgiohang;
            return $tongtien;
    }

    public function themVaoGio(Request $request, $idgiohang){
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $idsanpham = $request->input('idsanpham');
        $soluongsanpham = 1;
        $giasanpham = $request->input('giaSanPham') ;

        $sanPhamTrongGio = new ChiTietGioHang();
        $sanPhamTrongGio->idGioHang = $idgiohang;  
        $sanPhamTrongGio->idSanPham = $idsanpham;
        $sanPhamTrongGio->soLuongSanPham = $soluongsanpham;
        $sanPhamTrongGio->giaSanPham = $giasanpham;
        
        $soLuongSanPham = 1;
        $spTrongGIo = ChiTietGioHang::where('idGioHang', '=', $idgiohang)
                                    ->where('idSanPham', '=', $idsanpham)
                                    ->first();
        if(is_null($spTrongGIo)){
            
            $out->writeln("Hello from Terminal");
        }else{
            $out->writeln("San da co");
            ChiTietGioHang::where('idGioHang', '=', $idgiohang)
                                    ->where('idSanPham', '=', $idsanpham)
                                    ->update([
                'soLuongSanPham' => DB::raw('soLuongSanPham + ' . $soLuongSanPham)
            ]);
          //  ->update(['soLuongSanPham' => DB::raw('soLuongSanPham + ' . $soLuongSanPham)])
        }

        // if($sanPhamTrongGio->save()){
 
        //     $tongtien  = $this->tinhTongTien($idgiohang);

        //     return response()->json([
        //         'mess'=>'Them san pham vao gio thanh cong',
        //         'tongtien'=>$tongtien
        //     ], 200);
        // }else{
        //     return response()->json(['mess'=>'Co loi xay ra, them vao gio that bai'],409);
        // }


    }

    public function timSanPhamTrongGio(Request $request){
        $idsanpham = $request->input('idsanpham');
        $idGioHang = $request->input('idGioHang') ;
        $mess = '';
        $sanPham = ChiTietGioHang::where('idGioHang', $idGioHang)
                                ->where('idsanpham', $idsanpham)
                                ->first();

        if(is_null($sanPham)){
            $mess = 'San pham chua co';
        }else{
            $mess = 'San pham da co';
        }

        return response()->json([
            'mess'=>$mess
        ]);

    }

    public function chinhSuaSoLuong2(Request $request){
        $idSanPham = $request->input('idSanPham');
        $idGioHang = $request->input('idGioHang');
        
        $alldata = $request->input();
     //   dd($alldata);
        $kieuthaydoi=''; 
      //  echo 'idsanpham:'.$idSanPham.'   idgiohang'.$idGioHang;
        $sanPham = ChiTietGioHang::where('idSanPham', $idSanPham)->where('idGioHang', $idGioHang)->toSql();
        

        if(is_null($sanPham)){
            return response()->json([
                'mess'=>'Khong tim thay san pham chinh sua',
                'sp'=>$sanPham
            ], 404);
        }else{

            if($kieuthaydoi === 'tang'){ 
               $query =  ChiTietGioHang::where('idGioHang', $idGioHang)
                            ->where('idSanPham', $idSanPham)
                            ->toSql();
                            // ->update([
                            //     'soLuongSanPham'=> DB::raw('soLuongSanPham+1')
                            //      ]);
            }else{
    
            }

           // $tongtien  = $this->tinhTongTien($idGioHang);
            
            return response()->json([
                'mess'=>'Cap nhat so luong thanh cong',
               // 'tongtien'=>$tongtien,
                'sp'=>$sanPham
            ],
                200);
        
        }
    }

    public function lietKeSanPhamTrongGio($idgiohang){
        $danhsachsp = ChiTietGioHang::where('idGioHang', $idgiohang)->get();
        $idsp = $danhsachsp->value('idSanPham');
         

        $query2 = ChiTietGioHang::select(['chi_tiet_gio_hangs.idGioHang', 'chi_tiet_gio_hangs.soLuongSanPham', 'chi_tiet_gio_hangs.idSanPham', 'san_phams.tenSanPham', 'chi_tiet_gio_hangs.giaSanPham'])
                ->join('san_phams', function ($join){
                    $join->on('san_phams.id', '=', 'chi_tiet_gio_hangs.idSanPham');
                })
                ->where('chi_tiet_gio_hangs.idGioHang', '=', $idgiohang)
                ->get();

                

        return response()->json($query2, 200);
    }

    public function lietKeSanPhamTrongGioChiDinhCheBien($idgiohang){
        $danhsachsp = ChiTietGioHang::where('idGioHang', $idgiohang)->get();
        $idsp = $danhsachsp->value('idSanPham');
         

        $query2 = ChiTietGioHang::select(['chi_tiet_gio_hangs.idGioHang', 'chi_tiet_gio_hangs.soLuongSanPham', 'chi_tiet_gio_hangs.idSanPham', 'san_phams.tenSanPham', 'chi_tiet_gio_hangs.giaSanPham'])
                ->join('san_phams', function ($join){
                    $join->on('san_phams.id', '=', 'chi_tiet_gio_hangs.idSanPham');
                })
                ->where('chi_tiet_gio_hangs.idGioHang', '=', $idgiohang)
                ->where('chi_tiet_gio_hangs.trangThaiSanPham', '!=', 'dangCheBien')
                ->orWhere('chi_tiet_gio_hangs.trangThaiSanPham', '!=', 'daCheBienXong')
                ->get();

                

        return response()->json($query2, 200);
    }

    public function xoaKhoiGioHang($idsanpham, $idgiohang){
        $sanphamxoa = ChiTietGioHang::where('idSanPham', $idsanpham)
                    ->where('idGioHang', $idgiohang);
        
        $sanphamxoasql = $sanphamxoa->toSql();
       // dd($sanphamxoasql);
        if(is_null($sanphamxoa)){
            return response()->json([
                'mess'=>'Khong tim thay san pham can xoa trong gio'
            ], 404);
        }else{
            //xoakhoigio/{idsanpham}/{idgiohang}
             $sanphamxoa->delete();
            return response()->json([
                'mess'=>'Tim thay sp va xoa thanh cong'
            ], 200);
        }
        return response()->json([
            'sp'=>$sanphamxoa
        ]);
    }

    

    public function themDanhGia(Request $request){
        $idGioHang = $request->input('idGioHang');
        $idSanPham = $request->input('idSanPham');
        $soSaoDanhGia = $request->input('soSaoDanhGia');
        $sanPhamCanDanhGia = ChiTietGioHang::where('idSanPham', $idSanPham)
                    ->where('idGioHang', $idGioHang);
        
        if(is_null($sanPhamCanDanhGia)){
            
            return response()->json([
                'mess'=>'Khong tim thay san pham can danh gia'
            ], 404);
        }else{
            $sanPhamCanDanhGia->update(['danhGia'=>$soSaoDanhGia]);

            //tinh danh gia trung binh va them vao bang sanpham
            $giaTriDanhGia = ChiTietGioHang::where('idSanPham', $idSanPham)
                                        ->avg('danhGia');

            $sanPhamCanCapNhatDanhGia = SanPham::find($idSanPham);
            if(is_null($sanPhamCanCapNhatDanhGia)){
                return response()->json([
                    'mess'=>'Khong tim thay san pham can cap nhat danh gia'
                ]);
            }else{
                $sanPhamCanCapNhatDanhGia->update(['danhGiaSanPham'=>$giaTriDanhGia]);
            }

            //them danh gia va daubepchebien
            $dauBepCheBien = DauBepCheBien::where('idDonHang', $idGioHang)
                            ->where('idSanPhamDuocGiao', $idSanPham);
            if(is_null($dauBepCheBien)){
                return response()->json([
                    'mess'=>'Khong tim thay dauBepCheBien can cap nhat danh gia'
                ]);
            }else{
                $dauBepCheBien->update(['danhGiaKhachHang'=>$soSaoDanhGia]);
            }


            return response()->json([
                'mess'=>'Cap nhat danh gia thanh cong',
                'sp'=>$sanPhamCanDanhGia
            ],
                200);
        }
        

    }

    public function layDanhGiaSanPham($idSanPham){
        $sanPhamCanTinh = ChiTietGioHang::where('idSanPham', $idSanPham)
                                        ->avg('danhGia');
                        

        
        // return response()->json([
        //     'mess'=>$sanPhamCanTinh
        // ]);
    }

    public function testing(Request $request){
    //    $list =  DB::table('chi_tiet_gio_hangs')
    //             ->avg('danhGia');

    $dangnhap = $request->input('dangnhap');
    $email = $request->input('email');
    
   // echo "ten dang nhap: ".$dangnhap.", email: ".$email;
    return response()->json([
        'mess' => 'Dang nhap thanh cong'
    ], 200);
        
    }

    public function xoaKhoiGio(Request $request){
         $idGioHang = $request->input('idGioHang');
         $idSanPham = $request->input('idSanPham');

       
                    $query = ChiTietGioHang::where('idGioHang', $idGioHang)
                    ->where('idSanPham', $idSanPham)
                    ->delete();
        $this->tinhTongTien($idGioHang);
        return response()->json([
            'mess' => 'Xoa thanh cong',
            'query' => $query
        ], 200);

    }

    public function testing2($idKhachHang){
        // $test = ChiTietGioHang::where("actice", "=", true)
         
        // ->select(['tags.name AS tag_name', 'products.*'])
        // ->leftJoin('users', function($query){
        //     $query->on('rooms.id', '=', 'bookings.room_type_id');
        //     $query->on('rooms.id', '=', 'bookings.room_type_id');
        // })
        // ->whereIn('id', function($query){
        //     $query->select('paper_type_id')
        //     ;
        // })
        // ->toSql();
         
        // $query = SanPham::select(['san_phams.id', 'san_phams.tenSanPham', 'san_phams.anhSanPham', 'chi_tiet_gio_hangs.soLuongSanPham', 'chi_tiet_gio_hangs.giaSanPham'])
        //         ->ijoiJoin('chi_tiet_gio_hangs', function($join) use ($idGioHang){
        //             $join->on('san_phams.id', '=', 'chi_tiet_gio_hangs.idSanPham');
        //            //$join->on('chi_tiet_gio_hangs.idGioHang',  $idGioHang);
        //         })
        //         ->whereIn('san_phams.id', function($query) use ($idGioHang){
        //             $query->select('idSanPham')
        //             ->from('chi_tiet_gio_hangs')
        //             ->where('idGioHang', $idGioHang);
        //         })
        //         //->groupBy('san_phams.id')
        //         ->distinct( )  
        //         ->get();

        $query2 = SanPham::select(['san_phams.id as idSanPham', 'san_phams.tenSanPham', 'san_phams.anhSanPham', 'chi_tiet_gio_hangs.soLuongSanPham', 'chi_tiet_gio_hangs.giaSanPham', 'chi_tiet_gio_hangs.idGioHang'])
                ->join('chi_tiet_gio_hangs', function ($join){
                    $join->on('san_phams.id', '=', 'chi_tiet_gio_hangs.idSanPham');
                })
                ->join('gio_hangs', function ($join){
                    $join->on('chi_tiet_gio_hangs.idGioHang', '=', 'gio_hangs.id');
                })
                ->where('gio_hangs.idKhachHang', '=', $idKhachHang)
                ->where('gio_hangs.trangThaiDonHang', '=', 'gioHang')
                //->where('')
               ->get()
               // ->toSql()
                ;

        return response()->json($query2);
    }

    public function capnhatsoluong(Request $request){
        $idGioHang = $request->input('idGioHang');
        $idSanPham = $request->input('idSanPham');
        $soLuongCapNhat = $request->input('soLuongCapNhap');
        $this->tinhTongTien($idGioHang);
        $capNhapQuery = ChiTietGioHang::where('idGioHang', '=', $idGioHang)
                                      ->where('idSanPham', '=', $idSanPham)
                                      ;
        $capNhapQuery->update([
            'soLuongSanPham'=>$soLuongCapNhat
        ]);

        return response()->json($capNhapQuery);
    }

    public function layDsChiTietKemDauBep($idGioHang){
      //  echo '123';
        $dsChiTiet = ChiTietGioHang::select(['chi_tiet_gio_hangs.idGioHang', 'chi_tiet_gio_hangs.idSanPham', 'chi_tiet_gio_hangs.soLuongSanPham', 'chi_tiet_gio_hangs.giaSanPham', 'chi_tiet_gio_hangs.danhGia', 'dau_bep_che_biens.idDauBepThucHien', 'admins.id', 'admins.tenDayDu', 'san_phams.tenSanPham', 'san_phams.anhSanPham', 'dau_bep_che_biens.idCaLamViec'])
                                ->join('dau_bep_che_biens', function ($join){
                                    $join->on('chi_tiet_gio_hangs.idGioHang', '=', 'dau_bep_che_biens.idDonHang');
                                    $join->on('chi_tiet_gio_hangs.idSanPham', '=', 'dau_bep_che_biens.idSanPhamDuocGiao');
                                })
                                ->join('admins', function ($join){
                                    $join->on('admins.id', '=', 'dau_bep_che_biens.idDauBepThucHien');
                                })
                                ->join('san_phams', function ($join){
                                    $join->on('san_phams.id', '=', 'chi_tiet_gio_hangs.idSanPham');
                                })
                                ->where('chi_tiet_gio_hangs.idGioHang', '=', $idGioHang)
                                //->toSql()
                                ->get()
                                ;
        return response()->json($dsChiTiet);
    }

    public function tangGiamSoLuong(Request $request){
        $idSanPham = $request->input('idSanPham');
        $idgiohang = $request->input('idGioHang');
        $trangThai = $request->input('trangThai');
        $soLuongSanPham = 0;
    //    echo'idgio: '.$idgiohang;
        if($trangThai === 'tang'){
            $soLuongSanPham = 1;
        }else{
            $soLuongSanPham = -1;
        }

        $chiTiet = ChiTietGioHang::where('idGioHang', '=', $idgiohang)
                                ->where('idSanPham', '=', $idSanPham)
                                ->update(['soLuongSanPham' => DB::raw('soLuongSanPham + ' . $soLuongSanPham)])
                                ;
        $soLuongSp = ChiTietGioHang::where('idGioHang', $idgiohang)
                                    ->where('idSanPham', '=', $idSanPham)
                                    ->value('soLuongSanPham');
        
                                     
        if($soLuongSp <= 0){
       //     echo'Da het san pham';
            $query = ChiTietGioHang::where('idGioHang', $idgiohang)
                    ->where('idSanPham', $idSanPham)
                    ->delete()
                    ;
        }        
        $this->tinhTongTien($idgiohang);

        return response()->json($chiTiet);
        
    }



 
}
