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
                <div class="card-header">Control de Asistencia</div>
                <div class="card-body">
                    <form action="{{ url('/controlasistencias') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="cedula" name="cedula" placeholder="Cedula">
                                    <label for="cedula">Cedula</label>
                                </div>
                                @if ($errors->has('cedula'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('cedula') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-control" name="tipo_control" id="tipo_control">
                                        <option value="ENTRADA">ENTRADA</option>
                                        <option value="SALIDA">SALIDA</option>
                                    </select>
                                    <label for="cargo_id">Tipo Control</label>
                                </div>
                                @if ($errors->has('tipo_control'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('tipo_control') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <button style="margin-top:0.7rem;margin-left:-74%;" type="submit" class="btn btn-primary">INGRESAR</button>
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
                                        <th scope="col">Accion</i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($control_asistencias as $conasi)
                                    <tr>
                                        <th scope="row">{{ $conasi->nombres }} {{ $conasi->apellidos }}</th>
                                        <td>{{ $conasi->fecha_ingreso }}</td>
                                        <td>{{ $conasi->entrada }}</td>
                                        <td>{{ $conasi->hora_ingreso }}</td>
                                        <td>{{ $conasi->salida }}</td>
                                        <td>{{ $conasi->hora_salida }}</td>
                                        <td><a class="btn btn-info" href="{{ url('/controlasistencias') }}/{{ $conasi->id }}"><i class="bi bi-pencil-square" role="img" aria-label="GitHub"></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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