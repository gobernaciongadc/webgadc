<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_documento', function (Blueprint $table) {
            $table->bigIncrements('doc_id');
            $table->text('titulo')->nullable(false);
            $table->text('resumen')->nullable(false);
            $table->text('archivo')->nullable(false);
            $table->date('fecha_publicacion')->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('und_id');
            $table->bigInteger('usr_id');
            $table->bigInteger('tid_id');

            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('und_id')->references('und_id')->on('und_unidad')->onDelete('cascade')
                ->dropForeign(['und_id']);
            $table->foreign('tid_id')->references('tid_id')->on('tid_tipo_documento')->onDelete('cascade')
                ->dropForeign(['tid_id']);
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
        Schema::dropIfExists('doc_documento');
        Schema::enableForeignKeyConstraints();
    }
}
