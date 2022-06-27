<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlAsistencia;
use App\Models\Empleado;
use Validator;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use App\Clases\Funciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Control_asistenciaController extends Controller
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
        $date = Carbon::now();

        /**
         * se crea esta variable con el fin de pruebas segun la fecha que le quieran ingresar
         * @Variable $fechaEjecucion
         * @params 'PRUEBA' or NORMAL
         * PRUEBA: tomara y validara la fecha que se le asigne a la variable $fecha_valida para validar si 
         * el empleado salio o ingreso sin tener que esperar a que pase al otro dia
         * NORMAL: se ejecuta el proceso con la fecha actual con el fin de validar que el sistema valida que
         * el empleado no puede INGRESAR O SALIR 2 veces del sistema 
         */
        $fechaEjecucion = "PRUEBA";
        if ($fechaEjecucion == "NORMAL") {
            $fecha_actual = "2022-06-26";
        }else{
            $fecha_actual = $date->format('Y-m-d');
        }
        
        /** Consulta inicial para enseñar por medio de formulario los datos de control de asistencias existentes en la bd */
        $control_asistencias = DB::select("SELECT
                ca.id, 
                em.nombres,
                em.apellidos,
                ca.fecha_ingreso,
                'ENTRADA' as entrada,
                ca.hora_ingreso,
                'SALIDA' as salida,
                ca.hora_salida
            FROM control_asistencias ca
            INNER JOIN empleados em ON ca.empleado_id = em.id
            WHERE fecha_ingreso = ? ORDER BY hora_ingreso ASC", [$fecha_actual]);

        /** Retorno de una vista con los datos a presentar */
        return view('control_asistencias.index',['control_asistencias' => $control_asistencias]);
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
         * se crea esta variable con el fin de pruebas segun la fecha que le quieran ingresar
         * @Variable $fechaEjecucion
         * @params 'PRUEBA' or NORMAL
         * PRUEBA: tomara y validara la fecha que se le asigne a la variable $fecha_valida para validar si 
         * el empleado salio o ingreso sin tener que esperar a que pase al otro dia
         * NORMAL: se ejecuta el proceso con la fecha actual con el fin de validar que el sistema valida que
         * el empleado no puede INGRESAR O SALIR 2 veces del sistema 
         */
        $fechaEjecucion = "PRUEBA";
        
        /** Variables necesarias para realizar el registro de control asistencia segun la cedula ingresada */
        $fecha_valida = "2022-06-27";
        $cedula = $request->cedula;
        $tipo = $request->tipo_control;
        $empleado = Empleado::where('cedula', $cedula)->first();
        $date = Carbon::now();
        $fecha_actual = $date->format('Y-m-d');
        $hora_actual = $date->toTimeString();

        /** validacion para definir en que fecha se desea registrar la asistencia */
        if ($fechaEjecucion == 'PRUEBA') {
            $fecha_valida = "2022-06-27";
            $fecha_actual = $fecha_valida;
        }else if ($fechaEjecucion == 'NORMAL') {
            $fecha_valida = $date->format('Y-m-d');
            $fecha_actual = $date->format('Y-m-d');
        }

        /** Validacion para determinar si el numero de cedula ingresado existe entre los registros de empleado */
        if (empty($empleado)) {
            $msgError = "El Empleado con Cedula($cedula) no se Encuentra Registrado";
            Session::flash('error',$msgError);
            return redirect('/controlasistencias');
        }

        /** Se consulta en control asistencia si el empleado ya ingreso o lo hara inicialmente */
        $control_ingreso = ControlAsistencia::where('empleado_id','=',$empleado->id)
            ->where('tipo_control','=',$tipo)->where('fecha_ingreso','=',$fecha_valida)
            ->first();

        /** Validacion para enviar la hora con Valor o Nula dependiendo del tipo de contro, si el tipo
         * control es ENTRADA la hora salida debe ser nula y si es SALIDA debe llevar la hora que tenga 
         * el sistema
        */
        if ($tipo == 'ENTRADA') {
            $hora_salida = null;
        }else {
            $hora_salida = $hora_actual;
        }
        
        /** Validacion para determinar si el empleado ingreso la primera vez como ENTRADA para que no le permita hacer
         * una segunda ENTRADA y solicite la SALIDA
         */
        if (empty($control_ingreso)) {
            if ($tipo == 'ENTRADA') {
                /** Objeto con los datos para realizar el registro de control */
                $obj_control = [
                    'empleado_id'   => $empleado->id,
                    'fecha_ingreso' => $fecha_actual,
                    'tipo_control'  => $tipo,
                    'hora_ingreso'  => $hora_actual,
                    'hora_salida'  => $hora_salida,
                ];
                
                /** Objeto con el nuevo registro de control */
                $control_new = ControlAsistencia::create($obj_control);
                
                /** Validacion para retornar mensaje de confirmacion del registro */
                if ($control_new->id){
                    $msgSuccess = "Control Registrado ($control_new->id) Exitosamente para el Empleado($empleado->nombres $empleado->apellidos)!.";
                    Session::flash('success',$msgSuccess);
                    return redirect('/controlasistencias');
                }
            }else {

                /** Se crea objeto para que en caso de que el empleado este realizando SALIDA
                 * se actualize el registro y no realice otro
                 */
                $control_usuario = ControlAsistencia::where('empleado_id',$empleado->id)->first();
                /** Se actualiza la hora de salida del registro */
                $control_usuario->hora_salida = $hora_salida;
                /** Se realiza commit para que lleve a cabo el UPDATE control_asistencias SET hora_salida = '00:00:00' 
                 * WHERE id = 12 
                */
                $control_usuario->save();

                /** Retorno a la vista inicial confirmando que se actualizo el registro */
                $msgSuccess = "Control Actualizado ($control_usuario->id) Exitosamente para el Empleado($empleado->nombres $empleado->apellidos)!.";
                Session::flash('success',$msgSuccess);
                return redirect('/controlasistencias');
            }
            
        }else {
            $msgError = "El Empleado ($empleado->nombres $empleado->apellidos) ya Registro ENTADA/SALIDA";
            Session::flash('error',$msgError);
            return redirect('/controlasistencias');
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
        /** Se crea objeto con la del modelo ControlAsistencia con la funcion find para ubicar el registro a actualizar */
        $control_asistencia = ControlAsistencia::find($id);

        /** Se obtiene el empleado del control asistencia aunque es un sobre proceso por que tengo una relacion en el modelo de control contra
         * el empleado que no use
         */
        $empleado_id = $control_asistencia->empleado_id;
        $empleado_control = Empleado::find($empleado_id);

        /** Retorno vista donde se veran los datos para su actualizacion */
        return view('control_asistencias.formUpdate',['control_asistencia' => $control_asistencia,'empleado' => $empleado_control]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "EDIT";
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
        /** Reglas contra las que se validara los datos ingresaros por el formulario */
        $rules = [
            'empleado_id'       => 'required|exists:App\Models\Empleado,id',
            'fecha_ingreso'     => 'required|date',
            'hora_ingreso'      => 'required',
            'hora_salida'       => 'required',
        ];

        /** Validator ejecuta las reglas establecidas contra los datos */
        $validator = Validator::make($request->all(),$rules);
        
        /** Validacion para determinar si fallo alguna regla y retorne el error al formulario de actualizacion */
        if ($validator->fails()) {
            $urlError = "/controlasistencias/$id";
            return redirect($urlError)->withErrors($validator)->withInput();
        }

        /**se crea objeto del registro a actualizar teniendo en cuenta que paso todas las reglas de 
         * establecidas al inicio del proceso para commit
        */
        $controlasistencia = ControlAsistencia::find($id);
        $controlasistencia->fecha_ingreso = $request->fecha_ingreso;
        $controlasistencia->hora_ingreso = $request->hora_ingreso;
        $controlasistencia->hora_salida = $request->hora_salida;
        $controlasistencia->save();

        $empleado = Empleado::find($controlasistencia->empleado_id);

        /** Retorno a la vista inicial donde se refleja un mensaje informando que se actualizo el registro  */
        $msgSuccess = "Control Actualizado ($controlasistencia->id) Exitosamente para el Empleado($empleado->nombres $empleado->apellidos)!.";
        Session::flash('success',$msgSuccess);
        return redirect('/controlasistencias');
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
