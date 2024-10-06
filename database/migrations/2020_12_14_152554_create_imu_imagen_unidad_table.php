<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImuImagenUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imu_imagen_unidad', function (Blueprint $table) {
            $table->bigIncrements('imu_id');
            $table->text('imagen');
            $table->integer('alto');
            $table->integer('ancho');
            $table->integer('tipo');
            $table->string('estado',2);
            $table->bigInteger('und_id');
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
        Schema::dropIfExists('imu_imagen_unidad');
        Schema::enableForeignKeyConstraints();
    }
}
