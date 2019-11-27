<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProductIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('order', 'product_ids')) {
            Schema::table('order', function (Blueprint $table) {
                $table->text("product_ids")->nullable();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Schema::hasColumn('order', 'product_ids')) {
            Schema::table('order', function (Blueprint $table) {
                $table->dropTable('product_ids');
            });
        }
    }
}
