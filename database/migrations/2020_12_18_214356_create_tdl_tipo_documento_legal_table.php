<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdlTipoDocumentoLegalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdl_tipo_documento_legal', function (Blueprint $table) {
            $table->bigIncrements('tdl_id');
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
        Schema::dropIfExists('tdl_tipo_documento_legal');
        Schema::enableForeignKeyConstraints();
    }
}
