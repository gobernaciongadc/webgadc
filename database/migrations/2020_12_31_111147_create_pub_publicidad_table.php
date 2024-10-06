<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePubPublicidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pub_publicidad', function (Blueprint $table) {
            $table->bigIncrements('pub_id')->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->string('solicitante',200)->nullable(true);
            $table->date('fecha_desde')->nullable(false);
            $table->date('fecha_hasta')->nullable(false);
            $table->date('fecha_registro')->nullable(true);
            $table->text('link_destino')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('usr_id');
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
        Schema::dropIfExists('pub_publicidad');
        Schema::enableForeignKeyConstraints();
    }
}
