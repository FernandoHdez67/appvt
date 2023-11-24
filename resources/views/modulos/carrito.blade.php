@extends('principal')

@section('title',"Carrito | Cachorro PET")

@section ('contenido')
{{ Breadcrumbs::render('ayuda') }}


<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
    @endif
    <h3>Carrito de Compras</h3> <br>
    <div>
        @if($carrito->isEmpty())
        <center>
            <p>¡Empieza un carrito de compras!</p> <br><br>
            <a href="{{ route('productos') }}" class="btn btn-rojopet"> Explorar productos</a>
        </center>
        @else
        <form action="{{ route('carrito.limpiar') }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Limpiar Carrito</button>
        </form><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width:20%">Producto</th>
                    <th style="width:8%">Cantidad</th>
                    <th style="width:8%">Subtotal</th>
                    <th style="width:8%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $item)
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ asset('imgproductos/'.$item->imagen)}}"
                                    width="30" height="30" class="img-responsive" /></div>
                            <div class="col-sm-9">
                                <p class="nomargin">{{ $item->producto->nombre }}</p>
                            </div>
                        </div>
                    </td>
                    <td><input type="number" value="{{ $item->cantidad }}" class="form-control quantity cart_update"
                            min="1" /></td>
                    <td>$ {{ $item->total }}</td>
                    <td>
                        <form action="{{ route('carrito.eliminar', ['idcarrito' => $item->idcarrito]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i>
                                Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th>
                        <h5>${{ $totalCarrito }}</h5>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align:right;">
                        <form action="/session" method="POST">
                            <a href="{{ route('productos') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i>
                                Continuar comprando</a>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type='hidden' name="total" value="{{ $totalCarrito }}">
                            <input type='hidden' name="productname"
                                value="@foreach($carrito as $index => $item){{ $item->producto->nombre . ($index < count($carrito) - 1 ? ', ' : '.') }}@endforeach">
                            <button class="btn btn-success" type="submit" id="checkout-live-button"><i
                                    class="fa-solid fa-money-check"></i> Comprar Carrito</button>
                        </form>
                    </th>
                </tr>
            </tfoot>
        </table>
        @endif
    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection


