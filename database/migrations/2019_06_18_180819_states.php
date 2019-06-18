<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class States extends Migration
{
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->string('short_code')->index()->nullable();
            $table->longText('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('states');
    }
}
