<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/** Modelos para transacciones a la base de datos */
use App\Models\Empleado;
use App\Models\ControlAsistencia;

/** Librerias nativas para redireccion, session y uso de fechas y horas */
use Redirect;
use Session;
use Carbon\Carbon;

class ConsultaAsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        /** Instancia de la funcion carbon solicitado datos de la fecha y hora actual */
        $date = Carbon::now();

        /** Se obtiene la fecha actua con el siguiente formato (AÑO,MES.DIA) */
        $fecha_actual = $date->format('Y-m-d');

        /** Se crea objeto con consulta a la base de datos solicitado los datos de la tabla control asistencias
         * ordenando la consulta por la fecha de ingreso con la fecha actual
         */
        $control_asistencias = ControlAsistencia::orderBy('fecha_ingreso','ASC')->get();

        /** se retorna la vista con la el objeto consultado de la base de datos */
        return view('control_asistencias.search',['control_asistencias' => $control_asistencias,'fecha_actual' => $fecha_actual]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Con el fin de poder usar los filtros que se encuentran en la vista search se usa la funcion
         * Store para filtrar y volver a la Vista inicial con los datos ya filtrados
         */

        /** se obtienen las fechas del formulario filtro */
        $fecha_inicial = $request->fecha_desde;
        $fecha_final = $request->fecha_hasta;

        /** Instancia de la funcion carbon solicitado datos de la fecha y hora actual */
        $date = Carbon::now();

        /** Se obtiene la fecha actua con el siguiente formato (AÑO,MES.DIA) */
        $fecha_actual = $date->format('Y-m-d');

        /** Condicional para identificar en el caso de que alguna de las fechas llegue vacia, de lo contrario 
         * seguira el proceso llevando los datos a la vista o enseñando un mensaje ya sea de error o confirmacion
         */
        if (strlen($fecha_inicial) == 0 || strlen($fecha_final) == 0) {
            $msgError = "Por Favor Ingresar una Fecha Desde y una Fecha Hasta para Continuar con la Consulta";
            Session::flash('error',$msgError);
            return redirect('/consultaasistencias');
        }else {
            $control_asistencias = ControlAsistencia::whereBetween('fecha_ingreso',[$fecha_inicial,$fecha_final])->orderBy('fecha_ingreso','ASC')->get();
            return view('control_asistencias.search',['control_asistencias' => $control_asistencias,'fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
