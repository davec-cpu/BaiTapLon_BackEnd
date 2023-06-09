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
        Schema::table('giao_hangs', function (Blueprint $table) {
            // change() tells the Schema builder that we are altering a table
            $table->time('thoiGianDonHangDuocChiDinh')->nullable()->change();
            $table->time('thoiGianDonHangBatDauDuocGiao')->nullable()->change();
            $table->time('thoiGianDonHangDenNoi')->nullable()->change();
             
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
        Schema::table('giao_hangs', function (Blueprint $table) {
            $table->time('thoiGianDonHangDuocChiDinh')->nullable(false)->change();
            $table->time('thoiGianDonHangBatDauDuocGiao')->nullable(false)->change();
            $table->time('thoiGianDonHangDenNoi')->nullable(false)->change();
             
        });
    }
};
