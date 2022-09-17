<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plant_schedule_id')->unsigned();
            $table->bigInteger('stage_id')->unsigned();
            $table->integer('interval')->nullable();   //day number
            $table->boolean('is_repeating')->nullable();
            $table->text('description');
            $table->string('title');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('plant_schedule_id')->references('id')->on('plant_schedules')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steps');
    }
}
