<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConConvocatoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_convocatoria', function (Blueprint $table) {
            $table->bigIncrements('con_id');
            $table->text('titulo')->nullable(false);
            $table->text('resumen')->nullable(false);
            $table->text('contenido')->nullable(false);
            $table->text('archivo')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->date('fecha_publicacion')->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->text('convocante');
            $table->bigInteger('und_id');
            $table->bigInteger('usr_id');

            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);

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
        Schema::dropIfExists('con_convocatoria');
        Schema::enableForeignKeyConstraints();
    }
}
