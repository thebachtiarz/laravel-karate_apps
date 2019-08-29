<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelasDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_kelas', 11)->unique();
            $table->string('thsmt', 11);
            $table->string('kode_pelatih', 128);
            $table->string('nama_kelas', 128);
            $table->string('durasi_latihan', 5);
            $table->string('spp', 7)->nullable();
            $table->string('avatar', 255)->nullable();
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
        Schema::dropIfExists('kelas_data');
    }
}
