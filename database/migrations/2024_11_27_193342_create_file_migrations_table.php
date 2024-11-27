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
        Schema::create('file_migrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_id')->constrained('uploads')->onDelete('cascade'); // Relación con uploads
            $table->enum('status', ['completed', 'failed', 'pending'])->default('pending'); // Estado
            $table->integer('processed_records')->nullable(); // Número de registros procesados
            $table->text('error_message')->nullable(); // Errores si los hay
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
        Schema::dropIfExists('file_migrations');
    }
};
