@extends('principal')

@section('title',"Mi Perfil | Cachorro PET")

@section ('contenido')

<div class="container"> <br> <br>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
<h2>Mi Perfil</h2>
    <form method="POST" action="{{ route('perfilusuario.actualizar') }}" class="border p-3 form-2">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ $usuario->nombre }}" class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="apaterno">Apellido Paterno</label>
            <input type="text" name="apaterno" id="apaterno" value="{{ $usuario->apaterno }}" class="form-control @error('apaterno') is-invalid @enderror">
            @error('apaterno')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="amaterno">Apellido Materno</label>
            <input type="text" name="amaterno" id="amaterno" value="{{ $usuario->amaterno }}" class="form-control @error('amaterno') is-invalid @enderror">
            @error('amaterno')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" value="{{ $usuario->telefono }}" class="form-control @error('telefono') is-invalid @enderror">
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" name="email" id="email" value="{{ $usuario->email }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea class="form-control @error('direccion') is-invalid @enderror" name="direccion" id="direccion">{{ $usuario->direccion }}</textarea>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nombre_usuario">Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" value="{{ $usuario->nombre_usuario }}" class="form-control @error('nombre_usuario') is-invalid @enderror">
            @error('nombre_usuario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="preguntasecreta">Pregunta Secreta</label>
            <select class="form-select" aria-label="Default select example" id="preguntasecreta" name="preguntasecreta">
                @foreach($preguntas as $pregunta)
                    <option value="{{ $pregunta->idpreguntasecreta }}" {{ $pregunta->idpreguntasecreta == $usuario->idpreguntasecreta ? 'selected' : '' }}>{{ $pregunta->preguntasecreta }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="respuesta">Respuesta</label>
            <input type="text" id="respuesta" name="respuesta" value="{{ $usuario->respuesta }}" class="form-control @error('respuesta') is-invalid @enderror">
            @error('respuesta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" value="{{ $usuario->password }}" class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <button id="formulario-registro" type="submit" class="btn btn-rojopet">Actualizar</button>
    </form>

    <br><br><br><br>
    @endsection
