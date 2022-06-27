<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//rutas tipo resource (GET, POST, PUT, DELETE) para poder gestionar la informacion en la tabla
// de empleados por medio de un controlador asociado a un modelo 
Route::resource('/empleados',App\Http\Controllers\EmpleadoController::class);

/**
 * Rutas para el control de asistencias
 */

// Ruta Index
Route::get('/control-asistencias',[App\Http\Controllers\ControlAsistenciaController::class,'index']);
// Ruta Save
Route::post('/control-asistencias/save',[App\Http\Controllers\ControlAsistenciaController::class,'save']);
// Ruta getcontrol/1
Route::get('/control-asistencias/getcontrol/{id}',[App\Http\Controllers\ControlAsistenciaController::class,'getcontrol']);
// Ruta update/1
Route::post('/control-asistencias/setcontrol/update',[App\Http\Controllers\ControlAsistenciaController::class,'setcontrol']);

// Rutas para el control de sistencias
Route::resource('/controlasistencias',App\Http\Controllers\Control_asistenciaController::class);

//Consulta Empleados
Route::resource('/consultaempleados',App\Http\Controllers\ConsultaEmpleadosController::class);
//Consulta Asistencias
Route::resource('/consultaasistencias',App\Http\Controllers\ConsultaAsistenciasController::class);