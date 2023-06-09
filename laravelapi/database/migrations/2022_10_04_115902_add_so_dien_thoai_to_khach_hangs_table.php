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
        Schema::table('khach_hangs', function (Blueprint $table) {
            //
           // $table->string('soDienThoai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('khach_hangs', function (Blueprint $table) {
            //
          //  $table->dropIfExists('soDienThoai');
        });
    }
};
