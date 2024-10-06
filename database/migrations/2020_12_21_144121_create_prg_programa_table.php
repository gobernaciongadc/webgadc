<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrgProgramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prg_programa', function (Blueprint $table) {
            $table->bigIncrements('prg_id')->nullable(false);
            $table->text('nombre')->nullable(false);
            $table->string('sector',100)->nullable(false);
            $table->text('objetivo')->nullable(false);
            $table->string('responsable',200)->nullable(false);
            $table->decimal('presupuesto',12,2)->nullable(true);
            $table->string('benificiarios',200)->nullable(false);
            $table->integer('publicar')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->dateTime('fecha_registro')->nullable(false);
            $table->dateTime('fecha_modificacion')->nullable(false);
            $table->bigInteger('usr_id');
            $table->bigInteger('und_id');
            $table->text('metas')->nullable(true);
            $table->text('metas_alcanzadas')->nullable(true);

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
        Schema::dropIfExists('prg_programa');
        Schema::enableForeignKeyConstraints();
    }
}
