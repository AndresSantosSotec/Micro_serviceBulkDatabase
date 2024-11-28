<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('colocaciones', function (Blueprint $table) {
            $table->id('id_colocacion');
            $table->string('EMPRESA')->nullable();
            $table->string('CLIENTE')->nullable();
            $table->string('NUMERODOCUMENTO')->nullable();
            $table->string('ARRANGEMENT_ID')->nullable();
            $table->string('CATEGORIA')->nullable();
            $table->string('TIPODOCUMENTO')->nullable();
            $table->string('MONEDA')->nullable();
            $table->string('PRODUCTO')->nullable();
            $table->string('AREA_FINANCIERA')->nullable();
            $table->string('USUARIOASESOR')->nullable();
            $table->string('USUARIOCOBRANZA')->nullable();
            $table->string('USUARIOEJECUTIVO')->nullable();
            $table->string('RECORD_STATUS')->nullable();
            $table->integer('DIASMORA')->nullable();
            $table->decimal('TASAINTERES', 5, 2)->nullable();
            $table->decimal('MONTODOCUMENTO', 15, 2)->default(0.00);
            $table->decimal('SALDOCAPITAL', 15, 2)->default(0.00);
            $table->decimal('CAPITALVIGENTE', 15, 2)->default(0.00);
            $table->decimal('CAPITALVENCIDO', 15, 2)->default(0.00);
            $table->decimal('INTERESESVENCIDOS', 15, 2)->default(0.00);
            $table->decimal('MONTO_MORA', 15, 2)->default(0.00);
            $table->decimal('MONTO_ADEUDADO', 15, 2)->default(0.00);
            $table->decimal('INTERESESDEVENGADOS', 15, 2)->default(0.00);
            $table->integer('PLAZO')->nullable();
            $table->string('TIPOGARANTIA')->nullable();
            $table->date('fechainicio')->nullable();
            $table->date('fechavencimiento')->nullable();
            $table->string('frecuenciaCapital')->nullable();
            $table->string('frecuenciaInteres')->nullable();
            $table->string('ESTADODOCUMENTO')->nullable();
            $table->date('FECHAPROBACION')->nullable();
            $table->string('CALIFICACION_BW')->nullable();
            $table->string('CLASIFICACIONPROYECTO')->nullable();
            $table->string('ORIGENFONDOS')->nullable();
            $table->decimal('COLDISPONIBLE', 15, 2)->default(0.00);
            $table->string('ACTIVIDADECONOMICA')->nullable();
            $table->decimal('CUOTACAPITAL', 15, 2)->default(0.00);
            $table->string('REFERENCIA')->nullable();
            $table->boolean('LTDEPURADO')->default(false);
            $table->boolean('DEPURADO')->default(false);
            $table->date('FECHAULTIMOPAGO')->nullable();
            $table->string('GENDER')->nullable();
            $table->string('MARITALSTATUS')->nullable();
            $table->string('CUENTADEBITO')->nullable();
            $table->string('CUENTACREDITO')->nullable();
            $table->integer('DIASMORAINTERES')->nullable();
            $table->decimal('MONTOGASTOS', 15, 2)->default(0.00);
            $table->date('FECHAULTIMOPAGOCAPITAL')->nullable();
            $table->date('FECHAPROXIMOPAGOCAPITAL')->nullable();
            $table->string('TIPOFRECUENCIAPAGO')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('colocaciones');
    }
};
