<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservationsTable extends Migration
{
    public function up()
    {
        Schema::create('observations', function (Blueprint $table) {
            $table->id();     
            $table->string('type');
            $table->unsignedBigInteger('sortie_id');
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->unsignedBigInteger('bird_id')->nullable();  
            $table->foreign('bird_id')->references('id')->on('birds');
            $table->unsignedBigInteger('waste_id')->nullable();
            $table->foreign('waste_id')->references('id')->on('wastes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('observations');
    }
}
