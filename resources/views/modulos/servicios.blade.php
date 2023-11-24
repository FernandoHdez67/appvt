@extends('principal')

@section('title',"Servicios | Cachorro PET")

@section ('contenido')
{{ Breadcrumbs::render('servicios') }}

<div class="container">
    <center>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach ($servicios as $servicio)
            <div class="">
                <div class="col hvr-glow">
                    <div class="card shadow-sm" style="width: 18rem;">
                        <img src="{{ asset('imgservicios/'.$servicio->imagen)}}" class="card-img-top" alt="" width="250px" height="200px">
                        <div class="card-body">
                            <center>
                                <h3 class="card-title">{{$servicio->tipo}}</h3>
                            </center>
                            <p class="card-text">{{$servicio->descripcion}}</p> <br>

                            @if (session()->has('idusuario'))
                                <a href="{{ route('citas', ['idservicio' => $servicio->idservicio]) }}" class="btn btn-rojopet">Agendar Cita</a>
                            @else
                                <a href="{{ route('iniciar') }}" class="btn btn-rojopet">Agendar Cita</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </center>
</div>
</div> <br><br>
@endsection
