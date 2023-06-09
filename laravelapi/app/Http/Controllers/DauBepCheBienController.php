<?php

namespace App\Http\Controllers;

use App\Models\ChiTietGioHang;
use App\Models\DauBepCheBien;
use App\Models\DauBepCheBien_ThoiGianHoanThanh;
use App\Models\GioHang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DauBepCheBienController extends Controller
{
    
    //
    public function chiDinhDauBep(Request $request){
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPhamDuocGiao = $request->input('idSanPhamDuocGiao');
        $idDonHang = $request->input('idDonHang');
        $idCaLamViec = $request->input('idCaLamViec');
        $soLuongSanPham = $request->input('soLuongSanPham');
        $trangThaiSanPham = 'dangCho';
        $thoiGian = Carbon::now();
        $thoiGianSanPhamDuocChiDinh = $thoiGian->toTimeString(); 
        
        $spCanCapNhatTrangThai = ChiTietGioHang::where('idGioHang', '=', $idDonHang)
                                                ->where('idSanPham', '=', $idSanPhamDuocGiao)
                                                ->update(['trangThaiSanPham'=> 'dangCheBien']);
        
        
        
            
            $dauBep = new DauBepCheBien();
            $dauBep->idDauBepThucHien = $idDauBepThucHien;
            $dauBep->idSanPhamDuocGiao = $idSanPhamDuocGiao;
            $dauBep->idDonHang = $idDonHang;
            $dauBep->idCaLamViec = $idCaLamViec;
            $dauBep->trangThaiSanPham = $trangThaiSanPham;
            $dauBep->soLuongSanPhamConLai = $soLuongSanPham;
            $dauBep->thoiGianSanPhamDuocChiDinh = $thoiGianSanPhamDuocChiDinh;
            
            if($dauBep->save()){
                return response()->json(['mess'=>'Chi dinh dau bep thanh cong']);
            }else{
                return response()->json(['mess'=>'Co loi xay ra']);
            }
    }

    public function thayDoiTrangThai(Request $request){
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPhamDuocGiao = $request->input('idSanPhamDuocGiao');
        $idDonHang = $request->input('idDonHang');
        $idCaLamViec = $request->input('idCaLamViec');
        $trangthai = $request->input('trangthai');
        

         $dauBepCheBien = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
                        ->where('idDonHang', $idDonHang)
                        ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
                        ->where('idDauBepThucHien', $idDauBepThucHien);
        
        if(is_null($dauBepCheBien)){
            return response()->json([
                'mess'=>'Khong tim thay daubepchebien'
            ]);
        }
        $thoiGian = Carbon::now('Asia/Ho_Chi_Minh');
        if($trangthai === 'dangCheBien'){ //bat dau duoc che bien
                
                $thoiGianSanPhamBatDauDuocCheBien = $thoiGian->toTimeString();
                $dauBepCheBien->update([
                'trangThaiSanPham'=>'dangCheBien',
                'thoiGianSanPhamBatDauDuocCheBien'=>$thoiGianSanPhamBatDauDuocCheBien
                ]);

                return response()->json([
                    'mess' => 'dangCheBien thanh cong'
                ], 204);
        }
        elseif($trangthai === 'dangCho'){ //chi dinh dau bep
                 
                $thoiGianSanPhamDuocChiDinh = $thoiGian->toTimeString();
                $dauBepCheBien->update([
                'trangThaiSanPham'=>'dangCho',
                'thoiGianSanPhamDuocChiDinh'=>$thoiGianSanPhamDuocChiDinh
                ]);

                return response()->json([
                    'mess' => 'dangCho thanh cong'
                ], 204);
        }
        elseif($trangthai === 'tamDungCheBien'){ //dung che bien
            
            $dauBepCheBien->update([
            'trangThaiSanPham'=>'tamDungCheBien'
            ]);

            return response()->json([
                'mess' => 'tamDungCheBien thanh cong'
            ], 204);
        }
        elseif($trangthai === 'dauBepThayDoi'){ //da co dau bep thay vao
            
            $dauBepCheBien->update([
            'trangThaiSanPham'=>'dauBepThayDoi'
            ]);

            return response()->json([
                'mess' => 'dauBepThayDoi thanh cong'
            ], 204);
        }
        elseif($trangthai === 'daCheBienXong'){ //hoan thanh sp
            $thoiGian = Carbon::now('Asia/Ho_Chi_Minh');
            $thoiGianSanPhamDuocHoanThanh= $thoiGian->toTimeString();

            $dauBepCheBien->update([
            'trangThaiSanPham'=>'daCheBienXong',
            'thoiGianSanPhamDuocHoanThanh'=>$thoiGianSanPhamDuocHoanThanh
            ]);

            $soSanPhamDaCheBienXong = DauBepCheBien::where('idDonHang', 4)
                            ->where('trangThaiSanPham', 'daCheBienXong')
                            ->count();
            $soSanPhamTrongGio = ChiTietGioHang::where('idGioHang', 4)
            ->count('idSanPham');

            if($soSanPhamDaCheBienXong === $soSanPhamTrongGio){
                $donHang = GioHang::find($idDonHang);

                if(is_null($donHang)){
                    return response()->json([
                        'mess' => 'Khong tim thay don hang da che bien xong'
                    ], 404);
                }else{
                    $donHang->update([
                        'trangThaiDonHang' => 'daCheBienXong'
                    ]);
                }


                return response()->json([
                    'mess'=>'Don hang da che bien xong'
                     
                ], 204);
            } 


        }
    }

     
    public function dem(){
        $dem = DauBepCheBien::where('idDonHang', 4)
                            ->where('trangThaiSanPham', 'daCheBienXong')
                            ->count();
        $dem2 = ChiTietGioHang::where('idGioHang', 4)
        ->count('idSanPham');
       // dd(DauBepCheBien::getQueryLog());
        if($dem === $dem2){
            return response()->json([
                'abc'=>$dem,
                'def'=>$dem2
            ]);
        }else{
            return  response()->json([
                'mess'=>'Khong bang nhau'
            ]);
        }
    }


    

    public function batDauCheBien(Request $request){
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPhamDuocGiao = $request->input('idSanPhamDuocGiao');
        $idDonHang = $request->input('idDonHang');
        $idCaLamViec = $request->input('idCaLamViec');
      
        
        $trangThaiSanPham = 'dangCheBien';
        $thoiGian = Carbon::now('Asia/Ho_Chi_Minh');
        $thoiGianSanPhamBatDauDuocCheBien = $thoiGian->toTimeString();
        $dauBepCheBien = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
                        ->where('idDonHang', $idDonHang)
                        ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
                        ->where('idDauBepThucHien', $idDauBepThucHien)
                        ;
        $dauBepCheBien->update([
            'trangThaiSanPham'=>$trangThaiSanPham,  
        ])                    
        ;    

      //  return response()->json($dauBepCheBien);  
      
    //   $capNhatThoiGianCheBien = new  DauBepCheBien_ThoiGianHoanThanh();
    //   $capNhatThoiGianCheBien->idSanPham = $idSanPhamDuocGiao;
    //   $capNhatThoiGianCheBien->idCaLamViec = $idCaLamViec;
    //   $capNhatThoiGianCheBien->idDauBepThucHien = $idDauBepThucHien;
    //   $capNhatThoiGianCheBien->idDonHang = $idDonHang;
    //   $capNhatThoiGianCheBien->thoiGianBatDauCheBien = $thoiGianSanPhamBatDauDuocCheBien;
    //   $capNhatThoiGianCheBien->thoigianhoanthanh = '00:00:00';
    //   $capNhatThoiGianCheBien->save();

      $soLuongConLai = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
      ->where('idDonHang', $idDonHang)
      ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
      ->where('idDauBepThucHien', $idDauBepThucHien)
      ->first()
      ->soLuongSanPhamConLai;

    $thoigian = Carbon::now('Asia/Ho_Chi_Minh');
    $thoiGianBatDau = $thoigian->toTimeString();
    $soLuongBanDau = ChiTietGioHang::where('idGioHang', '=', $idDonHang)
                    ->where('idSanPham', '=', $idSanPhamDuocGiao)
                    ->value('soLuongSanPham');

        if($soLuongConLai === $soLuongBanDau){
            $dauBepCheBien->update([
                'thoiGianSanPhamBatDauDuocCheBien'=>$thoiGianBatDau,  
            ])                    
            ;
            
        }
     //   echo'kieu con lai: '.gettype($soLuongConLai).' kieu ban dau: '.gettype($soLuongBanDau);
        if(is_null($dauBepCheBien)){

            return response()->json([
                'mess'=>'Khong tim thay daubepchebien cho viec che bien'
            ], 404);
        }else{
            // $dauBepCheBien->update([
            //     'trangThaiSanPham'=>$trangThaiSanPham,
            //     'thoiGianSanPhamBatDauDuocCheBien'=>$thoiGianSanPhamBatDauDuocCheBien
            // ]);

            // $dauBepCheBien->trangThaiSanPham = $trangThaiSanPham;
            // $dauBepCheBien->thoiGianSanPhamBatDauDuocCheBien = $thoiGianSanPhamBatDauDuocCheBien;
            // $dauBepCheBien->save();
            return response()->json([
                // 'mess'=> 'Bat dau che bien thanh cong',
                 'thoigianbatdauchebien' => $thoiGianSanPhamBatDauDuocCheBien,
                // 'data' => $dauBepCheBien,
                // 'idDauBepThucHien input'=>$idDauBepThucHien,
                // 'idSanPhamDuocGiao'=>$idSanPhamDuocGiao,
                // 'idDonHang'=>$idDonHang,
                // 'idCaLamViec'=>$idCaLamViec,
                // 'capNhatThoiGianCheBien'=>$capNhatThoiGianCheBien
                'soLuongConLai' => $soLuongConLai,
                'soLuongBanDau' => $soLuongBanDau,
               // 'daCheBienXong'=>$daCheBienXong
            ], 200);
        }



    }

    public function layDsSanPhamChiDinh( $idDauBep){

        // $dsDauBep = CaLamViec::select(['ca_lam_viecs__dau_bep.idDauBep', 'admins.tenDangNhap', 'ca_lam_viecs.gioBatDau', 'ca_lam_viecs.id'])
        // ->join('ca_lam_viecs__dau_bep', function($join){
        //      $join->on('ca_lam_viecs__dau_bep.idCaLamViec', '=', 'ca_lam_viecs.id');
        // });

       $dsSanPhamChiDinh = DauBepCheBien::select(['san_phams.tenSanPham', 'chi_tiet_gio_hangs.soLuongSanPham', 'san_phams.anhSanPham', 'chi_tiet_gio_hangs.idGioHang', 'dau_bep_che_biens.idSanPhamDuocGiao', 'dau_bep_che_biens.soLuongSanPhamConLai'])
       ->join('san_phams', function($join){
        $join->on('san_phams.id', '=', 'dau_bep_che_biens.idSanPhamDuocGiao');
       })
       ->join('chi_tiet_gio_hangs', function($join){
        $join->on('chi_tiet_gio_hangs.idSanPham', '=', 'dau_bep_che_biens.idSanPhamDuocGiao');
        $join->on('chi_tiet_gio_hangs.idGioHang', '=' , 'dau_bep_che_biens.idDonHang');
       })
       ->where('dau_bep_che_biens.idDauBepThucHien','=',$idDauBep)
       ->where('dau_bep_che_biens.trangThaiSanPham', '<>', 'daCheBienXong')
       ->distinct()
       ->get();


       return response()->json($dsSanPhamChiDinh);

    }

    public function hoanThanhSanPham(Request $request){
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPhamDuocGiao = $request->input('idSanPhamDuocGiao');
        $idDonHang = $request->input('idDonHang');
        $idCaLamViec = $request->input('idCaLamViec');
        $thoiGianHoanThanh = $request->input('thoiGianHoanThanh'); 
      //  $thoiGianSanPhamBatDauDuocCheBien = $request->input('thoiGianSanPhamBatDauDuocCheBien');

        
        
        
        
        $thoiGian = Carbon::now('Asia/Ho_Chi_Minh');
        

        // $capnhatThoiGianHoanThanh = DauBepCheBien_ThoiGianHoanThanh::where('idCaLamViec', $idCaLamViec)
        //                             ->where('idDonHang', $idDonHang)
        //                             ->where('idSanPham', $idSanPhamDuocGiao)
        //                             ->where('idDauBepThucHien', $idDauBepThucHien)
        //                             ->where('thoiGianBatDauCheBien', $thoiGianSanPhamBatDauDuocCheBien)
        //                             ->update([
                            
        //                                 'thoigianhoanthanh'=> $thoiGianHoanThanh
        //                             ])
                                    
        //                             ;
        

        $dbCheBienCanCapNhat =  DauBepCheBien::where('idCaLamViec', $idCaLamViec)
        ->where('idDonHang', $idDonHang)
        ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
        ->where('idDauBepThucHien', $idDauBepThucHien);


        $dauBepCheBien = $dbCheBienCanCapNhat
                        
                        ->update([
                            'soLuongSanPhamConLai'=> DB::raw('soLuongSanPhamConLai-1')
                        ])
                        ;

        $thoiGian = Carbon::now('Asia/Ho_Chi_Minh');
        $thoiGianSanPhamDuocHoanThanh = $thoiGian->toTimeString();

        $soLuongConLai = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
        ->where('idDonHang', $idDonHang)
        ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
        ->where('idDauBepThucHien', $idDauBepThucHien)
        ->first()
        ->soLuongSanPhamConLai;     
        
        

                        
                        if ($soLuongConLai === 0){
                            $trangThaiSanPham = 'daCheBienXong';
                            
                            $daCheBienXong = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
                            ->where('idDonHang', $idDonHang)
                            ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
                            ->where('idDauBepThucHien', $idDauBepThucHien)
                           
                            ->update([
                                'trangThaiSanPham'=>$trangThaiSanPham,
                                'thoiGianSanPhamDuocHoanThanh'=> $thoiGianSanPhamDuocHoanThanh
                            ]);

                            $capNhatTrangThaiChiTietGioHang = ChiTietGioHang::where('idGioHang', $idDonHang)
                            ->where('idSanPham', $idSanPhamDuocGiao)
                            ->update([
                                'trangThaiSanPham'=>$trangThaiSanPham,
                                 
                            ]);

                            $soLuongSanPhamTrongGio = ChiTietGioHang::where('idGioHang', $idDonHang)
                          //  ->where('idSanPham', $idSanPhamDuocGiao)
                            ->count('idSanPham');

                            $soLuongSanPhamTrongGioDaCheBienXong = ChiTietGioHang::where('idGioHang', $idDonHang)
                            ->where('trangThaiSanPham', $trangThaiSanPham)
                            ->count('idSanPham');

                            if($soLuongSanPhamTrongGio === $soLuongSanPhamTrongGioDaCheBienXong){
                                $capNhatGioHangDaCheBienXong = GioHang::where('id', $idDonHang)
                                ->update([
                                    'trangThaiDonHang'=>$trangThaiSanPham,
                                     
                                ]);
                                 
                            }                            
                        }
        
        $trangThaiSanPham = 'daCheBienXong';
        return response()->json([
            'idDauBepThucHien'=>$idDauBepThucHien,
            'idSanPhamDuocGiao'=>$idSanPhamDuocGiao,
            'idDonHang'=>$idDonHang,
            'idCaLamViec'=>$idCaLamViec,
            'thoiGianHoanThanh'=>$thoiGianHoanThanh,
            'dauBepCheBien'=>$dauBepCheBien
        ]);
        
        return response()->json([
           
            
        ]);
    }

    public function testing(Request $request){
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPhamDuocGiao = $request->input('idSanPhamDuocGiao');
        $idDonHang = $request->input('idDonHang');
        $idCaLamViec = $request->input('idCaLamViec');
      //  $thoiGianHoanThanh = $request->input('thoiGianHoanThanh'); 
      //  $thoiGianSanPhamBatDauDuocCheBien = $request->input('thoiGianSanPhamBatDauDuocCheBien');

            $trangThaiSanPham = 'daCheBienXong';
            //cap nhat trang thai sp trong dau bep che bien
            $daCheBienXong = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
            ->where('idDonHang', $idDonHang)
            ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
            ->where('idDauBepThucHien', $idDauBepThucHien)
           
            ->update([
                'trangThaiSanPham'=>$trangThaiSanPham,
                 
            ]);

            //cap nhat trang thai sp trong chi tiet gio hang
            $capNhatTrangThaiChiTietGioHang = ChiTietGioHang::where('idGioHang', $idDonHang)
            ->where('idSanPham', $idSanPhamDuocGiao)
            ->update([
                'trangThaiSanPham'=>$trangThaiSanPham,
                 
            ]);

            //Neu nhu so luong sp trong gio = so luong sp da che bien xong => don hang da hoan thanh
            $soLuongSanPhamTrongGio = ChiTietGioHang::where('idGioHang', $idDonHang)
          //  ->where('idSanPham', $idSanPhamDuocGiao)
            ->count('idSanPham');

            $soLuongSanPhamTrongGioDaCheBienXong = ChiTietGioHang::where('idGioHang', $idDonHang)
            ->where('trangThaiSanPham', $trangThaiSanPham)
            ->count('idSanPham');
            

            if($soLuongSanPhamTrongGio === $soLuongSanPhamTrongGioDaCheBienXong){
                $capNhatGioHangDaCheBienXong = GioHang::where('id', $idDonHang)
                ->update([
                    'trangThaiDonHang'=>$trangThaiSanPham,
                     
                ]);
                 
            }
        return response()->json([
                'json'=>$soLuongSanPhamTrongGio,
                'daCheBienXong'=>$daCheBienXong,
                'capNhatTrangThaiChiTietGioHang'=>$capNhatTrangThaiChiTietGioHang


            ]);

        
    }

    public function chaythu(Request $request){
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPhamDuocGiao = $request->input('idSanPhamDuocGiao');
        $idDonHang = $request->input('idDonHang');
        $idCaLamViec = $request->input('idCaLamViec');

        $soLuongConLai = DauBepCheBien::where('idCaLamViec', $idCaLamViec)
        ->where('idDonHang', $idDonHang)
        ->where('idSanPhamDuocGiao', $idSanPhamDuocGiao)
        ->where('idDauBepThucHien', $idDauBepThucHien)
        ->get()
        // ->first()
        // ->soLuongSanPhamConLai
        ;

      return response()->json([
        'soLuongConLai'=>$soLuongConLai
      ]);
    }

    public function layDsDauBepCheBien(){
         
    }

    public function themdanhgiadaubep(Request $request)
    {   
        $idCaLamViec = $request->input('idCaLamViec');
        $idDauBepThucHien = $request->input('idDauBepThucHien');
        $idSanPham = $request->input('idSanPham');
        $idDonHang = $request->input('idDonHangThanhToan');
        $danhGiaKhachHang = $request->input('danhGiaKhachHang');

        $dauBepCheBien = DauBepCheBien::where('idCaLamViec', '=', $idCaLamViec)
                                    ->where('idDauBepThucHien', '=', $idDauBepThucHien)
                                    ->where('idDonHang', '=', $idDonHang)
                                    ->where('idSanPhamDuocGiao', '=', $idSanPham);
        
        $dauBepCheBien->update([
            'danhGiaKhachHang'=>$danhGiaKhachHang
        ])
        ;
        return response()->json([
            'idCaLamViec'=>$idCaLamViec,
            'idDauBepThucHien'=>$idDauBepThucHien,
            'idSanPham'=>$idSanPham,
            'idDonHang'=>$idDonHang,
            'danhGiaKhachHang'=>$danhGiaKhachHang,
          ]);
    }

    public function layDsDanhGia($idDauBep){
        $dsDanhGia = DauBepCheBien::select(['dau_bep_che_biens.idCaLamViec', 'dau_bep_che_biens.idDonHang', 'dau_bep_che_biens.danhGiaKhachHang', 'dau_bep_che_biens.idSanPhamDuocGiao', 'khach_hangs.tenDayDu', 'san_phams.tenSanPham', 'khach_hangs.id'])
        
        ->join('san_phams', function($join){
            $join->on('dau_bep_che_biens.idSanPhamDuocGiao', '=', 'san_phams.id');
        })
        ->join('gio_hangs', function($join){
            $join->on('dau_bep_che_biens.idDonHang', '=', 'gio_hangs.id');
        })
        ->join('khach_hangs', function($join){
            $join->on('khach_hangs.id', '=', 'gio_hangs.idKhachHang');
        })
        ->where('dau_bep_che_biens.idDauBepThucHien', '=', $idDauBep)
        ->get()
        ;

        return response()->json($dsDanhGia);
    }


    
    

    
}
