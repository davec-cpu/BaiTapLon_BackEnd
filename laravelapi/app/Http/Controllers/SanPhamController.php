<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Cloudinary\Configuration\Configuration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use PDO;

class SanPhamController extends Controller
{
    //
    public function index(){
        $image = SanPham::all();
        return response()->json([
            "status" => "success",
            "count" => count($image),
            "data" => $image
        ]);
    }

    public function laystring(){
        $string = Str::random(32);
        return response()->json($string);
    }
    public function themSanPham(Request $request){
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("Hello from Terminal");
        // $config = Configuration::instance();
        // $config->cloud->cloudName = 'dmjeqzep9';
        // $config->cloud->apiKey= '723277362379442';
        // $config->cloud->apiSecret = '910tuHGEQK5XCKXuvznrixR_QVU';
        // $config->url->secure = true;

        // $cloudinary = new Cloudinary($config);
        $tenSp = $request->input('tensp');
        $giaSp = $request->input('giasp');
         

        // $input = $request->input('data');
        // ///
        // try{
        // $cloudinary->uploadApi()->upload($input, [
        //     'upload_preset'=> 'kohpklag',
        //     'folder' => 'kohpklag'
        // ]);
        // }catch(Exception $e){
        //     $out->writeln($e);
        // }
        /////Bat dau
        $response = [];
        $imageNames =[];
        
        
        $validator = Validator::make($request->all(),
        [
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]
        );

        if($validator->fails()){
            $out->writeln('Loi 123');
            return response()->json([
                "status" => "failed",
                "message" => "Validation error",
                "error" => $validator->errors()
            ]);
           
        }
        
                if($request->has('images')) {
                    foreach($request->file('images') as $image) {
                        $filename = Str::random(32).".".$image->getClientOriginalExtension();
                        $response["filename"] = $filename;
                        $image->move('uploads/', $filename);
         
                        // $sp =  SanPham::where('id', '=', 2);
                        // $sp->update([
                        //     'anhSanPham'=> $filename
                        // ]);
                        $out->writeln($filename);
                        try{
                            SanPham::insert([
                                'tenSanPham'=>$tenSp,
                                'anhSanPham'=> $filename,
                                'giaSanPham'=>$giaSp,
                            ]);
                            
                        }catch(Exception $e){
                            $out->writeln($e);
                        }
                    }
         
                    $response["status"] = "successs";
                    $response["message"] = "Success! image(s) uploaded";
                }
         
                else {
                    $response["status"] = "failed";
                    $response["message"] = "Failed! image(s) not uploaded";
                }

         return response()->json($response);
    }

    public function layDanhSachSanPham(){
        return response()->json(SanPham::all(), 200);
    }
    
    public function test(){
        $sp =  SanPham::where('id', '=', 2);
                        $sp->update([
                            'anhSanPham'=> "vsadjvsdjv"
                        ]);
        return response()->json($sp);
    }
    
    public function suaSanPham(Request $request, $id){
        $sanPham = SanPham::find($id);
        if(is_null($sanPham)){
            return response()->json(
                ['mess'=>'Khong tim thay san pham'],
                404);
        } 
            $sanPham->update($request->all());
            return response()->json([
            $sanPham,
            'mess'=>'Cap nhat thanh cong'
        ], 200);
         
        
    }

    public function xoaSanPham($id){
        
            $sanPham = SanPham::find($id);
            
             
            if(is_null($sanPham)){
                return response()->json(['message'=>'Khong tim thay san pham'], 404);
            }else{
                $sanPham->delete();
                return response()->json(['message'=>'Xoa thanh cong'], 204);
            }
            
        
    }

    
}
