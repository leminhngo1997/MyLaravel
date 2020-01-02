<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCauhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cauhoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_cauhoi');
            $table->string('ungcuvien');
            $table->integer('gioihantoida')->nullable();
            $table->unsignedBigInteger('suluachon_id');
            $table->foreign('suluachon_id')->references('id')->on('suluachon');
            $table->unsignedBigInteger('coso_id');
            $table->foreign('coso_id')->references('id')->on('coso');
            $table->date('ngaybatdau')->nullable();
            $table->date('ngayketthuc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cauhoi');
    }
}
