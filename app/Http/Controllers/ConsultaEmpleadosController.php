<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Cargo;
use Redirect;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ConsultaEmpleadosController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::orderBy('nombres','ASC')->get();
        $cargos = Cargo::all();
        return view('empleados.search',['empleados' => $empleados,'cargos' => $cargos]);
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
        $filtro = $request->filtro;
        $edad_inicio = intval($request->edad_inicio);
        $edad_final = intval($request->edad_final);
        $cargo_id = $request->cargo_id;
        $cargos = Cargo::all();

        if($filtro == "EDADES"){
            if (strlen($edad_inicio) == 0 && strlen($edad_final) == 0) {
                $msgError = "Para el Filtro de Edades por Favor Ingresar la Edad de Inicio y Edad Hasta para Continuar con la Consulta";
                Session::flash('error',$msgError);
                return redirect('/consultaempleados');
            }else {
                $empleados1 = Empleado::whereBetween('edad',[$edad_inicio,$edad_final])->orderBy('edad','ASC')->get();
                $msgSuccess = "Registros Encontrados para el Filtro Edades con el Rango de ($edad_inicio -> $edad_final)";
                Session::flash('success',$msgSuccess);
                return view('empleados.search',['empleados' => $empleados1,'cargos' => $cargos]);
            }
        }
        else if ($filtro == "CARGO") {
            if (strlen($cargo_id) == 0) {
                $msgError = "Por Favor Seleccionar un Cargo para Poder Consultar los Registros";
                Session::flash('error',$msgError);
                return redirect('/consultaempleados');
            }else {
                $cargo_filtro = Cargo::find($cargo_id);
                $empleados = Empleado::where('cargo_id',$cargo_id)->orderBy('nombres','ASC')->get();
                $msgSuccess = "Registros Encontrados para el Filtro Cargo ($cargo_filtro->cargo_nombre)";
                Session::flash('success',$msgSuccess);
                return view('empleados.search',['empleados' => $empleados,'cargos' => $cargos]);
            }
        }
        else {
            $msgError =  "Por Favor Seleccione el Tipo de Filtro para Continuar con la Consulta";
            Session::flash('error',$msgError);
            return redirect('/consultaempleados');
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
