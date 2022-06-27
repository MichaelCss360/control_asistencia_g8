<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        //tabla creada para llevar el control de las asistencias de los empleados
        Schema::create('control_asistencias', function (Blueprint $table) {
            $table->id();

            //relacion para determinar que empleado registra asistencias
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            
            //fecha y hora de ingreso
            $table->string('tipo_control',20);
            $table->date('fecha_ingreso');
            $table->time('hora_ingreso');
            $table->time('hora_salida');

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
        Schema::dropIfExists('control_asistencias');
    }
}
