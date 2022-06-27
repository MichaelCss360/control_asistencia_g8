<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //migracion para crear la tabla de empleados 
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombres',60);
            $table->string('apellidos',60);
            $table->Integer('edad');

            //llave foranea o relacion con la tabla cargos
            $table->unsignedBigInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos');

            $table->string('cedula',12);
            $table->string('nocelular',12);

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
        Schema::dropIfExists('empleados');
    }
}
