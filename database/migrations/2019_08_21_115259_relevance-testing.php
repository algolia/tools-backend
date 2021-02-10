<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelevanceTesting extends Migration
{
    public function up()
    {
        Schema::create('relevance_testing_suites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->bigInteger('user_id');
            $table->timestamps();
        });
        Schema::create('relevance_testing_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('suite_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->bigInteger('position')->default(0);
            $table->timestamps();
        });
        Schema::create('relevance_testing_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id');
            $table->longText('test_data');
            $table->bigInteger('position')->default(0);
            $table->timestamps();
        });
        Schema::create('relevance_testing_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('suite_id');
            $table->string('email');
            $table->integer('read');
            $table->integer('write');
            $table->timestamps();
        });
        Schema::create('relevance_testing_runs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('suite_id');
            $table->string('app_id')->nullable();
            $table->string('index_name')->nullable();
            $table->integer('hits_per_page')->default(8);
            $table->longText('params');
            $table->bigInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('relevance_testing_suites');
        Schema::drop('relevance_testing_groups');
        Schema::drop('relevance_testing_tests');
        Schema::drop('relevance_testing_permissions');
        Schema::drop('relevance_testing_runs');
    }
}
