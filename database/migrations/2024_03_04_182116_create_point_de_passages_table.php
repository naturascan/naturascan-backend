<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointDePassagesTable extends Migration
{
    public function up()
    {
        Schema::create('point_de_passages', function (Blueprint $table) {
            $table->id();  
            $table->string('nom');
            $table->string('latitude_deg_min_sec');
            $table->string('latitude_deg_dec');
            $table->string('longitude_deg_min_sec');
            $table->string('longitude_deg_dec');
            $table->string('description');
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('point_de_passages');
    }
}
