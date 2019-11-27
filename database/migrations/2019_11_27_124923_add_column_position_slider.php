<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPositionSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('slider', 'position')) {
            Schema::table('slider', function (Blueprint $table) {
                $table->integer('position');
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
        if(Schema::hasColumn('slider', 'position')) {
            Schema::table('slider', function (Blueprint $table) {
                $table->dropTable('position');
            });
        }
    }
}
