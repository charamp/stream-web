<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function($table) {
            $table->increments('alarm_id', true);
            $table->string('node');
            $table->string('rack');
            $table->string('card');
            $table->string('port');
            $table->string('s1');
            $table->string('s2');
            $table->string('service_type');
            $table->timestamp('time_started');
            $table->timestamp('time_updated');
            $table->string('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alarms');
    }
}
