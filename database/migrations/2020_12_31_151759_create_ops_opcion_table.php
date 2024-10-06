<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpsOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ops_opcion', function (Blueprint $table) {
            $table->bigIncrements('ops_id')->nullable(false);
            $table->text('texto_respuesta')->nullable(false);
            $table->string('estado',2)->nullable(false);
            $table->bigInteger('pre_id');
            $table->foreign('pre_id')->references('pre_id')->on('pre_pregunta')->onDelete('cascade')
                ->dropForeign(['pre_id']);
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
        Schema::dropIfExists('ops_opcion');
        Schema::enableForeignKeyConstraints();
    }
}
