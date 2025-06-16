<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortieObservateursTable extends Migration
{
    public function up()
    {
        Schema::create('sortie_observateurs', function (Blueprint $table) {

            $table->id();    

            $table->string('role');
             
            $table->unsignedBigInteger('sortie_id');
            $table->foreign('sortie_id')->references('id')->on('sorties'); 

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); 

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('sortie_observateurs');
    }
}
