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
            $table->date('ngaybatdau')->nullable();
            $table->date('ngayketthuc')->nullable();
            $table->string('nguoitao');
            $table->string('nguoiduyet')->nullable();
            $table->integer('status_clone');
            $table->text('mota')->nullable();
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
