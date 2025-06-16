<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportsTable extends Migration
{
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {

            $table->id();    
            $table->string('uuid'); 
            $table->text('data'); 
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('exports');
    }
}
