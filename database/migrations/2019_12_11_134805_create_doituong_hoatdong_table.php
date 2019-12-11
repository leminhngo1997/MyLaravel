<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoituongHoatdongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doituong_hoatdong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doituong_id');
            $table->foreign('doituong_id')->references('id')->on('doituong');
            $table->unsignedBigInteger('hoatdong_id');
            $table->foreign('hoatdong_id')->references('id')->on('hoatdong');
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
        Schema::dropIfExists('doituong_hoatdong');
    }
}
