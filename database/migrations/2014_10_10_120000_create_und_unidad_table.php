<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUndUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('und_unidad', function (Blueprint $table) {
            $table->bigIncrements('und_id');
            $table->text('nombre');
            $table->text('mision')->nullable(true);
            $table->text('vision')->nullable(true);
            $table->text('objetivo');
            $table->text('historia');
            $table->text('organigrama');
            $table->text('mapa_organigrama')->nullable(true);
            $table->text('imagen_icono');
            $table->string('estado',2);
            $table->integer('celular_wp')->nullable(true);
            $table->text('telefonos')->nullable(true);
            $table->string('email',200)->nullable(true);
            $table->text('link_facebook')->nullable(true);
            $table->text('link_instagram')->nullable(true);
            $table->text('link_twiter')->nullable(true);
            $table->text('link_youtube')->nullable(true);
            $table->text('lugar')->nullable(true);
            $table->text('direccion')->nullable(true);
            $table->decimal('latitud',20,10)->nullable(true);
            $table->decimal('longitud',20,10)->nullable(true);
            $table->text('imagen_direccion')->nullable(true);

            $table->bigInteger('bio_id')->nullable(true);
            $table->bigInteger('und_padre_id')->nullable(true);
            $table->bigInteger('tiu_id');

            $table->foreign('tiu_id')->references('tiu_id')->on('tiu_tipo_unidad')->onDelete('cascade')
                ->dropForeign(['tiu_id']);
            $table->foreign('bio_id')->references('bio_id')->on('bio_biografia')->onDelete('cascade')
                ->dropForeign(['bio_id']);
            $table->foreign('und_padre_id')->references('und_id')->on('und_unidad')->onDelete('cascade')
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
        Schema::dropIfExists('und_unidad');
        Schema::enableForeignKeyConstraints();
    }
}
