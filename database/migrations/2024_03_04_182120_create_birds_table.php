<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirdsTable extends Migration
{
    public function up()
    {
        Schema::create('birds', function (Blueprint $table) {
            $table->id();   
            $table->string('nbre_estime')->nullable();
            $table->string('presence_jeune')->nullable();
            $table->string('etat_groupe')->nullable();
            $table->string('comportement')->nullable();
            $table->string('reaction_bateau')->nullable();
            $table->string('distance_estimee')->nullable();
            $table->string('especes_associees')->nullable();
            $table->string('heure_debut')->nullable();
            $table->string('heure_fin')->nullable();
            $table->string('vitesse_navire')->nullable();
            $table->string('activites_humaines_associees')->nullable();
            $table->string('effort')->nullable();
            $table->text('commentaires')->nullable();
            $table->string('location_d_latitude_deg_min_sec')->nullable();
            $table->string('location_d_latitude_deg_dec')->nullable();
            $table->string('location_d_longitude_deg_min_sec')->nullable();
            $table->string('location_d_longitude_deg_dec')->nullable();
            $table->string('location_f_latitude_deg_min_sec')->nullable();
            $table->string('location_f_latitude_deg_dec')->nullable();
            $table->string('location_f_longitude_deg_min_sec')->nullable();
            $table->string('location_f_longitude_deg_dec')->nullable();
            $table->unsignedBigInteger('espece_id');
            $table->foreign('espece_id')->references('id')->on('especes');
            $table->unsignedBigInteger('weather_report_id');
            $table->foreign('weather_report_id')->references('id')->on('weather_reports');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('birds');
    }
}
