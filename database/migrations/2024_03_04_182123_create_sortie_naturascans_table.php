<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortieNaturascansTable extends Migration
{
    public function up()
    {
        Schema::create('sortie_naturascans', function (Blueprint $table) {
            $table->id();     
            $table->string('structure')->nullable();
            $table->string('port_depart')->nullable();
            $table->string('port_arrivee')->nullable();
            $table->string('heure_depart_port')->nullable();
            $table->string('heure_arrivee_port')->nullable();
            $table->string('duree_sortie')->nullable();
            $table->string('nbre_observateurs')->nullable();
            $table->string('type_bateau')->nullable();
            $table->string('nom_bateau')->nullable();
            $table->string('hauteur_bateau')->nullable();
            $table->string('heure_utc')->nullable();
            $table->string('distance_parcourue')->nullable();
            $table->string('superficie_echantillonnee')->nullable();
            $table->text('remarque_depart')->nullable();
            $table->text('remarque_arrivee')->nullable();
            $table->unsignedBigInteger('sortie_id')->nullable();
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->unsignedBigInteger('departure_weather_report_id');
            $table->foreign('departure_weather_report_id')->references('id')->on('weather_reports');
            $table->unsignedBigInteger('arrival_weather_report_id');
            $table->foreign('arrival_weather_report_id')->references('id')->on('weather_reports'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sortie_naturascans');
    }
}
