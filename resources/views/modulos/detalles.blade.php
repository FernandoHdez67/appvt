@extends('principal')

@section('title',"Detalle | Cachorro PET")

@section ('contenido')
<div class="breadcrumbs">
    {{ Breadcrumbs::render('detalles', $detalles) }}
</div>

<div>
    <div class="container" style="margin-top: 8%">
        <div class="card">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <center>
                <h4>Detalles del producto</h4>
            </center> <br><br>
            <div class="row">
                <div class="col-md-6" style="width: 20rem; margin-left:20px">
                    <img src="{{ asset('imgproductos/'.$producto->imagen)}}" class="card-img-top" alt="" width="250px"
                        height="200px"> <br>
                </div>
                <div class="col-md-6" style="margin-left:20px">
                    <h5>Descripción</h5>
                    <p class="card-title">{{ $producto->nombre }}</p>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p class="card-text">${{ $producto->precio }}</p>
                    <p class="card-text">Categoria: {{ $producto->categoria }}</p>
                    <p class="card-text">Marca: {{ $producto->marca }}</p>
                    <p style="color:gray" class="card-text">{{ $producto->cantidad }} productos en existencia </p>
                    @if ($producto->cantidad > 0)
                    <p>Producto: <b style="color: rgb(5, 192, 5)">En existencia</b></p>
                    @else
                    <p>Producto: <b style="color: rgb(255, 189, 9)">Agotado</b></p>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            @if (session()->has('idusuario'))
                            <form action="/sessionproduct" method="POST">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type='hidden' name="total" value="{{ $producto->precio }}">
                                <input type='hidden' name="productname" value="{{$producto->nombre }}">
                                <button class="btn btn-success" type="submit" id="checkout-live-button"><i
                                        class="fa-solid fa-shop"></i> Comprar Ahora</button>
                            </form>
                            @else
                            <a href="{{ route('iniciar') }}" class="btn btn-success"><i class="fa-solid fa-shop"></i>
                                Comprar Ahora</a>
                            @endif
                            <br><br>
                        </div>
                        <div class="col-md-4">
                            @if (session()->has('idusuario'))
                            <form action="{{ route('carrito.agregar') }}" method="post">
                                @csrf
                                <input type="hidden" name="idproducto" value="{{ $producto->idproducto }}">
                                <label for="cantidad">Cantidad:</label>
                                <input style="width: 150px" type="number"
                                    class="form-control @error('cantidad') is-invalid @enderror" id="cantidad"
                                    name="cantidad" value="1">
                                @error('cantidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <br><button type="submit" class="btn btn-rojopet"><i class="fa-solid fa-plus"></i>
                                    Agregar
                                    al carrito</button>
                            </form>
                            @else
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" value="1">
                            <br>
                            <a href="{{ route('iniciar') }}" class="btn btn-rojopet"><i class="fa-solid fa-plus"></i>
                                Agregar al carrito</a>
                            @endif
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<style>
    .input-group input[type="number"] {
        text-align: center;

    }

    .input-group .btn {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
    }
</style>

<script>
    $(function() {
        $('#mas').click(function() {
            var value = parseInt($('#cantidad').val(), 10);
            value = isNaN(value) ? 1 : value;
            $('#cantidad').val(value + 1);
        });

        $('#menos').click(function() {
            var value = parseInt($('#cantidad').val(), 10);
            value = isNaN(value) ? 1 : value;
            $('#cantidad').val(value - 1);
        });
    });

</script>

@endsection
