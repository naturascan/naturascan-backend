<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecesTable extends Migration
{
    public function up()
    {
        Schema::create('especes', function (Blueprint $table) {
            $table->id(); 
            $table->string('common_name');
            $table->string('scientific_name');
            $table->string('description')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('especes');
    }
}
