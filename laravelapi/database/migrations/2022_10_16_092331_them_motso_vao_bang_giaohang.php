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
         

        Schema::table('gio_hangs', function($table) {
            $table->timestamp('ngayGioThanhToan')->nullable();
            $table->string('phuongThucThanhToan')->nullable();
            $table->string('diaChiNguoiNhan')->nullable();
        });

        Schema::table('giao_hangs', function (Blueprint $table) {
            $table->integer('danhGiaKhachHang')->nullable();    
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
         

        Schema::table('gio_hangs', function($table) {
            $table->dropColumn('ngayGioThanhToan');
            $table->dropColumn('phuongThucThanhToan');
            $table->dropColumn('diaChiNguoiNhan');
        });

        Schema::table('giao_hangs', function (Blueprint $table) {
            $table->dropColumn('danhGiaKhachHang')->nullable();    
        });
    }
};
