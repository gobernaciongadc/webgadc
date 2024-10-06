<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pla_plan', function (Blueprint $table) {
            $table->bigIncrements('pla_id')->nullable(false);
            $table->text('titulo')->nullable(false);
            $table->text('periodo')->nullable(false);
            $table->text('imagen')->nullable(false);
            $table->text('link_descarga')->nullable(false);
            $table->integer('publicar')->nullable(false);
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
        Schema::dropIfExists('pla_plan');
        Schema::enableForeignKeyConstraints();
    }
}
