<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name');
            $table->string('email');
            $table->string('domain')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('address1')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('currency')->nullable();
            $table->string('iana_timezone')->nullable();
            $table->string('shop_owner')->nullable();
            $table->string('plan_name');
            $table->string('myshopify_domain');

            $table->string('status')->nullable();
            $table->string('is_version_app')->nullable();
            $table->string('access_token')->nullable();
            $table->string('public_token')->nullable();

            $table->string('charge_id')->nullable();
            $table->string('app_plan')->default('free');
            $table->string('is_app_plan')->default('free');

            $table->timestamps();

            $table->primary('id');
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop');
    }
}
