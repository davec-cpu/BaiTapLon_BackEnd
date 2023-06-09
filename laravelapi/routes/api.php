<?php

use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\ChiTietGioHangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaLamViec_DauBepController;
use App\Http\Controllers\CaLamViec_NDonDepController;
use App\Http\Controllers\CaLamViec_NGiaoHangController;
use App\Http\Controllers\CaLamViecController;
use App\Http\Controllers\DauBepCheBienController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\GiaoHangController;
use App\Models\ChiTietGioHang;
use App\Models\Admin;
use App\Models\CaLamViec;
use App\Models\DauBepCheBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('khachhang')->group(function(){

    Route::post('dangnhap', [KhachHangController::class, 'khachHangDangNhap']);

    Route::post('dangki', [KhachHangController::class, 'khachHangDangKi']);

    Route::get('laythongtincanhan/{id}', [KhachHangController::class, 'layThongTinCaNhan']);

    Route::put('chinhsuathongtincanhan/{id}', [KhachHangController::class, 'chinhSuaThongTinCaNhan']);

    Route::get('dskhachhang', [KhachHangController::class, 'layDanhSachKhachHang']);

    

});


Route::prefix('sanpham')->group(function(){

    Route::get('dssanpham', [SanPhamController::class, 'layDanhSachSanPham']);

    Route::post('themsanpham', [SanPhamController::class, 'themSanPham']);

    Route::get('layanh', [SanPhamController::class, 'index']);

    Route::put('suasanpham/{id}', [SanPhamController::class, 'suaSanPham']);
    
    Route::delete('xoasanpham/{id}', [SanPhamController::class, 'xoaSanPham']);

    Route::post('vdndv', [SanPhamController::class, 'test']);

  //  Route::put('suasanpham', [SanPhamController::class, 'suaSanPham']);
    Route::get('bla', [SanPhamController::class, 'laystring']);
});

Route::prefix('giohang')->group(function(){
    Route::post('taogiohang/{idkhachhang}', [GioHangController::class, 'taoGioHang']);
    
    Route::post('testing/{id}', [GioHangController::class, 'testTaoGioHang']);

    Route::post('nhanhoactuchoidonhang/{idgiohang}/{trangthai}', [GioHangController::class, 'nhanHoacTuChoiDonHang']);
    
    Route::post('dathang/{id}', [GioHangController::class, 'datHang']);

    Route::get('dsdonhangchebienxong', [GioHangController::class, 'layDanhSachDonHangDaCheBienXong']);

    Route::get('laydsdonhang', [GioHangController::class, 'layDanhSachDonHang']);

    Route::get('laydsdonhangdanhan', [GioHangController::class, 'layDsDonHangDaNhan']);

    Route::get('laydsdonhangdagiaotoinoi/{idkhachhang}', [GioHangController::class, 'layDsDonHangDaGiaoDenNoi']);

    Route::post('capnhattrangthai', [GioHangController::class, 'thayDoiTrangThai']);

    Route::get('laydsdonhangdathanhtoan/{idkhachhang}', [GioHangController::class, 'layDsDonHangDaThanhToanXong']);

    Route::post('themdiachinhanhang', [GioHangController::class, 'themDiaChi']);

    Route::get('laydsdiachinhanhang/{idKhachHang}', [GioHangController::class, 'dsDiaChiNhanHang']);
    
});

Route::prefix('chitietgiohang')->group(function(){
    
    Route::post('themvaogio/{idgiohang}', [ChiTietGioHangController::class, 'themVaoGio']);

    Route::post('capnhatsoluong', [ChiTietGioHangController::class, 'tangGiamSoLuong'] );

    Route::get('lietkesp/{idgiohang}', [ChiTietGioHangController::class, 'lietKeSanPhamTrongGio'] );

    Route::get('lietkespcothechidinh/{idgiohang}', [ChiTietGioHangController::class, 'lietKeSanPhamTrongGioChiDinhCheBien'] );

    Route::post('checksp', [ChiTietGioHangController::class, 'timSanPhamTrongGio']);

    //Route::post('dathang', [ChiTietGioHangController::class, 'datHang']);

    Route::put('themdanhgia', [ChiTietGioHangController::class, 'themDanhGia']);

    Route::get('laydanhgia/{idSanPham}', [ChiTietGioHangController::class, 'layDanhGiaSanPham']);

    Route::post('testing', [ChiTietGioHangController::class, 'testing']);

    Route::get('testinghai/{idGioHang}', [ChiTietGioHangController::class, 'testing2']);

    Route::post('xoakhoigio', [ChiTietGioHangController::class, 'xoaKhoiGio']);

    Route::post('capnhat', [ChiTietGioHangController::class, 'capnhatsoluong']);
    
    Route::get('chitietdonhangkemdaubep/{idGioHang}', [ChiTietGioHangController::class, 'layDsChiTietKemDauBep']);

     
});

