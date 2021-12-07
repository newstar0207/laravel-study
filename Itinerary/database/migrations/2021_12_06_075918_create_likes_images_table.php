<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes_images', function (Blueprint $table) {
            $table->id();

            $table->timestamps();
        });
    }

    // 한 게시물에 한명당 하나 좋아요 함 유저 -> 여러개 좋아요 가능 (게시물에는 하나11)
    //  집가서 노드 책 보고 함

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes_images');
    }
}
