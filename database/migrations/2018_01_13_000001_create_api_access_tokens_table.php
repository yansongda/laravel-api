<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_access_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('app_id', 190);
            $table->string('access_token', 190);
            $table->string('refresh_token', 190);
            $table->dateTime('expired_at');
            $table->timestamps();

            $table->index('user_id');
            $table->index('app_id');
            $table->unique('access_token');
            $table->index('refresh_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_access_tokens');
    }
}