Route::prefix('admin')->group(function(){

    Route::post('admindangnhap', [AdminController::class, 'adminDangNhap']);

    //Route::get('laydsdonhan')

    Route::post('themnhanvien', [AdminController::class, 'themnv']);

    Route::get('laydsnhanvien', [AdminController::class, 'layDsNhanVien']);

    Route::get('laymotnhanvien/{id}', [AdminController::class, 'layMotNhanVien']);

    Route::put('suanhanvien/{id}', [AdminController::class, 'suaNhanVien']);

    Route::delete('xoanhanvien/{id}', [AdminController::class, 'xoaNhanVien']);

  //  Route::delete('xoanhanvien/{id}', [AdminController::class, 'xoaNhanVien']);

    Route::get('laydanhsachdaubep', [AdminController::class, 'layTatCaDauBep']);

    Route::get('laydanhsachdaubepcothechidinh', [AdminController::class, 'dsDauBepCoTheChiDinh']);

    Route::get('laydanhsachnguoigiaohangcothechidinh', [AdminController::class, 'dsNGiaoHangCoTheChiDinh']);

    Route::get('laythongtinngiaohang/{idNguoiGiaoHang}', [AdminController::class, 'layThongTinNguoiGiaoHang']);
    

     
});

// Route::prefix('donhang')->group(function(){

//     Route::post('themdonhang', [DonHangController::class, 'themDonHang']);

//     Route::get('dsdonhang', [DonHangController::class, 'layDsDonHang']);

// });

Route::prefix('daubepchebien')->group(function(){

    Route::post('chidinhdaubep', [DauBepCheBienController::class, 'chiDinhDauBep']);

    Route::post('batdauchebien', [DauBepCheBienController::class, 'batDauCheBien']);

    Route::get('laydssanphamchidinh/{idDauBep}', [DauBepCheBienController::class, 'layDsSanPhamChiDinh']);

    Route::post('hoanthanhsanpham', [DauBepCheBienController::class, 'hoanThanhSanPham']);

    Route::get('dem', [DauBepCheBienController::class, 'dem']);

    Route::put('capnhattrangthai', [DauBepCheBienController::class, 'thayDoiTrangThai']);

    Route::post('test', [DauBepCheBienController::class, 'testing']);

    Route::post('test2', [DauBepCheBienController::class, 'chaythu']);

    Route::get('laydanhsachdaubepchebien', [DauBepCheBienController::class, 'layDsDauBepCheBien']);

    Route::post('themdanhgiadaubep', [DauBepCheBienController::class, 'themdanhgiadaubep']);

    Route::get('laydanhsachdanhgia/{idDauBep}', [DauBepCheBienController::class, 'layDsDanhGia']);

});

Route::prefix('calamviec')->group(function(){

    Route::post('themcalamviec', [CaLamViecController::class, 'themCaLamViec']);

    Route::post('themdaubep', [CaLamViec_DauBepController::class, 'themDauBep']);

    Route::post('themngiaohang', [CaLamViec_NGiaoHangController::class, 'themNGiaoHang']);

    Route::post('themndondep', [CaLamViec_NDonDepController::class, 'themNDonDep']);

    Route::get('laycalamviec', [CaLamViecController::class, 'layCaLamViec']);

});

Route::prefix('giaohang')->group(function(){

    Route::post('themgiaohang', [GiaoHangController::class, 'themGiaoHang']);

  //  Route::put('danhgiagiaohang', [GiaoHangController::class, 'themDanhGia']);

    Route::get('laydschidinhgiaohang/{idCalamViec}/{idNguoiGiaoHang}', [GiaoHangController::class, 'layDsChiDinhGiaoHang']);

    Route::get('sapxepnhanviengiaohang/{kieusapxep}', [GiaoHangController::class, 'sapXepNhanVienGiaoHang']);

    Route::post('themdanhgia', [GiaoHangController::class, 'themDanhGia2']);

    Route::post('checkdanhgia', [GiaoHangController::class, 'checkTruocKhiThemDanhGia']);
    
    Route::get('dsdanhgia/{idNhanVienGiaoHang}', [GiaoHangController::class, 'layDsDanhGiaCuaKhachHang']);
});




