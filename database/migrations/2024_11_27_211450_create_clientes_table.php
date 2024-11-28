<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_asociado'); // Identificador único
            $table->string('Codigo_Cliente', 50)->unique()->nullable(); // Código único
            $table->timestamp('Actualizacion')->nullable(); // Última actualización
            $table->string('Nombre1', 100)->nullable();
            $table->string('Nombre2', 100)->nullable();
            $table->string('Nombre3', 100)->nullable();
            $table->string('Apellido1', 100)->nullable();
            $table->string('Apellido2', 100)->nullable();
            $table->string('ApellidoCasada', 100)->nullable();
            $table->string('Celular', 15)->nullable();
            $table->string('Telefono', 15)->nullable();
            $table->enum('Genero', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->date('Fecha_Apertura')->nullable();
            $table->string('Tipo_Cliente', 50)->nullable();
            $table->date('Fecha_Nacimiento')->nullable();
            $table->date('Fecha_Actualizacion_Ive')->nullable();
            $table->boolean('Alto_Riesgo')->default(false);
            $table->unsignedBigInteger('Id_Reple')->nullable(); // Relación con otra tabla, agregar foreignKey
            $table->string('Dpi', 13)->unique()->nullable(); // DPI único
            $table->string('Pasaporte', 20)->nullable();
            $table->string('Licencia', 20)->nullable();
            $table->string('Nit', 20)->unique()->nullable(); // NIT único
            $table->string('Departamento', 100)->nullable();
            $table->string('Municipio', 100)->nullable();
            $table->string('Pais', 100)->nullable();
            $table->string('Estado_Civil', 50)->nullable();
            $table->string('Depto_Nacimiento', 100)->nullable();
            $table->string('Muni_Nacimiento', 100)->nullable();
            $table->string('Pais_Nacimiento', 100)->nullable();
            $table->string('Nacionalidad', 100)->nullable();
            $table->string('Ocupacion', 100)->nullable();
            $table->string('Profesion', 100)->nullable();
            $table->string('Correo_Electronico', 150)->unique()->nullable(); // Correo único
            $table->string('Actividad_Economica', 150)->nullable();
            $table->string('Rubro', 100)->nullable();
            $table->string('SubRubro', 100)->nullable();
            $table->string('Direccion', 255)->nullable();
            $table->string('Zona_domicilio', 50)->nullable();
            $table->string('Pais_Domicilio', 100)->nullable();
            $table->string('Depto_Domicilio', 100)->nullable();
            $table->string('Muni_Domicilio', 100)->nullable();
            $table->string('Relacion_Dependencia', 100)->nullable();
            $table->string('Nombre_Relacion_Dependencia', 100)->nullable();
            $table->decimal('Ingresos_Laborales', 15, 2)->nullable();
            $table->string('Mondea_Ingreso_Laboral', 10)->nullable();
            $table->date('Fecha_Ingreso_Laboral')->nullable();
            $table->boolean('Negocio_Propio')->default(false);
            $table->string('Nombre_Negocio', 100)->nullable();
            $table->date('Fecha_Inicio_Negocio')->nullable();
            $table->decimal('Ingresos_Negocio_Propio', 15, 2)->nullable();
            $table->string('Moneda_Negocio_Propio', 10)->nullable();
            $table->decimal('Ingresos_Remesas', 15, 2)->nullable();
            $table->decimal('Monto_Otros_Ingresos', 15, 2)->nullable();
            $table->string('Otros_Ingresos', 255)->nullable();
            $table->decimal('Monto_Ingresos', 15, 2)->nullable();
            $table->string('Moneda_Ingresos', 10)->nullable();
            $table->string('Rango_Ingresos', 50)->nullable();
            $table->decimal('Monto_Egresos', 15, 2)->nullable();
            $table->string('Moneda_Egresos', 10)->nullable();
            $table->string('Rango_Egresos', 50)->nullable();
            $table->string('Act_Economica_Relacion_Dependencia', 100)->nullable();
            $table->string('Act_Economica_Negocio', 100)->nullable();
            $table->integer('Edad')->nullable();
            $table->string('Cooperativa', 100)->nullable();
            $table->string('Condicion_Vivienda', 100)->nullable();
            $table->string('Puesto', 100)->nullable();
            $table->string('Direccion_Laboral', 255)->nullable();
            $table->string('Zona_Laboral', 50)->nullable();
            $table->string('Depto_Laboral', 100)->nullable();
            $table->string('Muni_Laboral', 100)->nullable();
            $table->string('Telefono_Laboral', 15)->nullable();
            $table->boolean('Persona_PEP')->default(false);
            $table->boolean('Persona_CPE')->default(false);
            $table->string('Categoria', 100)->nullable();

            $table->timestamps();

            // Foreign key constraints
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
