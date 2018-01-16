<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_apps', function (Blueprint $table) {
            $table->string('app_id', 190);
            $table->integer('user_id');
            $table->string('app_secret');
            $table->string('others')->nullable();
            $table->timestamps();

            $table->primary('app_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_apps');
    }
}
