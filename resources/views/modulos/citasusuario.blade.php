@extends('principal')

@section('title', "Mis Citas | Cachorro PET")

@section('contenido')

<div class="container"> <br><br>
    <h2>Mis citas</h2> <br><br>

    @if($citasEnEspera->isEmpty() && $otrasCitas->isEmpty())
    <center>
        <h5>Usted aún no ha registrado ninguna cita :(</h5>
    </center>
    @else

    @if (!$citasEnEspera->isEmpty())
    <div class="table-responsive">
        <h5>Proximas Citas</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Razón</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citasEnEspera as $cita)
                <tr>
                    <td>{{ $cita->nombre_mascota }}</td>
                    <td>{{ $cita->fecha_cita }}</td>
                    <td>{{ $cita->horario->horario }}</td>
                    <td>{{ $cita->razon_cita }}</td>
                    @if ($cita->estado_cita=='En espera')
                    <td style="color:blue"><i class="fa-solid fa-clock"></i> <b>{{ $cita->estado_cita }}</b></td>
                    @endif
                    <td>
                        <div class="d-flex justify-content-between">
                            <button type="submit"
                                onclick="return confirm('¿Estás seguro de que quieres cancelar tu Cita?')"
                                class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i>
                                Cancelar</button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> <br> <br>
    @endif

    @if (!$otrasCitas->isEmpty())
    <div class="table-responsive">
        <h5>Historial de Citas</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Razón</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($otrasCitas as $cita)
                <tr>
                    <td>{{ $cita->nombre_mascota }}</td>
                    <td>{{ $cita->fecha_cita }}</td>
                    <td>{{ $cita->horario->horario }}</td>
                    <td>{{ $cita->razon_cita }}</td>
                    @if ($cita->estado_cita=='Cancelada')
                    <td style="color: red"><i class="fa-solid fa-ban"></i> <b>{{ $cita->estado_cita }}</b></td>
                    @elseif ($cita->estado_cita=='No asistió')
                    <td style="color:gray"><i class="fa-solid fa-circle-xmark"></i> <b>{{ $cita->estado_cita }}</b></td>
                    @elseif ($cita->estado_cita=='Finalizada')
                    <td style="color: green"><i class="fa-solid fa-check"></i> <b>{{ $cita->estado_cita }}</b></td>
                    @endif
                    <td>
                        <div class="d-flex justify-content-between">
                            @if($cita->estado_cita=='Finalizada')
                            <form action="#" method="get">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-star"></i>
                                    Calificar</button>
                            </form>
                            @else
                            <button disabled type="submit" class="btn btn-secondary btn-sm"><i
                                    class="fa-solid fa-xmark"></i> Cancelar</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @endif
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
