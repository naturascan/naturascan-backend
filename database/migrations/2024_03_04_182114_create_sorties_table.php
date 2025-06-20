<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortiesTable extends Migration
{
    public function up()
    {
        Schema::create('sorties', function (Blueprint $table) {
            $table->id(); 
            $table->string('type');
            $table->boolean('finished')->default(false);
            $table->boolean('synchronised')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sorties');
    }
}
