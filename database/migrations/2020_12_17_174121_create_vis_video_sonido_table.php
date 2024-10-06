<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisVideoSonidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vis_video_sonido', function (Blueprint $table) {
            $table->bigIncrements('vis_id');
            $table->text('titulo')->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->text('link_descarga')->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
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
        Schema::dropIfExists('vis_video_sonido');
        Schema::enableForeignKeyConstraints();
    }
}
