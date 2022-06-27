@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <div class="card">
                
                <div class="card-header">Gestion Empleados</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Edad</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Cedula</th>
                                <th scope="col">No Celular</th>
                                <th scope="col">Accion</i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $emp)
                                <tr>
                                    <th scope="row">{{ $emp->nombres }} {{ $emp->apellidos }}</th>
                                    <td>{{ $emp->edad }}</td>
                                    <td>{{ strtoupper($emp->Cargo->cargo_nombre) }}</td>
                                    <td>{{ $emp->cedula }}</td>
                                    <td>{{ $emp->nocelular }}</td>
                                    <td><a class="btn btn-info" href="{{ url('/empleados') }}/{{ $emp->id }}"><i class="bi bi-pencil-square" role="img" aria-label="GitHub"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
                {{ $empleados->links() }}
                <div class="card-footer">
                    <a class="btn btn-primary" href="{{ url('/empleados/create')}}">Registrar Empleado</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection