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
        Schema::create('chi_tiet_gio_hangs', function (Blueprint $table) {
            $table->unsignedBigInteger('idGioHang');
            $table->unsignedBigInteger('idSanPham');
            

            $table->integer('soLuongSanPham');
            $table->integer('giaSanPham');
            $table->timestamps();

            $table->foreign('idGioHang')
            ->references('id')
            ->on('gio_hangs')
            ->onDelete('cascade')
             ;

            $table->foreign('idSanPham')
            ->references('id')
            ->on('san_phams')
            ->onDelete('cascade')
            ;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_gio_hangs');
    }
};
