@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <div class="card">
                @if(Session::has('success'))
                    <div class="col-md">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Confirmacion:</strong> {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif 
                @if(Session::has('error'))
                    <div class="col-md">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Precaucion:</strong> {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif 
                <div class="card-header">Consulta Control de Asistencias</div>
                <div class="card-body">
                    <form action="{{ url('/consultaasistencias') }}" method="POST">
                    @csrf
                    <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control fecha" id="fecha_desde" value="{{ $fecha_actual }}" name="fecha_desde" placeholder="Fecha Desde">
                                    <label for="fecha_desde">Fecha Desde</label>
                                </div>
                                @if ($errors->has('fecha_desde'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('fecha_desde') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control fecha" id="fecha_hasta" value="{{ $fecha_actual }}" name="fecha_hasta" placeholder="Fecha Hasta">
                                    <label for="fecha_hasta">Fecha Hasta</label>
                                </div>
                                @if ($errors->has('fecha_hasta'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('fecha_ingfecha_hastareso') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-success" type="submit">BUSCAR</button>
                                </div>
                            </div>
                        
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <th scope="col">Tipo Control</th>
                                    <th scope="col">Hora Entrada</th>
                                    <th scope="col">Tipo Control</th>
                                    <th scope="col">Hora Salida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($control_asistencias as $conasi)
                                <tr>
                                    <th scope="row">{{ $conasi->Empleado->nombres }} {{ $conasi->Empleado->apellidos }}</th>
                                    <td>{{ $conasi->fecha_ingreso }}</td>
                                    <td>ENTRADA</td>
                                    <td>{{ $conasi->hora_ingreso }}</td>
                                    <td>SALIDA</td>
                                    <td>{{ $conasi->hora_salida }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-info" href="{{ url('home') }}">HOME</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection