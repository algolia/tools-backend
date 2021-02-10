<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transform extends Migration
{
    public function up()
    {
        Schema::create('transformations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->string('name')->index();
            $table->longText('body');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop('transformations');
    }
}
