<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_proyecto', function (Blueprint $table) {
            $table->bigIncrements('pro_id')->nullable(false);
            $table->text('nombre')->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->decimal('inversion',12,2)->nullable(true);
            $table->text('fuente_financiamiento')->nullable(false);
            $table->string('estado_proyecto',200)->nullable(false);
            $table->decimal('ejecucion_fisica',12,2)->nullable(false);            
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
            $table->bigInteger('usr_id');
            $table->bigInteger('und_id');
            $table->foreign('und_id')->references('und_id')->on('und_unidad')->onDelete('cascade')->dropForeign(['und_id']);
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
        Schema::dropIfExists('pro_proyecto');
        Schema::enableForeignKeyConstraints();
    }
}
