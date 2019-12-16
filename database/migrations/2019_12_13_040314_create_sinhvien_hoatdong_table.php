<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinhvienHoatdongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_hoatdong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sv_id');
            $table->foreign('sv_id')->references('id')->on('users');
            $table->unsignedBigInteger('hoatdong_id');
            $table->foreign('hoatdong_id')->references('id')->on('hoatdong');
            $table->integer('heso');
            $table->string('chuthich')->nullable();
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
        Schema::dropIfExists('user_hoatdong');
    }
}
