<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalizationsTable extends Migration
{
    public function up()
    {
        Schema::create('personalizations', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->unique(); // Asociados, Captaciones, Colocaciones
            $table->integer('intervalo_horas');
            $table->boolean('notificaciones_email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personalizations');
    }
}
