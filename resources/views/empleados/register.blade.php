@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <form action="{{ url('/empleados') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">Gestion Empleados - Registro</div>
                    <div class="card-body">
                        <div class="form-group" >
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nombres" placeholder="Nombres">
                                        <label for="nombres">Nombres</label>
                                    </div>
                                    @if ($errors->has('nombres'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> 
                                                @foreach ($errors->get('nombres') as $error)
                                                    <p>{{ $error }}</p><br>
                                                @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="apellidos" placeholder="Apellidos">
                                        <label for="apellidos">Apellidos</label>
                                    </div>
                                    @if ($errors->has('apellidos'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> 
                                                @foreach ($errors->get('apellidos') as $error)
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
                                        <input type="number" class="form-control" id="edad" placeholder="Edad">
                                        <label for="edad">Edad</label>
                                    </div>
                                    @if ($errors->has('edad'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> 
                                                @foreach ($errors->get('edad') as $error)
                                                    <p>{{ $error }}</p><br>
                                                @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
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
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cedula" placeholder="Cedula">
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
                                        <input type="text" class="form-control" id="nocelular" placeholder="Celular">
                                        <label for="nocelular">Celular</label>
                                    </div>
                                    @if ($errors->has('nocelular'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> 
                                                @foreach ($errors->get('nocelular') as $error)
                                                    <p>{{ $error }}</p><br>
                                                @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/empleados') }}" class="btn btn-danger">CANCELAR</a>
                        <button type="reset" class="btn btn-primary">LIMPIAR</button>
                        <button type="submit" class="btn btn-success">GRABAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection