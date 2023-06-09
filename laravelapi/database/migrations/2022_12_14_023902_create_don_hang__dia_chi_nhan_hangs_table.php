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
        Schema::create('khach_hang__dia_chi_nhan_hang', function (Blueprint $table) {
            $table->unsignedBigInteger('idKhachHang');
            $table->foreign('idKhachHang')
            ->references('id')
            ->on('khach_hangs')
            ->onDelete('cascade');
            $table->string('diaChiNhanHang');
            $table->primary(['idKhachHang', 'diaChiNhanHang']);
        });
        
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('don_hang__dia_chi_nhan_hangs');
    }
};
