<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Cargo;
use Validator;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use App\Clases\Funciones;

class EmpleadoController extends Controller
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
        //Objeti de clase empleado obteniendo todos los empleados con paginacion hasta 6 registros
        $empleados = Empleado::orderBy('nombres','ASC')->paginate(6);

        /**
         * Retorno a la vista con el objeto de $empleados
         * @params vista('empleados.index') ['empleados' => $empleados]
         */
        return view('empleados.index',['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Objeto de clase empleado obteniendo todos los cargos
        $cargos = Cargo::all();
        /**
         * Retorno a la vista con el objeto de $empleados
         * @params vista('empleados.register') ['empleados' => $empleados]
         */
        return view('empleados.register',['cargos' => $cargos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombres'       => 'required|string|max:60',
            'apellidos'     => 'required|string|max:60',
            'edad'          => 'required|numeric',
            'cargo_id'      => 'required|exists:App\Models\Cargo,id',
            'cedula'        => 'required|unique:empleados|string',
            'nocelular'     => 'required|unique:empleados',
        ];

        $validator = Validator::make($request->all(),$rules);
            
        if ($validator->fails()) {
            return redirect('/empleados/create')->withErrors($validator)->withInput();
        }

        $objFun = new Funciones();
            
        $obj_empleado = [
            'nombres'       => $objFun->titleCase($request->nombres),
            'apellidos'     => $objFun->titleCase($request->apellidos),
            'edad'          => $request->edad,
            'cargo_id'      => $request->cargo_id,
            'cedula'        => $request->cedula,
            'nocelular'     => $request->nocelular,
        ];

        $empleado_new = Empleado::create($obj_empleado);

        $msgSuccess = "Empleado Registrado ($empleado_new->id) Exitosamente!.";
        if ($empleado_new->id){
            Session::flash('success',$msgSuccess);
            return redirect('/empleados');
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
        $empleado = Empleado::find($id);
        $cargos = Cargo::all();
        return view('empleados.update',['empleado' => $empleado,'cargos' => $cargos]);
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
        $rules = [
            'nombres'       => 'required|string|max:60',
            'apellidos'     => 'required|string|max:60',
            'edad'          => 'required|numeric',
            'cargo_id'      => 'required|exists:App\Models\Cargo,id',
        ];

        $validator = Validator::make($request->all(),$rules);
            
        if ($validator->fails()) {
            return redirect('/empleados/create')->withErrors($validator)->withInput();
        }

        $objFun = new Funciones();
        $empleado = Empleado::find($id);
       
        $empleado->nombres       = $objFun->titleCase($request->nombres);
        $empleado->apellidos     = $objFun->titleCase($request->apellidos);
        $empleado->edad          = $request->edad;
        $empleado->cargo_id      = $request->cargo_id;
        $empleado->cedula        = $request->cedula;
        $empleado->nocelular     = $request->nocelular;
        $empleado->save();
        
        $msgSuccess = "Empleado Actualizado ($empleado->id) Exitosamente!.";
        
        Session::flash('success',$msgSuccess);
        return redirect('/empleados');
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
