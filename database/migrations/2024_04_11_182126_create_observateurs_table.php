<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservateursTable extends Migration
{
    public function up()
    {
        Schema::create('observateurs', function (Blueprint $table) {

            $table->id();    
            $table->string('nom'); 
            $table->string('prenom'); 
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('observateurs');
    }
}
