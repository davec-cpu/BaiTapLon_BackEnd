<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('dau_bep_che_bien__thoi_gian_hoan_thanhs', function (Blueprint $table) {
            
        //         $table->unsignedBigInteger('idSanPham');
        //         $table->foreign('idSanPham')
        //         ->references('idSanPhamDuocGiao')
        //         ->on('dau_bep_che_biens')
        //         ->onDelete('cascade');


        //         $table->unsignedBigInteger('idDauBepThucHien');
        //         $table->foreign('idDauBepThucHien')
        //         ->references('idDauBepThucHien')
        //         ->on('dau_bep_che_biens')
        //         ->onDelete('cascade');


        //         $table->unsignedBigInteger('idDonHang');
        //         $table->foreign('idDonHang')
        //         ->references('idDonHang')
        //         ->on('dau_bep_che_biens')
        //         ->onDelete('cascade');


        //         $table->unsignedBigInteger('idCaLamViec');
        //         $table->foreign('idCaLamViec')
        //         ->references('idCaLamViec')
        //         ->on('dau_bep_che_biens')
        //         ->onDelete('cascade');

                
        //         // $table->unsignedBigInteger('idCaLamViec');
        //         // $table->foreign('idCaLamViec')
        //         // ->references('id')
        //         // ->on('ca_lam_viecs')
        //         // ->onDelete('cascade');

        //         // $table->unsignedBigInteger('idDauBep');
        //         // $table->foreign('idDauBep')
        //         // ->references('id')
        //         // ->on('admins')
        //         // ->onDelete('cascade');

        //         $table->time('thoiGianHoanThanh');
    
        //         $table->primary(['idSanPham', 'idDauBepThucHien', 'idDonHang', 'idCaLamViec', 'thoiGianHoanThanh']);
    
                
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dau_bep_che_bien__thoi_gian_hoan_thanhs');
    }
};
