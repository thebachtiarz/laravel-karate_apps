<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticReqBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_req_budget', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thsmt', 11);
            $table->string('kode_kelas', 11);
            $table->string('tingkat', 3);
            $table->string('biaya_ujian', 7);
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
        Schema::dropIfExists('static_req_budget');
    }
}
