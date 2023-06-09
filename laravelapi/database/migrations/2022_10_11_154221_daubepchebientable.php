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
        //

        Schema::create('dau_bep_che_biens', function (Blueprint $table){
            $table->unsignedBigInteger('idCaLamViec');
            $table->foreign('idCaLamViec')
            ->references('id')
            ->on('ca_lam_viecs')
            ->onDelete('cascade');
            
            $table->unsignedBigInteger('idDauBepThucHien');
            $table->foreign('idDauBepThucHien')
            ->references('id')
            ->on('admins')
            ->onDelete('cascade');

            $table->unsignedBigInteger('idDonHang');
            $table->foreign('idDonHang')
            ->references('id')
            ->on('gio_hangs')
            ->onDelete('cascade');
            $table->time('thoiGianCheBien');

           // $table->float('danhGiaKhachHang');

            $table->string('trangThaiSanPham');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
