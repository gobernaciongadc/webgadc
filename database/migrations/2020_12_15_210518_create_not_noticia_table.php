<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotNoticiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('not_noticia', function (Blueprint $table) {
            $table->bigIncrements('not_id');
            $table->text('slug')->unique();
            $table->string('antetitulo',300);
            $table->string('titulo',300);
            $table->string('resumen',300);
            $table->text('contenido');
            $table->text('imagen');
            $table->text('link_video')->nullable(true);
            $table->text('categorias');
            $table->text('palabras_clave');
            $table->integer('publicar');
            $table->date('fecha');
            $table->text('fuente');
            $table->integer('prioridad');
            $table->dateTime('fecha_registro');
            $table->dateTime('fecha_modificacion');
            $table->string('estado',2);
            $table->bigInteger('und_id');
            $table->bigInteger('usr_id');
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
        Schema::dropIfExists('not_noticia');
        Schema::enableForeignKeyConstraints();
    }
}
