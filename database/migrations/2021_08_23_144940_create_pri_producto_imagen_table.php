<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriProductoImagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pri_producto_imagen', function (Blueprint $table) {
            $table->bigIncrements('pri_id');
            $table->string('titulo',300);
            $table->text('descripcion');
            $table->text('imagen');
            $table->integer('publicar');
            $table->string('estado',2);
            $table->integer('tipo_imagen');
            $table->integer('ancho');
            $table->integer('alto');
            $table->bigInteger('pro_id');
            $table->foreign('pro_id')->references('pro_id')->on('pro_producto')->onDelete('cascade')
                ->dropForeign(['pro_id']);
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
        Schema::dropIfExists('pri_producto_imagen');
        Schema::enableForeignKeyConstraints();
    }
}
