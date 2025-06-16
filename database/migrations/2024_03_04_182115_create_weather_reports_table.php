<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherReportsTable extends Migration
{
    public function up()
    {
        Schema::create('weather_reports', function (Blueprint $table) {
            $table->id();  
            $table->string('sea_state');
            $table->string('cloud_cover');
            $table->string('visibility');
            $table->string('wind_force');
            $table->string('wind_direction');
            $table->string('wind_speed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_reports');
    }
}
