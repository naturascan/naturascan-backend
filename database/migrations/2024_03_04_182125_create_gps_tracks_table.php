<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpsTracksTable extends Migration
{
    public function up()
    {
        Schema::create('gps_tracks', function (Blueprint $table) {
            $table->id();    

            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('device')->nullable();
            $table->unsignedBigInteger('sortie_id');
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->boolean('inObservation')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gps_tracks');
    }
}
