<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConSemanariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_semanarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('edicion');
            $table->date('fecha_publicacion')->nullable(false);
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('con_seminarios');
        Schema::enableForeignKeyConstraints();
    }
}
