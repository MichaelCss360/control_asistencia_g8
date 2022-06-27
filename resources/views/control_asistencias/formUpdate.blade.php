@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <form action="{{ url('/controlasistencias') }}/{{ $control_asistencia->id }}" method="POST">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-header">Control Asistencia - Actualizacion</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="hidden" id="empleado_id" name="empleado_id" value="{{ $empleado->id }}">
                                    <input type="text" class="form-control" readonly value="{{ $empleado->nombres }} {{ $empleado->apellidos }}" id="empleado" placeholder="Empleado">
                                    <label for="empleado">Empleado</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control fecha" id="apellidos" value="{{ $control_asistencia->fecha_ingreso }}" name="fecha_ingreso" placeholder="Fecha Ingreso">
                                    <label for="fecha_ingreso">Fecha Ingreso</label>
                                </div>
                                @if ($errors->has('fecha_ingreso'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('fecha_ingreso') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control horamask" id="hora_ingreso" value="{{ $control_asistencia->hora_ingreso }}" name="hora_ingreso" placeholder="Hora Ingreso"
                                    max="22:30:00" min="01:00:00" step="1">
                                    <label for="hora_ingreso">Hora Ingreso</label>
                                </div>
                                @if ($errors->has('hora_ingreso'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('hora_ingreso') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control horamask" id="hora_salida" value="{{ $control_asistencia->hora_salida }}" name="hora_salida" placeholder="Hora Salida"
                                    max="22:30:00" min="01:00:00" step="1">
                                    <label for="hora_salida">Hora Salida</label>
                                </div>
                                @if ($errors->has('hora_salida'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('hora_salida') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/control-asistencias') }}" class="btn btn-danger">CANCELAR</a>
                        <button type="submit" class="btn btn-success">GRABAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection