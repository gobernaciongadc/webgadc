<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgSeminariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_semanarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semanario_id')->constrained()->onDelete('cascade'); // Asegúrate de tener una relación con la tabla seminarios
            $table->string('imagen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_seminarios');
    }
}
