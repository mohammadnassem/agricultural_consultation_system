<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plant_id')->unsigned();
            $table->string('name');
            $table->integer('interval')->nullable();
            $table->text('description')->nullable();
            $table->integer('step');
            $table->integer('week')->default(0);
            $table->integer('watering_period')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('plant_id')->references('id')->on('plants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stages');
    }
}
