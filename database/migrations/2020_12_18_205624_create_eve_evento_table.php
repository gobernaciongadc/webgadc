<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEveEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_evento', function (Blueprint $table) {
            $table->bigIncrements('eve_id');
            $table->bigInteger('und_id');
            $table->bigInteger('usr_id');
            $table->dateTime('fecha_registro');
            $table->dateTime('fecha_modificacion');
            $table->text('slug')->unique();
            $table->string('nombre',300);
            $table->text('descripcion');
            $table->string('publico',200);
            $table->text('imagen');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->integer('publicar');
            $table->string('estado',2);
            $table->text('lugar');
            $table->text('direccion');
            $table->decimal('latitud',20,10);
            $table->decimal('longitud',20,10);
            $table->text('imagen_direccion');
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
        Schema::dropIfExists('eve_evento');
        Schema::enableForeignKeyConstraints();
    }
}
