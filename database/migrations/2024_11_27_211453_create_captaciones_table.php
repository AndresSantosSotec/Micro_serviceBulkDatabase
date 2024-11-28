<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('captaciones', function (Blueprint $table) {
            $table->id('id_captacion');
            $table->string('Codigo_Empresa')->nullable();
            $table->string('Nombre_Empresa')->nullable();
            $table->string('Cliente')->nullable();
            $table->string('Numero_Cuenta')->nullable();
            $table->string('Arrangement')->nullable();
            $table->string('Categoria')->nullable();
            $table->string('Producto')->nullable();
            $table->string('Grupo_Producto')->nullable();
            $table->string('Moneda')->nullable();
            $table->decimal('Saldo', 15, 2)->default(0.00);
            $table->string('Estado')->nullable();
            $table->date('Fecha_Apertura')->nullable();
            $table->integer('Plazo')->nullable();
            $table->date('Vencimiento')->nullable();
            $table->decimal('Tasa', 5, 2)->nullable();
            $table->decimal('Interes_Acumulado', 15, 2)->default(0.00);
            $table->decimal('Monto_Reserva', 15, 2)->default(0.00);
            $table->string('Ejecutivo')->nullable();
            $table->string('Frecuencia_Pago')->nullable();
            $table->date('Fecha_Ultimo_Credito')->nullable();
            $table->date('Fecha_Ultimo_Debito')->nullable();
            $table->string('Agencia')->nullable();
            $table->string('Usuario_Act')->nullable();
            $table->decimal('Monto_Disponible', 15, 2)->default(0.00);
            $table->string('Referencia')->nullable();
            $table->string('Tipo_Cliente')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('captaciones');
    }
};
