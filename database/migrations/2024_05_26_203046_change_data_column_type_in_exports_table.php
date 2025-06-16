<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataColumnTypeInExportsTable extends Migration
{
    public function up()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->longText('data')->change();
        });
    }

    public function down()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->text('data')->change();
        });
    }
}
