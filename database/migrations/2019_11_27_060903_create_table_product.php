<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('title', 1000);
            $table->string('handle', 1000)->nullable();
            $table->text('body_html')->nullable();
            $table->string('image', 2000)->nullable();
            $table->string('tag', 2000)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('shop_id');
            $table->integer("view")->default(0);
            $table->integer("add_to_cart")->default(0);
            $table->integer("checkout")->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index('id');

            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
