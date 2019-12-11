<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosoHoatdongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coso_hoatdong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coso_id');
            $table->foreign('coso_id')->references('id')->on('coso');
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
        Schema::dropIfExists('coso_hoatdong');
    }
}
