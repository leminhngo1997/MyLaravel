<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhongtraoHoatdongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phongtrao_hoatdong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('phongtrao_id');
            $table->foreign('phongtrao_id')->references('id')->on('phongtrao');
            $table->unsignedBigInteger('hoatdong_id');
            $table->foreign('hoatdong_id')->references('id')->on('hoatdong');
            $table->integer('status');
            $table->string('nguoiduyet');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phongtrao_hoatdong');
    }
}
