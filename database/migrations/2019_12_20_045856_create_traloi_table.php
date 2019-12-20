<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraloiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traloi_talbe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_traloi');
            $table->unsignedBigInteger('sv_id');
            $table->foreign('sv_id')->references('id')->on('users');
            $table->unsignedBigInteger('cauhoi_id');
            $table->foreign('cauhoi_id')->references('id')->on('cauhoi');
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
        Schema::dropIfExists('traloi_talbe');
    }
}
