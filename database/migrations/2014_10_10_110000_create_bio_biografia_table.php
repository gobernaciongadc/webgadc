<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBioBiografiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bio_biografia', function (Blueprint $table) {
            $table->bigIncrements('bio_id');
            $table->string('nombres',200);
            $table->string('apellidos',200);
            $table->text('imagen_foto')->nullable(true);
            $table->string('profesion',300);
            $table->text('resenia');
            $table->string('estado',2);
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
        Schema::dropIfExists('bio_biografia');
        Schema::enableForeignKeyConstraints();
    }
}
