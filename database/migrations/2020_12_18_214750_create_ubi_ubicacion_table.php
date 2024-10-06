<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbiUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubi_ubicacion', function (Blueprint $table) {
            $table->bigIncrements('ubi_id')->nullable(false);
            $table->string('unidad',200)->nullable(false);
            $table->text('lugar')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->text('direccion')->nullable(false);
            $table->decimal('latitud',20,10)->nullable(true);
            $table->decimal('longitud',20,10)->nullable(true);
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
        Schema::dropIfExists('ubi_ubicacion');
        Schema::enableForeignKeyConstraints();
    }
}
