<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccAccesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_acceso', function (Blueprint $table) {
            $table->bigIncrements('acc_id');
            $table->string('descripcion',200);
            $table->string('estado',2);
            $table->string('operacion',200);
            $table->integer('codigo')->unique();
            $table->integer('orden');
            $table->bigInteger('mod_id');
            $table->foreign('mod_id')->references('mod_id')->on('mod_modulo')->onDelete('cascade')
                ->dropForeign(['mod_id']);
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
        Schema::dropIfExists('acc_acceso');
        Schema::enableForeignKeyConstraints();
    }
}
