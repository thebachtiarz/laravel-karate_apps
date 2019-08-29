<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesertaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_peserta', 128)->unique();
            $table->string('kode_kelas_peserta', 11);
            $table->string('nama_peserta', 128);
            $table->string('tingkat', 3);
            $table->string('noinduk', 11)->nullable();
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
        Schema::dropIfExists('peserta_data');
    }
}
