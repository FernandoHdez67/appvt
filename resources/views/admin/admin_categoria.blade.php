@extends('adminlte::page')

@section('title', 'Categoria')

@section('content_header')
<h1>Categoria de productos</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('insertar.categoria') }}" method="POST" style="margin:10px" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="categoria">Categoria <b style="color: red">*</b></label>
                    <input type="text" name="categoria" id="categoria"
                        class="form-control @error('categoria') is-invalid @enderror" value="{{ old('categoria') }}">
                    <div class="invalid-feedback" id="categoria-error"></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="imagencat" class="form-label">Imagen<b style="color: red">*</b></label>
                    <input class="form-control @error('imagencat') is-invalid @enderror" name="imagencat" type="file"
                        id="imagencat" accept="image/jpeg, image/png">
                    <div class="invalid-feedback" id="imagen-error"></div>
                </div>
            </div><br>
        </div>
        <div class="col-3">
            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Agregar Categoria</button>
            </div>
        </div>
    </form>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-success table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoria as $category)
                    <tr>

                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->categoria }}</td>
                        <td><img src="{{ 'imgcategorias/'.$category->imagencat}}" class="img-responsive" alt="" width="50px" height="60px"></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('categoria.edit', $category->idcategoria) }}"
                                    class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form method="POST" action="{{ route('destroy.categoria', $category->idcategoria) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar esta Categoria?')"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    Swal.fire(
        'Buen Trabajo!'
        , 'Tarea exitosa!'
        , 'success'
    )

</script>
<script>
    // Obtenemos el formulario y agregamos un event listener para validar los campos antes de enviar
    const formulario = document.querySelector('form');
    formulario.addEventListener('submit', function(event) {
        // Prevenimos el envío del formulario para poder validar los campos
        event.preventDefault();

        // Validamos los campos del formulario
        let formValid = true;
        formValid = validarCategoria() && formValid;

        // Verificamos si todos los campos son válidos
        if (formValid) {
            formulario.submit();
        } else {
            // Buscamos el primer campo que tenga un error de validación y mostramos el mensaje de error correspondiente
            let invalidField = formulario.querySelector('.is-invalid');
            invalidField.focus();
            mostrarError(invalidField, invalidField.nextElementSibling.innerHTML);
        }
    });



    // Obtenemos los elementos del formulario que necesitamos validar
    const categoria = document.getElementById('categoria');

    // Agregamos event listeners para los campos que queremos validar
    categoria.addEventListener('input', validarCategoria);

    // Funciones de validación para cada campo
    function validarCategoria() {
        if (categoria.value.trim() === '') {
            mostrarError(categoria, 'La categoria es obligatoria.');
        } else {
            mostrarExito(categoria);
        }
    }


    // Función para mostrar un mensaje de error para un campo
    function mostrarError(campo, mensaje) {
        campo.classList.add('is-invalid');
        campo.nextElementSibling.innerHTML = mensaje;
        campo.nextElementSibling.style.display = 'block';
    }

    // Función para mostrar que un campo es válido
    function mostrarExito(campo) {
        campo.classList.remove('is-invalid');
        campo.nextElementSibling.innerHTML = '';
        campo.nextElementSibling.style.display = 'none';
    }

</script>
@stop
