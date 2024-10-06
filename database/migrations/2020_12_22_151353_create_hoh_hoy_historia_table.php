<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHohHoyHistoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoh_hoy_historia', function (Blueprint $table) {
            $table->bigIncrements('hoh_id')->nullable(false);
            $table->date('fecha');
            $table->text('titulo')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->text('acontecimiento')->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
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
        Schema::dropIfExists('hoh_hoy_historia');
        Schema::enableForeignKeyConstraints();
    }
}
