<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('mota')->nullable();
            $table->string('name_tieuchi');
            $table->string('name_phongtrao');
            $table->string('name_hoatdong');
            $table->unsignedBigInteger('sv_id');
            $table->foreign('sv_id')->references('id')->on('users');
            $table->unsignedBigInteger('bangdiem_id');
            $table->foreign('bangdiem_id')->references('id')->on('bangdiem');
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
        Schema::dropIfExists('posts');
    }
}
