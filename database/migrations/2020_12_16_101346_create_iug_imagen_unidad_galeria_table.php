<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIugImagenUnidadGaleriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iug_imagen_unidad_galeria', function (Blueprint $table) {
            $table->bigIncrements('iug_id');
            $table->text('imagen')->nullable(false);
            $table->integer('alto')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->integer('tipo')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->text('titulo')->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->bigInteger('und_id');
            $table->foreign('und_id')->references('und_id')->on('und_unidad')->onDelete('cascade')
                ->dropForeign(['und_id']);
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
        Schema::dropIfExists('iug_imagen_unidad_galeria');
        Schema::enableForeignKeyConstraints();
    }
}
