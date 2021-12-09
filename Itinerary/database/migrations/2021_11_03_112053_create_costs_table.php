<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('room_id')->unique();
            $table->integer('food_cost')->default(0);
            $table->integer('room_cost')->default(0);
            $table->integer('other_cost')->default(0);
            $table->integer('tran_cost')->default(0);
            $table->integer('sum_cost')->default(0);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costs');
    }
}
