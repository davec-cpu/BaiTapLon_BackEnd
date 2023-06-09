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
        Schema::create('ca_lam_viecs__dau_bep', function (Blueprint $table) {
            $table->unsignedBigInteger('idCaLamViec');
            $table->foreign('idCaLamViec')
            ->references('id')
            ->on('ca_lam_viecs')
            ->onDelete('cascade');

            $table->unsignedBigInteger('idDauBep');
            $table->foreign('idDauBep')
            ->references('id')
            ->on('admins')
            ->onDelete('cascade');


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
