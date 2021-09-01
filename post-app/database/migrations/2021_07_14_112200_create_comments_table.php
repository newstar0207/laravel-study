<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            // 포스트 번호(부모아이디), 유저아이디, 댓글,
            $table->id();
            $table->string('user_name');
            $table->string('comment');
            $table->foreignId('post_id')->constrained()->OnDelete();
            $table->foreignId('user_id')->constrained()->OnDelete();
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
        Schema::dropIfExists('comments');
    }
}
