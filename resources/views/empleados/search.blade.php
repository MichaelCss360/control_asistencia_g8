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
                <div class="card-header">Consulta Empleados</div>
                <div class="card-body">
                    <form action="{{ url('/consultaempleados') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="edad_inicio" name="edad_inicio" placeholder="Edad Inicial">
                                    <label for="edad_inicio">Edad Inicial</label>
                                </div>
                                @if ($errors->has('edad_inicio'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('edad_inicio') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="edad_final" name="edad_final" placeholder="Edad Hasta">
                                    <label for="edad_final">Edad Hasta</label>
                                </div>
                                @if ($errors->has('edad_final'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('edad_final') as $error)
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
                                    <select class="form-control" name="cargo_id" id="cargo_id">
                                        <option value="">Seleccione el Cargo</option>
                                        @foreach ($cargos as $car)
                                            <option value="{{ $car->id }}">{{ $car->cargo_nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="cargo_id">Cargo</label>
                                </div>
                                @if ($errors->has('cargo_id'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('cargo_id') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-control" name="filtro" id="filtro">
                                        <option value="">Seleccione el filtro</option>
                                        <option value="EDADES">EDADES</option>
                                        <option value="CARGO">CARGO</option>
                                    </select>
                                    <label for="cargo_id">Filtro</label>
                                </div>
                                @if ($errors->has('cargo_id'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                            @foreach ($errors->get('cargo_id') as $error)
                                                <p>{{ $error }}</p><br>
                                            @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-info" type="reset">LIMPIAR</button>
                                <button class="btn btn-success" type="submit">BUSCAR</button>
                            </div>
                        </div>
                    </form>
                    <br><br>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Cedula</th>
                                    <th scope="col">No Celular</th>
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