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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name'); // Nombre del archivo
            $table->string('file_path'); // Ruta del archivo
            $table->string('uploader')->nullable(); // Usuario que subió el archivo
            $table->integer('record_count')->nullable(); // Número de registros procesados
            $table->enum('status', ['success', 'error', 'pending'])->default('pending'); // Estado
            $table->text('error_message')->nullable(); // Mensaje de error si falla
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
        Schema::dropIfExists('uploads');
    }
};
