<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoatdongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoatdong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('diem');
            $table->string('doituong');
            $table->date('ngaybatdau');
            $table->date('ngayketthuc');
            $table->string('nguoitao');
            $table->string('nguoiduyet');
            $table->integer('status_clone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoatdong');
    }
}
