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
        Schema::create('ca_lam_viecs__n_don_dep', function (Blueprint $table) {
            $table->unsignedBigInteger('idCaLamViec');
            $table->foreign('idCaLamViec')
            ->references('id')
            ->on('ca_lam_viecs')
            ->onDelete('cascade');

            $table->unsignedBigInteger('idNDonDep');
            $table->foreign('idNDonDep')
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
