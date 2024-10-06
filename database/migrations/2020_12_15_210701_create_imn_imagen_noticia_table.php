<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImnImagenNoticiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imn_imagen_noticia', function (Blueprint $table) {
            $table->bigIncrements('imn_id');
            $table->string('titulo',300);
            $table->text('descripcion');
            $table->date('fecha');
            $table->text('imagen');
            $table->integer('publicar');
            $table->string('estado',2);
            $table->integer('tipo_imagen');
            $table->integer('ancho');
            $table->integer('alto');
            $table->bigInteger('not_id');
            $table->foreign('not_id')->references('not_id')->on('not_noticia')->onDelete('cascade')
                ->dropForeign(['not_id']);
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
        Schema::dropIfExists('imn_imagen_noticia');
        Schema::enableForeignKeyConstraints();
    }
}
