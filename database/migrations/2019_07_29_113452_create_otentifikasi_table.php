<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtentifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otentifikasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tujuan_code', 128);
            $table->string('tujuan_kelas', 11);
            $table->string('asal_email', 100);
            $table->string('asal_newstat', 3);
            $table->Text('asal_info')->nullable();
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
        Schema::dropIfExists('otentifikasi');
    }
}
