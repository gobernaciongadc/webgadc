<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDolDocumentoLegalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dol_documento_legal', function (Blueprint $table) {
            $table->bigIncrements('dol_id');
            $table->text('titulo')->nullable(false);
            $table->text('resumen')->nullable(false);
            $table->text('contenido')->nullable(false);
            $table->text('archivo')->nullable(false);
            $table->date('fecha_aprobacion')->nullable(false);
            $table->date('fecha_promulgacion')->nullable(false);
            $table->string('numero_documento',50)->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('und_id');
            $table->bigInteger('usr_id');
            $table->bigInteger('tdl_id');

            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('und_id')->references('und_id')->on('und_unidad')->onDelete('cascade')
                ->dropForeign(['und_id']);
            $table->foreign('tdl_id')->references('tdl_id')->on('tdl_tipo_documento_legal')->onDelete('cascade')
                ->dropForeign(['tdl_id']);
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
        Schema::dropIfExists('dol_documento_legal');
        Schema::enableForeignKeyConstraints();
    }
}
