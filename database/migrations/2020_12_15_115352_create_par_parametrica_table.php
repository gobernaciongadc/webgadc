<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParParametricaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_parametrica', function (Blueprint $table) {
            $table->integer('par_id')->nullable(false);
            $table->string('codigo',30)->nullable(false);
            $table->string('valor1',100)->nullable(true);
            $table->string('valor2',100)->nullable(true);
            $table->string('valor3',100)->nullable(true);
            $table->string('valor4',100)->nullable(true);
            $table->string('valor5',100)->nullable(true);
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
        Schema::dropIfExists('par_parametrica');
        Schema::enableForeignKeyConstraints();
    }
}
