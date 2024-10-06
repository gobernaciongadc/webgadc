<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeiServicioImagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sei_servicio_imagen', function (Blueprint $table) {
            $table->bigIncrements('sei_id');
            $table->string('titulo',300);
            $table->text('descripcion');
            $table->text('imagen');
            $table->integer('publicar');
            $table->string('estado',2);
            $table->integer('tipo_imagen');
            $table->integer('ancho');
            $table->integer('alto');
            $table->bigInteger('sep_id');
            $table->foreign('sep_id')->references('sep_id')->on('sep_servicio_publico')->onDelete('cascade')
                ->dropForeign(['sep_id']);
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
        Schema::dropIfExists('sei_servicio_imagen');
        Schema::enableForeignKeyConstraints();
    }
}
