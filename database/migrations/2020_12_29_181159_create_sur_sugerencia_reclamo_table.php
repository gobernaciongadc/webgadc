<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurSugerenciaReclamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sur_sugerencia_reclamo', function (Blueprint $table) {
            $table->bigIncrements('sur_id')->nullable(false);
            $table->text('sugerencia')->nullable(false);
            $table->integer('estado_visto')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->string('ip_terminal',50)->nullable(false);
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
        Schema::dropIfExists('sur_sugerencia_reclamo');
        Schema::enableForeignKeyConstraints();
    }
}
