<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWastesTable extends Migration
{
    public function up()
    {
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();     
            $table->string('nature_deche')->nullable();
            $table->string('estimated_size')->nullable();
            $table->string('matiere')->nullable();
            $table->string('color')->nullable();
            $table->string('deche_peche')->nullable();
            $table->boolean('picked')->default(false);
            $table->string('heure_debut')->nullable();
            $table->string('vitesse_navire')->nullable();
            $table->string('effort')->nullable();
            $table->text('commentaires')->nullable();
            $table->string('location_latitude_deg_min_sec')->nullable();
            $table->string('location_latitude_deg_dec')->nullable();
            $table->string('location_longitude_deg_min_sec')->nullable();
            $table->string('location_longitude_deg_dec')->nullable();  
            $table->unsignedBigInteger('weather_report_id');
            $table->foreign('weather_report_id')->references('id')->on('weather_reports');
            $table->unsignedBigInteger('dechet_id');
            $table->foreign('dechet_id')->references('id')->on('dechets');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wastes');
    }
}
