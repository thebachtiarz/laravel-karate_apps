<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticReqFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_req_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thsmt', 11);
            $table->string('kode_file', 11)->unique();
            $table->string('kode_kelas', 11);
            $table->string('nama_file', 30);
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
        Schema::dropIfExists('static_req_file');
    }
}
