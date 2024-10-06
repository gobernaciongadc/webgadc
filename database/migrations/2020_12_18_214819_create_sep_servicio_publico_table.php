<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepServicioPublicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sep_servicio_publico', function (Blueprint $table) {
            $table->bigIncrements('sep_id')->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->text('descripcion')->nullable(false);
            $table->text('horario_atencion')->nullable(false);
            $table->decimal('costo_base',10,2)->nullable(true);

            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
            $table->text('slug')->unique();
            $table->bigInteger('und_id');
            $table->bigInteger('ubi_id');
            $table->bigInteger('usr_id');

            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')
                ->dropForeign(['id']);
            $table->foreign('und_id')->references('und_id')->on('und_unidad')->onDelete('cascade')
                ->dropForeign(['und_id']);
            $table->foreign('ubi_id')->references('ubi_id')->on('ubi_ubicacion')->onDelete('cascade')
                ->dropForeign(['ubi_id']);
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
        Schema::dropIfExists('sep_servicio_publico');
        Schema::enableForeignKeyConstraints();
    }
}
