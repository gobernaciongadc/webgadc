<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstEstadisticaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_estadistica', function (Blueprint $table) {
            $table->bigIncrements('est_id');
            $table->bigInteger('und_id');
            $table->bigInteger('usr_id');
            $table->dateTime('fecha_registro');
            $table->dateTime('fecha_modificacion');
            $table->text('slug')->unique();
            $table->text('titulo');
            $table->text('imagen');
            $table->text('descripcion');
            $table->date('fecha');
            $table->text('autor');
            $table->text('archivo');
            $table->integer('publicar');
            $table->string('estado',2);
            $table->foreign('und_id')->references('und_id')->on('und_unidad')->onDelete('cascade')
                ->dropForeign(['und_id']);
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('est_estadistica');
        Schema::enableForeignKeyConstraints();
    }
}
