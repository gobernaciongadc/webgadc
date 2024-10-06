<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenDenunciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('den_denuncia', function (Blueprint $table) {
            $table->bigIncrements('den_id')->nullable(false);
            $table->string('nombre',200)->nullable(false);
            $table->text('correo')->nullable(false);
            $table->text('denuncia')->nullable(false);
            $table->dateTime('fecha_hora')->nullable(false);
            $table->integer('estado_visto')->nullable(false);
            $table->string('ip_terminal',100)->nullable(false);
            $table->text('celular')->nullable(true);
            $table->string('estado',2)->nullable(false);
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
        Schema::dropIfExists('den_denuncia');
        Schema::enableForeignKeyConstraints();
    }
}
