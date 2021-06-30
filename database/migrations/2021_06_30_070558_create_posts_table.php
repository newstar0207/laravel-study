<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() // migration 
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('content');
            $table->string('image')
                    ->nullable();
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->timestamps(); // updateAt, createAt 을 자동으로 생성해줌
        });
    }
    // 객체하나가 레코드 하나로 매핑되는것!
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() // rollback
    {
        Schema::dropIfExists('posts');
    }
}
