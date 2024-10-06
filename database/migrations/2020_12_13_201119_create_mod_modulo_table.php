<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModModuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_modulo', function (Blueprint $table) {
            $table->bigIncrements('mod_id');
            $table->string('descripcion',200);
            $table->string('estado',2);
            $table->integer('orden');
            $table->bigInteger('sis_id');
            $table->foreign('sis_id')->references('sis_id')->on('sis_sistema')->onDelete('cascade')
                ->dropForeign(['sis_id']);
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
        Schema::dropIfExists('mod_modulo');
        Schema::enableForeignKeyConstraints();
    }
}
