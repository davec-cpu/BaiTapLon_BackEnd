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
        Schema::table('dau_bep_che_biens', function (Blueprint $table) {
            $table->unsignedBigInteger('idSanPhamDuocGiao');
            $table->foreign('idSanPhamDuocGiao')
            ->references('idSanPham')
            ->on('chi_tiet_gio_hangs')
            ->onDelete('cascade');
           });
        //
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
