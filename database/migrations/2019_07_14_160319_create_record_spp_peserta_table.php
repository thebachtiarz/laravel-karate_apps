<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordSppPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_spp_peserta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thsmt', 11);
            $table->string('kode_kelas', 11);
            $table->string('kode_peserta', 128);
            $table->string('kredit', 7);
            $table->string('untuk_bulan', 3);
            $table->string('kode_pj', 128);
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
        Schema::dropIfExists('record_spp_peserta');
    }
}
