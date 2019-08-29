<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessAuthTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_auth_token', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token', 128);
            $table->string('type', 32);
            $table->string('email_pair', 100);
            $table->string('code_pair', 128)->nullable();
            $table->string('new_status', 15)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_auth_token');
    }
}
