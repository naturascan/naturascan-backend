<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapesTable extends Migration
{
    public function up()
    {
        Schema::create('etapes', function (Blueprint $table) {
            $table->id();   
            $table->string('nom');
            $table->string('description');
            $table->string('heure_depart_port');
            $table->string('heure_arrivee_port');
            $table->unsignedBigInteger('sortie_id');
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->unsignedBigInteger('point_de_passage_id');
            $table->foreign('point_de_passage_id')->references('id')->on('point_de_passages');
            $table->unsignedBigInteger('departure_weather_report_id');
            $table->foreign('departure_weather_report_id')->references('id')->on('weather_reports');
            $table->unsignedBigInteger('arrival_weather_report_id');
            $table->foreign('arrival_weather_report_id')->references('id')->on('weather_reports');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('etapes');
    }
}
