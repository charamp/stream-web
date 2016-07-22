<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmCustTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarm_custs', function($table) {
            $table->increments('id', true);
            $table->string('cust_id');
            $table->integer('alarm_id')->unsigned();
            $table->timestamp('time_started');
            $table->timestamp('time_updated');
        }); 

        Schema::table('alarm_custs', function($table) {
            $table->foreign('alarm_id')->references('alarm_id')->on('alarms');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alarm_custs');
    }
}
