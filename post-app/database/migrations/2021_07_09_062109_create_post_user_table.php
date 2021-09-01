<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // constrainted사용시 자동으로 이름관례에 따라 자동으로 해줌
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            // $table->timestamps(); // createdAt, updatedAt
            // $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP')); // createdAt, updatedAt
            $table->timestamp('created_at')->useCurrent(); // createdAt, updatedAt
            $table->unique(['user_id', 'post_id']);
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_user');
    }
}
