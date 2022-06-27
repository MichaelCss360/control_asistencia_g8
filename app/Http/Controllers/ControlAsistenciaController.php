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

class ControlAsistenciaController extends Controller
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
     * Metodo con el cual se ingresara al modulo de control
     */

    public function index(){

        $date = Carbon::now();
        $fecha_actual = $date->format('Y-m-d');

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

        return view('control_asistencias.index',['control_asistencias' => $control_asistencias]);
    }

    /**
     * Metodo con el cual se registra la asistencia del empleado segun su cedula
     */

     public function save(Request $request) {
        
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
        
        $fecha_valida = "2022-06-27";
        $cedula = $request->cedula;
        $tipo = $request->tipo_control;
        $empleado = Empleado::where('cedula', $cedula)->first();
        $date = Carbon::now();
        $fecha_actual = $date->format('Y-m-d');
        $hora_actual = $date->toTimeString();

        if ($fechaEjecucion == 'PRUEBA') {
            $fecha_valida = "2022-06-27";
            $fecha_actual = $fecha_valida;
        }else if ($fechaEjecucion == 'NORMAL') {
            $fecha_valida = $date->format('Y-m-d');
            $fecha_actual = $date->format('Y-m-d');
        }

        if (empty($empleado)) {
            $msgError = "El Empleado con Cedula($cedula) no se Encuentra Registrado";
            Session::flash('error',$msgError);
            return redirect('/control-asistencias');
        }

        $control_ingreso = ControlAsistencia::where('empleado_id','=',$empleado->id)
            ->where('tipo_control','=',$tipo)->where('fecha_ingreso','=',$fecha_valida)
            ->first();

        if ($tipo == 'ENTRADA') {
            $hora_salida = null;
        }else {
            $hora_salida = $hora_actual;
        }
        
        if (empty($control_ingreso)) {
            if ($tipo == 'ENTRADA') {
                $obj_control = [
                    'empleado_id'   => $empleado->id,
                    'fecha_ingreso' => $fecha_actual,
                    'tipo_control'  => $tipo,
                    'hora_ingreso'  => $hora_actual,
                    'hora_salida'  => $hora_salida,
                ];
    
                $control_new = ControlAsistencia::create($obj_control);
                
                if ($control_new->id){
                    $msgSuccess = "Control Registrado ($control_new->id) Exitosamente para el Empleado($empleado->nombres $empleado->apellidos)!.";
                    Session::flash('success',$msgSuccess);
                    return redirect('/control-asistencias');
                }
            }else {
                $control_usuario = ControlAsistencia::where('empleado_id',$empleado->id)->first();
                $control_usuario->hora_salida = $hora_salida;
                $control_usuario->save();

                $msgSuccess = "Control Actualizado ($control_usuario->id) Exitosamente para el Empleado($empleado->nombres $empleado->apellidos)!.";
                Session::flash('success',$msgSuccess);
                return redirect('/control-asistencias');
            }
            
        }else {
            $msgError = "El Empleado ($empleado->nombres $empleado->apellidos) ya Registro ENTADA/SALIDA";
            Session::flash('error',$msgError);
            return redirect('/control-asistencias');
        }
     }
}
