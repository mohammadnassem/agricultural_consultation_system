<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreatePlantUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('stage_id')->constrained();
            $table->boolean('is_finished')->default(false);
            $table->timestamp('is_protected')->nullable();
            $table->timestamp('is_clean')->nullable();
            $table->timestamp('watering_date')->nullable();
            $table->string('soil_type')->nullable();
            $table->decimal('long', 15, 8)->nullable();
            $table->decimal('lat', 15, 8)->nullable();
            $table->double('area',15,8)->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plant_user');
    }
}
