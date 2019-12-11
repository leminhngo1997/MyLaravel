<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTieuchiPhongtraoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tieuchi_phongtrao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tieuchi_id');
            $table->foreign('tieuchi_id')->references('id')->on('tieuchi');
            $table->unsignedBigInteger('phongtrao_id');
            $table->foreign('phongtrao_id')->references('id')->on('phongtrao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tieuchi_phongtrao');
    }
}
