<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('slider');
        Schema::create('slider', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position');
            $table->bigInteger('product_id');
            $table->bigInteger('shop_id');
            $table->timestamps();
             $table->index('shop_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
