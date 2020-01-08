<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinhvienBangdiem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinhvien_bangdiem_coso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sv_id');
            $table->foreign('sv_id')->references('id')->on('users');
            $table->unsignedBigInteger('bangdiem_id');
            $table->foreign('bangdiem_id')->references('id')->on('bangdiem');
            $table->unsignedBigInteger('coso_id');
            $table->foreign('coso_id')->references('id')->on('coso');
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
        Schema::dropIfExists('sinhvien_bangdiem_coso');
    }
}
