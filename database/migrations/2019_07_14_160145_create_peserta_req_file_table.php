<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesertaReqFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This is pivot table
        Schema::create('peserta_req_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thsmt', 11);
            $table->string('kode_kelas', 11);
            $table->string('kode_peserta', 128);
            $table->string('kode_pj', 128);
            $table->string('kode_file', 30);
            $table->string('file_info', 255);
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
        Schema::dropIfExists('peserta_req_file');
    }
}
