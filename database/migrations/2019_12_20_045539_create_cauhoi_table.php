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
            $table->string('name_ungcuvien');
            $table->unsignedBigInteger('sv_id');
            $table->foreign('sv_id')->references('id')->on('users');
            $table->unsignedBigInteger('suluachon_id');
            $table->foreign('suluachon_id')->references('id')->on('suluachon');
            $table->date('ngaybatdau');
            $table->date('ngayketthuc');
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
