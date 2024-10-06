<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_respuesta', function (Blueprint $table) {
            $table->bigIncrements('res_id')->nullable(false);
            $table->text('ip_terminal')->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('pre_id');
            $table->bigInteger('ops_id');
            $table->foreign('pre_id')->references('pre_id')->on('pre_pregunta')->onDelete('cascade')
                ->dropForeign(['pre_id']);
            $table->foreign('ops_id')->references('ops_id')->on('ops_opcion')->onDelete('cascade')
                ->dropForeign(['ops_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('res_respuesta');
        Schema::enableForeignKeyConstraints();
    }
}
