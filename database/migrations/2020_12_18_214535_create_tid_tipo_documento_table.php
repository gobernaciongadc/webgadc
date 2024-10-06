<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTidTipoDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tid_tipo_documento', function (Blueprint $table) {
            $table->bigIncrements('tid_id');
            $table->string('descripcion',100)->nullable(false);
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
        Schema::dropIfExists('tid_tipo_documento');
        Schema::enableForeignKeyConstraints();
    }
}
