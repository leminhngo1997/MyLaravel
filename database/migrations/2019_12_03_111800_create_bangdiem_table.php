<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBangdiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bangdiem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('loaibangdiem_id');
            $table->foreign('loaibangdiem_id')->references('id')->on('loaibangdiem');
            // $table->unsignedBigInteger('doituong_id');
            // $table->foreign('doituong_id')->references('id')->on('doituong');
            $table->integer('maxbangdiem'); 
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
        Schema::dropIfExists('bangdiem');
    }
}
