<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\ControlAsistencia;
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
        $date = Carbon::now();
        $fecha_actual = $date->format('Y-m-d');
        $control_asistencias = ControlAsistencia::orderBy('fecha_ingreso','ASC')->get();
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
        $fecha_inicial = $request->fecha_desde;
        $fecha_final = $request->fecha_hasta;
        $date = Carbon::now();
        $fecha_actual = $date->format('Y-m-d');

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
