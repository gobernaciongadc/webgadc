<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiaSistemaApoyoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sia_sistema_apoyo', function (Blueprint $table) {
            $table->bigIncrements('sia_id')->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->date('fecha')->nullable(true);
            $table->text('link_destino')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->bigInteger('usr_id');
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sia_sistema_apoyo');
    }
}
