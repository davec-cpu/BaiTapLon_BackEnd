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
        Schema::create('giao_hangs', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('idCaLamViec');
            $table->foreign('idCaLamViec')
            ->references('id')
            ->on('ca_lam_viecs')
            ->onDelete('cascade');
            
            $table->unsignedBigInteger('idNhanVienGiaoHang');
            $table->foreign('idNhanVienGiaoHang')
            ->references('id')
            ->on('admins')
            ->onDelete('cascade');

            $table->unsignedBigInteger('idDonHang');
            $table->foreign('idDonHang')
            ->references('id')
            ->on('gio_hangs')
            ->onDelete('cascade');

            $table->time('thoiGianDonHangDuocChiDinh');

            $table->time('thoiGianDonHangBatDauDuocGiao');

            $table->time('thoiGianDonHangDenNoi');

            $table->string('trangThaiDonHang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giao_hangs');
    }
};
