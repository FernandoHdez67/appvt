@extends('adminlte::page')

@section('title', 'Carrusel')

@section('content_header')
<h1>Carrusel</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-info" href="{{ Route('agregar-imagen') }}"><i class="fa-solid fa-plus"></i> Nueva Imagen</a>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            {!! Form::open(['method' => 'DELETE', 'route' => ['eliminar-varios.imagen']]) !!}
            {!! Form::submit('Eliminar seleccionados', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("¿Estás seguro de que quieres eliminar los elementos seleccionados?")']) !!} 
            <br><br>
            <table class="table table-success table-striped">
                <thead>
                    <tr>
                        <th>
                            {!! Form::checkbox('eliminar_todos', null, false, ['class' => 'seleccionar-todos']) !!}
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrucel as $carrucel)
                    <tr>
                        <td>
                            {!! Form::checkbox('eliminar[]', $carrucel->idimagen, false, ['class' => 'seleccionar']) !!}
                        </td>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $carrucel->nombre }}</td>
                        <td><img src="{{ 'imgcarrucel/'.$carrucel->imagen}}" class="col-sm-6 hidden-xs" alt="" width="50px" height="100px"></td>
                        <td>
                            <form method="POST" action="{{ route('destroy.imagen', $carrucel->idimagen) }}">
                                @csrf
                                <a href="{{ route('imagen.edit', $carrucel->idimagen) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta imagen?')"><i class="fa-solid fa-trash-can"></i></button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! Form::close() !!} <br>
        </div>
    </div>
</div>
@stop

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
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
    $(document).ready(function() {
        $('.seleccionar-todos').click(function() {
            $('.seleccionar').prop('checked', $(this).prop('checked'));
        });
    });

</script>
@stop
