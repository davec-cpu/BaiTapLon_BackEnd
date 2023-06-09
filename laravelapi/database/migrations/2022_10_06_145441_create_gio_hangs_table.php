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
        Schema::create('gio_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idKhachHang');
            $table->foreign('idKhachHang')
            ->references('id')
            ->on('khach_hangs')
            ->onDelete('cascade');
            $table->timestamp('ngayTao');
            $table->integer('tongTien')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gio_hangs');
    }
};
