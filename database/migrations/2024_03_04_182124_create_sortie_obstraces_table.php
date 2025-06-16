<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortieObstracesTable extends Migration
{
    public function up()
    {
        Schema::create('sortie_obstraces', function (Blueprint $table) {
            $table->id();     
            
            $table->unsignedBigInteger('sortie_id');
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->unsignedBigInteger('weather_report_id');
            $table->foreign('weather_report_id')->references('id')->on('weather_reports');
            $table->string('plage');
            $table->string('nbre_observateurs');
            $table->string('suivi');
            $table->string('prospection_heure_debut');
            $table->string('prospection_heure_fin');
            $table->text('remark')->nullable();
            $table->string('type_bateau')->nullable();
            $table->string('nom_bateau')->nullable();
            $table->string('hauteur_bateau')->nullable();


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sortie_obstraces');
    }
}
