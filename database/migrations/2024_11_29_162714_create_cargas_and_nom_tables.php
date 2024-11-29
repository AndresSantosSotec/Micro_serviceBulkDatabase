<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear tabla nom
        Schema::create('nom', function (Blueprint $table) {
            $table->id('id_tipo');
            $table->string('nombre_tipo')->unique();
            $table->timestamps();
        });

        // Crear tabla cargas
        Schema::create('cargas', function (Blueprint $table) {
            $table->id('id_carga');
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->text('metadatos')->nullable();
            $table->unsignedBigInteger('id_tipo_carga');
            $table->timestamps();

            $table->foreign('id_tipo_carga')->references('id_tipo')->on('nom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargas_and_nom_tables');
    }
};
