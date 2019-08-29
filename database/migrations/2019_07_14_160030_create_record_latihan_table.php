<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This is pivot table
        Schema::create('record_latihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thsmt', 11);
            $table->string('kode_kelas_peserta', 11);
            $table->string('kode_peserta', 128);
            $table->string('kode_pelatih', 128);
            $table->string('keterangan', 15);
            $table->string('durasi', 2);
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
        Schema::dropIfExists('record_latihan');
    }
}
