<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiuTipoUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiu_tipo_unidad', function (Blueprint $table) {
            $table->bigIncrements('tiu_id');
            $table->integer('tipo');
            $table->string('descripcion',300);
            $table->string('estado',2);
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
        Schema::dropIfExists('tiu_tipo_unidad');
        Schema::enableForeignKeyConstraints();
    }
}
